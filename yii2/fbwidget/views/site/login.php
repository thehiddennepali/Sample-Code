<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>


<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_cart.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
    	<div id="sub_content">
    	 <h1>Login</h1>
         
         <p></p>
        </div><!-- End sub_content -->
	</div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="<?php echo Yii::$app->homeUrl;?>"><?php echo Yii::t('basicfield', 'Home')?></a></li>
                <li><?php echo Yii::t('basicfield', 'Login');?></li>
                
            </ul>
        </div>
    </div><!-- Position -->
<div class="container margin_60_35">
    
    <div class="box_style_2" id="order_process">
    

    <p><?php echo Yii::t('basicfield', 'Please fill out the following fields to login:')?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    <?= Html::a(Yii::t('basicfield', 'If you forgot your password you can reset it'), ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('basicfield', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
