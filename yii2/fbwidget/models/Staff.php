<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "staff".
 *
 * @property integer $id
 * @property string $name
 * @property integer $merchant_id
 * @property integer $is_active
 *
 * @property AddonHasStaff[] $addonHasStaff
 * @property CategoryHasMerchant[] $categoryHasMerchants
 * @property Order[] $orders
 * @property MtMerchant $merchant
 * @property StaffHasCategory[] $staffHasCategories
 * @property StaffSchedule[] $staffSchedules
 * @property StaffScheduleHistory[] $staffScheduleHistories
 * @property StaffVacation[] $staffVacations
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'merchant_id'], 'required'],
            [['merchant_id', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => MtMerchant::className(), 'targetAttribute' => ['merchant_id' => 'merchant_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'merchant_id' => 'Merchant ID',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddonHasStaff()
    {
        return $this->hasMany(AddonHasStaff::className(), ['staff_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryHasMerchants()
    {
        return $this->hasMany(CategoryHasMerchant::className(), ['staff_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['staff_id' => 'id']);
    }
    
    public function getAddons()
    {
        
        return $this
       ->hasMany(Addons::className(), ['id' => 'addon_id'])
       ->viaTable('addon_has_staff', ['staff_id' => 'id']);
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchant()
    {
        return $this->hasOne(MtMerchant::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffHasCategories()
    {
        return $this->hasMany(StaffHasCategory::className(), ['staff_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffSchedules()
    {
        return $this->hasMany(StaffSchedule::className(), ['staff_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHistories()
    {
        return $this->hasMany(StaffScheduleHistory::className(), ['staff_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffVacations()
    {
        return $this->hasMany(StaffVacation::className(), ['staff_id' => 'id']);
    }
    
    
    public function getLastSchedule()
    {
        return $this->hasOne(StaffScheduleHistory::className(), ['staff_id' => 'id'])->orderBy(['id'=>SORT_DESC]);
    }
    
    public function getGroupCat(){
        return $this->hasMany(CategoryHasMerchant::className(), ['staff_id' => 'id']);
    }
    
    public function getFreeTime($d,$m,$u, $service)
    {
        $merchantS = \common\models\MerchantSchedule::find()->where(['work_date' => $d, 'merchant_id' => $service->merchant_id])->one();
        $s = StaffSchedule::findOne(['work_date'=>$d,'staff_id'=>$this->id]);
        $res = [];
        
        if($merchantS){
            
            if($merchantS->scheduleDaysTemplate){
                foreach($merchantS->scheduleDaysTemplate->timeRanges as $val){
                    $va = $val->time_from;
                    $to = date('H:i', strtotime("-$m minutes", strtotime($val->time_to)));
                    do{
                        $res[] =$va;
                        $va= date('H:i',strtotime('+15 minutes',strtotime($va)));
                    }while($va <= $to);
                }
            }
            
        }
        else if($s){
            if($s->scheduleDaysTemplate){
                foreach($s->scheduleDaysTemplate->timeRanges as $val){
                    $va = $val->time_from;
                    $to = date('H:i', strtotime("-$m minutes", strtotime($val->time_to)));
                    do{
                        $res[] =$va;
                        $va= date('H:i',strtotime('+15 minutes',strtotime($va)));
                    }while($va <= $to);
                }
            }
        }else{
            if($this->lastSchedule->{strtolower(date('D',strtotime($d)))}){
                $tr = ScheduleDaysTemplate::findOne($this->lastSchedule->{strtolower(date('D',strtotime($d)))});

                foreach($tr->timeRanges as $val){

                    $va = $val->time_from;
                    $t_to = date('H:i',strtotime("-$m minutes", strtotime($val->time_to)));
                    if($va < $t_to)
                        do{
                            $res[] =$va;
                            $va= date('H:i',strtotime('+15 minutes',strtotime($va)));
                        }while($va < $t_to);
                }
            }
        }
        
        //print_r($res);

        foreach($res as $key => $val){
            
            //print_r($this->groupCat);
            
            $grupSchedule = \frontend\components\GroupScheduleHelper::checkGroupServices($this->groupCat, $d, $val, $m, $service);
            
            if(!$grupSchedule){
                //echo '';
                unset($res[$key]);
            }

            if(!\frontend\components\SingleScheduleHelper::issetOrder($d,$val,$m,$this->id,$u)){
                unset($res[$key]);
            }
        }
        return $res;
    }
}
