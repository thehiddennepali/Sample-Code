<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box_style_2" id="order_process">


    <h2 class="inner"><?php echo Yii::t('basicfield', 'Please enter your personal details')?></h2>

    <?php $form = ActiveForm::begin(['id'=> 'checkout-form']); ?>



    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','First name')]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Last name')]) ?>
    
    <div class="form-group field-client-dob required">
    <label class="control-label" for="client-dob"><?php echo Yii::t('basicfield', 'Date of Birth')?></label>
            
    <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'dob',
                    'template' => '{input}{addon}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                        'minDate' => '1900-01-01',

                    ],
                    'options' => [
                        'class' => 'grey-fields full-widthe',
                        'tag'=>false
                    ]
                ]);?>
    <div class="help-block"></div>
    </div>
    <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Telephone/Mobile')]) ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Your email')]) ?>

    <?= $form->field($model, 'street')->textInput(['placeholder' => Yii::t('basicfield','Your full address')]) ?>

    <div class="row">
        <div class="col-md-6 col-sm-6">

            <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Your postal code')]) ?>

        </div>

        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => Yii::t('basicfield','Your city')]) ?>
        </div>
    </div>

    <hr>

<!--    <div class="row">
        <div class="col-md-12">

            <label><?php Yii::t('basicfield','Notes for the business');?></label>
            <?= $form->field($model, 'business_note')->textarea(['style' => "height:150px", 'placeholder' => Yii::t('basicfield','Special request etc ...')])->label(false); ?>

        </div>
    </div>-->



    <?php ActiveForm::end(); ?>
</div>
                   



