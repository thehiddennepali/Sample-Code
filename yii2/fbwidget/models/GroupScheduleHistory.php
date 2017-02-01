<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "group_schedule_history".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $mon
 * @property integer $tue
 * @property integer $wed
 * @property integer $thu
 * @property integer $fri
 * @property integer $sat
 * @property integer $sun
 * @property string $change_date
 *
 * @property CategoryHasMerchant $group
 */
class GroupScheduleHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_schedule_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id'], 'required'],
            [['group_id', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'], 'integer'],
            [['change_date'], 'safe'],
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
            'group_id' => 'Group ID',
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
    public function getGroup()
    {
        return $this->hasOne(CategoryHasMerchant::className(), ['id' => 'group_id']);
    }
}
