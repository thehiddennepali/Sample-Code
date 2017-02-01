<?php
namespace frontend\components;

use Yii;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Mar-16
 * Time: 22:50
 */
class SingleScheduleHelper
{

    public static $merchantAdditionalSchedule;
    public static $groupAdditionalSchedule;
    public static $groups;

    public static $freeMerchantDays = null;
    public static $freeStaffDays;

    /**
     * @param $staff_id
     * @return string
     */
    public static function getEmptyDays($staff_id)
    {
        $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        if (is_null(self::$freeMerchantDays)) {
            self::$freeMerchantDays = [];

            foreach ($days as $key => $day) {
                if (empty(Yii::app()->user->model->lastSchedule) || empty(Yii::app()->user->model->lastSchedule->$day)) {
                    self::$freeMerchantDays[] = $key;
                }
            }
        }

        if (!isset(self::$freeStaffDays[$staff_id])) {
            $staff = Staff::model()->findByPk($staff_id);
            self::$freeStaffDays[$staff_id] = [];
            foreach ($days as $key => $day) {
                if (empty($staff->lastSchedule) || empty($staff->lastSchedule->$day)) {
                    self::$freeStaffDays[$staff_id][] = $key;
                }
            }
        }

        $res = array_values(array_unique(array_merge(self::$freeMerchantDays, self::$freeStaffDays[$staff_id])));

        if (count($res) == 7) {
            return false;
        } else
            return CJSON::encode($res);

    }

    /**
     * @param $d
     * @param $t
     * @param $m
     * @return bool
     */
    public static function isMerchantWork($d, $t, $m, $merchant_id)
    {
        $merchant = \frontend\models\MtMerchant::findOne($merchant_id);
        
        
        $s = \frontend\models\MerchantSchedule::find()->where(['work_date' => $d, 'merchant_id' => $merchant_id])->one();
        
        
        if ($s) {
            if ($s->scheduleDaysTemplate) {
                
                foreach ($s->scheduleDaysTemplate->timeRanges as $val) {
                    $date = date('H:i', strtotime("+$m minutes", strtotime($t)));
                    //if ($val->time_from <= $t && $val->time_to > $date) {
                        return true;
                    //}
                }
            }
        } else {
            
            if ($merchant->lastSchedule && $merchant->lastSchedule->{strtolower(date('D', strtotime($d)))}) {
                $tr = \frontend\models\ScheduleDaysTemplate::findOne(['id'=>$merchant->lastSchedule->{strtolower(date('D', strtotime($d)))}]);
                
                
                foreach ($tr->timeRanges as $val) {
                    $date = date('H:i', strtotime("+$m minutes", strtotime($t))); 
                    
                    //if (($val->time_from <= $t) && ($val->time_to > $date)) {
                        
                        return true;
                    //}
                }
            }
        }
        return false;
    }

    public static function isStaffWork($d, $t, $m, $staff, $u, $c)
    {
        if ($staff->staffVacations) {
            
            $vacation = \frontend\models\StaffVacation::find()
                    ->where(['<=','start_date', $d ])
                    ->andWhere(['>=', 'end_date', $d])
                    ->andWhere(['staff_id'=> $staff->id])
                    ->all();

            if ($vacation) return false;

        }
        $s = \frontend\models\StaffSchedule::find()->where(['work_date' => $d, 'staff_id' => $staff->id])->one();

        if ($s) {
            if ($s->scheduleDaysTemplate) {
                foreach ($s->scheduleDaysTemplate->timeRanges as $val) {
                    //if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {

                        return self::issetOrder($d, $t, $m, $staff->id, $u, $c);
                    //}
                }
            }
        } else {
            if ($staff->lastSchedule && $staff->lastSchedule->{strtolower(date('D', strtotime($d)))}) {
                $tr = \frontend\models\ScheduleDaysTemplate::findOne($staff->lastSchedule->{strtolower(date('D', strtotime($d)))});

                foreach ($tr->timeRanges as $val) {
                    //if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {

                        return self::issetOrder($d, $t, $m, $staff->id, $u,$c);
                    //}
                }
            }
        }

        return false;
    }

