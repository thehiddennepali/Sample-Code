<?php

namespace fbwidget\models;

use Yii;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mt_client".
 *
 * @property integer $client_id
 * @property string $social_strategy
 * @property string $first_name
 * @property string $last_name
 * @property string $email_address
 * @property string $password
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $country_code
 * @property string $location_name
 * @property string $contact_phone
 * @property string $lost_password_token
 * @property string $date_created
 * @property string $date_modified
 * @property string $last_login
 * @property string $ip_address
 * @property integer $status
 * @property string $token
 * @property integer $mobile_verification_code
 * @property string $mobile_verification_date
 * @property string $custom_field1
 * @property string $custom_field2
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 */
class Client extends ActiveRecord implements IdentityInterface
{
    
    const UPLOAD_DIR = 'client';
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    public $confirm_password, $agree, $business_note, $newpassword;
    public $image;
    /**
     * @inheritdoc
     */
    
    
    public function behaviors(){
        return [
            'imageBehavior' => [
                'class' => \fbwidget\components\ImageBehavior::className(),
                'imagePath' => self::UPLOAD_DIR,
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => 'date_modified',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    
    public static function tableName()
    {
        return 'mt_client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email_address', 'password', 'confirm_password'], 'required', 'on' => 'register'],
            [['first_name', 'last_name', 'email_address', 'street', 'contact_phone', 'dob'], 'required', 'on' => 'checkout'],
            [['location_name'], 'string'],
            [['email_address'], 'email'],
            [['email_address'], 'unique'],
            ['confirm_password','compare','compareAttribute'=>'password', 'on' => 'register'],
            [['date_created', 'date_modified', 'last_login', 'mobile_verification_date',
                'confirm_password', 'agree', 'business_note',
                'activation_key', 'newpassword', 'dob', 'image',
		'fb_identifier'
                ],
                'safe'],
            
            
            [['activation_key'], 'required', 'on' => 'activation'],
            [['status', 'mobile_verification_code'], 'integer'],
            [['social_strategy', 'password', 'zipcode'], 'string', 'max' => 100],
            [['first_name', 'last_name', 'street', 'city', 'state', 'lost_password_token', 'token', 'custom_field1', 'custom_field2', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['email_address'], 'string', 'max' => 200],
            [['country_code'], 'string', 'max' => 3],
            [['contact_phone'], 'string', 'max' => 20],
            [['ip_address'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }
    
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->dob = date('Y-m-d', strtotime($this->dob));
            return true;
        } else {
            return false;
        }
    }
    
    public function afterFind()
    {
        $this->dob = date('d-m-Y', strtotime($this->dob));

        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => Yii::t('basicfield', 'Client ID'),
            'social_strategy' => Yii::t('basicfield','Social Strategy'),
            'first_name' => Yii::t('basicfield','First Name'),
            'last_name' => Yii::t('basicfield','Last Name'),
            'email_address' => Yii::t('basicfield','Email Address'),
            'password' => Yii::t('basicfield','Password'),
            'street' => Yii::t('basicfield','You full Address'),
            'city' => Yii::t('basicfield','City'),
            'state' => Yii::t('basicfield','State'),
            'zipcode' => Yii::t('basicfield','Zipcode'),
            'country_code' => Yii::t('basicfield','Country Code'),
            'location_name' => Yii::t('basicfield','You full Address'),
            'contact_phone' => Yii::t('basicfield','Mobile Phone'),
            'lost_password_token' => Yii::t('basicfield','Lost Password Token'),
            'date_created' => Yii::t('basicfield','Date Created'),
            'date_modified' => Yii::t('basicfield','Date Modified'),
            'last_login' => Yii::t('basicfield','Last Login'),
            'ip_address' => Yii::t('basicfield','Ip Address'),
            'status' => Yii::t('basicfield','Status'),
            'token' => Yii::t('basicfield','Token'),
            'mobile_verification_code' => Yii::t('basicfield','Mobile Verification Code'),
            'mobile_verification_date' => Yii::t('basicfield','Mobile Verification Date'),
            'custom_field1' => Yii::t('basicfield','Custom Field1'),
            'custom_field2' => Yii::t('basicfield','Custom Field2'),
            'auth_key' => Yii::t('basicfield','Auth Key'),
            'password_hash' => Yii::t('basicfield','Password Hash'),
            'password_reset_token' => Yii::t('basicfield','Password Reset Token'),
            'dob' => Yii::t('basicfield','Date of Birth')
        ];
    }
    
    
    public static function findIdentity($id)
    {
        return static::findOne(['client_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email_address' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        
        
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
}
