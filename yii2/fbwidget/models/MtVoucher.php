<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "mt_voucher".
 *
 * @property integer $voucher_id
 * @property string $voucher_owner
 * @property integer $merchant_id
 * @property string $joining_merchant
 * @property string $voucher_name
 * @property string $voucher_type
 * @property double $amount
 * @property string $expiration
 * @property integer $status
 * @property string $date_created
 * @property string $date_modified
 * @property integer $used_once
 * @property integer $service_id
 *
 * @property MtMerchant $merchant
 * @property CategoryHasMerchant $service
 */
class MtVoucher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_voucher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'status', 'used_once', 'service_id'], 'integer'],
            [['joining_merchant'], 'string'],
            [['voucher_name', 'voucher_type', 'amount', 'date_created'], 'required'],
            [['amount'], 'number'],
            [['expiration', 'date_created', 'date_modified'], 'safe'],
            [['voucher_owner', 'voucher_name', 'voucher_type'], 'string', 'max' => 255],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => MtMerchant::className(), 'targetAttribute' => ['merchant_id' => 'merchant_id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryHasMerchant::className(), 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'voucher_id' => 'Voucher ID',
            'voucher_owner' => 'Voucher Owner',
            'merchant_id' => 'Merchant ID',
            'joining_merchant' => 'Joining Merchant',
            'voucher_name' => 'Voucher Name',
            'voucher_type' => 'Voucher Type',
            'amount' => 'Amount',
            'expiration' => 'Expiration',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'date_modified' => 'Date Modified',
            'used_once' => 'Used Once',
            'service_id' => 'Service ID',
        ];
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
    public function getService()
    {
        return $this->hasOne(CategoryHasMerchant::className(), ['id' => 'service_id']);
    }
    
    public static function getServices($model){
        
        if($model['apply_all_services'] == 1){
            $services = 'All Services';
        }else{
            $service = json_decode($model['service_id']);
//            echo '';
//            print_r($service);
//            exit;
            
            foreach ($service as $key=>$value){
                $services .= CategoryHasMerchant::findOne(['id'=>$value])->title;
                $services .= '<br>';
                
            }
            
        }
        return $services;
        
    }
}
