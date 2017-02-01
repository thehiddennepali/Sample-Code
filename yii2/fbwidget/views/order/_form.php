<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="box box-primary">
    <?php
    
    
    $form = ActiveForm::begin([
        'id' => 'order-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>
    

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">


        <?php echo $form->field($model, 'status')->dropDownList(
                \common\models\SingleOrder::getOrderStatuses()
           ); ?>


        <?php //echo $form->field($model,'client_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

        <?php echo $form->field($model,
            'payment_type')->radioList(array('1' => Yii::t('default', 'On Spot'), '0' => 'Paypal')
        ); ?>


        <?php echo $form->field($model, 'client_name'); ?>

        <?php echo $form->field($model, 'client_phone'); ?>

        <?php echo $form->field($model, 'client_email'); ?>

        <?php echo $form->field($model, 'order_time'); ?>

        <?php 
        
        $cats_merch = common\models\CategoryHasMerchant::find()->where(['is_active' => 1, 'merchant_id' => Yii::$app->user->id, 'is_group' => 0])->all();
                echo $form->field($model, 'category_id')
                        ->dropDownList(\yii\helpers\ArrayHelper::map($cats_merch, 'id', 'titleWithPriceAndTime')
                    , array(
                        'prompt' => 'select category',
                    )
                );
        
        
        //echo $form->field($model, 'category_id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>