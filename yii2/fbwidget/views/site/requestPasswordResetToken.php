<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('basicfield','Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_cart.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
    	<div id="sub_content">
    	 <h1><?php echo $this->title;?></h1>
         
         <p></p>
        </div><!-- End sub_content -->
	</div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="<?php echo Yii::$app->homeUrl;?>"><?php echo Yii::t('basicfield', 'Home')?></a></li>
                <li><?php echo Yii::t('basicfield', 'Request password reset')?></li>
            </ul>
        </div>
    </div><!-- Position -->
<div class="container margin_60_35">
    
    <div class="box_style_2" id="order_process">

    <h1><?= $this->title; ?></h1>
    
    <?php
    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
    }
    ?>

    <p><?php echo Yii::t('basicfield', 'Please fill out your email. A link to reset password will be sent there.')?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email_address')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('basicfield', 'Send'), ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
