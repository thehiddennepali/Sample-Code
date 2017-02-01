<?php
namespace fbwidget\components;

use Yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class EmailManager{
    
        public static function adminEmail(){
            return \fbwidget\models\Option::getValByName('global_admin_sender_email');
        }
    
        public static function adminSendEmail($subjectName, $bodyName, $variable, $emailProvider){
            
            
            
            $subject = \fbwidget\models\Option::getValByName($subjectName);
            
            $subject = self::getBody($subject, $variable);
            
            $body = \fbwidget\models\Option::getValByName($bodyName);
            
            $body = self::getBody($body, $variable);
            
            
            
            if($emailProvider == 0){
                self::sendPhpEmail(self::adminEmail(), $subject, $body);
            }else if($emailProvider == 1){
                $email = self::sendSmtpEmail(self::adminEmail(), $subject, $body);
                
            }

        }
        
        public static function loyaltyExpire($model, $clientLoyaltyPoints){
            $client = \common\models\Client::findOne(['client_id'=>$model['client_id']]);
            
            $merchant = \common\models\Merchant::findOne(['merchant_id' => $model['merchant_id']]);
            
            $language = 'de';
        
            $option = \fbwidget\models\Option::getValByName('email_tpl_customer_loyality_exire', $language);

            $email_provider = \fbwidget\models\Option::getValByName('email_provider');
            
            $variable = [];
            $variable['first_name'] = $client->first_name;
            $variable['last_name'] = $client->last_name;
            $variable['merchant_name'] = $merchant->service_name;
            $variable['loyalty_point'] = $clientLoyaltyPoints->points;
            $variable['loyalty_expire'] = date('Y-m-d');
            
             
            $body = self::getBody($option, $variable);
        
            $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_customer_loyality_exire', $language);
            
            if($email_provider == 0){
                self::sendPhpEmail($client->email_address, $subject, $body);
            }else if($email_provider == 1){
                self::sendSmtpEmail($client->email_address, $subject, $body);
            }
            
        }


        public static function newsLetter($model){
            
            $email_provider = \fbwidget\models\Option::getValByName('email_provider');
            
            $variable = [];
            $variable['email'] = $model->email_address;
            
            $adminEmail = self::adminSendEmail('email_tpl_sub_admin_newsletter', 'email_tpl_admin_newsletter', $variable, $email_provider);
            
        }
        
        
        
        
        public static function customerLoyaltyPoints($order, $loyaltyPoint){
            
            $language = $order->merchant->language->code;
        
            $option = \fbwidget\models\Option::getValByName('email_tpl_customer_loyality', $language);

            $email_provider = \fbwidget\models\Option::getValByName('email_provider');
            
            $variable = [];
            $variable['first_name'] = Yii::$app->user->identity->first_name;
            $variable['last_name'] = Yii::$app->user->identity->last_name;
            $variable['merchant_name'] = $order->merchant->service_name;
            $variable['loyalty_point'] = $loyaltyPoint->points;
            $variable['loyalty_expire'] = date('Y-m-d', strtotime('+1 years', strtotime(date('Y-m-d'))));
            
             
            $body = self::getBody($option, $variable);
        
            $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_customer_loyality', $language);;

            
            
            if($email_provider == 0){
                self::sendPhpEmail(Yii::$app->user->identity->email_address, $subject, $body);
            }else if($email_provider == 1){
                self::sendSmtpEmail(Yii::$app->user->identity->email_address, $subject, $body);
            }
            
        }
        
        public static function membershipExpired($model){
            
            $language = 'en';
            if(!empty($model['language_id'])){
                $language = \common\models\Language::findOne(['id' => $model['language_id']])->code;
            }
            
            
            
            //$language = $model->language->code;
        
            $option = \fbwidget\models\Option::getValByName('email_tpl_merchant_membership_expires', $language);

            $email_provider = \fbwidget\models\Option::getValByName('email_provider');
            
            
            
            $variable = [];
            $variable['merchant_name'] = $model['service_name'];
            $variable['website_title'] = $model['url'];
            $variable['expiration_date'] = $model['membership_expired'];
            
            $body = self::getBody($option, $variable);
            
        
            $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_merchant_membership_expires', $language);;

            $adminEmail = self::adminSendEmail('email_tpl_sub_admin_membership_expires', 'email_tpl_admin_membership_expires', $variable, $email_provider);
            
            if($email_provider == 0){
                self::sendPhpEmail($model['contact_email'], $subject, $body);
            }else if($email_provider == 1){
                self::sendSmtpEmail($model['contact_email'], $subject, $body);
            }
            
        }

        public static function merchantRegistration($model){
        
        
        $option = \fbwidget\models\Option::getValByName('email_tpl_merchant_welcome_message');
        
        $email_provider = \fbwidget\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['client_name'] = $model->service_name;
        $variable['username'] = $model->username;
        $variable['password'] = $model->password;
        $variable['link'] = \yii\helpers\Html::a('Login into your Account',Yii::$app->getRequest()->getHostInfo().'/merchant/web/login/index');
        
        $body = self::getBody($option, $variable);
        
        $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_merchant_welcome_message');;
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_new_merchant', 'email_tpl_admin_new_merchant', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($model->contact_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($model->contact_email, $subject, $body);
        }
        
        
        
    }


    
    public static function appointmentRemider($order){
        
        $language = $order->merchant->language->code;
        
        $option = \fbwidget\models\Option::getValByName('email_tpl_customer_reminder_email', $language);
        
        $email_provider = \fbwidget\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['first_name'] = $order->client_name;
        $variable['last_name'] = "";
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['booked_service'] = $order->category->title;
        $variable['booking_total'] = $order->price;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
       
        
        
        $body = self::getBody($option, $variable);
        
        
        $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_customer_reminder_email', $language);;
        
        $subvariable = [];
        $subvariable['merchant_name'] = $order->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);
        
        
        if($email_provider == 0){
            self::sendPhpEmail($order->client_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->client_email, $subject, $body);
        }
        
    }

        public static function birthday($user, $coupon, $userBirthdayCoupon){
        $language = $coupon->merchant->language->code;
        
        $option = \fbwidget\models\Option::getValByName('email_tpl_customer_birthday_coupon', $language);
        
        $email_provider = \fbwidget\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['first_name'] = $user['first_name'];
        $variable['last_name'] = $user['last_name'];
        $variable['merchant_name'] = $coupon->merchant->service_name;
        $variable['coupon'] = $userBirthdayCoupon->code;
        $variable['coupon_expire'] = $coupon->expiration;
        
        if($coupon->voucher_type == 1){
            $coupon_value = $coupon->amount.'%';
        }else{
            $coupon_value = '€'.$coupon->amount;
        }
        
        $variable['coupon_amount'] = $coupon_value;
        
        $body = self::getBody($option, $variable);
         
//        echo '<pre>';
//        print_r($body);
        
        $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_customer_birthday_coupon', $language);;
        
        $subvariable = [];
        $subvariable['first_name'] = $user['first_name'];
        
        $subject = self::getBody($subject, $subvariable);
        
        if($email_provider == 0){
            self::sendPhpEmail($user['email_address'], $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($user['email_address'], $subject, $body);
        }
        
    }
    
    
    public static function cancelAppointment($order){
        $language = $order->merchant->language->code;
        
        $option = \fbwidget\models\Option::getValByName('email_tpl_customer_appointment_cancelled', $language);
        
        $email_provider = \fbwidget\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['first_name'] = $order->client->first_name;
        $variable['last_name'] = $order->client->last_name;
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
       
        
        
        $body = self::getBody($option, $variable);
        
        
        
        
        
        $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_customer_appointment_cancelled', $language);;
        
        $subvariable = [];
        $subvariable['merchant_name'] = $order->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);
        
        
        
        if($email_provider == 0){
            self::sendPhpEmail($order->client->email_address, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->client->email_address, $subject, $body);
        }
    }
    
    public static function cancelAppointmentMerchant($order){
        $language = $order->merchant->language->code;
        $option = \fbwidget\models\Option::getValByName('email_tpl_merchant_appointment_cancelled', $language);
        
        $email_provider = \fbwidget\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['first_name'] = $order->client->first_name;
        $variable['last_name'] = $order->client->last_name;
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
       
        
        
        $body = self::getBody($option, $variable);
        
        
        
        $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_merchant_appointment_cancelled', $language);;
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_appointment_cancelled', 'email_tpl_admin_appointment_cancelled', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($order->merchant->contact_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->merchant->contact_email, $subject, $body);
        }
    }


    public static function newAppointmentMerchant($order){
        $language = $order->merchant->language->code;
        
        $option = \fbwidget\models\Option::getValByName('email_tpl_merchant_new_appointment', $language);
        
        $email_provider = \fbwidget\models\Option::getValByName('email_provider');
        $variable = [];
        
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['customer_name'] = $order->client->first_name.' '.$order->client->last_name;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
        $variable['booking_total'] = $order->price;
        
        
        $body = self::getBody($option, $variable);
        
        
        
        $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_merchant_new_appointment', $language);;
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_new_appointment', 'email_tpl_admin_new_appointment', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($order->merchant->contact_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->merchant->contact_email, $subject, $body);
        }
        
    }


    
    public static function newAppointment($order){
        $language = $order->merchant->language->code;
        $option = \fbwidget\models\Option::getValByName('email_tpl_customer_appointment', $language);
        
        $email_provider = \fbwidget\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['first_name'] = $order->client->first_name;
        $variable['last_name'] = $order->client->last_name;
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
        $variable['booking_total'] = $order->price;
        $variable['booked_seats'] = $order->no_of_seats;
        
        $body = self::getBody($option, $variable);
        
        
        
        $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_customer_appointment', $language);;
        
        $subvariable = [];
        $subvariable['merchant_name'] = $order->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);
        
        if($email_provider == 0){
            self::sendPhpEmail($order->client->email_address, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->client->email_address, $subject, $body);
        }

    }


    public static function passwordResetRequest($user){
        
        $language = 'de';
        
        $option = \fbwidget\models\Option::getValByName('email_tpl_customer_forgot_password', $language);
        
        $email_provider = \fbwidget\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['first_name'] = $user->first_name;
        $variable['last_name'] = $user->last_name;
        $variable['link'] = \yii\helpers\Html::a('Click to change password',Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]));
        
        $body = self::getBody($option, $variable);
        
        $subject = 'Password Reset Request.';
        
        $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_customer_forgot_password', $language);;
        
        if($email_provider == 0){
            $mail = self::sendPhpEmail($user->email_address, $subject, $body);
        }else if($email_provider == 1){
            $mail = self::sendSmtpEmail($user->email_address, $subject, $body);
        }
        
        return $mail;
    }
    
    
    
    public static function customerAccountActivate($customer){
        
        $language = 'de';
        
        $option = \fbwidget\models\Option::getValByName('email_tpl_customer_user_welcome_activation', $language);
        
        $email_provider = \fbwidget\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['first_name'] = $customer->first_name;
        $variable['last_name'] = $customer->last_name;
        $variable['activation_key'] = $customer->activation_key;
        $variable['password'] = $customer->password;
        
        $body = self::getBody($option, $variable);
        
        $subject = 'Account Activation.';
        
        $subject = \fbwidget\models\Option::getValByName('email_tpl_sub_customer_user_welcome_activation', $language);;
        
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_new_customer_register', 'email_tpl_admin_new_customer_register', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($customer->email_address, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($customer->email_address, $subject, $body);
        }
        
        
    }
    
    public static function getBody($option, $variable){
        
        foreach($variable as $key => $value)
        {
                //print_r($value);
                $option = str_replace('{'.$key.'}', $value, $option);
        }
        
        return $option;
        
    }
    
    public static function sendPhpEmail($emailAddress, $subject, $body ){
        $headers = "From: appointmentapp.com<www-data@appointmentapp>\r\n";
        $headers .= "To: " . strip_tags($emailAddress) . " <" . $emailAddress . ">\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        
        //echo 'i ma here';
        
        $email = @mail($emailAddress, $subject, $body, $headers);
        
        //exit;
        
        return $email;
        
	   
    }
    
    public static function sendSmtpEmail($emailAddress, $subject, $body ){
        
        $smtpHost = \fbwidget\models\Option::getValByName('smtp_host');
        $smtpPort = \fbwidget\models\Option::getValByName('smtp_port');
        $smtpUsername = \fbwidget\models\Option::getValByName('smtp_username');
        $smtpPassword = \fbwidget\models\Option::getValByName('smtp_password');
        
        $smtp = new \yii\swiftmailer\Mailer;
        $smtp->transport = [
            
            'class' => 'Swift_SmtpTransport',
            'host' => $smtpHost,
            'username' => $smtpUsername,
            'password' => $smtpPassword,
            'port' => $smtpPort,
            'encryption' => 'tls',
            
            
        ];
        
        $smtp->compose()
        ->setFrom('appointment-portal@domain.com')
        ->setTo($emailAddress)
        ->setSubject($subject)
        ->setHtmlBody($body)
        ->send();
        
        return true;
        
                

        
        
    }
    
}

