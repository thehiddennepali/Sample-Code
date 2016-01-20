<?php
/**
 * This is the model class for table "login_history".
 *
 * The followings are the available columns in table 'login_history':
 * @property integer    $id
 * @property integer    $account_id
 * @property string     $login_time
 * @property string     $logout_time
 * @property string     $logout_reason
 * @property string     $ip_address Description
 * The followings are the available model relations:
 * @property Users $user
 */
class LoginHistory extends BaseActiveRecord {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'login_history';
    }
    public function rules() {
        return array(
            array('account_id', 'required'),
            array('id, account_id', 'numerical', 'integerOnly' => true),
            array('login_time, logout_time, logout_reason', 'safe'),
            array('id, account_id, login_time, logout_time, logout_reason', 'safe', 'on' => 'search'),
        );
    }
    public function relations() {
        return array(
            'accounts' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
        );
    }
    public function attributeLabels() {
        return array(
            'account_id'    => 'Account Name',
            'login_time'    => 'Login Time',
            'logout_time'   => 'Logout Time',
            'logout_reason' => 'Logout Reason',
        );
    }
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('accounts');
        $criteria->compare('LOWER(accounts.account_name)', strtolower($this->account_id), true);
        $criteria->compare('CAST(t.login_time AS DATE)', $this->login_time);
      

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
