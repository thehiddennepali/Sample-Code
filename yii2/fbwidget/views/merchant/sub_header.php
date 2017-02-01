<div class="col-md-3 col-xs-3 ">
    <a class="active" href="<?php echo Yii::$app->urlManager->createUrl('merchant/sign-up')?>">
        <?php echo Yii::t('basicfield', 'Select Package')?>          </a>  
</div>

<div class="col-md-3 col-xs-3">
    <a class="inactive" 
       href="javascript:;">
        <?php echo Yii::t('basicfield', 'Merchant information')?> </a>
</div>

<div class="col-md-3 col-xs-3">
    <a class="inactive "
       href="javascript:;">
        <?php echo Yii::t('basicfield', 'Payment Information')?></a>
</div>

<div class="col-md-3 col-xs-3">
    <a class="inactive "
       href="javascript:;"><?php echo Yii::t('basicfield', 'Activation')?></a>
</div>