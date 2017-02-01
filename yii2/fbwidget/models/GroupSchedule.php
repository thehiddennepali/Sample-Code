<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "group_schedule".
 *
 * @property integer $id
 * @property string $work_date
 * @property integer $status
 * @property integer $group_id
 * @property string $reason
 * @property integer $schedule_days_template_id
 *
 * @property CategoryHasMerchant $group
 */
class GroupSchedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_date', 'group_id'], 'required'],
            [['work_date'], 'safe'],
            [['status', 'group_id', 'schedule_days_template_id'], 'integer'],
            [['reason'], 'string', 'max' => 520],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryHasMerchant::className(), 'targetAttribute' => ['group_id' => 'id']],
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
            'group_id' => 'Group ID',
            'reason' => 'Reason',
            'schedule_days_template_id' => 'Schedule Days Template ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(CategoryHasMerchant::className(), ['id' => 'group_id']);
    }
    
    public function getModel(){
        return $this;
    }
    
    public function getGroupScheduleDaysTemplate()
    {
        return $this->hasOne(GroupScheduleDaysTemplate::className(), ['id' => 'schedule_days_template_id']);
    }
}
