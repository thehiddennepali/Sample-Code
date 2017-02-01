<?php

namespace fbwidget\models;

use fbwidget\models\GroupSchedule;
use fbwidget\models\GroupScheduleHistory;
use fbwidget\components\ImageBehavior;
use fbwidget\models\MerchCatHasAddon;
use fbwidget\models\Order;
use fbwidget\models\Staff;
use fbwidget\models\StaffHasCategory;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category_has_merchant".
 *
 * @property integer $category_id
 * @property integer $merchant_id
 * @property double $price
 * @property integer $is_active
 * @property integer $id
 * @property integer $time_in_minutes
 * @property integer $additional_time
 * @property integer $service_time_slot
 * @property string $title
 * @property integer $group_people
 * @property integer $is_group
 * @property integer $staff_id
 * @property string $color
 * @property string $description
 *
 * @property Staff $staff
 * @property MtMerchant $merchant
 * @property MtServiceSubcategory $category
 * @property GroupSchedule[] $groupSchedules
 * @property GroupScheduleHistory[] $groupScheduleHistories
 * @property MerchCatHasAddon[] $merchCatHasAddons
 * @property MtVoucher[] $mtVouchers
 * @property Order[] $orders
 * @property StaffHasCategory[] $staffHasCategories
 */
class CategoryHasMerchant extends ActiveRecord
{
    const UPLOAD_DIR = 'service';
    public $memcache_key;
    
    public function behaviors(){
        return [
            
            'imageBehavior' => [
                'class' => ImageBehavior::className(),
                'imagePath' => self::UPLOAD_DIR,
            ],
            
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_has_merchant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'merchant_id', 'price', 'service_time_slot', 'title'], 'required'],
            [['category_id', 'merchant_id', 'is_active', 'time_in_minutes', 'additional_time', 'service_time_slot', 'group_people', 'is_group', 'staff_id'], 'integer'],
            [['price'], 'number'],
            ['memcache_key', 'safe'],
            [['description'], 'string'],
            [['title', 'color'], 'string', 'max' => 255],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => MtMerchant::className(), 'targetAttribute' => ['merchant_id' => 'merchant_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MtServiceSubcategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }
    
    public function getModel(){
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'merchant_id' => 'Merchant ID',
            'price' => 'Price',
            'is_active' => 'Is Active',
            'id' => 'ID',
            'time_in_minutes' => 'Time In Minutes',
            'additional_time' => 'Additional Time',
            'service_time_slot' => 'Service Time Slot',
            'title' => 'Title',
            'group_people' => 'Group People',
            'is_group' => 'Is Group',
            'staff_id' => 'Staff ID',
            'color' => 'Color',
            'description' => 'Description',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMerchant()
    {
        return $this->hasOne(MtMerchant::className(), ['merchant_id' => 'merchant_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(MtServiceSubcategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGroupSchedules()
    {
        return $this->hasMany(GroupSchedule::className(), ['group_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGroupScheduleHistories()
    {
        return $this->hasMany(GroupScheduleHistory::className(), ['group_id' => 'id']);
    }
    
    
    public function getLastGroupScheduleHistories()
    {
        return $this->hasOne(GroupScheduleHistory::className(), ['group_id' => 'id'])->orderBy(['id'=>SORT_DESC]);
    }

    /**
     * @return ActiveQuery
     */
    public function getMerchCatHasAddons()
    {
        return $this->hasMany(MerchCatHasAddon::className(), ['m_c_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMtVouchers()
    {
        return $this->hasMany(MtVoucher::className(), ['service_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['category_id' => 'id']);
    }
    
    public function getLastSchedule()
    {
        return $this->hasOne(GroupScheduleHistory::className(), ['group_id' => 'id'])->orderBy('id desc');
    }

    /**
     * @return ActiveQuery
     */
   
    
    public function getStaffHasCategories()
    {
        return $this->hasMany(StaffHasCategory::className(), ['category_id' => 'id']);
    }
    
    public function getTimeOfService(){
        return $this->time_in_minutes + $this->additional_time;
    }
    
    public function getAddons()
    {
        
        return $this
       ->hasMany(Addons::className(), ['id' => 'addon_id'])
       ->viaTable('merch_cat_has_addon', ['m_c_id' => 'id']);
        
    }
}
