<?php

namespace fbwidget\components;

use Yii;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Mar-16
 * Time: 22:50
 */

class GroupScheduleHelper {

     public static $merchantAdditionalSchedule;
    public static $groupAdditionalSchedule;
    public static $groups;

    public static function init($date, $group_id, $service){
        

//        $criteria = new CDbCriteria();
//        $criteria->condition = 'merchant_id = :id';
//        $criteria->addCondition('work_date >= :date_start');
//        $criteria->addCondition('work_date <= :date_end');
//        $criteria->params = [':id'=>Yii::app()->user->id, ':date_start'=>date('Y-m-d',$date), ':date_end'=> date('Y-m-d',strtotime("next Sunday",$date))];
//        
        $merchantSchedule = \frontend\models\MerchantSchedule::find()
                ->where(['>=', 'work_date', date('Y-m-d',$date)])
                ->andWhere(['<=', 'work_date', date('Y-m-d',strtotime("next Sunday",$date))])
                ->andWhere(['merchant_id' => $service->merchant_id])
                ->all();
                    
        
        
        if(is_null(self::$merchantAdditionalSchedule))
            self::$merchantAdditionalSchedule = \yii\helpers\ArrayHelper::map ($merchantSchedule, 'work_date','model');
                

//        $criteria = new CDbCriteria();
//        $criteria->condition = 'group_id = :id';
//        $criteria->addCondition('work_date >= :date_start');
//        $criteria->addCondition('work_date <= :date_end');
//        $criteria->params = [':id'=>$group_id, ':date_start'=>date('Y-m-d',$date), ':date_end'=> date('Y-m-d',strtotime("next Sunday",$date))];

        $groupSchedule = \frontend\models\GroupSchedule::find()
                ->where(['>=', 'work_date', date('Y-m-d',$date)])
                ->andWhere(['<=', 'work_date', date('Y-m-d',strtotime("next Sunday",$date))])
                ->andWhere(['group_id' => $group_id])
                ->all();
        self::$groupAdditionalSchedule[$group_id] = \yii\helpers\ArrayHelper::map($groupSchedule,'work_date', 'model');
                

        if(is_null(self::$groups))
            self::$groups = \yii\helpers\ArrayHelper::map(\frontend\models\CategoryHasMerchant::find()
                ->where(['merchant_id' => $service->merchant_id, 'is_group'=> 1, 'is_active' => 1])
                ->all(),'id','model');
        
        
               
                
    }

    public static function getDateSchedule($date, $group_id, $service)
    {
        
        $dateSQL = date('Y-m-d', $date);
        
        
        if(isset(self::$merchantAdditionalSchedule[$dateSQL])) {
            
            if(self::$merchantAdditionalSchedule[$dateSQL]->schedule_days_template_id)
            $currentMerchantSchedule =  [
                'reason' => self::$merchantAdditionalSchedule[$dateSQL]->reason,
                'type'=> 1,
                'model'=>self::$merchantAdditionalSchedule[$dateSQL]->scheduleDaysTemplate
            ];
            else return
                [
                    'reason' => self::$merchantAdditionalSchedule[$dateSQL]->reason,
                    'type'=> 1,
                    'models'=>''
                ];
        }
        else{
            if($service->merchant->lastSchedule && $service->merchant->lastSchedule->{strtolower(date('D',$date))}){
                $currentMerchantSchedule =  [
                    'reason' => '',
                    'type'=> 2,
                    'model'=>  \frontend\models\ScheduleDaysTemplate::findOne($service->merchant->lastSchedule->{strtolower(date('D',$date))})
                ];

            }

            else
                return   [
                    'reason' => '',
                    'type'=> 2,
                    'models'=>''
                ];

        }
        
        
        
        
        if(isset(self::$groupAdditionalSchedule[$group_id][$dateSQL])) {
            
            if(self::$groupAdditionalSchedule[$group_id][$dateSQL]->schedule_days_template_id)
                $currentGroupSchedule = [
                    'reason' => self::$groupAdditionalSchedule[$group_id][$dateSQL]->reason,
                    'type'=> 3,
                    'model'=>self::$groupAdditionalSchedule[$group_id][$dateSQL]->groupScheduleDaysTemplate
                ];
            else
                return
                    [
                        'reason' => self::$groupAdditionalSchedule[$group_id][$dateSQL]->reason,
                        'type'=> 3,
                        'models'=>''
                    ];

        }
        else{ 
            $varval = strtolower(date('D',$date));
            
            if(self::$groups[$group_id]->lastSchedule && self::$groups[$group_id]->lastSchedule->$varval){

                $currentGroupSchedule = [
                    'reason' => '',
                    'type' => 4,
                    'model' => \frontend\models\GroupScheduleDaysTemplate::findOne(['id'=>self::$groups[$group_id]->lastSchedule->$varval]),
                    //GroupScheduleDaysTemplate::model()->findByPk(self::$groups[$group_id]->lastSchedule->$varval)
                ];
            }else{
                return
                    [
                    'reason' => '',
                    'type' => 4,
                    'models' => ''
                    ];
            }
        }
        
        

        $result = [];
        $nonSorted = $currentGroupSchedule['model']->groupTimeRanges;
                
               // print_r($nonSorted);
        //exit;
        
        
        foreach($currentMerchantSchedule['model']->timeRanges as $val){
            
            foreach($nonSorted as $key => $res){
                $time = strtotime('+30 minutes', strtotime($res->time_start));
                
                if($res->time_start >= $val->time_from && date("H:i", $time) <= $val->time_to ){
                    $result[] = $res->time_start;
                    unset($nonSorted[$key]);
                }
                
            }
            
        }
        
        

        return [
            'reason' =>$currentMerchantSchedule['reason'].' '.$currentMerchantSchedule['reason'],
            'type' =>'',
            'models' => $result
        ];

    }
    
    
    public static function checkGroupServices($group , $d, $t, $m, $service){
        
        foreach ($group as $model) {
            
                $k = 0;
                $dStart = new \DateTime($d);

                \frontend\components\GroupScheduleHelper::init(strtotime("+$k day", $dStart->getTimestamp()), $model->id, $service);
                $dayGroupSchedule = \frontend\components\GroupScheduleHelper::getDateSchedule(strtotime("+$k day", $dStart->getTimestamp()), $model->id, $service);
                
                
                
                
                if ($dayGroupSchedule['models']) {
                    foreach ($dayGroupSchedule['models'] as $val) {
                        
                        $date2 = $val;
                        //print_r($val['time_start']);
                        
                        $date3 = date('H:i', strtotime("+$m minutes", strtotime($val)));
                        
                        if($t == $date2 || ($t < $date3 && $t > $date2)){

                            return false;

                        }else if($t < $date2){

                            $diff1 = strtotime($date2) - strtotime($t);
                            $totalDiff = $diff1/60;
                            
                            //exit;
                            if($totalDiff < $m){
                                
                                return false;
                            }


                        }
                    }

                }
            }
            
            return true;
        
    }

} 