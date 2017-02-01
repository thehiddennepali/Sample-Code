<?php

namespace fbwidget\models;

use Yii;
use Addon;
use fbwidget\components\UrlHelper;
//use LoyaltyPoints;
use fbwidget\models\MerchantSchedule;
use fbwidget\models\MerchantScheduleHistory;
use fbwidget\models\ScheduleDaysTemplate;
use fbwidget\models\Staff;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "mt_merchant".
 *
 * @property integer $merchant_id
 * @property string $service_name
 * @property string $service_phone
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $country_code
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $post_code
 * @property string $cuisine
 * @property string $service
 * @property integer $free_delivery
 * @property string $delivery_estimation
 * @property string $username
 * @property string $password
 * @property string $activation_key
 * @property string $activation_token
 * @property integer $status
 * @property string $date_created
 * @property string $date_modified
 * @property string $date_activated
 * @property string $last_login
 * @property string $ip_address
 * @property integer $package_id
 * @property double $package_price
 * @property string $membership_expired
 * @property integer $payment_steps
 * @property integer $is_featured
 * @property integer $is_ready
 * @property integer $is_sponsored
 * @property string $sponsored_expiration
 * @property string $lost_password_code
 * @property integer $user_lang
 * @property string $membership_purchase_date
 * @property integer $sort_featured
 * @property integer $is_commission
 * @property double $percent_commission
 * @property double $fixed_commission
 * @property string $session_token
 * @property integer $commission_type
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $url
 * @property string $manager_username
 * @property string $manager_password
 * @property integer $manager_extended
 * @property string $fb
 * @property string $tw
 * @property string $gl
 * @property string $yt
 * @property string $it
 * @property string $paypall_id
 * @property string $paypall_pass
 * @property string $gmap_altitude
 * @property string $gmap_latitude
 * @property integer $gallery_id
 * @property string $address
 * @property string $vk
 * @property string $pr
 * @property integer $is_purchase
 * @property string $description
 *
 * @property Addon[] $addons
 * @property CategoryHasMerchant[] $categoryHasMerchants
 * @property LoyaltyPoints[] $loyaltyPoints
 * @property MerchantSchedule[] $merchantSchedules
 * @property MerchantScheduleHistory[] $merchantScheduleHistories
 * @property MtVoucher[] $mtVouchers
 * @property ScheduleDaysTemplate[] $scheduleDaysTemplates
 * @property Staff[] $staff
 */
class MtMerchant extends ActiveRecord implements IdentityInterface
{
    
