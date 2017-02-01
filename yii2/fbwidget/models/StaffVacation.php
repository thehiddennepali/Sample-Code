<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "staff_vacation".
 *
 * @property integer $id
 * @property integer $staff_id
 * @property string $start_date
 * @property string $end_date
 * @property string $remark
 *
 * @property Staff $staff
 */
class StaffVacation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_vacation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id'], 'required'],
            [['staff_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['remark'], 'string', 'max' => 510],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'remark' => 'Remark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
}
