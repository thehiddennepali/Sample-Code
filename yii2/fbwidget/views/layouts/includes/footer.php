<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;


//echo Yii::$app->getRequest()->getUserIP();exit;
$model = new \frontend\models\Newsletter;
if($model->load(Yii::$app->request->post())){
    if($model->validate()){
        
        $model->date_created = new \yii\db\Expression('NOW()');
        $model->ip_address = Yii::$app->getRequest()->getUserIP();
        if($model->save()){
            
            frontend\components\EmailManager::newsLetter($model);
            
            $model = new \frontend\models\Newsletter;
            \Yii::$app->getSession()->setFlash('newsletter', 'Subscribe Successfully.');
        }else{
           \Yii::$app->getSession()->setFlash('newsletter', 'There is some error in subscribing.Please try again later.'); 
        }
        
    }
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <h3><?php echo Yii::t('basicfield', 'Secure payments with')?></h3>
            <p><img src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/cards.png" alt="" class="img-responsive"></p>

        </div>
        <div class="col-md-2 col-sm-2">
            <h3><?php echo Yii::t('basicfield', 'About')?></h3>
            <ul>
                
                <?php 
                $defaultLanguage = \common\models\Language::findOne(['is_default' => 1])->id;
                
                //print_r($defaultLanguage);
               // exit;
                
                $sql = "select * from mt_custom_page where language_id = $defaultLanguage and assign_to like '%1%' and status=1";
                $query = Yii::$app->db->createCommand($sql)->queryAll();
                
//                echo '<pre>';
//                print_r($query);
//                exit;
                
                if($query){
                foreach($query as $page){?>
                
                    <li>
                        <a href="<?php echo Yii::$app->urlManager->createUrl(['mt-custom-page/view', 'slug'=>$page['slug_name']]) ?>">
                            <?php 
                            
                            
                            if(Yii::$app->language == 'en-US') {
                                Yii::$app->language = 'en';
                            }
                            
                            $language = \common\models\Language::findOne(['code' => Yii::$app->language]);
                            
                            $title = $page['page_name'];
                            $customePage = common\models\CustomPage::findOne(['slug_name' => $page['slug_name'], 'language_id'=>$language->id]);
                            
                            if(count($customePage) !=0 ){
                                $title = $customePage->page_name;
                            }
                            echo Yii::t('custompage',$title) ?></a></li>
<!--                    <li><a href="faq.html">Faq</a></li>
                    <li><a href="<?php // echo Yii::$app->urlManager->createUrl('site/contact') ?>">Contacts</a></li>
                    <li><a href="#0">Terms and conditions</a></li>-->
                
                <?php }
                }?>
                
                <li>
                    <a href="#0" data-toggle="modal" data-target="#login_2">
                        <?php echo Yii::t('basicfield', 'Login')?>
                    </a>
                </li>
                <li>
                    <a href="#0" data-toggle="modal" data-target="#register">
                        <?php echo Yii::t('basicfield', 'Register')?>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="col-md-2 col-sm-2">
            <h3><?php echo Yii::t('basicfield', 'For Merchants')?></h3>
            <ul>
                
                <?php 
                $defaultLanguage = \common\models\Language::findOne(['is_default' => 1])->id;
                
                //print_r($defaultLanguage);
               // exit;
                
                $sql = "select * from mt_custom_page where language_id = $defaultLanguage and assign_to like '%2%' and status=1";
                $query = Yii::$app->db->createCommand($sql)->queryAll();
                
//                echo '<pre>';
//                print_r($query);
//                exit;
                
                if($query){
                foreach($query as $page){?>
                
                    <li>
                        <a href="<?php echo Yii::$app->urlManager->createUrl(['mt-custom-page/view', 'slug'=>$page['slug_name']]) ?>">
                            <?php 
                            
                            
                            if(Yii::$app->language == 'en-US') {
                                Yii::$app->language = 'en';
                            }
                            
                            $language = \common\models\Language::findOne(['code' => Yii::$app->language]);
                            
                            $title = $page['page_name'];
                            $customePage = common\models\CustomPage::findOne(['slug_name' => $page['slug_name'], 'language_id'=>$language->id]);
                            
                            if(count($customePage) !=0 ){
                                $title = $customePage->page_name;
                            }
                            echo Yii::t('custompage',$title) ?></a></li>
<!--                    <li><a href="faq.html">Faq</a></li>
                    <li><a href="<?php // echo Yii::$app->urlManager->createUrl('site/contact') ?>">Contacts</a></li>
                    <li><a href="#0">Terms and conditions</a></li>-->
                
                <?php }
                }?>
                
                
                <li>
                    <a href="<?php echo Yii::$app->urlManager->createUrl('merchant/sign-up')?>" >
                        <?php echo Yii::t('basicfield', 'Register')?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-4 col-sm-4"  id="newsletter">
            <h3><?php echo Yii::t('basicfield', 'Newsletter')?></h3>
            <p><?php echo Yii::t('basicfield', 'Join our newsletter to keep be informed about offers and news.')?></p>
            <div id="message-newsletter_2"></div>
            
            
            <?php 
            $notification = Yii::$app->session->getFlash('newsletter');
            if(isset($notification)){
                echo '<div class="alert alert-success">';
                echo Yii::$app->session->getFlash('newsletter');
                echo '</div>';
            }
            
//            $notificationMessage = Yii::$app->session->getFlash('newsletter');
//            
//            if(isset($notificationMessage)){
//                foreach (Yii::$app->session->getFlash('newsletter') as $key => $message) {
//                    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
//                }
//            }
            
            
            $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'email_address')->textInput(['maxlength' => true, 'placeholder'=>Yii::t('basicfield', 'Your mail')])->label(false); ?>

            

            <div class="form-group">
                <?= Html::submitButton( Yii::t('basicfield', 'Subscribe'), ['class' =>  'btn_1']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            
            
        </div>

    </div><!-- End row -->
    <div class="row">
        <div class="col-md-12">
            <div id="social_footer">
                <ul>
                    
                    <?php $facebook = frontend\models\Option::getValByName('admin_fb_page');
                    $pinterest = frontend\models\Option::getValByName('admin_pinterest_page');
                    $instagramm = frontend\models\Option::getValByName('admin_instagramm_page');
                    $twitter = frontend\models\Option::getValByName('admin_twitter_page');
                    $google = frontend\models\Option::getValByName('admin_google_page');
                    ?>
                    
                    <?php if(!empty($facebook)){?>
                        <li><a href="<?php echo $facebook;?>"><i class="icon-facebook"></i></a></li>
                    <?php }?>
                        
                    <?php if(!empty($twitter)){?>
                    <li><a href="<?php echo $twitter;?>"><i class="icon-twitter"></i></a></li>
                    
                    <?php }?>
                    
                    <?php if(!empty($google)){?>
                    <li><a href="<?php echo $google;?>"><i class="icon-google"></i></a></li>
                    
                    <?php }?>
                    
                    <?php if(!empty($instagramm)){?>
                    <li><a href="<?php echo $instagramm;?>"><i class="icon-instagram"></i></a></li>
                    <?php }?>
                    
                    <?php if(!empty($pinterest)){?>
                    <li><a href="<?php echo $pinterest;?>"><i class="icon-pinterest"></i></a></li>
                    
                    <?php }?>
                    
<!--                    <li><a href="#0"><i class="icon-vimeo"></i></a></li>
                    <li><a href="#0"><i class="icon-youtube-play"></i></a></li>-->
                </ul>
                <p> 
                    <?php $name = frontend\models\Option::getValByName('website_title');?>
                    <?php echo $name;?> - &copy; <?php echo date('Y');?></p>
            </div>
        </div>
    </div><!-- End row -->
</div><!-- End container -->