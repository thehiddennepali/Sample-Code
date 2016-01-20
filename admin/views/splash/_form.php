<div class="form">
<?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'splash-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
       'enableAjaxValidation'=>true,
    ));
?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>


    <div class="row">
        <?php echo $form->labelEx($model,'splash_template'); ?>
        <?php echo $form->dropDownList($model,'splash_template', CHtml::listData(SplashTemplates::model()->findAll(),'login_url','template_name'), array('empty'=>'Select')); ?>
        <?php echo $form->error($model,'splash_template'); ?>

    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'property'); ?>
        <?php echo $form->dropDownList($model, 'property', CHtml::listData(Property::model()->findAll(),'id','property_name'), array('empty'=>'Select')); ?>
        <?php echo $form->error($model, 'property'); ?>
    </div>

    <div class="row buttons">
    <?php
            echo CHtml::ajaxSubmitButton('Generate',
                    Yii::app()->controller->createUrl('view'),
                    array('update'=>'#view-page'),
                    array('type'=>'submit','id' => 'submit-button-'.uniqid(), 'live'=>false));

    ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
