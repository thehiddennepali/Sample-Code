<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "merchant_schedule".
 *
 * @property integer $id
 * @property string $work_date
 * @property integer $status
 * @property integer $merchant_id
 * @property string $reason
 * @property integer $schedule_days_template_id
 *
 * @property MtMerchant $merchant
 * @property ScheduleDaysTemplate $scheduleDaysTemplate
 */
class MerchantSchedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchant_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_date', 'merchant_id'], 'required'],
            [['work_date'], 'safe'],
            [['status', 'merchant_id', 'schedule_days_template_id'], 'integer'],
            [['reason'], 'string', 'max' => 520],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => MtMerchant::className(), 'targetAttribute' => ['merchant_id' => 'merchant_id']],
            [['schedule_days_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleDaysTemplate::className(), 'targetAttribute' => ['schedule_days_template_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_date' => 'Work Date',
            'status' => 'Status',
            'merchant_id' => 'Merchant ID',
            'reason' => 'Reason',
            'schedule_days_template_id' => 'Schedule Days Template ID',
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
    public function getScheduleDaysTemplate()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'schedule_days_template_id']);
    }
    
    public function getModel(){
        return $this;
    }
}
