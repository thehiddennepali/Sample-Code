<div class="wide form">

<?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
?>

    <div class="row">
    <?php echo $form->label($model, 'login_time'); ?>
    <?php echo $form->textField($model, 'login_time'); ?>
    </div>

    <div class="row">
    <?php echo $form->label($model, 'account_id'); ?>
    <?php echo $form->textField($model, 'account_id'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
