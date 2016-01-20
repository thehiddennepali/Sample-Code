<div id="bar">
     <h1 class="create">List Clients</h1>
     <div class="links_container">
    <?php
        echo CHtml::ajaxLink('Create', Yii::app()->controller->createUrl('create'), array('success' => "function(data) {\$('#view-page').html(data);}"), array('class' => 'link create left', 'href' => Yii::app()->controller->createUrl('create'), 'id' => 'send-link-' . uniqid()));
        echo CHtml::ajaxLink('List', Yii::app()->controller->createUrl('admin'), array('success' => "function(data) {\$('#view-page').html(data);}"), array('class' => 'link list right', 'href' => Yii::app()->controller->createUrl('admin'), 'id' => 'send-link-' . uniqid()));
        echo CHtml::ajaxLink('Edit', Yii::app()->controller->createUrl('update', array('id'=>$model->id)), array('success' => "function(data) {\$('#view-page').html(data);}"), array('class' => 'link edit right', 'href' => Yii::app()->controller->createUrl('update', array('id'=>$model->id)), 'id' => 'send-link-' . uniqid()));
        if($model->subscription_status == "pending") {
            echo CHtml::ajaxLink('Approve', Yii::app()->controller->createUrl('quickApprove', array("id"=>$model->id)), array('success' => "function(data) {\$('#view-page').html(data);}"), array('class' => 'link edit right', 'href' => Yii::app()->controller->createUrl('quickApprove', array("id"=>$model->id)), 'id' => 'send-link-' . uniqid()));
        }
    ?>
    </div>
</div><!-- bar end -->

<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'client_name',
            'company_name',
            'email',
            'address',
            'city',
            'state',
            array(
                'label' => $model->getAttributeLabel("country"),
                'value' => CountryStates::getCountryName($model->country),
            ),
            'zipcode',
            'office_number',
            'cell_number',
            'subscription_status',
            'hotspots_purchased',
            'hotspots_used',
            'next_billing_date',
            array(
                    'label' => $account->getAttributeLabel("login_name"),
                    'value' => $account->login_name,
                ),
            array(
                    'label' => $account->getAttributeLabel("password"),
                    'value' => $account->password,
                ),
            array(
                    'label' => $preference->getAttributeLabel("realm"),
                    'value' => $preference->realm,
                ),
            array(
                    'label' => $preference->getAttributeLabel("timezone"),
                    'value' => AdminGlobals::getTimeZoneName($preference->timezone),
                ),
            array(
                    'label' => $preference->getAttributeLabel("payment_gateway"),
                    'value' => ($preference->payment_gateway) ? $preference->payment_gateways->gateway_name : "<span class='null'>Not set</span>",
                    'type'  => 'raw',
                ),
            array(
                    'label' => $preference->getAttributeLabel("date_format"),
                    'value' => $preference->date_format,
                ),
            'date_created',
        ),
    ));
?>
