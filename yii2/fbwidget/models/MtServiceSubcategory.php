<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "mt_service_subcategory".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $description
 * @property integer $is_active
 * @property integer $is_approved
 * @property string $approved_text
 * @property string $date_created
 * @property string $date_updated
 * @property integer $merchant_id
 * @property string $url
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property integer $is_group
 *
 * @property CategoryHasMerchant[] $categoryHasMerchants
 * @property MtServiceCategory $category
 */
class MtServiceSubcategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_service_subcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'date_created', 'url'], 'required'],
            [['category_id', 'is_active', 'is_approved', 'merchant_id', 'is_group'], 'integer'],
            [['description'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['title', 'url', 'seo_title', 'seo_description', 'seo_keywords'], 'string', 'max' => 255],
            [['approved_text'], 'string', 'max' => 500],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MtServiceCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'description' => 'Description',
            'is_active' => 'Is Active',
            'is_approved' => 'Is Approved',
            'approved_text' => 'Approved Text',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'merchant_id' => 'Merchant ID',
            'url' => 'Url',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
            'seo_keywords' => 'Seo Keywords',
            'is_group' => 'Is Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryHasMerchants()
    {
        return $this->hasMany(CategoryHasMerchant::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(MtServiceCategory::className(), ['id' => 'category_id']);
    }
}
