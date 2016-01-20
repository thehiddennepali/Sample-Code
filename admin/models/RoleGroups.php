<?php
class RoleGroups extends BaseActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'role_groups';
    }

    public function rules() {
        return array(
            array('role_group_name', 'required'),
            array('role_group_name', 'match', 'pattern'=>'/^([a-zA-Z0-9- ])+$/'),
            array('client_id', 'numerical', 'integerOnly'=>true),
            array('role_group_name', 'length', 'max'=>64),
            array('role', 'length', 'max'=>4096),
            array('date_created', 'safe'),
            array('role_group_name, role,date_created', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array();
    }

    public function attributeLabels() {
        return array(
            'role_group_name' => 'Role Group Name',
            'role'            => 'Role',
            'date_created'    => 'Date Created',

        );
    }

    public function search() {
        $criteria = new DatetimeSearchCirteria;
        $criteria->compare('LOWER(t.role_group_name)',  strtolower($this->role_group_name), true);
        $criteria->addDateCriteria('t.date_created',              $this->date_created,true);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
?>
