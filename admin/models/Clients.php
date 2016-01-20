<?php
/**
 * This is the model class for table "clients".
 *
 * The followings are the available columns in table 'clients':
 * @property integer    $id
 * @property string     $client_name
 * @property string     $company_name
 * @property string     $login_name
 * @property string     $email
 * @property string     $address
 * @property string     $city
 * @property string     $state
 * @property string     $country
 * @property string     $zipcode
 * @property string     $office_number
 * @property string     $cell_number
 * @property string     $subscription_status
 * @property string     $client_code
 * @property integer    $hotspots_purchased
 * @property integer    $hotspots_used
 * @property string     $next_billing_date
 * @property string     $date_created
 *
 */
class Clients extends BaseActiveRecord {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'clients';
    }

    public function rules() {
        return array(
            array('client_name, email, address, country, state, office_number', 'required'),
            array('client_name', 'unique', 'caseSensitive'=>false),
            array('state, country, client_name, company_name, login_name', 'match', 'pattern'=>'/^([a-zA-Z0-9- ])+$/'),
            array('email', 'email'),
            array('email', 'unique'),
            array('hotspots_purchased, hotspots_used', 'numerical', 'integerOnly'=>true),
            array('company_name, email', 'length', 'max'=>128),
            array('client_name, login_name', 'length', 'max'=>64),
            array('address', 'length', 'max'=>512),
            array('subscription_status', 'length', 'max'=>32),
            array('city', 'length', 'max'=>256),
            array('city', 'match', 'pattern'=>'/^([a-zA-Z ])+$/'),
            array('zipcode, office_number, cell_number', 'length', 'max'=>16),
            array('next_billing_date, date_created', 'safe'),
            array('client_name, company_name, email, address, country, state, city, zipcode, office_number, cell_number, date_created', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array();
    }

    public function attributeLabels() {
        return array(
            'client_name'           => 'Client Name',
            'company_name'          => 'Company Name',
            'login_name'            => 'Login Name',
            'email'                 => 'Email',
            'address'               => 'Address',
            'country'               => 'Country',
            'state'                 => 'State',
            'city'                  => 'City',
            'zipcode'               => 'Zipcode',
            'office_number'         => 'Office Number',
            'cell_number'           => 'Cell Number',
            'subscription_status'   => 'Status',
            'next_billing_date'     => 'Next Billing Date',
            'date_created'          => 'Date Created',
        );
    }

    public function search() {
        $criteria = new DatetimeSearchCirteria;
        $criteria->compare('LOWER(t.client_name)',      strtolower($this->client_name),     true);
        $criteria->compare('LOWER(t.company_name)',     strtolower($this->company_name),    true);
        $criteria->compare('LOWER(t.login_name)',       strtolower($this->login_name),      true);
        $criteria->compare('LOWER(t.email)',            strtolower($this->email),           true);
        $criteria->compare('LOWER(t.address)',          strtolower($this->address),         true);
        $criteria->compare('country',                   $this->country,                     true);
        $criteria->compare('state',                     $this->state,                       true);
        $criteria->compare('LOWER(t.city)',             strtolower($this->city),            true);
        $criteria->compare('LOWER(t.zipcode)',          strtolower($this->zipcode),         true);
        $criteria->compare('LOWER(t.office_number)',    strtolower($this->office_number),   true);
        $criteria->compare('LOWER(t.cell_number)',      strtolower($this->cell_number),     true);
        $criteria->addDateCriteria('t.date_created',            $this->date_created,                true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
?>
