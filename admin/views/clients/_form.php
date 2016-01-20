<div class="form">
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'clients-form',
        'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
    ));
?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary(array($model, $account, $preference)); ?>

    <div class="row"><h4><b>Profile Info</b></h4></div>

    <div class="row">
        <?php echo $form->labelEx($model, 'client_name'); ?>
        <?php echo $form->textField($model, 'client_name', array('size'=>60, 'maxlength'=>128)); ?>
        <?php echo $form->error($model, 'client_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'company_name'); ?>
        <?php echo $form->textField($model, 'company_name',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model, 'company_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'address'); ?>
        <?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>512)); ?>
        <?php echo $form->error($model,'address'); ?>
    </div>

   <div class="row">
        <?php echo $form->labelEx($model,'country'); ?>
        <?php echo $form->dropDownList($model,'country', CountryStates::getCountries(),
                                       array(
                                            'prompt'=> 'Select Country',
                                            'ajax' => array(
                                                'type'   => 'POST',
                                                'url'    => Yii::app()->createUrl('countries/dynamicStates'),
                                                'data'   => array('country' => 'js: $("#Clients_country option:selected").val()'),
                                                'update' => '#Clients_state',
                                            ),
                                            'live' => false,
                                        )
                    ); ?>

        <?php echo $form->error($model,'country'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'state'); ?>
        <?php echo $form->dropDownList($model,'state', CountryStates::getCountryStates($model->country), array('empty'=>'Select')); ?>
        <?php echo $form->error($model,'state'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'city'); ?>
        <?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'city'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'zipcode'); ?>
        <?php echo $form->textField($model,'zipcode',array('size'=>32,'maxlength'=>32)); ?>
        <?php echo $form->error($model,'zipcode'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'office_number'); ?>
        <?php echo $form->textField($model,'office_number',array('size'=>16,'maxlength'=>16)); ?>
        <?php echo $form->error($model,'office_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'cell_number'); ?>
        <?php echo $form->textField($model,'cell_number',array('size'=>16,'maxlength'=>16)); ?>
        <?php echo $form->error($model,'cell_number'); ?>
    </div>

    <?php  if(!$model->isNewRecord) { ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'subscription_status'); ?>
        <?php echo $form->dropDownList($model, 'subscription_status', AdminGlobals::getSubscriptionStatuses()); ?>
        <?php echo $form->error($model, 'subscription_status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'hotspots_purchased'); ?>
        <?php echo $form->textField($model, 'hotspots_purchased'); ?>
        <?php echo $form->error($model, 'hotspots_purchased'); ?>
    </div>
    <?php } ?>

    <div class="row"><h4><b>Account Info</b></h4></div>

    <div class="row">
        <?php echo $form->labelEx($account, 'login_name'); ?>
        <?php echo $form->textField($account, 'login_name'); ?>
        <?php echo $form->error($account, 'login_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($account, 'password'); ?>
        <?php echo $form->textField($account, 'password'); ?>
        <?php echo $form->error($account, 'password'); ?>
    </div>

    <div class="row"><h4><b>Preferences</b></h4></div>

    <?php  if($model->isNewRecord) { ?>
    <div class="row">
        <?php echo $form->labelEx($preference, 'realm'); ?>
        <?php echo $form->textField($preference, 'realm'); ?>
        <?php echo $form->error($preference, 'realm'); ?>
    </div>
    <?php } ?>

    <div class="row">
        <?php echo $form->labelEx($preference, 'timezone'); ?>
        <?php echo $form->dropDownList($preference, 'timezone', AdminGlobals::getTimezones()); ?>
        <?php echo $form->error($preference, 'timezone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($preference, 'payment_gateway'); ?>
        <?php echo $form->dropDownList($preference, 'payment_gateway', CHtml::listData(PaymentGateways::model()->findAll(),'id','gateway_name'), array('empty'=>'Select')); ?>
        <?php echo $form->error($preference, 'payment_gateway'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($preference, 'date_format'); ?>
        <?php echo $form->dropDownList($preference, 'date_format', Globals::getDateFormats()); ?>
        <?php echo $form->error($preference, 'date_format'); ?>
    </div>

    <div class="row buttons">
    <?php
        $this->widget('application.widgets.AjaxFormSubmit',
                      array("newRecord" => $model->isNewRecord,
                            "modelId"   => $model->id
                      )
               );
    ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
