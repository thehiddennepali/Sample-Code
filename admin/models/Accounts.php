<?php
/**
 * This is the model class for table "accounts".
 *
 * The followings are the available columns in table 'accounts':
 * @property integer    $id
 * @property string     $account_name
 * @property string     $login_name
 * @property string     $password
 * @property string     $email
 * @property integer    $role_group_id
 * @property integer    $is_visible
 * @property string     $date_created
 * @property integer    $client_id
 */
class Accounts extends BaseActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'accounts';
    }

    public function rules() {
        return array(
            array('account_name,login_name, password, email, role_group_id', 'required'),
            array('account_name', 'match', 'pattern'=>'/^([a-zA-Z0-9- ])+$/'),
            array('login_name', 'match', 'pattern'=>'/^([a-zA-Z0-9_. ])+$/'),
            array('login_name', 'unique', 'caseSensitive'=>false),
            array('account_name', 'ext.validators.UniquePerClientValidator', 'caseSensitive'=>false),
            array('role_group_id, is_visible, client_id', 'numerical', 'integerOnly'=>true),
            array('login_name, password', 'length', 'max'=>64),
            array('date_created', 'safe'),
            array('email', 'email'),
            array('email', 'unique'),
            array('login_name, password, date_created, is_visible, email', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array('role_groups'=>array(self::BELONGS_TO, 'RoleGroups', 'role_group_id'));
    }

    public function attributeLabels() {
        return array(
            'account_name'  => 'Account Name',
            'login_name'    => 'Login Name',
            'password'      => 'Password',
            'role_group_id' => 'Role Group',
            'date_created'  => 'Date Created',
            'email'         => 'Email',
        );
    }

    public function search() {
        $criteria = new DatetimeSearchCirteria;
        $criteria->compare('LOWER(t.login_name)',       strtolower($this->login_name),  true);
        $criteria->compare('t.role_group_id',           $this->role_group_id);
        $criteria->addDateCriteria('t.date_created',            $this->date_created,            true);
        $criteria->compare('t.is_visible',              1);
        $criteria->compare('LOWER(t.email)',            strtolower($this->email),       true);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function scopes() {
        return array(
            'visible' => array(
                'condition' => 'is_visible = 1',
            ),
        );
    }
}
?>
