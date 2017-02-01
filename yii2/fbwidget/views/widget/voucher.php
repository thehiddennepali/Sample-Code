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
                        <?php echo $this->render('voucher_right_bar'); ?>
                      
                </div>
            </div><!-- End col-md-3 -->

        </div><!-- End row -->
    </div><!-- End container pin -->
</div><!-- End container -->
<!-- End Content =============================================== -->
