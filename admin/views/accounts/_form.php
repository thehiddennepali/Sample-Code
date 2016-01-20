<div class="form">
<?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'accounts-form',
        'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
    ));
?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'account_name'); ?>
        <?php echo $form->textField($model,'account_name',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'account_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'login_name'); ?>
        <?php echo $form->textField($model,'login_name',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'login_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

     <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

     <div class="row">
        <?php echo $form->labelEx($model,'role_group_id'); ?>
        <?php echo $form->dropDownList($model,'role_group_id',CHtml::listData(RoleGroups::model()->findAll(),'id','role_group_name'), array("empty" => "Select")); ?>
        <?php echo $form->error($model,'role_group_id'); ?>
    </div>

    <div class="row buttons">
     <?php
        if($model->isNewRecord) {
            echo CHtml::ajaxSubmitButton('Submit',
                    Yii::app()->controller->createUrl('create'),
                    array('update'=>'#view-page'),
                    array('type'=>'submit','id' => 'submit-button-'.uniqid(),));
        }
        else {
            echo CHtml::ajaxSubmitButton('Update',
                    Yii::app()->controller->createUrl('update', array("id" => $model->id)),
                    array('update'=>'#view-page'),
                    array('type'=>'submit','id' => 'submit-button-'.uniqid(),));
        }
    ?>
    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->
