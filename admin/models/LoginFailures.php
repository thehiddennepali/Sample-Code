<?php
class LoginFailures extends BaseActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'login_failures';
    }

    public function rules() {
        return array(
                    array('login_name', 'length', 'max'=>64),
                    array('ip_address', 'length', 'max'=>32),
                    array('date_created', 'safe'),
                    array('login_name, date_created, ip_address', 'safe', 'on'=>'search'),
                );
    }

    public function relations() {
        return array();
    }

    public function attributeLabels() {
        return array(
                'login_name'    => 'Login Name',
                'date_created'  => 'Login Time',
                'ip_address'    => 'Ip Address',
                );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('login_name',    $this->login_name,   true);
        $criteria->compare('date_created',  $this->date_created, true);
        $criteria->compare('ip_address',    $this->ip_address,   true);

        return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                    ));
    }
}
?>
