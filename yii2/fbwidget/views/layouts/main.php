<?php
/* @var $this View */
/* @var $content string */

use fbwidget\assets\AppAsset;
use fbwidget\models\LoginForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body itemscope itemtype="http://schema.org/WebPage">
        
        
        <?php $this->beginBody();
        
        $cookies = Yii::$app->request->cookies;
        
        $languageCookie = $cookies['language'];
        
        if(isset($languageCookie->value) && !empty($languageCookie->value)){
            Yii::$app->language = $languageCookie->value;
        }
        
        
        
        ?>


        <!--[if lte IE 8]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
        <![endif]-->

        <div id="preloader">
            <div class="sk-spinner sk-spinner-wave" id="status">
                <div class="sk-rect1"></div>
                <div class="sk-rect2"></div>
                <div class="sk-rect3"></div>
                <div class="sk-rect4"></div>
                <div class="sk-rect5"></div>
            </div>
        </div><!-- End Preload -->

        <!-- Header ================================================== -->
        <header>

            <?php echo $this->render('includes/header') ?>
        </header>

        <?php echo $content; ?>
        <footer>
            <?php echo $this->render('includes/footer') ?>
        </footer>
        <!-- End Footer =============================================== -->

        <div class="layer"></div><!-- Mobile menu overlay mask -->

        <!-- Login modal -->   
        <div class="modal fade" id="login_2" tabindex="-1" role="dialog" aria-labelledby="myLogin" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-popup">
                    <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                    
                    <?php 
                    $model = new LoginForm;
                    $form = ActiveForm::begin(['id' => 'login-form',
                        
                        'options'=>[
                        'class'=>'popup-form'
                            ],
                            
                        ]); ?>
                    
                    <div class="login_icon"><i class="icon_lock_alt"></i></div>

                        <?= $form->field($model, 'email', ['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->textInput(['autofocus' => true,'class'=>'form-control form-white','placeholder'=>Yii::t('basicfield','Email')])->label(false) ?>

                        <?= $form->field($model, 'password', ['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->passwordInput(['class'=>'form-control form-white','placeholder'=>Yii::t('basicfield','Password')])->label(false)  ?>

                        

                        <div class="text-left">
                            <?= Html::a(Yii::t('basicfield','Forgot Password?'), ['site/request-password-reset']) ?>.
                        </div>

                        <div class="form-group">
                            <?= Html::button(Yii::t('basicfield','Submit'), ['class' => 'btn btn-submit save',
                                'name' => 'login-button',
                                'id'=>'save',
                                'data-url'=>Yii::$app->urlManager->createUrl('site/login'),
                                'data-formid' => 'login-form']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                    
                    

                </div>
            </div>
        </div><!-- End modal -->   

        <!-- Register modal -->   
        <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myRegister" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-popup">
                    <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                    <?php 
                    
                    $register = new fbwidget\models\Client;
                    
                    $form = ActiveForm::begin([
                        'id' => 'register-form',
                        
                        'options' =>[
                            'class' => 'popup-form'
                        ]
                    ]); ?>

                    <div class="login_icon"><i class="icon_lock_alt"></i></div>

                    <?= $form->field($register, 'first_name',['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->textInput(['maxlength' => true,'class'=>'form-control form-white',
                            'placeholder'=>Yii::t('basicfield','First Name')])->label(false) ?>

                    <?= $form->field($register, 'last_name',['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->textInput(['maxlength' => true,'class'=>'form-control form-white',
                            'placeholder'=>Yii::t('basicfield','Last Name')])->label(false) ?>

                    <?= $form->field($register, 'email_address',['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->textInput(['maxlength' => true,'class'=>'form-control form-white',
                            'placeholder'=>Yii::t('basicfield','Email')])->label(false) ?>

                    <?= $form->field($register, 'password',['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->passwordInput(['maxlength' => true,'class'=>'form-control form-white',
                            'placeholder'=>Yii::t('basicfield','Password')])->label(false) ?>

                    <?= $form->field($register, 'confirm_password',['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->passwordInput(['maxlength' => true,'class'=>'form-control form-white',
                            'placeholder'=>Yii::t('basicfield','Confirm Password')])->label(false) ?>
                    <div class="checkbox-holder text-left">
                        <div class="checkbox">
                            <input type="checkbox" value="accept_2" id="check_2" name="check_2" />
                            <label for="check_2">
                                <span> <?php echo Yii::t('basicfield', 'I Agree to the Terms & Conditions')?>
                                    </span></label>
                        </div>
                    </div>
<!--                    <div class="checkbox-holder text-left">
                        <div class="checkbox">
                            <?= $form->field($register, 'agree',['template'=>'{input}{error}', 
                            'options' => [
                            'tag'=>false
                        ]])->checkbox(['label'=>false])->label(false) ?>
                    
                            <label for="check_2"><span>I Agree to the <strong>Terms &amp; Conditions</strong></span></label>
                        </div>
                    </div>-->

                    
                    <?= Html::submitButton( Yii::t('basicfield','Register'), ['class' =>  'btn btn-submit save', 'id'=>'save', 
                        'data-url'=>Yii::$app->urlManager->createUrl('client/create'),
                        'data-formid' => 'register-form'
                        ]) ?>
                    

    <?php ActiveForm::end(); ?>
                    
<!--                    <form action="#" class="popup-form" id="myRegister">
                        <div class="login_icon"><i class="icon_lock_alt"></i></div>
                        <input type="text" class="form-control form-white" placeholder="Name">
                        <input type="text" class="form-control form-white" placeholder="Last Name">
                        <input type="email" class="form-control form-white" placeholder="Email">
                        <input type="text" class="form-control form-white" placeholder="Password"  id="password1">
                        <input type="text" class="form-control form-white" placeholder="Confirm password"  id="password2">
                        <div id="pass-info" class="clearfix"></div>
                        <div class="checkbox-holder text-left">
                            <div class="checkbox">
                                <input type="checkbox" value="accept_2" id="check_2" name="check_2" />
                                <label for="check_2"><span>I Agree to the <strong>Terms &amp; Conditions</strong></span></label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-submit">Register</button>
                    </form>-->
                </div>
            </div>
        </div><!-- End Register modal -->


        <?php $this->registerJs("
            $(document).ready(function(){
            
		'use strict';
		$.cookieBar({
                    message : '".Yii::t('basicfield', 'We use cookies to track usage and preferences')."', 
                    fixed: true,
                    policyText: '".Yii::t('basicfield','Privacy Policy')."', 
                    acceptText: '".Yii::t('basicfield','OK')."', 
                    policyURL : '".Yii::$app->urlManager->createUrl(['mt-custom-page/view', 'slug' => 'term-and-condition'])."',
		});
                
                $('.save').click(function(e){
                    e.preventDefault();
                    
                    var url = $(this).data('url');
                    var formid = $(this).data('formid');
                    
                    console.log(formid);
                    
                    
                    $.ajax({
                        type : 'post',
                        url : url,
                        data : $('#' + formid).serialize(),
                        success : function (response){
                        
                            $('body .help-block').remove();
                            if(response.success == true){
                                window.location.assign(response.redirect);
                            }
                            else{
                                $.each(response, function(key, val) {

                                    $('#'+key).after('<div class=\"help-block\">'+val+'</div>');

                                });
                            }
                        
                        }
                    })
                
                    })
                    
                    
                
                
                
		});
                
        "); ?>


        <?php $this->endBody() ;
        
        $this->registerJs("
            var socket = io.connect('https://aondego.com:8080/', {secure: true});
                    socket.on('connect', function () {
                        console.log('Connected!');
                        var order = {user: 'order', text: 'name'};
                        console.log(order);


                    });
                    socket.on('order-".Yii::$app->user->id."', function (order) {
                        console.log('i am hjere');
                        console.log(order);
                        if (order.data_id)
                            $('.calendar-' + order.staff_id).fullCalendar('removeEvents', order.data_id);
                        if (order.type != 5)
                            $('.calendar-' + order.staff_id).fullCalendar('renderEvent', order, true);
                        $('.notif-new-order-total-counter').html(parseInt($('.notif-new-order-total-counter').html()) + 1);

                        if (($('#group-order-grid').length > 0) && (order.type == 4 || order.type == 3 || order.type == 7)) {
                            $('#group-order-grid').yiiGridView('update');
                        }

                        switch (order.type) {
                            case 1:
                                $('#notif-new-order-created').html(parseInt($('#notif-new-order-created').html()) + 1);
                                break;
                            case 2:
                                $('#notif-new-order-changed').html(parseInt($('#notif-new-order-changed').html()) + 1);
                                break;
                            case 3:
                                $('#notif-new-order-created').html(parseInt($('#notif-new-order-created').html()) + 1);
                                break;
                            case 4:
                                $('#notif-new-order-canceled').html(parseInt($('#notif-new-order-canceled').html()) + 1);
                                break;
                            case 5:
                                $('#notif-new-order-canceled').html(parseInt($('#notif-new-order-canceled').html()) + 1);
                                break;
                            case 7:
                                $('#notif-new-order-changed').html(parseInt($('#notif-new-order-changed').html()) + 1);
                                break;
                        }
                        //$('.calendar-' + order.staff_id).fullCalendar('render');
                    });
                    ");
        ?>
    </body>
</html>
<?php $this->endPage() 
        
        
        ?>
