<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('basicfield', 'Reset password');
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
                <li><a href="<?php echo Yii::$app->homeUrl;?>">
                        <?php echo Yii::t('basicfield', 'Home')?></a></li>
                <li><?php echo Yii::t('basicfield', 'Reset Password')?></li>
                
            </ul>
        </div>
    </div><!-- Position -->
<div class="container margin_60_35">
    
    <div class="box_style_2" id="order_process">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?php echo Yii::t('basicfield', 'Please choose your new password:')?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('basicfield', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
