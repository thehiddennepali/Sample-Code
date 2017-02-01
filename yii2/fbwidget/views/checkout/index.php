<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$session = Yii::$app->session;
$keyword = $session['keyword'];
$merchantid = $session['merchant_id'];

if (isset($merchantid)) {
    $merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantid]);
    
    $merchantUrl = preg_replace('/\s+/', '', $merchant->service_name);
    $merchantUrl = strtolower($merchantUrl) . '-' . $merchant->merchant_id;
}
?>

<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_cart.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">

        <?php echo $this->render('sub_header') ?>

    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

<?php
$session = Yii::$app->session;
$keyword = $session['keyword'];
$merchantid = $session['merchant_id'];

if (isset($merchantid)) {
    $merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantid]);
}
?>

<div id="position">
    <div class="container">
        <ul>
            <li><a href="<?php echo Yii::$app->homeUrl; ?>"><?php echo Yii::t('basicfield', 'Home') ?></a></li>
            <li><a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/search', 'Merchant[search]' => $keyword]) ?>">Search</a></li>
            <li>
                <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id' => $merchantUrl]) ?>">
                    <?php echo $merchant->service_name; ?>
                </a>
            </li>
            <li><?php echo Yii::t('basicfield', 'Checkout') ?></li>
        </ul>
    </div>
</div><!-- Position -->

<!-- Content ================================================== -->
<div class="container margin_60_35">
    <div id="container_pin">
        <div class="row">
            <div class="col-md-3">

                <div class="box_style_2 info">
                    <h2 class="inner"><?php echo Yii::t('basicfield', 'Login') ?></h2>


                    <?php //echo $this->render('left_bar')  ?>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($login, 'email')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($login, 'password')->passwordInput() ?>



                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('basicfield', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
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
                        <?php echo $this->render('right_bar'); ?>
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
</div><!-- End container -->
<!-- End Content =============================================== -->