    public static function issetOrder($d, $t, $m, $staff_id, $u = 0, $c = null)
    {
//        $crit = new CDbCriteria();
//        $crit->condition = 'staff_id = ' . $staff_id;
//        $crit->addCondition('order_time>="' . date('Y-m-d', strtotime($d)) . ' 00:00:00"');
//        $crit->addCondition('order_time<"' . date('Y-m-d', strtotime($d)) . ' 23:59:00"');
        if ($u) {
            $crit->addCondition('id!=' . $u);
        }
        
        $orders = \frontend\models\Order::find()
                ->where(['staff_id'=> $staff_id])
                ->andWhere(['>=', 'order_time' , date('Y-m-d', strtotime($d)) . ' 00:00:00"'])
                ->andWhere(['<', 'order_time', date('Y-m-d', strtotime($d)) . ' 23:59:00"'])
                ->andWhere(['!=', 'status', 2])
                ->all();
        //$orders = SingleOrder::model()->findAll($crit);

        $cOrders = CachedSingleOrder::getOrdersByStaffAndDay($staff_id,$d);
        
        $session = Yii::$app->session;
        
        
        //print_r($session['cart']);
        
        if(isset($session['cart'])){
            
            foreach ($session['cart'] as $c=>$value){
                
                
                foreach ($value as $o){
                    
                    if($staff_id == $o['staff_id']){
                    
                    //print_r($o);
                $ordertime = $o['order_date']. ' '. $o['free_time_list'].':00';
                $ot = date('Y-m-d H:i', strtotime($ordertime));
                $orderTimeLength = self::getOrderTimeLength($o['addons_list']);
                $totalOrderTimeLenght = $orderTimeLength + $o['time_in_minutes'] + $o['additional_time'];
                
//                if (($ot == $d . ' ' . $t) || (($ot <= $d . ' ' . $t) && ($d . ' ' . $t < date('Y-m-d H:i', strtotime("+" . $totalOrderTimeLenght . " minutes", strtotime($ot))))) ||
//                    (($ot < $d . ' ' . date('H:i', strtotime("+$m minutes", strtotime($t)))) && ($d . ' ' . date('H:i', strtotime("+$m minutes", strtotime($t))) <= date('Y-m-d H:i', strtotime("+" . $totalOrderTimeLenght . " minutes", strtotime($ot)))))
//                ) {
//                   return false;
//                }
                
                
                $date2 = date('H:i', strtotime($o['free_time_list']));


                $date3 = date('H:i', strtotime("+$totalOrderTimeLenght minutes", strtotime($o['free_time_list'])));
    //            
    //            
    //            echo $t;
    //            echo '<br>';
    //            echo $date2;
    //            echo '<br>';


                //exit;
                
                



                if($t == $date2 || ($t < $date3 && $t > $date2)){
                    return false;

                }else if($t < $date2){

                    $diff1 = strtotime($date2) - strtotime($t);
                    $totalDiff = $diff1/60;
                    
                    


                    if($totalDiff < $m){
                        return false;
                    }


                
                }
                    } 
                
            }
            }
        }
        //exit;


        foreach ($orders + $cOrders as $order) {
            
            
            $date2 = date('H:i', strtotime($order->order_time));
            $order->orderTimeLength;
            
            $date3 = date('H:i', strtotime("+$order->orderTimeLength minutes", strtotime($order->order_time)));
//            
//            
//            echo $t;
//            echo '<br>';
//            echo $date2;
//            echo '<br>';
            
            
            //exit;
            
            
            
            if($t == $date2 || ($t < $date3 && $t > $date2)){
                return false;
            
            }else if($t < $date2){
                
                $diff1 = strtotime($date2) - strtotime($t);
                $totalDiff = $diff1/60;
                
                if($totalDiff < $m){
                    return false;
                }
                
                
            }
            
            
//            $ot = date('Y-m-d H:i', strtotime($order->order_time));
//            
//            $ddd = date('Y-m-d H:i', strtotime("+" . $order->orderTimeLength . " minutes", strtotime($ot)));
//            
//            $date1 = $d . ' ' . date('H:i', strtotime("+$m minutes", strtotime($t)));
//            
//            $date2 = $d . ' ' . date('H:i', strtotime("+$m minutes", strtotime($t)));
//            
//            $date3 = date('Y-m-d H:i', strtotime("+" . $order->orderTimeLength . " minutes", strtotime($ot)));
//            
//            //print_r($order->attributes);
//            
//            if (($ot == $d . ' ' . $t) || (($ot <= ($d . ' ' . $t)) && (($d . ' ' . $t) < $ddd)) ||
//                (($ot < $date1) && ( $date2 <= $date3))
//            ) {
//                return false;
//            }
        }
        
        
        return true;

    }
    
    
    public static function getOrderTimeLength($addons_list){
        
        $l =0;
        foreach($addons_list as $val){
            $l += $val['time_in_minutes'];
        }
        return $l;
        
        
    }

