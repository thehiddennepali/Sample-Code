<?php
namespace fbwidget\controllers;

use fbwidget\components\EmailManager;
use fbwidget\models\AddonHasOrder;
use fbwidget\models\Addons;
use fbwidget\models\Client;
use fbwidget\models\LoginForm;
use fbwidget\models\Order;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\widgets\ActiveForm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class CheckoutController extends Controller{
    
    public $enableCsrfValidation = false;
    
    public $successUrl = 'Success';
    
    
    
    public function beforeAction($event)
    {
        $this->enableCsrfValidation = false;
        $cookies = Yii::$app->request->cookies;
        
        $languageCookie = $cookies['language'];
        
        if(isset($languageCookie->value) && !empty($languageCookie->value)){
            Yii::$app->language = $languageCookie->value;
        }
        
        
        
        return parent::beforeAction($event);
    }
    
    
      
      
      

    
    public function actionCheckLoyalty(){
        if(Yii::$app->request->isAjax){
            if(isset($_POST)){
                $minimum = $_POST['minimum'];
                $clientLoyalty = $_POST['clientloyalty'];
                $points = $_POST['points'];
                
                $session = Yii::$app->session;
                
                $loyaltyPointsOne = \common\models\Option::getValByName('website_loyalty_points');
                
                if($points <= $clientLoyalty && $points >= $minimum){
                    
                    $session['loyalty'] = $points;
                    $amount = $points * $loyaltyPointsOne;
                    
                    $subtotal = $session['subtotal'] - $amount;
                    $total = ($session['total'] - $session['discount'])  - $amount;
                    
                    $subtotal = number_format($subtotal, 2, '.', '');
                    $total = number_format($total, 2, '.', '');
                    
                    echo json_encode(['success' => true, 'subtotal' => $subtotal, 'total'=> $total]);
                    Yii::$app->end();
                    
                }else{
                    echo json_encode(['success' => false, 
                        'msg' => Yii::t('basicfield', 'Loyalty points should be greater than {count1} and less than {count2}', ['count1' => $minimum, 'count2' => $clientLoyalty])]);
                    Yii::$app->end();
                    
                }
            }
            //print_r($_POST);
        }
        
    }
    
    public function actionVerification(){
        
        $login = new LoginForm;
        $client = new Client;
        $client->scenario = 'activation';
        
        if($login->load(Yii::$app->request->post())){
            if($login->login()){
                $this->redirect(['checkout/payment']);
            }
            
        }
        
        if($client->load(Yii::$app->request->post())){
            if($client->validate()){
                $checkClient = Client::findOne(['activation_key' => trim($client->activation_key)]);
                
                if(count($checkClient) == 1){
                    $checkClient->status = 1;
                    $checkClient->save(false);
                    
                    $login = new LoginForm;
                    $login->email = $checkClient->email_address;
                    $login->password = $checkClient->password;
                    //$error = ActiveForm::validate($login);
                    
                    
                    if($login->login()){
                    
                        $this->redirect(['payment']);
                    }
                }else{
                    $client->addError('activation_key', 'Wrong activation key.');
                }
                
                
            }
            
        }
        
        return $this->render('verification',[
            'login' => $login, 
            'client' => $client
        ]);
        
    }
    
    
    public function actionWidgetVerification(){
        
        $login = new LoginForm;
        $client = new Client;
        $client->scenario = 'activation';
        
        $this->layout = 'widget-layout';
        
        if($login->load(Yii::$app->request->post())){
            if($login->login()){
                $this->redirect(['checkout/widget-payment']);
            }
            
        }
        
        if($client->load(Yii::$app->request->post())){
            if($client->validate()){
                $checkClient = Client::findOne(['activation_key' => trim($client->activation_key)]);
                
                if(count($checkClient) == 1){
                    $checkClient->status = 1;
                    $checkClient->save(false);
                    
                    $login = new LoginForm;
                    $login->email = $checkClient->email_address;
                    $login->password = $checkClient->password;
                    //$error = ActiveForm::validate($login);
                    
                    
                    if($login->login()){
                    
                        $this->redirect(['widget-payment']);
                    }
                }else{
                    $client->addError('activation_key', 'Wrong activation key.');
                }
                
                
            }
            
        }
        
        return $this->render('widget-verification',[
            'login' => $login, 
            'client' => $client
        ]);
        
    }
    
    public function actionIndex(){
        $session = Yii::$app->session;
        $login = new LoginForm;
        $client = new Client();
        $client->scenario = 'checkout';
        
        if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
            return $this->goHome();
            
        }
        
        if(!empty($session['client'])){
            $client->attributes = $session['client'];
        }
        
        if($client->load(Yii::$app->request->post())){
            
            if($client->validate()){
                
                
                $session['client'] = $client->attributes;
                
                $client = Client::find()->where(['email_address' => trim($session['client']['email_address'])])->one();
                
                if(count($client) == 0 ){
                        $password = Yii::$app->getSecurity()->generateRandomString(6);
                        $client = new Client;
                        $client->attributes = $session['client'];

                        $client->password = $password;
                        $client->setPassword($password);
                        $client->generateAuthKey();
                        $client->status = 0;
                        $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                        $client->dob = date('Y-m-d', strtotime($session['client']['dob']));
                        
//                        print_r(Yii::$app->request->userIP);
//                        exit;
                        
//                        $email = EmailManager::customerAccountActivate($client);
//                        
//                        exit;
        
                        if($client->save(false)){
                            $addressBook  = new \fbwidget\models\MtAddressBook;
                            $addressBook->attributes = $session['client'];
                            $addressBook->client_id = $client->id;
                            $addressBook->ip_address = Yii::$app->request->userIP;
                            $addressBook->save(false);
                            
                            $email = EmailManager::customerAccountActivate($client);
                            $url = Yii::$app->urlManager->createUrl('checkout/verification');
                            
                        }
                    
                    
                    
                }else if(empty($client->password)){
                    
                    $client->password = $session['client']['email_address'];
                    $client->setPassword($session['client']['email_address']);
                    $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                    $client->status = 0;
                    $client->save(false);
                    $email = EmailManager::customerAccountActivate($client);
                    $url = Yii::$app->urlManager->createUrl('checkout/verification');
                    
                }else if($client->status == 0){
                    $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                    $client->save(false);
                    $email = EmailManager::customerAccountActivate($client);
                    $url = Yii::$app->urlManager->createUrl('checkout/verification');
                }else{
                    $login = new LoginForm;
                    $login->email = $client->email_address;
                    $login->password = $client->password;
                    //$error = ActiveForm::validate($login);
                    
                    
                    $login->login();
                    $url = Yii::$app->urlManager->createUrl('checkout/payment');
                }
                
                
                
                
                
                echo Json::encode(['success' => true, 'data' => $url]);
                Yii::$app->end();
                
                
            }else{
                echo Json::encode(['success' => false, 'data' => $client->getErrors()]);
                Yii::$app->end();
            }
            
        }
        
        if($login->load(Yii::$app->request->post())){
            if($login->login()){
                $this->redirect(['checkout/payment']);
            }
            
        }
        
        return $this->render('index', [
            'client' => $client,
            'login' => $login
        ]);
    }
    
    public function actionWidgetIndex(){
        
        
        
        $this->layout = 'widget-layout';
        
        $session = Yii::$app->session;
        $login = new LoginForm;
        $client = new Client();
        $client->scenario = 'checkout';
        
        if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
            return $this->goHome();
            
        }
        
        if(!empty($session['client'])){
            $client->attributes = $session['client'];
        }
        
        if($client->load(Yii::$app->request->post())){
            
            if($client->validate()){
                
                
                $session['client'] = $client->attributes;
                
                $client = Client::find()->where(['email_address' => trim($session['client']['email_address'])])->one();
                
                if(count($client) == 0 ){
                        $password = Yii::$app->getSecurity()->generateRandomString(6);
                        $client = new Client;
                        $client->attributes = $session['client'];

                        $client->password = $password;
                        $client->setPassword($password);
                        $client->generateAuthKey();
                        $client->status = 0;
                        $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                        
//                        print_r(Yii::$app->request->userIP);
//                        exit;
                        
//                        $email = EmailManager::customerAccountActivate($client);
//                        
//                        exit;
        
                        if($client->save(false)){
                            $addressBook  = new \fbwidget\models\MtAddressBook;
                            $addressBook->attributes = $session['client'];
                            $addressBook->client_id = $client->id;
                            $addressBook->ip_address = Yii::$app->request->userIP;
                            $addressBook->save(false);
                            
                            $email = EmailManager::customerAccountActivate($client);
                            $url = Yii::$app->urlManager->createUrl('checkout/widget-verification');
                            
                        }
                    
                    
                    
                }else if(empty($client->password)){
                    
                    $client->password = $session['client']['email_address'];
                    $client->setPassword($session['client']['email_address']);
                    $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                    $client->status = 0;
                    $client->save(false);
                    $email = EmailManager::customerAccountActivate($client);
                    $url = Yii::$app->urlManager->createUrl('checkout/widget-verification');
                    
                }else if($client->status == 0){
                    $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                    $client->save(false);
                    $email = EmailManager::customerAccountActivate($client);
                    $url = Yii::$app->urlManager->createUrl('checkout/widget-verification');
                }else{
                    $login = new LoginForm;
                    $login->email = $client->email_address;
                    $login->password = $client->password;
                    //$error = ActiveForm::validate($login);
                    
                    
                    $login->login();
                    $url = Yii::$app->urlManager->createUrl('checkout/widget-payment');
                }
                
                
                
                
                
                echo Json::encode(['success' => true, 'data' => $url]);
                Yii::$app->end();
                
                
            }else{
                echo Json::encode(['success' => false, 'data' => $client->getErrors()]);
                Yii::$app->end();
            }
            
        }
        
        if($login->load(Yii::$app->request->post())){
            if($login->login()){
                $this->redirect(['checkout/widget-payment']);
            }
            
        }
        
        return $this->render('widget-index', [
            'client' => $client,
            'login' => $login
        ]);
    }
    
    public function actionPaypalIpn(){
        Yii::$app->controller->enableCsrfValidation = false;
        $paypal = new \fbwidget\components\Paypal;
        $paypal->ipn();
    }
    
    
    public function actionPayment(){
        
        
         
        
        if(isset($_POST['payment_method']) && !empty($_POST['payment_method'])){
            
            
            
            $session = Yii::$app->session;
            
            $session['payment_method'] = $_POST['payment_method'];
            
            $loyalty = $session['loyalty'];
            
            if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
                return $this->goHome();

            }
            
            
            
            if(!empty($session['cart'])){
                $orders = $session['cart'];
                $subtotal = $session['subtotal'];
                $total = $session['total'];
                $couponPer = $session['couponPer'];
                $discount = $session['discount'];
                
                $totalSize = 0;
                
                foreach($session['cart'] as $key=>$value){
                    $size = sizeof($value);
                    $totalSize += $size;
                }
                
                $singleLoyalty = $loyalty / $totalSize;
                
                $loyaltyPointsOne = \common\models\Option::getValByName('website_loyalty_points');
                

                    $client = Yii::$app->user->identity;
                    $clientId = Yii::$app->user->id;
                    $response = [] ;
                    
                    
            
            
                if($session['payment_method'] == 1){
                    
                    $query = \fbwidget\components\Paypal::Post($session);
                    
//                    print_r($query);
//                    exit;
                    
//                    $post = \fbwidget\components\Paypal::Post($session);
//                    echo Json::encode(['success' => true,
//                        'data' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.$post, 
//                        'response' => $response]);
//                    Yii::$app->end();
            

                }
                    
                    
                    

                $i=1;foreach($session['cart'] as $key=>$value){

                    foreach($value as $k=>$v){
                        $model = new Order;
                        $model->attributes = $v;
                        $model->payment_type = $session['payment_method'];
                        $model->user_birthday_coupon_id = $session['userbirthdaycoupon'];
                        $model->client_id = $client->client_id;
                        $model->source_type = 1;

                        if($v['is_group'] == 0){
                        //print_r($v['is_group']);
                            $model->order_time = date('Y-m-d', strtotime($v['order_date'])) . ' ' . $v['free_time_list'];
                        }else if($v['is_group'] == 1){
                            $model->order_time = date('Y-m-d', strtotime($v['order_date'])) . ' ' . $v['time_req'];
                        }
                        $model->category_id = $key;
                        $model->client_name = $client->first_name;
                        $model->client_email = $client->email_address;
                        $model->client_phone = $client->contact_phone;

                        $model->loyalty_points = $loyaltyPointsOne * $singleLoyalty;
                        $price = $model::getPrice($model); 
                        
                        $model->price = $price;
                        
                        if($model->payment_type == 1){
                            $model->payment_status = 'pending';
                            $model->status = 4;
                            
                        }
                        
                        
//                        print_r($model->attributes);
//                        exit;
                        
                        

                        if($model->save(false)){
                            
                            
                            
                            if(isset($v['addons_list'])){
                                foreach($v['addons_list'] as $val){
                                    $m = Addons::findOne(['id'=>$val]);
                                    $model->price += $m->price;
                                    $addonHasOrder = new AddonHasOrder;
                                    $addonHasOrder->addon_id = $val;
                                    $addonHasOrder->order_id = $model->id;
                                    $addonHasOrder->save(false);
                                }
                            }
                            
                            

                            $commission = $model::getCommision($model->merchant_id, $model->price);

                            $model->total_commission = $commission['total_commision'];
                            $model->merchant_earnings = $commission['merchant_earnings'];
                            $model->percent_commision = $commission['percent_commision'];

                            if(isset($session['couponid'])){
                                $model->voucher_id = $session['couponid'];
                            }
                            $model->save(false);
                            
                            
                            
                            
                            $response[] = [
                                'id' => $model->id,
                                'staff_id' => $model->staff_id,
                                'merchant_id' => $model->merchant_id,
                                'title' => $model->client_name,
                                'start' => date('Y-m-d\TH:i:s', strtotime($model->order_time)),
                                'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->category->time_in_minutes} minutes", strtotime($model->order_time))),
                                'url' => 'order/update-inst?id=' . $model->id,
                                'backgroundColor' => $model->category->color,
                                'is_group' =>$model->is_group
                            ];
                                
                                if($session['payment_method'] == 2){
                                
                                    EmailManager::newAppointment($model);
                                    EmailManager::newAppointmentMerchant($model);
                                }
                            
                            
                            if($session['payment_method'] == 1){
                                $addons = implode('/', $v['addons_list']);
                                $custom .= '&'.'_'.$i.'_'.$key.'_'.$model->merchant_id.'_'.Yii::$app->user->id.'_'.$addons.'_'.$v['order_date'].'_'.$v['free_time_list'].'_'.$v['time_req'].'_'.$v['is_group'].'_'.$session['couponid'].'_'.$session['userbirthdaycoupon'].'_'.$session['loyalty'].'_'.$v['staff_id'].'_'.$model->id;


                                //$custom = base64_encode($custom);
                                //$query['custom_'.$i] = json_encode(['id' => $key, 'addonlist' => $v['addons_list']]);
                                $query['item_name_'.$i] = $v['title'];
                                $query['quantity_'.$i] = 1;
                                $query['amount_'.$i] = $model->price;
                            }
                        
                        }




                    $i++;}


                }
                
                
                if($session['payment_method'] == 2){
                
                    $merchantLoylitypoints = \fbwidget\models\LoyaltyPoints::findOne(['merchant_id' => $model->merchant_id]);

                    if($merchantLoylitypoints->is_active == 1){

                        $loyalitypoint = \fbwidget\models\Option::getValByName('website_loyalty_points');

                        if(!empty($loyalitypoint)){
                            $clintLoyalityPoint = \fbwidget\models\ClientLoyalityPoints::findOne(['client_id' => Yii::$app->user->id, 'merchant_id' => $model->merchant_id]);


                            if(count($clintLoyalityPoint) == 0){
                                $clintLoyalityPoint = new \fbwidget\models\ClientLoyalityPoints();
                                $clintLoyalityPoint->client_id = Yii::$app->user->id;
                                $clintLoyalityPoint->merchant_id = $model->merchant_id;
                                $clintLoyalityPoint->created_at = new \yii\db\Expression('NOW()');
                            }

                            $clintLoyalityPoint->points -= $session['loyalty'];

                            $clintLoyalityPoint->points += $loyalitypoint * $total;
                            $clintLoyalityPoint->save(false);

                            $minimumLoyaltyPoints = \common\models\Option::getValByName('minimum_loyalty_points');

                            if($clintLoyalityPoint->points >= $minimumLoyaltyPoints){
                                EmailManager::customerLoyaltyPoints($model, $clintLoyalityPoint);

                            }
                        }

                    }
                }
                
                if($session['payment_method'] == 1){
                    
                    $query['custom'] = base64_encode($custom);
                
                    $post = http_build_query($query);
                    echo Json::encode(['success' => true,
                        'data' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.$post, 
                        'payment' => $session['payment_method'],
                        'response' => $response]);
                    Yii::$app->end();
                }
                



            }
            
            echo Json::encode(['success' => true,
                'data' => Yii::$app->urlManager->createUrl('checkout/finish'), 
                'payment' => $session['payment_method'],
                'response' => $response]);
            Yii::$app->end();
            
        }
        return $this->render('payment');
    }
    
    
    public function actionWidgetPayment(){
        
        
        
        $this->layout = 'widget-layout';
        
        if(isset($_POST['payment_method']) && !empty($_POST['payment_method'])){
            $session = Yii::$app->session;
            
            $session['payment_method'] = $_POST['payment_method'];
            
            $session = Yii::$app->session;
            
            if($session['payment_method'] == 1){
                    
                $query = \fbwidget\components\Paypal::Post($session);
            }
            
            if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
                return $this->goHome();

            }
            
            
            if(!empty($session['cart'])){
                $orders = $session['cart'];
                $subtotal = $session['subtotal'];
                $total = $session['total'];
                $couponPer = $session['couponPer'];
                $discount = $session['discount'];

                    $client = Yii::$app->user->identity;
                    $clientId = Yii::$app->user->id;
                    $response = [] ;

                $i=1;foreach($session['cart'] as $key=>$value){

                    foreach($value as $k=>$v){
                        $model = new Order;
                        $model->attributes = $v;
                        $model->payment_type = $session['payment_method'];
                        $model->client_id = $client->client_id;
                        $model->source_type = 1;

                        if($v['is_group'] == 0){
                        //print_r($v['is_group']);
                            $model->order_time = date('Y-m-d', strtotime($v['order_date'])). ' ' . $v['free_time_list'];
                        }else if($v['is_group'] == 1){
                            $model->order_time = date('Y-m-d', strtotime($v['order_date'])) . ' ' . $v['time_req'];
                        }
                        $model->category_id = $key;
                        $model->client_name = $client->first_name;
                        $model->client_email = $client->email_address;
                        $model->client_phone = $client->contact_phone;

                        $price = $model::getPrice($model); 
                        
                        $model->price = $price;
                                

                        if($model->save(false)){
                            if(isset($v['addons_list'])){
                                foreach($v['addons_list'] as $val){
                                    $m = Addons::findOne(['id'=>$val]);
                                    $model->price += $m->price;
                                    $addonHasOrder = new AddonHasOrder;
                                    $addonHasOrder->addon_id = $val;
                                    $addonHasOrder->order_id = $model->id;
                                    $addonHasOrder->save(false);
                                }
                            }

                            $commission = $model::getCommision($model->merchant_id, $model->price);

                            $model->total_commission = 0;
                            $model->merchant_earnings = $commission['merchant_earnings'];
                            $model->percent_commision = 0;

                            if(isset($session['couponid'])){
                                $model->voucher_id = $session['couponid'];
                            }
                            $model->save(false);
                            
                            
                            
                            
                            $response[] = [
                                'id' => $model->id,
                                'staff_id' => $model->staff_id,
                                'merchant_id' => $model->merchant_id,
                                'title' => $model->client_name,
                                'start' => date('Y-m-d\TH:i:s', strtotime($model->order_time)),
                                'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->category->time_in_minutes} minutes", strtotime($model->order_time))),
                                'url' => 'order/update-inst?id=' . $model->id,
                                'backgroundColor' => $model->category->color,
                            ];
                                
                            EmailManager::newAppointment($model);
                            EmailManager::newAppointmentMerchant($model);
                            
                            if($session['payment_method'] == 1){
                                $addons = implode('/', $v['addons_list']);
                                $custom .= '&'.'_'.$i.'_'.$key.'_'.$model->merchant_id.'_'.Yii::$app->user->id.'_'.$addons.'_'.$v['order_date'].'_'.$v['free_time_list'].'_'.$v['time_req'].'_'.$v['is_group'].'_'.$session['couponid'].'_'.$session['userbirthdaycoupon'].'_'.$session['loyalty'].'_'.$v['staff_id'].'_'.$model->id;


                                //$custom = base64_encode($custom);
                                //$query['custom_'.$i] = json_encode(['id' => $key, 'addonlist' => $v['addons_list']]);
                                $query['item_name_'.$i] = $v['title'];
                                $query['quantity_'.$i] = 1;
                                $query['amount_'.$i] = $model->price;
                            }
                        
                        }




                    $i++;}


                }
                
                
                $merchantLoylitypoints = \fbwidget\models\LoyaltyPoints::findOne(['merchant_id' => $model->merchant_id]);
        
                if($merchantLoylitypoints->is_active == 1){

                    $loyalitypoint = \fbwidget\models\Option::getValByName('website_loyalty_points');

                    if(!empty($loyalitypoint)){
                        $clintLoyalityPoint = \fbwidget\models\ClientLoyalityPoints::findOne(['client_id' => Yii::$app->user->id, 'merchant_id' => $model->merchant_id]);


                        if(count($clintLoyalityPoint) == 0){
                            $clintLoyalityPoint = new \fbwidget\models\ClientLoyalityPoints();
                            $clintLoyalityPoint->client_id = Yii::$app->user->id;
                            $clintLoyalityPoint->merchant_id = $model->merchant_id;
                            $clintLoyalityPoint->created_at = new \yii\db\Expression('NOW()');
                        }
                        
                        

                        $clintLoyalityPoint->points += $loyalitypoint * $total;
                        $clintLoyalityPoint->save(false);
                    }

                }
                
                if($session['payment_method'] == 1){
                    
                    $query['custom'] = base64_encode($custom);
                
                    $post = http_build_query($query);
                    echo Json::encode(['success' => true,
                        'data' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.$post, 
                        'payment' => $session['payment_method'],
                        'response' => $response]);
                    
                    $session['cart'] = NULL;
                    $session['subtotal'] = NULL;
                    $session['total'] = NULL;
                    $session['couponPer'] = NULL;
                    $session['discount'] = NULL;
                    $session['client'] = NULL;
                    $session['loyalty'] = NULL;
                    $session['userbirthdaycoupon'] = NULL;
                    
                    Yii::$app->end();
                }
                



            }
            
            echo Json::encode(['success' => true,
                'data' => Yii::$app->urlManager->createUrl('checkout/widget-finish'), 
                'payment' => $session['payment_method'],
                'response' => $response]);
            Yii::$app->end();
            
        }
        return $this->render('widget-payment');
    }
    
    
    public function actionWidgetFinish(){
        
        
        
        $this->layout = 'widget-layout';
        
        $session = Yii::$app->session;
        
        if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
            return $this->goHome();
            
        }
        if(!empty($session['cart'])){
            $loyaltyPointsOne = \fbwidget\models\Option::getValByName('website_loyalty_points');
            $orders = $session['cart'];
            $loyalty = $session['loyalty'] * $loyaltyPointsOne;
            $subtotal = $session['subtotal'] - $loyalty;
            $total = ($session['total'] - $session['discount']) - $loyalty;
            $couponPer = $session['couponPer'];
            $discount = $session['discount'];
            
                
            
            $session['cart'] = NULL;
            $session['subtotal'] = NULL;
            $session['total'] = NULL;
            $session['couponPer'] = NULL;
            $session['discount'] = NULL;
            $session['client'] = NULL;
            $session['loyalty'] = NULL;
            $session['userbirthdaycoupon'] = NULL;
            
            
            
        }
        
        
        
        
        return $this->render('widget-finish', ['orders' => $orders,
            'subtotal' => $subtotal,
            'total' => $total,
            'couponPer' => $couponPer,
            'discount' => $discount
            
                ]);
    }
    
    public function actionFinish(){
        
        
        $session = Yii::$app->session;
        
        if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
            return $this->goHome();
            
        }
        if(!empty($session['cart'])){
            $loyaltyPointsOne = \common\models\Option::getValByName('website_loyalty_points');
            $orders = $session['cart'];
            $loyalty = $session['loyalty'] * $loyaltyPointsOne;
            $subtotal = $session['subtotal'] - $loyalty;
            $total = ($session['total'] - $session['discount']) - $loyalty;
            $couponPer = $session['couponPer'];
            $discount = $session['discount'];
            
                
            
            $session['cart'] = NULL;
            $session['subtotal'] = NULL;
            $session['total'] = NULL;
            $session['couponPer'] = NULL;
            $session['discount'] = NULL;
            $session['client'] = NULL;
            $session['loyalty'] = NULL;
            $session['userbirthdaycoupon'] = NULL;
            
            
        }
        
        
        
        
        return $this->render('finish', ['orders' => $orders,
            'subtotal' => $subtotal,
            'total' => $total,
            'couponPer' => $couponPer,
            'discount' => $discount,
            
            
                ]);
    }
}

