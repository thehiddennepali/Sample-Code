<?php

namespace fbwidget\controllers;

use fbwidget\components\GroupScheduleHelper;
use fbwidget\components\SingleScheduleHelper;
use fbwidget\models\AddToCart;
use fbwidget\models\CategoryHasMerchant;
use fbwidget\models\MtVoucher;
use fbwidget\models\Order;
use fbwidget\models\Staff;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function beforeAction($event)
    {
        $cookies = Yii::$app->request->cookies;
        
        $languageCookie = $cookies['language'];
        
        if(isset($languageCookie->value) && !empty($languageCookie->value)){
            Yii::$app->language = $languageCookie->value;
        }
        
        
        
        return parent::beforeAction($event);
    }
    
    public function actionAddSingleMemcachedOrder()
    {
        
        if($_POST['update']) {
            $cache = Yii::$app->cache->get($_POST['staff_id']);
            
            $uid = $_POST['u_id']?$_POST['u_id']:uniqid();
            if ($cache) {
                if(isset($cache[$_POST['date_val']])){
                    $cache[$_POST['date_val']][$uid] = ['order_time'=>$_POST['date_val'].' '.$_POST['free_time_list'].':00','orderTimeLength'=>$_POST['min_val']];

                }else{
                    $cache[$_POST['date_val']] = [$uid=>['order_time'=>$_POST['date_val'].' '.$_POST['free_time_list'].':00','orderTimeLength'=>$_POST['min_val']]];
                }
            } else {
                $cache = [$_POST['date_val']=>[$uid=>['order_time'=>$_POST['date_val'].' '.$_POST['free_time_list'].':00','orderTimeLength'=>$_POST['min_val']]]];
            }
            Yii::$app->cache->set($_POST['staff_id'],$cache,300);
            echo $uid;
        }
        Yii::$app->end();
    }
    
    public function actionCancel($id){
        $model = $this->findModel($id);
        $model->status = 2;
        
        if($model->save(false)){
            $merchantLoylitypoints = \fbwidget\models\LoyaltyPoints::findOne(['merchant_id' => $model->merchant_id]);
        
                if($merchantLoylitypoints->is_active == 1){
                    $loyalitypoint = \frontend\models\Option::getValByName('website_loyalty_points');

                    if(!empty($loyalitypoint)){
                        $clintLoyalityPoint = \fbwidget\models\ClientLoyalityPoints::findOne(['client_id' => $model->client_id, 'merchant_id' => $model->merchant_id]);
                        
                        if($clintLoyalityPoint){
                            $clintLoyalityPoint->points -= $loyalitypoint * $model->price;
                            $clintLoyalityPoint->save(false);
                            
                        }
                    }
                }
            \fbwidget\components\EmailManager::cancelAppointment($model);
            \fbwidget\components\EmailManager::cancelAppointmentMerchant($model);
            Yii::$app->session->setFlash('success', "Order cancelled successfully");
            $this->redirect(['client/dashboard']);
        }
        
    }
    
    public function actionCoupon(){
        
        if(Yii::$app->request->isAjax){
            
            $couponCode = trim($_POST['coupon']);
            $merchantId = $_POST['merchanid'];
            $session  = Yii::$app->session;
            $total = $session['total'];
            $is_checked = $_POST['checkornot'];
            $discount = 0;
            $couponPer = "";
            
            
            if($is_checked == 'true'){
            
            $voucher = MtVoucher::find()
                    ->where(['voucher_name'=> trim($couponCode), 'merchant_id'=> $merchantId])
                    ->one();
            
            if(Yii::$app->user->id){
                $birthdayCoupon = \common\models\UserBirthdayCoupon::findOne([
                    'merchant_id' => $merchantId,
                    'user_id' => Yii::$app->user->id,
                    'code' => trim($couponCode),
                    'year' => date('Y')
                ]);
                
                
                
                if($birthdayCoupon){
                    $order = Order::findOne(['user_birthday_coupon_id' => $birthdayCoupon->id]);
                    
                    if(count($order) == 0){
                        $voucher = MtVoucher::find()
                            ->where(['voucher_id'=> $birthdayCoupon->voucher_id])
                            ->one();
                        
                        
                        $session['userbirthdaycoupon'] = $birthdayCoupon->id;
                        
                        
                    }else{
                        echo json_encode(['success' => false, 'msg' => 'You have already used this coupon for this merchant.']);
                        Yii::$app->end();
                        
                    }
                    
                }
                
                
            }
                    
            
            
                if(count($voucher) > 0 && $voucher->expiration >= date('Y-m-d')){

                    $amount = 0;
                    if($voucher->apply_all_services == 1){
                        $amount = $session['total'];

                    }else{
                        if(!empty($voucher->service_id)){
                        $services = json_decode($voucher->service_id);
                        
                        
                            foreach ($services as $key=>$val){
                                if(isset($session['cart'][$val])){
                                    $amount = array_sum(array_column($session['cart'][$val],'price'));

                                }
                            }
                        }

                    }
                    
                    if($amount != 0){
                        
                        //print_r($voucher->attributes);

                        if($voucher->voucher_type == 0){
                            $discount = number_format($voucher->amount, 2, '.', '');
                            $dis  = '€ '.$discount;
                            $couponPer = '€';
                        }else{
                            $couponPer = $voucher->amount.'%';
                            $discount =  ($voucher->amount / 100) * $amount;
                            
                            $discount = number_format($discount, 2, '.', '');
                            $dis  = '€ '.$discount;
                        }

                    }
                    
                    

                    $total = $total - $discount;

                    $session['total'] = number_format($total, 2, '.', '');
                    $session['couponid'] = $voucher->voucher_id;
                    $session['discount'] = $discount;
                    $session['couponPer'] = $couponPer;
                    $total  = $session['total'];
                    echo Json::encode(  ['couponPer' => $couponPer, 'discount' => $dis, 'total' => $total]);

                    Yii::$app->end();
                    


                }else{
                    $session['total'] = $session['subtotal'];
                    $session['couponid'] = NULL;
                    $session['discount'] = NULL;
                    $session['couponPer'] = NULL;
                    $session['userbirthdaycoupon'] = NULL;
                    $total = $session['total'];
                    echo Json::encode(['couponPer' => $couponPer, 'discount' => $discount, 'total' => $total]);
                    Yii::$app->end();
                    
                }
            }else{
                
                $session['total'] = $session['subtotal'];
                $session['couponid'] = NULL;
                $session['discount'] = NULL;
                $session['couponPer'] = NULL;
                $total = $session['total'];
                echo Json::encode(['couponPer' => $couponPer, 'discount' => $discount, 'total' => $total]);
                Yii::$app->end();
            }
            
            
            //$coupon = 
            
        }
    }


    public function actionGetFreeStaff(){
        
        if (isset($_POST['date_val']) && $_POST['date_val']) {

            $d = trim($_POST['date_val']);
            //$t = trim($_POST['time_val']);
            $t = "";
            $m = trim($_POST['min_val']);
            $c = trim($_POST['cat']);
            $merchant_id = trim($_POST['merchant_id']);
            
            if (SingleScheduleHelper::isMerchantWork($d, $t, $m, $merchant_id)) {
                $u = 0;
                
                $staffs = Staff::find()
                    ->joinWith('staffHasCategories')
                    ->where(['is_active' => 1,
                        'merchant_id' => $merchant_id,
                        'staff_has_category.category_id'=>$c])
                    ->all();
                    
                $data = [];

                foreach ($staffs as $staff) {
                    //echo 'category'.$c;
                    //print_r($staff->attributes);

                    if (SingleScheduleHelper::isStaffWork($d, $t, $m, $staff, $u, $c))
                        $data[] = $staff;
                }

                $data = ArrayHelper::map($data, 'id', 'name');
                if ($data) {
                    echo Html::tag('option',
                         Html::encode('select'), ['value'=>""]);
                    foreach ($data as $value => $name) {
                        echo Html::tag('option',
                             Html::encode($name),  ['value'=>$value]);
                    }
                } else {
                    echo Html::tag('option',
                         Html::encode('No staff for this time'),  ['value'=>""]);
                }
        }else {
            echo Html::tag('option', Html::encode('this day is free'), ['value'=>'']);
        }
        
    }
    }
    
    public function actionGetGroupTime(){
        
        
        if(Yii::$app->request->isAjax){
            
            
            $addToCart = new AddToCart();
            
            if($addToCart->load(Yii::$app->request->post())){
                $dStart = strtotime($addToCart->order_date);
                
                
                $service = CategoryHasMerchant::findOne(['id'=>$addToCart->serviceid]);
                
                $k = 0;
                GroupScheduleHelper::init(strtotime("+$k day", $dStart), $addToCart->serviceid, $service);
                $dayGroupSchedule = GroupScheduleHelper::getDateSchedule(strtotime("+$k day", $dStart), $addToCart->serviceid, $service);
                
                echo  $this->renderAjax('group_time', ['model' =>$dayGroupSchedule ]);
                Yii::$app->end();
                
                
            }
        
            
        }              
    }
    
    
    public function actionGetStaffFreeTime()
    {
        if (isset($_POST['staff_id']) && $_POST['staff_id']) {
            $d = $_POST['date_val'];
            $m = $_POST['min_val'];
            $u = (isset($_POST['update'])) ? $_POST['update'] : 0;
            
            $service = CategoryHasMerchant::findOne(['id' => $_POST['cat']]);
            
            $staff = Staff::findOne($_POST['staff_id']);
            $dd = Html::tag('option', Html::encode('select'), 
                ['value' => '']);
            foreach ($staff->getFreeTime($d, $m, $u, $service) as $name) {
                $dd.= Html::tag('option',
                Html::encode($name), ['value' => $name]);
            }

            $addOns = $this->renderAjax('_addons_single', ['addons' => $staff->addons]);
            $res = [
                'dd' => $dd,
                'add_ons' => $addOns

            ];

            echo json_encode($res);

        }
        Yii::$app->end();
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
