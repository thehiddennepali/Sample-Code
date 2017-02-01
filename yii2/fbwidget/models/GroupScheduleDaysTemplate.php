<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "group_schedule_days_template".
 *
 * @property integer $id
 * @property string $title
 * @property integer $merchant_id
 *
 * @property GroupTimeRange[] $groupTimeRanges
 */
class GroupScheduleDaysTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_schedule_days_template';
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
    public function getGroupTimeRanges()
    {
        return $this->hasMany(GroupTimeRange::className(), ['group_schedule_days_template_id' => 'id']);
    }
}