    static $days = ['mon'=>'Monday',
                    'tue'=>'Tuesday',
                    'wed' => 'Wednesday',
                    'thu' => 'Thursday',
                    'fri' => 'Friday',
                    'sat' => 'Saturday',
                    'sun' => 'Sunday',
        
            ];
    const UPLOAD_DIR = 'merchant';
    const UPLOAD_DIR_MAIN = 'merchant/main';
    public $confirm_password, $image, $image_big;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_merchant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_name', 'service_phone', 'contact_name', 'contact_phone', 'contact_email', 'street', 'city', 'state', 'post_code', 'package_id', 'username', 'password', 'confirm_password', 'country_code'], 'required'],
            [['street', 'cuisine', 'description'], 'string'],
            [['free_delivery', 'status', 'package_id', 'payment_steps', 'is_featured', 'is_ready', 'is_sponsored', 'user_lang', 'sort_featured', 'is_commission', 'commission_type', 'manager_extended', 'gallery_id', 'is_purchase'], 'integer'],
            [['date_created', 'date_modified', 'date_activated', 'last_login', 'membership_expired', 'sponsored_expiration', 'membership_purchase_date'], 'safe'],
            [['package_price', 'percent_commission', 'fixed_commission'], 'number'],
            [['service_name', 'contact_name', 'contact_email', 'city', 'state', 'service', 'session_token', 'seo_title', 'seo_description', 'seo_keywords', 'url', 'fb', 'tw', 'gl', 'yt', 'it', 'paypall_id', 'paypall_pass', 'vk', 'pr'], 'string', 'max' => 255],
            [['service_phone', 'contact_phone', 'post_code', 'delivery_estimation', 'username', 'password', 'activation_token', 'manager_username', 'manager_password'], 'string', 'max' => 100],
            [['country_code'], 'string', 'max' => 3],
            [['activation_key', 'ip_address', 'lost_password_code'], 'string', 'max' => 50],
            [['gmap_altitude', 'gmap_latitude'], 'string', 'max' => 10],
            [['address'], 'string', 'max' => 510],
            [['confirm_password', 'password_hash', 'password_reset_token', 'auth_key', 'language_id'], 'safe'],
            [['contact_email'], 'email'],
            [['contact_email', 'username'], 'unique'],
            ['confirm_password','compare','compareAttribute'=>'password'],
        ];
    }
    
    public function behaviors(){
        return [
            'imageBehavior' => [
                'class' => \frontend\components\ImageBehavior::className(),
                'imagePath' => self::UPLOAD_DIR,
            ],
            'imageBehavior2' => [
                'class' => \frontend\components\ImageBehavior::className(),
                'imagePath' => self::UPLOAD_DIR_MAIN,
                'imageField' => 'image_big'

            ],
            'galleryBehavior' => array(
                'class' => \common\extensions\gallerymanager\GalleryBehavior::className(),
                'idAttribute' => 'gallery_id',
                'versions' => array(
                    'small' => array(
                        'centeredpreview' => array(98, 98),
                    ),
                    'medium' => array(
                        'resize' => array(800, null),
                    )
                ),
                'name' => true,
                'description' => true,
            ),
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'merchant_id' => 'Merchant ID',
            'service_name' => 'Service Name',
            'service_phone' => 'Service Phone',
            'contact_name' => 'Contact Name',
            'contact_phone' => 'Contact Phone',
            'contact_email' => 'Contact Email',
            'country_code' => 'Country Code',
            'street' => 'Street',
            'city' => 'City',
            'state' => 'State',
            'post_code' => 'Post Code',
            'cuisine' => 'Cuisine',
            'service' => 'Service',
            'free_delivery' => 'Free Delivery',
            'delivery_estimation' => 'Delivery Estimation',
            'username' => 'Username',
            'password' => 'Password',
            'activation_key' => 'Activation Key',
            'activation_token' => 'Activation Token',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'date_modified' => 'Date Modified',
            'date_activated' => 'Date Activated',
            'last_login' => 'Last Login',
            'ip_address' => 'Ip Address',
            'package_id' => 'Package ID',
            'package_price' => 'Package Price',
            'membership_expired' => 'Membership Expired',
            'payment_steps' => 'Payment Steps',
            'is_featured' => 'Is Featured',
            'is_ready' => 'Is Ready',
            'is_sponsored' => 'Is Sponsored',
            'sponsored_expiration' => 'Sponsored Expiration',
            'lost_password_code' => 'Lost Password Code',
            'user_lang' => 'User Lang',
            'membership_purchase_date' => 'Membership Purchase Date',
            'sort_featured' => 'Sort Featured',
            'is_commission' => 'Is Commission',
            'percent_commission' => 'Percent Commission',
            'fixed_commission' => 'Fixed Commission',
            'session_token' => 'Session Token',
            'commission_type' => 'Commission Type',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
            'seo_keywords' => 'Seo Keywords',
            'url' => 'Url',
            'manager_username' => 'Manager Username',
            'manager_password' => 'Manager Password',
            'manager_extended' => 'Manager Extended',
            'fb' => 'Fb',
            'tw' => 'Tw',
            'gl' => 'Gl',
            'yt' => 'Yt',
            'it' => 'It',
            'paypall_id' => 'Paypall ID',
            'paypall_pass' => 'Paypall Pass',
            'gmap_altitude' => 'Gmap Altitude',
            'gmap_latitude' => 'Gmap Latitude',
            'gallery_id' => 'Gallery ID',
            'address' => 'Address',
            'vk' => 'Vk',
            'pr' => 'Pr',
            'is_purchase' => 'Is Purchase',
            'description' => 'Description',
        ];
    }
    
    public static function getSeo($model, $description){
        
        $sql = 'SELECT chm.category_id, ssc.*, ssc.title as subtitle,sc.*  from category_has_merchant as chm 
        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
        LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
        WHERE chm.merchant_id=' . $model->merchant_id . ' group by sc.id';

        $query = Yii::$app->db->createCommand($sql)->queryAll();
        
        $service = '';
        $mservice = '';
        foreach ($query as $key => $cat) {
            $service .= $cat['title'];
            $mservice .= $cat['subtitle'];
            if ((sizeof($query) - 1) > $key) {
                $mservice .= ' | ';
                $service .= ' / ';
            }
        }
        
        $variable['merchant_name'] = $model->service_name;
        $variable['merchant_description'] = $model->description;
        $variable['merchant_city'] = $model->city;
        $variable['merchant_category'] = $service;
        $variable['merchant_subcategory'] = $mservice;
        
        foreach($variable as $key => $value)
        {
                //print_r($value);
                $description = str_replace('{'.$key.'}', $value, $description);
        }
        
        return strip_tags($description);
        
    }

    /**
     * @return ActiveQuery
     */
    public function getAddons()
    {
        return $this->hasMany(Addons::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategoryHasMerchants()
    {
        return $this->hasMany(CategoryHasMerchant::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoints::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMerchantSchedules()
    {
        return $this->hasMany(MerchantSchedule::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMerchantScheduleHistories()
    {
        return $this->hasMany(MerchantScheduleHistory::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMtVouchers()
    {
        return $this->hasMany(MtVoucher::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getScheduleDaysTemplates()
    {
        return $this->hasMany(ScheduleDaysTemplate::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['merchant_id' => 'merchant_id']);
    }
    
    public function getPackage()
    {
        return $this->hasOne(MtPackages::className(), ['package_id' => 'package_id']);
    }
    
    
    public function getLastSchedule()
    {
        return $this->hasOne(MerchantScheduleHistory::className(), ['merchant_id' => 'merchant_id'])->orderBy(['id'=>SORT_DESC]);
    }
    
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if(empty($this->url)) $this->url = UrlHelper::getSlugFromString($this->service_name);
            
            if(!$this->isNewRecord) $this->date_modified = date("Y-m-d H:i:s");
            if($this->isNewRecord) $this->date_created = date("Y-m-d H:i:s");
            if(!$this->isNewRecord && $this->is_ready && !$this->is_ready_old){
                $this->date_activated = date("Y-m-d H:i:s");
                if($this->package->expiration_type)
                    $this->membership_expired = date("Y-m-d H:i:s",strtotime('+'.$this->package->expiration.' days'));
                    else

                $this->membership_expired = date("Y-m-d H:i:s",strtotime('+1 year'));

            }
            return true;
        } else
            return false;
    }
    
    public static function getLatLang($keyword){
        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($keyword) . "&sensor=false";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);
        
        $lat = "";
        $long = "";
        if(isset($geoloc['results'][0])){
            
            $lat = $geoloc['results'][0]['geometry']['location']['lat'];
            $long = $geoloc['results'][0]['geometry']['location']['lng'];
        }
        
        return ['lat'=>$lat,'long'=>$long];
        
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
    
    public static function getSchedule($squerySchedule){
        
        
        
        $array = [];
        foreach($squerySchedule as $key=>$value){
            
            if($key == 'mon' || $key == 'tue' || $key == 'wed' || $key == 'thu' || $key == 'fri' || $key == 'sat' || $key == 'sun'){
                $queryMonday = "";
                if(!empty($value)){
                    $mondaySql  = 'SELECT tr.*,sdt.* FROM schedule_days_template AS sdt 
                            LEFT JOIN time_range AS tr ON sdt.id=tr.schedule_days_template_id
                            where sdt.id='.$value;

                    $queryMonday = Yii::$app->db->createCommand($mondaySql)->queryAll();
                }
                $array[$key] = $queryMonday;
            }

        }
        
        return $array;
    }
    
    public function getLanguage()
    {
        return $this->hasOne(\common\models\Language::className(), ['id' => 'language_id']);
    }
    
    public function getGiftVoucherSetting(){
	    return $this->hasOne(\common\models\GiftVoucherSetting::className(), ['merchant_id'=> 'merchant_id']);
    }
    
	public function getCurrency(){
		
		return $this->hasOne(\common\models\Currency::className(), ['currency_code' => 'currency_id']);
	}
    
}
