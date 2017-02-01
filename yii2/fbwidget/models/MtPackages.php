<?php

namespace fbwidget\models;

use Yii;

/**
 * This is the model class for table "mt_packages".
 *
 * @property integer $package_id
 * @property string $title
 * @property string $description
 * @property double $price
 * @property double $promo_price
 * @property integer $expiration
 * @property integer $expiration_type
 * @property integer $unlimited_post
 * @property integer $post_limit
 * @property integer $sequence
 * @property integer $status
 * @property string $date_created
 * @property string $date_modified
 * @property integer $sell_limit
 * @property integer $workers_limit
 * @property integer $is_commission
 * @property integer $commission_type
 * @property double $percent_commission
 * @property double $fixed_commission
 */
class MtPackages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_packages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'price', 'date_created'], 'required'],
            [['description'], 'string'],
            [['price', 'promo_price', 'percent_commission', 'fixed_commission'], 'number'],
            [['expiration', 'expiration_type', 'unlimited_post', 'post_limit', 'sequence', 'status', 'sell_limit', 'workers_limit', 'is_commission', 'commission_type'], 'integer'],
            [['date_created', 'date_modified'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'package_id' => 'Package ID',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'promo_price' => 'Promo Price',
            'expiration' => 'Expiration',
            'expiration_type' => 'Expiration Type',
            'unlimited_post' => 'Unlimited Post',
            'post_limit' => 'Post Limit',
            'sequence' => 'Sequence',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'date_modified' => 'Date Modified',
            'sell_limit' => 'Sell Limit',
            'workers_limit' => 'Workers Limit',
            'is_commission' => 'Is Commission',
            'commission_type' => 'Commission Type',
            'percent_commission' => 'Percent Commission',
            'fixed_commission' => 'Fixed Commission',
        ];
    }
}
