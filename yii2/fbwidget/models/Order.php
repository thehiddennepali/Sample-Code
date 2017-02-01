<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $client_id
 * @property integer $payment_type
 * @property string $client_name
 * @property string $client_phone
 * @property string $client_email
 * @property string $order_time
 * @property integer $category_id
 * @property integer $staff_id
 * @property integer $merchant_id
 * @property string $create_time
 * @property integer $is_group
 * @property integer $source_type
 * @property integer $order_id
 * @property double $price
 * @property string $more_info
 *
 * @property AddonHasOrder[] $addonHasOrders
 * @property Addon[] $addons
 * @property Client $client
 * @property CategoryHasMerchant $category
 * @property Staff $staff
 */
class Order extends \yii\db\ActiveRecord
{
    //public $addons;
    const SOURCE_PHONE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'client_id', 'payment_type', 'category_id', 'staff_id', 'merchant_id', 'is_group', 'source_type', 'order_id'], 'integer'],
            [['order_time', 'category_id', 'create_time', 'order_id'], 'required'],
            [['order_time', 'create_time',
                'discounted_amount', 
                'discount_percentage', 
                'percent_commision', 
                'total_commission', 
                'commision_ontop', 
                'merchant_earnings',
                'voucher_code', 
                'voucher_amount', 
                'voucher_type',
                'no_of_seats',
                'loyalty_points',
                'user_birthday_coupon_id',
                'payment_status'
                ], 'safe'],
            [['price'], 'number'],
            [['client_name', 'client_phone', 'client_email'], 'string', 'max' => 50],
            [['more_info'], 'string', 'max' => 511],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryHasMerchant::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => Yii::t('basicfield','Status'),
            'client_id' => 'Client ID',
            'payment_type' => Yii::t('basicfield','Payment Type'),
            'client_name' => Yii::t('basicfield','Client Name'),
            'client_phone' => Yii::t('basicfield','Client Phone'),
            'client_email' => Yii::t('basicfield','Client Email'),
            'order_time' => Yii::t('basicfield','Order Time'),
            'category_id' => Yii::t('basicfield','Category ID'),
            'staff_id' => Yii::t('basicfield','Staff ID'),
            'merchant_id' => Yii::t('basicfield','Merchant ID'),
            'create_time' => Yii::t('basicfield','Create Time'),
            'is_group' => Yii::t('basicfield','Is Group'),
            'source_type' => Yii::t('basicfield','Source Type'),
            'order_id' => 'Order ID',
            'price' => Yii::t('basicfield','Price'),
            'more_info' => Yii::t('basicfield','More Info'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddonHasOrders()
    {
        return $this->hasMany(AddonHasOrder::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddons()
    {
        return $this->hasMany(Addons::className(), ['id' => 'addon_id'])
                ->viaTable('addon_has_order', ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['client_id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoryHasMerchant::className(), ['id' => 'category_id']);
    }
    
    public function getMerchant()
    {
        return $this->hasOne(MtMerchant::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
    
    
    public function getOrderTimeLength()
    {
        return $this->category->getTimeOfService() + $this->getAddonsTimeLength();
    }

    public function getAddonsTimeLength()
    {
        $l =0;
        foreach($this->addons as $val){
            $l += $val->time_in_minutes;
        }
        return $l;
    }
    
    public function beforeSave($insert)
    {
        
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) $this->order_id = time() . $this->category_id;
            if ($this->isNewRecord) $this->source_type = self::SOURCE_PHONE;
            if($this->isNewRecord) $this->create_time = date("Y-m-d H:i:s");
                return true;
            } else {
                return false;
            }
        
        
        return parent::beforeSave();
    }
    
    
    public static function getPrice($model){
        $price = $model->price;
        $session = Yii::$app->session;
        if(isset($session['couponid'])){
            
            $voucher = MtVoucher::findOne(['voucher_id' => $session['couponid']]);
            
                
                if(count($voucher) > 0 && $voucher->expiration >= date('Y-m-d')){

                    $amount = 0;
                    if($voucher->apply_all_services == 1){
                        $amount = $price;

                    }else{
                        if(!empty($voucher->service_id)){
                        $services = json_decode($voucher->service_id);
                        
                        
                            foreach ($services as $key=>$val){
                                if($model->category_id == $val){
                                    $amount = $price;

                                }
                            }
                        }

                    }
                    
                    
                    
                    if($amount != 0){
                        
                        //print_r($voucher->attributes);

                        if($voucher->voucher_type == 0){
                            $discount = number_format($voucher->amount, 2, '.', '');
                            $dis  = '€ '.$discount;
                            $couponPer = '€';
                        }else{
                            $couponPer = $voucher->amount.'%';
                            $discount =  ($voucher->amount / 100) * $amount;
                            
                            $discount = number_format($discount, 2, '.', '');
                            $dis  = '€ '.$discount;
                        }

                    }
                    
                    $price = ($price - $discount) ;

                    


                }
            
        }
        
        $price = $price - $model->loyalty_points;
        
        return $price;
        
    }
    
    public static function getCommision($merchantId, $total){
        
        $merchant  = MtMerchant::findOne($merchantId);
        $adminCommission =  \fbwidget\models\Option::getValByName('admin_commission_type');
        $commissionOnTotalOrSub = \fbwidget\models\Option::getValByName('commission_total_order');
        
        
            if($merchant->commission_type == 3){
                $commissionType = 'fixed';
                if(!empty($merchant->fixed_commission)){
                    $commissionFixed = $merchant->fixed_commission;
                }
            }else if($merchant->commission_type == 4){
                $commissionType = 'percentage';
                if(!empty($merchant->percent_commission)){
                    $commissionPer = $merchant->percent_commission;
                }
            }
            else{
                $commissionType = $adminCommission;
                $commissionPer = \fbwidget\models\Option::getValByName('admin_commission_percent');
                $commissionFixed = \fbwidget\models\Option::getValByName('admin_commission_fixed_val');
            }
            
            if($commissionType == "fixed"){
                $commission = $commissionFixed;
                
            }else{
                $commission = ($commissionPer/100) * $total;
            }
            
            return [
                'total_commision' => $commission,
                'percent_commision' => $commissionPer,
                'merchant_earnings' => ( $total  - $commission )
                ];
        
    }
}
