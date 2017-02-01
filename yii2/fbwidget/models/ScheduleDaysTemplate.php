<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "schedule_days_template".
 *
 * @property integer $id
 * @property string $title
 * @property integer $merchant_id
 *
 * @property MerchantSchedule[] $merchantSchedules
 * @property MerchantScheduleHistory[] $merchantScheduleHistories
 * @property MerchantScheduleHistory[] $merchantScheduleHistories0
 * @property MerchantScheduleHistory[] $merchantScheduleHistories1
 * @property MerchantScheduleHistory[] $merchantScheduleHistories2
 * @property MerchantScheduleHistory[] $merchantScheduleHistories3
 * @property MerchantScheduleHistory[] $merchantScheduleHistories4
 * @property MerchantScheduleHistory[] $merchantScheduleHistories5
 * @property MtMerchant $merchant
 * @property StaffSchedule[] $staffSchedules
 * @property StaffScheduleHistory[] $staffScheduleHistories
 * @property StaffScheduleHistory[] $staffScheduleHistories0
 * @property StaffScheduleHistory[] $staffScheduleHistories1
 * @property StaffScheduleHistory[] $staffScheduleHistories2
 * @property StaffScheduleHistory[] $staffScheduleHistories3
 * @property StaffScheduleHistory[] $staffScheduleHistories4
 * @property StaffScheduleHistory[] $staffScheduleHistories5
 * @property TimeRange[] $timeRanges
 */
class ScheduleDaysTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule_days_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id'], 'required'],
            [['merchant_id'], 'integer'],
            [['title'], 'string', 'max' => 45],
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
            'title' => 'Title',
            'merchant_id' => 'Merchant ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantSchedules()
    {
        return $this->hasMany(MerchantSchedule::className(), ['schedule_days_template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantScheduleHistories()
    {
        return $this->hasMany(MerchantScheduleHistory::className(), ['mon' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantScheduleHistories0()
    {
        return $this->hasMany(MerchantScheduleHistory::className(), ['tue' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantScheduleHistories1()
    {
        return $this->hasMany(MerchantScheduleHistory::className(), ['wed' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantScheduleHistories2()
    {
        return $this->hasMany(MerchantScheduleHistory::className(), ['thu' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantScheduleHistories3()
    {
        return $this->hasMany(MerchantScheduleHistory::className(), ['fri' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantScheduleHistories4()
    {
        return $this->hasMany(MerchantScheduleHistory::className(), ['sat' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchantScheduleHistories5()
    {
        return $this->hasMany(MerchantScheduleHistory::className(), ['sun' => 'id']);
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
    public function getStaffSchedules()
    {
        return $this->hasMany(StaffSchedule::className(), ['schedule_days_template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHistories()
    {
        return $this->hasMany(StaffScheduleHistory::className(), ['mon' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHistories0()
    {
        return $this->hasMany(StaffScheduleHistory::className(), ['tue' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHistories1()
    {
        return $this->hasMany(StaffScheduleHistory::className(), ['wed' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHistories2()
    {
        return $this->hasMany(StaffScheduleHistory::className(), ['thu' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHistories3()
    {
        return $this->hasMany(StaffScheduleHistory::className(), ['fri' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHistories4()
    {
        return $this->hasMany(StaffScheduleHistory::className(), ['sat' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHistories5()
    {
        return $this->hasMany(StaffScheduleHistory::className(), ['sun' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimeRanges()
    {
        return $this->hasMany(TimeRange::className(), ['schedule_days_template_id' => 'id']);
    }
}
