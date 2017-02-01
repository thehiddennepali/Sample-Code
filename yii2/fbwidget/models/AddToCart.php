<?php
namespace fbwidget\models;

use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class AddToCart extends Model
{
    public $order_date;
    public $time_req;
    public $staff_id;
    public $free_time_list;
    public $serviceid;
    public $no_of_seats;
    public $paymentMethod;
    public $deliveryOption;
    public $deliveryFee, $notevoucher;
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_date',  'staff_id', 'free_time_list'], 'required', 'on' => 'singleorder'],
            
            [['order_date', 'time_req', 'staff_id', 'no_of_seats'], 'required', 'on' => 'grouporder'],
	    
	    [['paymentMethod',  'deliveryOption'], 'required', 'on' => 'giftvoucher'],
            
            [['serviceid', 'order_date', 'time_req', 'staff_id', 'free_time_list', 'deliveryFee', 'notevoucher'], 'safe'],
            
            ['no_of_seats', 'checkSeats', 'on' => 'grouporder']
            
        ];
    }
    
    public function checkSeats($attribute, $params)
    {
        
        $category = CategoryHasMerchant::findOne(['id' => $this['serviceid']]);
        
        $dateTime = $this['order_date'].' '.$this['time_req'].':00';
        
        $left = self::countByDate($dateTime, $this['serviceid']);
        
        $sessionOrder = self::getSessionOrder($this['serviceid'], $this['time_req']);
        
        $left += $sessionOrder;
        
        if(empty($left)){
            $left = 0;
        }
        
        
        
        $remaining = $category->group_people - $left;
        
        if($this['no_of_seats'] > $remaining && $remaining != 0 ){
            $this->addError('no_of_seats', Yii::t('basicfield', 'Only {count} seats remaining', ['count' => $remaining]));
        }else if($remaining == 0){
            $this->addError('no_of_seats', Yii::t('basicfield', 'No seats available'));
            
        }
        
        
    }
    
    public static function getSessionOrder($serviceId, $timeReq){
        $session = Yii::$app->session;
        
        $seats = 0;
        
        if(isset($session['cart'][$serviceId])){
            
            foreach ($session['cart'][$serviceId] as $key=>$value){
                if($timeReq == $value['time_req']){
                    $seats += $value['no_of_seats'];
                }
                
            }
            
            
            
        }
        
        return $seats;
        
    }
    
    public static function countByDate($date, $service_id){
        
        //print_r(CachedSingleOrder::countGroupByDay($service_id,$date));
        
        $sql = 'SELECT SUM(no_of_seats) as total from `order` where order_time="'.$date.'" and category_id="'.$service_id.'" and status=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        
        //return $query['total'] + CachedSingleOrder::countGroupByDay($service_id,$date);
        return $query['total'];
    }
    
    public function attributeLabels()
    {
        return [
            'staff_id' => Yii::t('basicfield', 'Staff'),
        ];
    }
}