    public static function getStaffOrders($staff_id, $range_start, $range_end)
    {
        $result = [];

        $staff = Staff::model()->findByPk($staff_id);

        foreach ($staff->futureOrders as $order) {
            if ($order->order_time >= $range_start.' 00:00:00' && $order->order_time <= $range_end.' 00:00:00')
                $result[] = [
                    'id' => $order->id,
                    'title' => $order->client_name,
                    'start' => date('Y-m-d\TH:i:s', strtotime($order->order_time)),
                    'end' => date('Y-m-d\TH:i:s', strtotime("+{$order->orderTimeLength} minutes", strtotime($order->order_time))),
                    'url' => 'order/updateInst/' . $order->id,
                    'backgroundColor' => $order->category->color,

                ];
        }

        foreach ($staff->futureStaffVacations as $vacation) {
            $result[] = [
                'start' => $vacation->start_date,
                'end' => date('Y-m-d', strtotime('+1 day', strtotime($vacation->end_date))),
                'rendering' => 'background',
                'overlap' => false,
                'color' => '#ff9f89'
            ];
        }

        foreach ($staff->futureFreeStaffSchedules as $val) {

            $result[] = [
                'start' => $val->work_date,
                'end' => date('Y-m-d', strtotime('+1 day', strtotime($val->work_date))),
                'rendering' => 'background',
                'overlap' => false,
                'color' => '#ff9f89'
            ];
        }
        if ($staff->staff_has_category) {
            if ($range_start < date('Y-m-d'))
                $range_start = date('Y-m-d');
            if ($range_end < date('Y-m-d'))
                $range_end = date('Y-m-d');
            if ($range_start != $range_end) {
                $dStart = new DateTime($range_start);
                $dEnd = new DateTime($range_end);
                $dDiff = $dStart->diff($dEnd);
                $diff = $dDiff->days;
                
               

                foreach ($staff->groupCat as $model) {
                    
                    
                    
                    $k = 0;
                    do {

                        GroupScheduleHelper::init(strtotime("+$k day", $dStart->getTimestamp()), $model->id);
                        $dayGroupSchedule = GroupScheduleHelper::getDateSchedule(strtotime("+$k day", $dStart->getTimestamp()), $model->id);
                         
                        if ($dayGroupSchedule['models']) {
                            foreach ($dayGroupSchedule['models'] as $val) {

                                $result[] = [
                                    'id' => 'g-' . strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00')). $model->id,
                                    'title' => $model->title . ' (' . $val->time_start . ') left:' . ($model->group_people - GroupOrder::countByDate(date('Y-m-d H:i:s', strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00'))), $model->id)),
                                    'start' => date('Y-m-d\TH:i:s', strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00'))),
                                    'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->time_in_minutes} minutes", strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00')))),
                                    'url' => 'groupOrder/getGroupOrders/id/' . $model->id . '/date_id/' . strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00')),
                                    'backgroundColor' => $model->color,

                                ];

                            }
                        }
                        $k++;

                    } while ($k < $diff);
                }
            }


        }

        $blocked = CachedSingleOrder::getOrdersByStaffAndRange($staff_id, $range_start, $range_end);
        foreach($blocked as $order){
            $result[] = [
                'id' => uniqid(),
                'title' => 'blocked',
                'start' => date('Y-m-d\TH:i:s', strtotime($order->order_time)),
                'end' => date('Y-m-d\TH:i:s', strtotime("+{$order->orderTimeLength} minutes", strtotime($order->order_time))),
               // 'url' => '/order/updateInst/' . $order->id,
                'backgroundColor' => '#000000',

            ];
        }


        return CJSON::encode($result);
    }

} 