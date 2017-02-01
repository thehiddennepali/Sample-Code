<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php
$session = Yii::$app->session;
$keyword = $session['keyword'];
$merchantid = $session['merchant_id'];

if (isset($merchantid)) {
    $merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantid]);
    
    $currencyCode = common\components\Helper::getCurrencyCode($merchant);
}
?>



<div id="container_pin">
    <div class="row">
        <div class="col-md-3">

            <div id="cart_box">
                <h3>
                    <?php echo Yii::t('basicfield', 'Existing customer Login')?> 
                    <i class="icon_calendar pull-right"></i></h3>


                <?php //echo $this->render('left_bar')  ?>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($login, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($login, 'password')->passwordInput() ?>



                <div class="form-group">
                    <?= Html::submitButton(Yii::t('basicfield', 'Login to proceed'), ['class' => 'btn_full', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div><!-- End col-md-3 -->

        <div class="col-md-5">

            <?php
            echo $this->render('personal_detail', [
                'model' => $client
            ])
            ?>
        </div><!-- End col-md-6 -->

        <div class="col-md-4">
            <div id="cart_box">
                <?php echo $this->render('widget-right-bar', [
		    'currencyCode' => $currencyCode
		]); ?>
                <a class="btn_full" href="javascript:void(0)" id="checkout">
                    <?php echo Yii::t('basicfield', 'Go to checkout') ?>
                </a>

                <hr class="styled">
                <div class="row">
                    <div class="col-md-6 col-sm-3 col-xs-3">

                        <p><a href="#" alt="aondego terminverwaltung einfach gemacht"><img class="img-responsive" src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/logo-sign-800-bg.png" alt="aondego appointment management" border="0" /></a></p>
                    </div>
                    <div class="col-md-6 col-sm-3 col-xs-3">

                        <p><img class="img-responsive" src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/ssl.png" alt="aondego appointment management" border="0" /></p>
                    </div>
                </div>

            </div>
        </div><!-- End col-md-3 -->

    </div><!-- End row -->
</div><!-- End container pin -->

