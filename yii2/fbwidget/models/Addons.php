<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "addon".
 *
 * @property integer $id
 * @property string $name
 * @property double $price
 * @property integer $time_in_minutes
 * @property integer $merchant_id
 *
 * @property MtMerchant $merchant
 * @property AddonHasOrder[] $addonHasOrders
 * @property Order[] $orders
 * @property AddonHasStaff[] $addonHasStaff
 * @property MerchCatHasAddon[] $merchCatHasAddons
 */
class Addons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'merchant_id'], 'required'],
            [['price'], 'number'],
            [['time_in_minutes', 'merchant_id'], 'integer'],
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
            'price' => 'Price',
            'time_in_minutes' => 'Time In Minutes',
            'merchant_id' => 'Merchant ID',
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
    public function getAddonHasOrders()
    {
        return $this->hasMany(AddonHasOrder::className(), ['addon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id' => 'order_id'])->viaTable('addon_has_order', ['addon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddonHasStaff()
    {
        return $this->hasMany(AddonHasStaff::className(), ['addon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchCatHasAddons()
    {
        return $this->hasMany(MerchCatHasAddon::className(), ['addon_id' => 'id']);
    }
    
    public function getNameWithPriceAndTime(){
        return $this->name.' '.$this->time_in_minutes.'/'.$this->price;
    }
}
