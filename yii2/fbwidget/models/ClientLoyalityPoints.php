<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "client_loyality_points".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $merchant_id
 * @property double $points
 * @property string $created_at
 * @property string $updated_at
 */
class ClientLoyalityPoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_loyality_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'merchant_id', 'points', 'created_at'], 'required'],
            [['client_id', 'merchant_id'], 'integer'],
            [['points'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => Yii::t('basicfield','Client ID'),
            'merchant_id' => Yii::t('basicfield','Merchant ID'),
            'points' => Yii::t('basicfield','Points'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getMerchant()
    {
        return $this->hasOne(MtMerchant::className(), ['merchant_id' => 'merchant_id']);
    }
}
