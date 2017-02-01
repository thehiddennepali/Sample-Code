<?php
namespace fbwidget\components;

use Yii;
use yii\db\Expression;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Paypal{
    
    public $ipn_response;
    public $ipn_post;
    public $paypal_url;
    public $paypal_url_parse;
    
    function __construct() 
    {
        $this->paypal_url = 'www.sandbox.paypal.com';
        $this->paypal_url_parse = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }

    
    
    
    public function merchantIpn(){
        
        $sql = 'INSERT into dummy (dummy) values("i am here")';
        $query = Yii::$app->db->createCommand($sql)->execute();
        
//                $sql = 'SELECT * FROM dummy WHERE id=47';
//        $query = Yii::$app->db->createCommand($sql)->queryOne();
//        
//        echo '<pre>';
////        $urldeccode = explode('&', urldecode($query['dummy']));
////        $explode = explode('=', $urldeccode[19]);
////        print_r(json_decode($explode[1]));
//        echo $data = base64_decode($query['dummy']);
//        //$data1 = (explode('&', $data));
//        print_r(explode('_', $data));
//        
//        
//        exit;
        $post = $_POST;
        $url = $this->paypal_url;
        
        $url_parsed = parse_url($this->paypal_url_parse);
        $post_string = '';
        $post = $_POST;
        foreach ($_POST as $field => $value) {
            
            $post_string .= $field . '=' . urlencode(stripslashes($value)) . '&';
        }
        
        $post_string.="cmd=_notify-validate"; // append ipn command
        // open the connection to paypal
        
        $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        $fp = fsockopen('ssl://' . $url, 443, $errno, $errstr, 30);
        
        $sql = 'INSERT into dummy (dummy) values("'. $post_string.'")';
        $query = Yii::$app->db->createCommand($sql)->execute();
        
        //exit;
        
        if (!$fp) {

            // could not open the connection.  If loggin is on, the error message
            // will be in the log.
//            $this->last_error = "fsockopen error no. $errnum: $errstr";
//            $this->log_ipn_results(false);
            return false;
        } else {

            // Post the data back to paypal
            fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n");
            fputs($fp, "Host: $url_parsed[host]\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: " . strlen($post_string) . "\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $post_string . "\r\n\r\n");

            // loop through the response from the server and append to variable
            while (!feof($fp)) {
                $this->ipn_response .= fgets($fp, 1024);
            }
            
            $sql = 'INSERT into dummy (dummy) values("'.  $this->ipn_response.'")';
            $query = Yii::$app->db->createCommand($sql)->execute();

            fclose($fp); // close connection
        }
        
        //if (eregi("VERIFIED", $this->ipn_response)) {
            
            $sql = 'INSERT into dummy (dummy) values("'.$post['custom'].'")';
            $query = Yii::$app->db->createCommand($sql)->execute();
            
            $custom = base64_decode($post['custom']);
            
            $custom = explode('_', $custom);
            
            $merchant = \frontend\models\MtMerchant::findOne(['contact_email' => $custom[4]]);
            
            if(count($merchant) == 0)
            $merchant = new \frontend\models\MtMerchant;
            
            $merchant->service_name = $custom[0];
            $merchant->service_phone = $custom[1];
            $merchant->contact_name = $custom[2];
            $merchant->contact_phone = $custom[3];
            $merchant->contact_email = $custom[4];
            $merchant->street = $custom[5];
            $merchant->city = $custom[6];
            $merchant->post_code = $custom[7];
            $merchant->country_code = $custom[8];
            $merchant->username = $custom[9];
            $merchant->package_id = $custom[11];
            
            
            $merchant->setPassword($custom[10]);
            $merchant->payment_steps = 2;
            $merchant->ip_address = $_SERVER['REMOTE_ADDR'];
            $merchant->generateAuthKey();
            $merchant->free_delivery = 0;
            $merchant->status = 1;
            $merchant->date_created = new Expression('NOW()');
            


            $seoRule = \common\models\SeoRule::findOne(['type' =>1]);
            $merchant->is_manual_seorule = 1;
            $merchant->seo_rule_id = $seoRule->id;
            $merchant->seo_description = $seoRule->meta_description;
            $merchant->seo_title = $seoRule->meta_title;
            $merchant->seo_keywords = $seoRule->meta_keyword;
            
            if($merchant->save(false)){
                        
                
                
                $merchantPackageOrder = \common\models\MerchantPackageOrder::findOne(['merchant_id' => $merchant->id, 'package_id' => $merchant->package_id]);
                
                if(count($merchantPackageOrder) == 0)
                $merchantPackageOrder = new \common\models\MerchantPackageOrder;
                
                $merchantPackageOrder->attributes = $post;
                
                $merchantPackageOrder->merchant_id = $merchant->merchant_id;
                $merchantPackageOrder->package_id = $merchant->package_id;
                $merchantPackageOrder->item_name = $post['item_name1'];
                $merchantPackageOrder->price = $post['mc_gross_1'];
                $merchantPackageOrder->email = $post['payer_email'];
                
                $merchantPackageOrder->payment_type = 2;
                
                if($merchantPackageOrder->save(false)){
                    \frontend\components\EmailManager::merchantRegistration($merchant);
                }
            }
            
            
        //}
        
        
        
        
        
    }
    
    public static function merchantPost($model){
        
            
            //$merchant = Option;
            
            
            $query = [];
            
            
            $server = Yii::$app->params['server'];
            
            $host = ($server == 1) ? Yii::$app->getRequest()->getHostInfo() : 'http://c0e02485.ngrok.io/appointment-portal';
            
            
            $query['notify_url'] = $host.'/merchant/paypal-ipn';
            $query['return'] = $host.'/merchant/verification';
            $query['cancel_return'] = $host.'/merchant/payment';
            
            $query['cmd'] = '_cart';
            $query['upload'] = '1';
            $query['business'] = 'nirmal_roka2006@gmail.com';
            $query['address_override'] = '0';
            $query['first_name'] = $model->contact_name;
            
            $query['email'] = $model->contact_email;
            $query['address1'] = $model->street;
            $query['city'] = $model->city;
            $query['state'] = $model->state;
            $query['zip'] = $model->post_code;
            
            $custom = $model->service_name.'_';
            $custom .= $model->service_phone.'_';
            $custom .= $model->contact_name.'_';
            $custom .= $model->contact_phone.'_';
            $custom .= $model->contact_email.'_';
            $custom .= $model->street.'_';
            $custom .= $model->city.'_';
            $custom .= $model->post_code.'_';
            $custom .= $model->country_code.'_';
            $custom .= $model->username.'_';
            $custom .= $model->password.'_';
            $custom .= $model->package_id;
            
            
            
            $query['item_name_1'] = $model->package->title;
            $query['quantity_1'] = 1;
            $query['amount_1'] = $model->package->price ;
            
            $query['custom'] = base64_encode($custom);
            
//            print_r($query);
//            exit;
            
            
            
            $query_string = http_build_query($query);
            
            return $query_string;
            
            
            
            
        
        
    }


    public function ipn(){
        
//        $sql = 'INSERT into dummy (dummy) values("i ma here")';
//        $query = Yii::$app->db->createCommand($sql)->execute();
        
        
        
//        $sql = 'SELECT * FROM dummy WHERE id=6';
//        $query = Yii::$app->db->createCommand($sql)->queryOne();
//        
//        echo '<pre>';
////        $urldeccode = explode('&', urldecode($query['dummy']));
////        $explode = explode('=', $urldeccode[19]);
////        print_r(json_decode($explode[1]));
//        $data = base64_decode($query['dummy']);
//        //$data1 = (explode('&', $data));
//        
//        print_r($data);
//        print_r(explode('_', $data));
//        
//        
//        exit;
        
        $url = 'www.sandbox.paypal.com';
        
        $url_parsed = parse_url('https://www.sandbox.paypal.com/cgi-bin/webscr');
        $post_string = '';
        $post = $_POST;
        foreach ($_POST as $field => $value) {
            
            $post_string .= $field . '=' . urlencode(stripslashes($value)) . '&';
        }
        
        $post_string.="cmd=_notify-validate"; // append ipn command
        // open the connection to paypal
        
        $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        $fp = fsockopen('ssl://' . $url, 443, $errno, $errstr, 30);
        
        $sql = 'INSERT into dummy (dummy) values("'. $post_string.'")';
        $query = Yii::$app->db->createCommand($sql)->execute();
        
        //exit;
        
        if (!$fp) {

            // could not open the connection.  If loggin is on, the error message
            // will be in the log.
//            $this->last_error = "fsockopen error no. $errnum: $errstr";
//            $this->log_ipn_results(false);
            return false;
        } else {

            // Post the data back to paypal
            fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n");
            fputs($fp, "Host: $url_parsed[host]\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: " . strlen($post_string) . "\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $post_string . "\r\n\r\n");

            // loop through the response from the server and append to variable
            while (!feof($fp)) {
                $this->ipn_response .= fgets($fp, 1024);
            }
            
            $sql = 'INSERT into dummy (dummy) values("'.  $this->ipn_response.'")';
            $query = Yii::$app->db->createCommand($sql)->execute();

            fclose($fp); // close connection
        }
        
        //if (eregi("VERIFIED", $this->ipn_response)) {
            
            $custom = base64_decode($post['custom']);
            
            $custom = explode('&', $custom);
            
            $sql = 'INSERT into dummy (dummy) values("'.  $post['num_cart_items'].'")';
            $query = Yii::$app->db->createCommand($sql)->execute();
            
            $total = 0;
            
//            if(!isset($post['num_cart_items']))
//                $post['num_cart_items'] = 1;
            
            for($i=1; $i <= $post['num_cart_items']; $i++){
                
                
                
                $custumdata = explode('_', $custom[$i]);
                $loyalty  = $custumdata[12];
                
                $singleLoyalty = $loyalty / $post['num_cart_items'];
                
                $loyaltyPointsOne = \common\models\Option::getValByName('website_loyalty_points');
                
                $model = \frontend\models\Order::findOne(['id' => $custumdata[14]]);
                if(count($model) == 0){
                    $model = new \frontend\models\Order;
                }
                
                $model->merchant_id = $merchant = $custumdata[3];
                $model->client_id = $client = $custumdata[4];
                $model->payment_type = 1;
                $model->user_birthday_coupon_id = $custumdata[10];
                $model->staff_id = $custumdata[13];
                
                $model->source_type = 1;

                if($custumdata[9] == 0){
                //print_r($v['is_group']);
                    $model->order_time = $custumdata[6] . ' ' . $custumdata[7];
                }else if($custom[$i]['is_group'] == 1){
                    $model->order_time = $custumdata[6] . ' ' . $custumdata[8];
                }
                $model->category_id = $custumdata[2];
                $model->client_name = $post['first_name']. ' '.$post['last_name'];
                $model->client_email = $post['payer_email'];
                

                $model->loyalty_points = $loyaltyPointsOne * $singleLoyalty;
                
                $model->price = $post['mc_gross_'.$i];
                $model->txn_id = $post['txn_id'];
                $model->payment_status = $post['payment_status'];
                $model->item_no = $i;

//                        print_r($model->attributes);
//                        exit;



                if($model->save(false)){

                    $addons = $custumdata[5] ;

                    if(!empty($addons)){
                        $addons = explode('/', $addons);
                        foreach($addons as $val){
                            $m = Addons::findOne(['id'=>$val]);
                            $model->price += $m->price;
                            
                            $addonHasOrder = \frontend\models\AddonHasOrder::findOne(['order_id' => $model->id]);
                            
                            if(count($addonHasOrder) == 0)
                            $addonHasOrder = new AddonHasOrder;
                            
                            $addonHasOrder->addon_id = $val;
                            $addonHasOrder->order_id = $model->id;
                            $addonHasOrder->save(false);
                        }
                    }
                    
                    $total +=$model->price;
                            



                    $commission = $model::getCommision($model->merchant_id, $model->price);

                    $model->total_commission = $commission['total_commision'];
                    $model->merchant_earnings = $commission['merchant_earnings'];
                    $model->percent_commision = $commission['percent_commision'];

                    if(isset($custumdata[5])){
                        $model->voucher_id = $custumdata[11];
                    }
                    $model->status = 0;
                    $model->save(false);


                    \frontend\components\EmailManager::newAppointment($model);
                    \frontend\components\EmailManager::newAppointmentMerchant($model);

                }
                
            }
            
            $merchantLoylitypoints = \frontend\models\LoyaltyPoints::findOne(['merchant_id' => $merchant]);
        
                if($merchantLoylitypoints->is_active == 1){

                    $loyalitypoint = \frontend\models\Option::getValByName('website_loyalty_points');

                    if(!empty($loyalitypoint)){
                        $clintLoyalityPoint = \frontend\models\ClientLoyalityPoints::findOne(['client_id' => $client, 'merchant_id' => $merchant]);


                        if(count($clintLoyalityPoint) == 0){
                            $clintLoyalityPoint = new \frontend\models\ClientLoyalityPoints();
                            $clintLoyalityPoint->client_id = $client;
                            $clintLoyalityPoint->merchant_id = $merchant;
                            $clintLoyalityPoint->created_at = new \yii\db\Expression('NOW()');
                        }
                        
                        $clintLoyalityPoint->points -= $loyalty;

                        $clintLoyalityPoint->points += $loyalitypoint * $total;
                        $clintLoyalityPoint->save(false);
                    }

                }
            
        //}
        
    }
    
    
    public static function Post($session){
        
        if(!empty($session['cart'])){
            
            $merchant = \common\models\Merchant::findOne(['merchant_id' => $session['merchant_id']]);
            $user = Yii::$app->user->identity;
            
            $query = [];
            
            
            $server = Yii::$app->params['server'];
            
            $host = ($server == 1) ? Yii::$app->getRequest()->getHostInfo() : 'http://c0e02485.ngrok.io/appointment-portal';
            
            
            $query['notify_url'] = $host.'/checkout/paypal-ipn';
            $query['return'] = $host.'/checkout/finish';
            $query['cancel_return'] = $host.'/checkout/payment';
            $query['cmd'] = '_cart';
            $query['upload'] = '1';
            $query['business'] = $merchant->paypall_id;
            $query['address_override'] = '0';
            $query['first_name'] = $user->first_name;
            $query['last_name'] = $user->last_name;
            $query['email'] = $user->email_address;
            $query['address1'] = $user->street;
            $query['city'] = $user->city;
            $query['state'] = $user->state;
            $query['zip'] = $user->zipcode;
            $query['currency_code'] = 'EUR';
            
            return $query;
            
            //print_r($session['cart']);
            
            $i =1;foreach ($session['cart'] as $key=>$value){
                foreach($value as $k=>$v){
                    
                    $order = new \frontend\models\Order;
                    $order->attributes = $v;
                    $order->category_id = $key;
                    
//                    $custom[$i]['id'] = $key; 
//                    $custom[$i]['merchant_id'] = $merchant->id;
//                    $custom[$i]['client_id'] = $user->id;
//                    $custom[$i]['addon'] = $v['addons_list']; 
//                    $custom[$i]['order_date'] = $v['order_date'];
//                    $custom[$i]['free_time_list'] = $v['free_time_list'];
//                    $custom[$i]['time_req'] = $v['time_req'];
//                    $custom[$i]['is_group'] = $v['is_group'];
                    
                    $addons = implode('/', $v['addons_list']);
                    $custom .= '&'.'_'.$i.'_'.$key.'_'.$merchant->id.'_'.$user->id.'_'.$addons.'_'.$v['order_date'].'_'.$v['free_time_list'].'_'.$v['time_req'].'_'.$v['is_group'].'_'.$session['couponid'].'_'.$session['userbirthdaycoupon'].'_'.$session['loyalty'].'_'.$v['staff_id'];
                    
                    
                    //$custom = base64_encode($custom);
                    //$query['custom_'.$i] = json_encode(['id' => $key, 'addonlist' => $v['addons_list']]);
                    $query['item_name_'.$i] = $v['title'];
                    $query['quantity_'.$i] = 1;
                    $query['amount_'.$i] = $order::getPrice($order); ;
                
               $i++; }
            
            
                }
                
                
//                print_r($query);
//                exit;
                
            $query['custom'] = base64_encode($custom);

            $query_string = http_build_query($query);
            
            return $query_string;
            
            
        }
        
    }
}

