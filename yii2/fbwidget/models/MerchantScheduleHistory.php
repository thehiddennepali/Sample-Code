<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "merchant_schedule_history".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $mon
 * @property integer $tue
 * @property integer $wed
 * @property integer $thu
 * @property integer $fri
 * @property integer $sat
 * @property integer $sun
 * @property string $change_date
 *
 * @property MtMerchant $merchant
 * @property ScheduleDaysTemplate $mon0
 * @property ScheduleDaysTemplate $tue0
 * @property ScheduleDaysTemplate $wed0
 * @property ScheduleDaysTemplate $thu0
 * @property ScheduleDaysTemplate $fri0
 * @property ScheduleDaysTemplate $sat0
 * @property ScheduleDaysTemplate $sun0
 */
class MerchantScheduleHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchant_schedule_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id'], 'required'],
            [['merchant_id', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'], 'integer'],
            [['change_date'], 'safe'],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => MtMerchant::className(), 'targetAttribute' => ['merchant_id' => 'merchant_id']],
            [['mon'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleDaysTemplate::className(), 'targetAttribute' => ['mon' => 'id']],
            [['tue'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleDaysTemplate::className(), 'targetAttribute' => ['tue' => 'id']],
            [['wed'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleDaysTemplate::className(), 'targetAttribute' => ['wed' => 'id']],
            [['thu'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleDaysTemplate::className(), 'targetAttribute' => ['thu' => 'id']],
            [['fri'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleDaysTemplate::className(), 'targetAttribute' => ['fri' => 'id']],
            [['sat'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleDaysTemplate::className(), 'targetAttribute' => ['sat' => 'id']],
            [['sun'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleDaysTemplate::className(), 'targetAttribute' => ['sun' => 'id']],
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
            'mon' => 'Mon',
            'tue' => 'Tue',
            'wed' => 'Wed',
            'thu' => 'Thu',
            'fri' => 'Fri',
            'sat' => 'Sat',
            'sun' => 'Sun',
            'change_date' => 'Change Date',
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
    public function getMon0()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'mon']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTue0()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'tue']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWed0()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'wed']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThu0()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'thu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFri0()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'fri']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSat0()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'sat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSun0()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'sun']);
    }
}
