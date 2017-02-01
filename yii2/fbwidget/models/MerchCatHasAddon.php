<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "merch_cat_has_addon".
 *
 * @property integer $id
 * @property integer $m_c_id
 * @property integer $addon_id
 *
 * @property Addon $addon
 * @property CategoryHasMerchant $mC
 */
class MerchCatHasAddon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merch_cat_has_addon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_c_id', 'addon_id'], 'required'],
            [['m_c_id', 'addon_id'], 'integer'],
            [['addon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addon::className(), 'targetAttribute' => ['addon_id' => 'id']],
            [['m_c_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryHasMerchant::className(), 'targetAttribute' => ['m_c_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'm_c_id' => 'M C ID',
            'addon_id' => 'Addon ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddon()
    {
        return $this->hasOne(Addons::className(), ['id' => 'addon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMC()
    {
        return $this->hasOne(CategoryHasMerchant::className(), ['id' => 'm_c_id']);
    }
}
