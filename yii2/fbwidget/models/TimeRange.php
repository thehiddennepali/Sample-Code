<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "time_range".
 *
 * @property integer $id
 * @property string $time_from
 * @property string $time_to
 * @property string $additional_time
 * @property integer $schedule_days_template_id
 *
 * @property StaffScheduleHasTimeRange[] $staffScheduleHasTimeRanges
 * @property StaffSchedule[] $staffSchedules
 * @property ScheduleDaysTemplate $scheduleDaysTemplate
 */
class TimeRange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'time_range';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time_from', 'time_to', 'schedule_days_template_id'], 'required'],
            [['schedule_days_template_id'], 'integer'],
            [['time_from', 'time_to', 'additional_time'], 'string', 'max' => 45],
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
            'time_from' => 'Time From',
            'time_to' => 'Time To',
            'additional_time' => 'Additional Time',
            'schedule_days_template_id' => 'Schedule Days Template ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHasTimeRanges()
    {
        return $this->hasMany(StaffScheduleHasTimeRange::className(), ['time_range_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffSchedules()
    {
        return $this->hasMany(StaffSchedule::className(), ['id' => 'staff_schedule_id'])->viaTable('staff_schedule_has_time_range', ['time_range_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleDaysTemplate()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'schedule_days_template_id']);
    }
}
