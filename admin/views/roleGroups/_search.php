<?php $calenderDateFormat = Globals::getCalenderDateFormat(Yii::app()->user->getState("dateFormat"));?>  
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'id'); ?>
        <?php echo $form->textField($model,'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'role_group_name'); ?>
        <?php echo $form->textField($model,'role_group_name',array('size'=>60,'maxlength'=>64)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'role'); ?>
        <?php echo $form->textField($model,'role',array('size'=>60,'maxlength'=>1024)); ?>
    </div>

   

    <div class="row">
        <?php echo $form->label($model,'client_id'); ?>
        <?php echo $form->textField($model,'client_id'); ?>
    </div>

    <div class="row">
                    <?php echo $form->label($model,'date_created'); ?>
         <?php
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $this->widget('CJuiDateTimePicker',array(
                    'model'     =>$model,
                    'attribute' =>'date_created',
                    'mode'=>'date',
                    'options'   =>array(
                        'showAnim'=>'fold',
                        'dateFormat'=> $calenderDateFormat,
                        'showOn'=>'button',
                        'buttonImage'=>'images/calendar.gif',
                        'buttonImageOnly'=>true,
                        'language'=> '',
                    ),
                    'language' => '',
                    'htmlOptions' => array(
                        'style' => 'height:20px;',
                    ),
                ));
            ?>
        </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
