<?php
namespace fbwidget\controllers;

use Yii;
use \yii\helpers\Json;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class WidgetController extends \yii\web\Controller{
	
	public $layout = 'widget-layout';
	public $enableCsrfValidation = false;
	
	public function behaviors()
	{
		return [
		    'access' => [
			'class' => \yii\filters\AccessControl::className(),
			
			'rules' => [
			    [
				'actions' => [
				    'gift-voucher',
				    'voucher',
				    'verification'
				    
				    ],
				'allow' => true,
				'roles' => ['?', '@'],
			    ],
			    [
				'actions' => [
				    'voucher-payment',
				    'voucher-finish'
				    
				    ],
				'allow' => true,
				'roles' => ['@'],
			    ],
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
	
	
	public function actionGiftVoucher($id){
		
		$session = Yii::$app->session;
		$session['merchant_id'] = $id;
		
		$merchant = \fbwidget\models\MtMerchant::findOne(['merchant_id' => $id]);
		
		
		$language = $merchant->language->code;
		if(isset($language)){            

		    Yii::$app->language = $language;

		    $languageCookie = new \yii\web\Cookie([
			'name' => 'language',
			'value' => $language,
			'expire' => time() + 60 * 60 * 24 * 30, // 30 days
		    ]);
		    Yii::$app->response->cookies->add($languageCookie);

		}
		
		
		$giftVoucher = \common\models\GiftVoucher::find()->where(['merchant_id' => $id, 'status' => 1])->orderBy('type asc')->all();
		
		
		if(Yii::$app->request->isPost){
			$session = Yii::$app->session;
			if(isset($session['Vouchercart']) && count(array_filter($session['Vouchercart'])) != 0){
				
				if(Yii::$app->user->id){
					$this->redirect(['voucher-payment']);
					
				}else{
					
					$this->redirect(['voucher']);
				}
				
				
			}
			
		}
		
		return $this->render('gift-voucher', [
		    'model' => $merchant,
		    'giftVoucher' => $giftVoucher,
		    'currencycode' => \common\components\Helper::getCurrencyCode($merchant)
		]);
		
	}
	
	public function actionVoucher(){
	    $session = Yii::$app->session;
	    $login = new \fbwidget\models\LoginForm;
	    $client = new \fbwidget\models\Client();
	    $client->scenario = 'checkout';


	    if(empty($session['Vouchercart']) || count(array_filter($session['Vouchercart'])) == 0){

		return $this->goHome();

	    }

	    if(!empty($session['client'])){
		$client->attributes = $session['client'];
	    }

	    if($client->load(Yii::$app->request->post())){

		if($client->validate()){


		    $session['client'] = $client->attributes;

		    $client = \fbwidget\models\Client::find()->where(['email_address' => trim($session['client']['email_address'])])->one();

		    if(count($client) == 0 ){
			    $password = Yii::$app->getSecurity()->generateRandomString(6);
			    $client = new \common\models\Client;
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
				$addressBook  = new \frontend\models\MtAddressBook;
				$addressBook->attributes = $session['client'];
				$addressBook->client_id = $client->id;
				$addressBook->ip_address = Yii::$app->request->userIP;
				$addressBook->save(false);

				$email = EmailManager::customerAccountActivate($client);
				$url = Yii::$app->urlManager->createUrl('verification');

			    }



		    }else if(empty($client->password)){

			$client->password = $session['client']['email_address'];
			$client->setPassword($session['client']['email_address']);
			$client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
			$client->status = 0;
			$client->save(false);
			$email = EmailManager::customerAccountActivate($client);
			$url = Yii::$app->urlManager->createUrl('verification');

		    }else if($client->status == 0){
			$client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
			$client->save(false);
			$email = EmailManager::customerAccountActivate($client);
			$url = Yii::$app->urlManager->createUrl('verification');
		    }else{
			$login = new \frontend\models\LoginForm;
			$login->email = $client->email_address;
			$login->password = $client->password;
			//$error = ActiveForm::validate($login);


			$login->login();
			$url = Yii::$app->urlManager->createUrl('voucher-payment');
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
		    $this->redirect(['voucher-payment']);
		}

	    }

	    return $this->render('voucher', [
		'client' => $client,
		'login' => $login
	    ]);
	}
	
	
	public function actionVerification(){
        
		$login = new \fbwidget\models\LoginForm;
		$client = new \fbwidget\models\Client;
		$client->scenario = 'activation';

		$this->layout = 'widget-layout';

		if($login->load(Yii::$app->request->post())){
		    if($login->login()){
			$this->redirect(['voucher-payment']);
		    }

		}

		if($client->load(Yii::$app->request->post())){
		    if($client->validate()){
			$checkClient = \fbwidget\models\Client::findOne(['activation_key' => trim($client->activation_key)]);

			if(count($checkClient) == 1){
			    $checkClient->status = 1;
			    $checkClient->save(false);

			    $login = new \fbwidget\models\LoginForm;
			    $login->email = $checkClient->email_address;
			    $login->password = $checkClient->password;
			    //$error = ActiveForm::validate($login);


			    if($login->login()){

				$this->redirect(['voucher-payment']);
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
	
	public function actionVoucherPayment(){
		
		$addressBilling = new \frontend\models\BillingAddress();
		
		
		$addressShipping = new \frontend\models\ShippingAddress();
		
		$addToCart = new \fbwidget\models\AddToCart;
		$addToCart->scenario = 'giftvoucher';
		
			
		if(Yii::$app->request->isAjax){
			
			$addToCart->load(Yii::$app->request->post());
			
			
			if($addToCart->validate()){
				
				$session = Yii::$app->session;
				
				
				if(!empty($session['Vouchercart'])){
					
					
					
					
					if($addToCart->deliveryOption == 2){

						$addressShipping->load(Yii::$app->request->post());
						if($addressShipping->validate()){
							$address = new \frontend\models\MtAddressBook;
							$address->attributes = $addressShipping->attributes;
							$address->client_id = Yii::$app->user->id;
							$address->as_default = 2;	
							$address->save();
							$addressId = $address->id;

						}else{
							echo Json::encode(['success' => false, 'message' => $addressShipping->errors]);
							Yii::$app->end();

						}

					}else if($addToCart->deliveryOption == 1){
						$addressClient = \frontend\models\MtAddressBook::findOne(['client_id' => Yii::$app->user->id, 'as_default' => 1]);
						
						if(count($addressClient) == 0){
							
							$addressBilling->load(Yii::$app->request->post());
							
							if($addressBilling->validate()){
								$address = new \frontend\models\MtAddressBook;
								$address->attributes = $addressBilling->attributes;
								$address->client_id = Yii::$app->user->id;
								$address->as_default = 1;	
								$address->save();
								$addressId = $address->id;

							}else{
								echo Json::encode(['success' => false, 'message' => $addressBilling->errors]);
								Yii::$app->end();

							}
							
						}else{
							
							if(isset($_POST['BillingAddress'])){
								$addressBilling->load(Yii::$app->request->post());

								if($addressBilling->validate()){

									$addressClient->attributes = $addressBilling->attributes;
									$addressClient->client_id = Yii::$app->user->id;
									$addressClient->as_default = 1;	
									$addressClient->save();
									$addressId = $addressClient->id;

								}else{
									echo Json::encode(['success' => false, 'message' => $addressBilling->errors]);
									Yii::$app->end();

								}
							}
							
							$addressId = $addressClient->id;
							
							
						}
						
						
					
						
					}
					
					$client = Yii::$app->user->identity;
					
					$query = \frontend\components\Paypal::VoucherPost($session);
					
					$orderId = 0;
					
					$i=1;foreach ($session['Vouchercart'] as $key=>$value){
						
						$model = new \frontend\models\Order;
						$model->client_name = $client->first_name.' '.$client->last_name;
						
						$model->payment_type = $addToCart->paymentMethod;
						$model->client_id = $client->client_id;
						$model->source_type = 1;
						$model->merchant_id = $session['merchant_id'];
						$model->voucher_note = $address->notevoucher;
						

						
						$model->gift_voucher_id = $key;
						$model->client_name = $client->first_name;
						$model->client_email = $client->email_address;
						$model->client_phone = $client->contact_phone;

						$model->no_of_seats = $value['qty'];
						$model->is_service_gift = 1;
						$model->delivery_option = $addToCart->deliveryOption;
						$model->delivery_fee = $addToCart->deliveryFee;
						if(!empty($addressId))  $model->address_id = $addressId;
						$price = $value['price']; 

						$model->price = $price;

						if($model->payment_type == 2){
						    $model->payment_status = 'pending';
						    $model->status = 4;

						}
						
						$commission = $model::getCommision($model->merchant_id, $model->price);

						$model->total_commission = $commission['total_commision'];
						$model->merchant_earnings = $commission['merchant_earnings'];
						$model->percent_commision = $commission['percent_commision'];
						
						
						if($model->payment_type == 2){
							
							$query['custom'] =  $orderId;


							//$custom = base64_encode($custom);
							//$query['custom_'.$i] = json_encode(['id' => $key, 'addonlist' => $v['addons_list']]);
							$query['item_name_'.$i] = $value['title'];
							$query['quantity_'.$i] = $value['qty'];
							$query['amount_'.$i] = $model->price;
						}
						
						$model->order_id = $orderId;
						
						
						
						if($model->save(false)){
							if($model->payment_type != 2){
								\frontend\components\EmailManager::buyVoucher($model);
								\frontend\components\EmailManager::buyVoucherMerchant($model);
							}
						}
						
						if($i==1){
							$orderId = $model->id;
						}
						


					$i++;
					}
					
					$merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $model->merchant_id]);
					
					$session['orderid'] = $orderId;
					
//					print_r($query);
//					exit;
					
					if($addToCart->paymentMethod == 2){
						
						$post = http_build_query($query);
						
						$paypal = new \frontend\components\Paypal;
						
						$paypal->is_sandbox = $merchant->is_paypall_sandbox;
						
						
						echo Json::encode(['success' => true,
						    'data' => $paypal->paypal_url_parse.'?'.$post, 
						    'payment' => $addToCart->paymentMethod,
						    ]);
						Yii::$app->end();
					}else{
						
						
						
						$merchantLoylitypoints = \frontend\models\LoyaltyPoints::findOne(['merchant_id' => $model->merchant_id]);

						if($merchant->giftVoucherSetting->receive_loyalty_points == 1 && $merchantLoylitypoints->is_active == 1){

						    $loyalitypoint = \frontend\models\Option::getValByName('website_loyalty_points');

						    if(!empty($loyalitypoint)){
							$clintLoyalityPoint = \frontend\models\ClientLoyalityPoints::findOne(['client_id' => Yii::$app->user->id, 'merchant_id' => $model->merchant_id]);


							if(count($clintLoyalityPoint) == 0){
							    $clintLoyalityPoint = new \frontend\models\ClientLoyalityPoints();
							    $clintLoyalityPoint->client_id = Yii::$app->user->id;
							    $clintLoyalityPoint->merchant_id = $model->merchant_id;
							    $clintLoyalityPoint->created_at = new Expression('NOW()');
							}

							$total = $session['voucher-total'];

							$clintLoyalityPoint->points += $loyalitypoint * $total;
							$clintLoyalityPoint->save(false);

							$minimumLoyaltyPoints = \frontend\models\Option::getValByName('minimum_loyalty_points');

							if($clintLoyalityPoint->points >= $minimumLoyaltyPoints){
								\frontend\components\EmailManager::customerLoyaltyPoints($model, $clintLoyalityPoint);

							}
						    }

						}
						
						
						
						echo Json::encode(['success' => true,
						    'data' => Yii::$app->urlManager->createUrl('widget/voucher-finish'),
						    'payment' => $addToCart->paymentMethod,
						    ]);
						Yii::$app->end();
					}
					
				
					
					
				}
				
				
				
				
			}else{
				if(Yii::$app->request->isAjax){
					echo Json::encode(['success' => false, 'message' => $addToCart->errors]);
					Yii::$app->end();
					
				}
			}
			
			

		}
			
		
		
		return $this->render('voucher-payment', [
		    'addressBilling' => $addressBilling,
		    'addressShipping' => $addressShipping,
		    'addToCart' => $addToCart
		]);
	}
	
	
	public function actionVoucherFinish(){
		
		$session = Yii::$app->session;
		
		$cart = $session['Vouchercart'];
		
		$session['Vouchercart'] = NULL;
	
		$order = \frontend\models\Order::findOne(['id' => $session['orderid']]);
		
		return $this->render('voucher_finish', [
		    'cart' => $cart,
		    'subtotal' => \frontend\components\UrlHelper::numberFormat($session['voucher-subtotal']),
		    'order' => $order
		]);
		
		
	}
}

