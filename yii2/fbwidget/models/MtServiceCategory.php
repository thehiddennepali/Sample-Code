<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "mt_service_category".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $is_active
 * @property integer $is_approved
 * @property string $approved_text
 * @property string $date_created
 * @property string $date_updated
 * @property integer $merchant_id
 * @property string $seo_title
 * @property string $url
 * @property string $seo_description
 * @property string $seo_keywords
 *
 * @property MtServiceSubcategory[] $mtServiceSubcategories
 */
class MtServiceCategory extends \yii\db\ActiveRecord
{
    const UPLOAD_DIR = 'category';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_service_category';
    }
    
    
    public function behaviors(){
        return [
            'imageBehavior' => [
                'class' => \frontend\components\ImageBehavior::className(),
                'imagePath' => self::UPLOAD_DIR,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'date_created', 'url'], 'required'],
            [['description'], 'string'],
            [['is_active', 'is_approved', 'merchant_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['title', 'seo_title', 'url', 'seo_description', 'seo_keywords'], 'string', 'max' => 255],
            [['approved_text'], 'string', 'max' => 500],
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
            'description' => 'Description',
            'is_active' => 'Is Active',
            'is_approved' => 'Is Approved',
            'approved_text' => 'Approved Text',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'merchant_id' => 'Merchant ID',
            'seo_title' => 'Seo Title',
            'url' => 'Url',
            'seo_description' => 'Seo Description',
            'seo_keywords' => 'Seo Keywords',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMtServiceSubcategories()
    {
        return $this->hasMany(MtServiceSubcategory::className(), ['category_id' => 'id']);
    }
    
    public function getTitles(){
        return Yii::t('servicecategory',$this->title);
    }
}
