<?php

use fbwidget\models\MtMerchant;
use fbwidget\models\MtServiceCategory;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model MtMerchant */
/* @var $form ActiveForm */
?>


<?php $form = ActiveForm::begin([
    'id'=>'',
    
    'options'=>[
        'class' => 'forms'
    ],
    'fieldConfig' => [
        'template' => "{input}{error}",
        'options' => [
            'tag'=>false
        ]
    ]
    
]); ?>

    <input type="hidden" value="merchantSignUp" name="action" id="action" />	  
    <input type="hidden" value="store" name="currentController" id="currentController" />	 
    <input type="hidden" value="1" name="package_id" id="package_id" /> 
    <div class="row top10">
        <div class="col-md-3 "><?php echo Yii::t('basicfield', 'Selected Package')?></div>
        <div class="col-md-8  bold"><?php echo $package->title;?></div>
    </div>

    <div class="row top10">
        <div class="col-md-3 "><?php echo Yii::t('basicfield', 'Price')?></div>
        <div class="col-md-8  bold">
            &euro; <?php echo (!empty($package->promo_price)) ? $package->promo_price : $package->price;?>
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3 "><?php echo Yii::t('basicfield', 'Membership Limit')?></div>
        <div class="col-md-8  bold">
            <?php echo Yii::t('basicfield', '1 year');?>                  </div>
    </div>

    <div class="row top10">
        <div class="col-md-3 "><?php echo Yii::t('basicfield', 'Usage')?></div>
        <div class="col-md-8  bold">
            
            <?php echo Yii::t('basicfield', 'up to {count} Staff members', ['count' => $package->workers_limit]);?>
                               </div>
    </div> 

    <div class="row top10">
        <div class="col-md-3 "><?php echo Yii::t('basicfield', 'Business name')?></div>
        <div class="col-md-8 ">
            
            <?= $form->field($model, 'service_name')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?>   
            
        </div>
    </div>


    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Business phone')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'service_phone')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?>  
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Contact name')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'contact_name')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Contact phone')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'contact_phone')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Contact email')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'contact_email')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div> 

    <div class="row top10">
        <div class="col-md-3"></div>
        <div class="col-md-8">
            <p class="text-muted text-small">
                <?php echo Yii::t('basicfield', 'Important: Please enter your correct email. we will sent an activation code to your email')?>
                </p>
        </div>
    </div>   


    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Street address')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'street')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'City')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'city')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Post code/Zip code')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'post_code')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Country Code')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'country_code')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?>          
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'State/Region')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'state')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div>
    
    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Service 1')?></div>
        <div class="col-md-8">
            <?php  echo $form->field($model, 'cuisine')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(MtServiceCategory::find()->all(), 'id', 'titles'),
                'options' => ['placeholder' => Yii::t('basicfield','Select Service'),
                    'multiple' => true,
                    'class'=>'grey-fields full-width'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
             ?> 
        </div>
    </div>
    
    

    



    <div class="top15">
        <div class="section-label">
            <a class="section-label-a">
                <span class="bold">
                    <?php echo Yii::t('basicfield', 'Login Information')?></span>
                <b></b>
            </a>     
        </div>    
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Username')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'username')->textInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Password')?></div>
        <div class="col-md-8">
           <?= $form->field($model, 'password')->passwordInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"><?php echo Yii::t('basicfield', 'Confirm Password')?></div>
        <div class="col-md-8">
            <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' =>true , 'class'=>'grey-fields full-width']); ?> 
        </div>
    </div>


    <div class="row top10">
        <div class="col-md-3"></div>
        <div class="col-md-8">
            <input value="2" class="" required="required" type="checkbox" name="terms_n_condition" id="terms_n_condition" /> 
             <a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['mt-custom-page/view', 'slug' => 'terms-and-condition']) ?>" target="_blank"><?php echo Yii::t('basicfield', 'I Agree to the Terms & Conditions')?></a>  
        </div>
    </div>

    <div class="row top10">
        <div class="col-md-3"></div>
        <div class="col-md-8">
            <input type="<?php echo Yii::t('basicfield', 'submit');?>" value="<?php echo Yii::t('basicfield', 'Next')?>" class="orange-button inline medium">
        </div>
    </div>

<?php ActiveForm::end(); ?>


