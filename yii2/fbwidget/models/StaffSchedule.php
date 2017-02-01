<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "staff_schedule".
 *
 * @property integer $id
 * @property string $work_date
 * @property string $work_time
 * @property integer $status
 * @property integer $staff_id
 * @property string $reason
 * @property integer $schedule_days_template_id
 *
 * @property Staff $staff
 * @property ScheduleDaysTemplate $scheduleDaysTemplate
 * @property StaffScheduleHasTimeRange[] $staffScheduleHasTimeRanges
 * @property TimeRange[] $timeRanges
 */
class StaffSchedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_date', 'work_time', 'staff_id'], 'required'],
            [['work_date', 'work_time'], 'safe'],
            [['status', 'staff_id', 'schedule_days_template_id'], 'integer'],
            [['reason'], 'string', 'max' => 520],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
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
            'work_time' => 'Work Time',
            'status' => 'Status',
            'staff_id' => 'Staff ID',
            'reason' => 'Reason',
            'schedule_days_template_id' => 'Schedule Days Template ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleDaysTemplate()
    {
        return $this->hasOne(ScheduleDaysTemplate::className(), ['id' => 'schedule_days_template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffScheduleHasTimeRanges()
    {
        return $this->hasMany(StaffScheduleHasTimeRange::className(), ['staff_schedule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimeRanges()
    {
        return $this->hasMany(TimeRange::className(), ['id' => 'time_range_id'])->viaTable('staff_schedule_has_time_range', ['staff_schedule_id' => 'id']);
    }
}
