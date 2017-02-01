<?php
namespace fbwidget\models;

/**
 * This is the model class for table "{{option}}".
 *
 * The followings are the available columns in table '{{option}}':
 * @property integer $id
 * @property integer $merchant_id
 * @property string $option_name
 * @property string $option_value
 */
class Option extends \yii\db\ActiveRecord
{
    public $values = [];

    public static function getValByName($name, $language = 'en')
    {
        
        $model = static::findOne(['option_name' => $name, 'language_code' => $language]);
        if ($model)
            return $model->option_value;
        else
            return '';

    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'mt_option';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('option_name', 'required', 'on' => 'settings'),
            array('merchant_id', 'numerical', 'integerOnly' => true),
            array('option_name', 'length', 'max' => 255),
            ['values, option_value, language_code', 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, merchant_id, option_name, option_value', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'merchant_id' => Yii::t('default', 'Merchant'),
            'option_name' => Yii::t('default', 'option name'),
            'values[customer_ask_address]' => Yii::t('default', 'Disabled popup asking customer address'),
            'values[merchant_changeorder_sms]' => Yii::t("default", "Disabled send sms/email after change order"),
            'values[website_disabled_guest_checkout]' => Yii::t("default", "Disabled Guest Checkout"),
            'values[admin_activated_menu]' => Yii::t("default", "Default Menu"),
            'values[disabled_cart_sticky]' => Yii::t("default", "Disabled Sticky Cart"),
            'values[website_enabled_map_address]' => Yii::t("default", "Enabled Map Address"),
            'values[disabled_featured_merchant]' => Yii::t("default", "Disabled"),
            'values[disabled_subscription]' => Yii::t("default", "Disabled"),
            'values[merchant_disabled_registration]' => Yii::t("default", "Disabled Registration"),
            'values[merchant_email_verification]' => Yii::t("default", "Disabled Verification"),
            'values[merchant_payment_enabled]' => Yii::t("default", "Enabled Payment"),
            'values[admin_enabled_paypal]' => Yii::t("default", "Disabled Paypal"),
            'values[admin_enabled_card]' => Yii::t("default", "Disabled Card Payment"),
            'values[admin_exclude_cod_balance]' => Yii::t("default", "Exclude All Offline Payment from admin balance"),
            'values[admin_commission_enabled]' => Yii::t("default", "Enabled Commission"),
            'values[admin_disabled_membership]' => Yii::t("default", "Disabled Membership"),
            'values[admin_include_merchant_cod]' => Yii::t("default", "Include Cash Payment on merchant balance"),
            'values[commission_total_order]' => Yii::t("default", "Set commission on"),
            'values[email_provider]' => Yii::t("default", "email provider"),
            'values[contact_map]' => Yii::t("default", "Display Google Map"),
            'values[social_flag]' => Yii::t("default", "Disabled Social Icon"),
            'values[admin_merchant_share]' => Yii::t("default", "Disabled restaurant share"),
            'values[fb_flag]' => Yii::t("default", "Disabled Facebook Login"),
            'values[google_login_enabled]' => Yii::t("default", "Enabled Google Login"),
            'values[admin_paypal_mode]' => Yii::t("default", "Mode"),
            'option_value' => Yii::t('default', 'Option Value'),
            'values[admin_commission_type]' => Yii::t('default', 'Admin Commission Type'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    

//    public function beforeSave()
//    {
//        if (parent::beforeSave()) {
//
//            if ($this->values) {
//                foreach ($this->values as $key => $val) {
//                    $model = self::model()->findByAttributes(['option_name' => $key]);
//                    if (empty($model)) $model = new self;
//                    $model->scenario = 'settings';
//                    $model->option_name = $key;
//                    $model->option_value = $val;
//                    $model->save();
//                }
//
//                return false;
//            }
//            return true;
//        } else
//            return false;
//    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Option the static model class
     */
    
}
