<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "loyalty_points".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $count_on_order
 * @property integer $count_on_like
 * @property integer $is_active
 * @property integer $count_on_comment
 * @property integer $count_on_rate
 *
 * @property MtMerchant $merchant
 */
class LoyaltyPoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loyalty_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id'], 'required'],
            [['merchant_id', 'count_on_order', 'count_on_like', 'is_active', 'count_on_comment', 'count_on_rate'], 'integer'],
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
            'merchant_id' => 'Merchant ID',
            'count_on_order' => 'Count On Order',
            'count_on_like' => 'Count On Like',
            'is_active' => 'Is Active',
            'count_on_comment' => 'Count On Comment',
            'count_on_rate' => 'Count On Rate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchant()
    {
        return $this->hasOne(MtMerchant::className(), ['merchant_id' => 'merchant_id']);
    }
}
