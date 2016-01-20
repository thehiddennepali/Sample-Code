<?php $calenderDateFormat = Globals::getCalenderDateFormat(Yii::app()->user->getState("dateFormat"));?>  
<div class="wide form">
<?php
    $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    ));
?>
    <div class="row">
        <?php echo $form->label($model,'client_name'); ?>
        <?php echo $form->textField($model,'client_name',array('size'=>60,'maxlength'=>128)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'company_name'); ?>
        <?php echo $form->textField($model,'company_name',array('size'=>60,'maxlength'=>128)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'address'); ?>
        <?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>512)); ?>
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
