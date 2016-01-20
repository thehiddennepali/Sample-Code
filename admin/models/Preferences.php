<?php
/**
 * This is the model class for table "preferences".
 *
 * The followings are the available columns in table 'preferences':
 * @property string     $id
 * @property string     $realm
 * @property string     $language
 * @property string     $timezone
 * @property integer    $payment_gateway
 * @property string     $date_format
 * @property string     $prepaid_passwd
 * @property integer    $client_id
 */
class Preferences extends BaseActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'preferences';
    }

    public function rules() {
        return array(
            array('realm, timezone', 'required'),
            array('realm', 'unique', 'caseSensitive'=>false),
            array('payment_gateway, client_id', 'numerical', 'integerOnly'=>true),
            array('realm, language, timezone, date_format', 'length', 'max'=>32),
            array('prepaid_passwd', 'length', 'max'=>16),
            array('realm, language, timezone, payment_gateway, client_id', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'payment_gateways'  => array(self::BELONGS_TO, 'PaymentGateways', 'payment_gateway'),
        );
    }

    public function attributeLabels() {
        return array(
            'realm'             => 'Realm',
            'language'          => 'Language',
            'timezone'          => 'Timezone',
            'payment_gateway'   => 'Payment Gateway',
            'date_format'       => 'Date Format',
            'prepaid_passwd'    => 'Prepaid Passwd',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('LOWERT(t.realm)',   strtolower($this->realm), true);
        $criteria->compare('language',          $this->language, true);
        $criteria->compare('timezone',          $this->timezone, true);
        $criteria->compare('payment_gateway',   $this->payment_gateway);
        $criteria->compare('client_id',         $this->client_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
?>
