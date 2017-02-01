<?php

namespace fbwidget\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "mt_address_book".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $location_name
 * @property string $country_code
 * @property integer $as_default
 * @property string $date_created
 * @property string $date_modified
 * @property string $ip_address
 */
class MtAddressBook extends ActiveRecord
{
	
	public $notevoucher;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_address_book';
    }
    
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => 'date_modified',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'street', 'city', 'state', 'zipcode', 'location_name',
                'country_code'], 'required', 'on' => 'billing'],
	    
	    [['city',  'zipcode', 'street',
                'first_name', 'last_name', 'notevoucher'], 'required', 'on' => 'giftvoucher'],
	    
            [['client_id', 'as_default'], 'integer'],
            [['date_created', 'date_modified', 'ip_address', 'first_name', 'last_name', 'notevoucher'], 'safe'],
            [['street', 'city', 'state', 'zipcode', 'location_name'], 'string', 'max' => 255],
            [['country_code'], 'string', 'max' => 3],
            [['ip_address'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'street' => Yii::t('basicfield','Street'),
            'city' => Yii::t('basicfield','City'),
            'state' => Yii::t('basicfield','State'),
            'zipcode' => Yii::t('basicfield','Zipcode'),
            'location_name' => Yii::t('basicfield','Full Address'),
            'country_code' => Yii::t('basicfield','Country Code'),
            'as_default' => Yii::t('basicfield','As Default'),
            'date_created' => 'Date Created',
            'date_modified' => 'Date Modified',
            'ip_address' => 'Ip Address',
	    'noteVoucher' => 'Note on the voucher'
        ];
    }
}
