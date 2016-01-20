<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel"      => "Manage Clients",
                        "barType"       => "admin",
                        "searchGridId"  => "clients-grid",
                        "model"         => $model,
                  )
           );

    $this->widget('application.components.CGridView', array(
        'id'            => 'clients-grid',
        'dataProvider'  => $model->search(),
        'columns'       => array(
            'client_name',
            'company_name',
            'email',
            array(
                    'name'  => 'country',
                    'value' => 'CountryStates::getCountryName($data->country)',
            ),
            'subscription_status',
            array(
                'class'=>'CButtonColumn',
                'template'=> '{approve}{view}{update}{delete}',
                'buttons' => array(
                    'approve' => array(
                        'label' => 'approve',
                        'url' => 'Yii::app()->controller->createUrl("quickApprove", array("id"=>$data->id))',
                        'visible' => '$data->subscription_status == "pending"',
                        'options' => array(
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => 'js:$(this).attr("href")',
                                'success' => 'js:function(data){$("#view-page").html(data);}',
                            ),
                            'live' => false,
                        ),
                    ),
                    'view' => array(
                        'label' => 'view',
                        'url' => 'Yii::app()->controller->createUrl("view",array("id"=>$data->id))',
                        'options' => array(
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => 'js:$(this).attr("href")',
                                'success' => 'js:function(data){$("#view-page").html(data);}',
                            ),
                            'live' => false,
                        ),
                    ),
                    'update' => array(
                        'label' => 'update',
                        'url' => 'Yii::app()->controller->createUrl("update",array("id"=>$data->id))',
                        'options' => array(
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => 'js:$(this).attr("href")',
                                'success' => 'js:function(data){$("#view-page").html(data);}',
                            ),
                            'live' => false,
                        ),
                    ),
                    'delete' => array(
                        'label' => 'delete',
                        'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->id))',
                        'options' => array(
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => 'js:$(this).attr("href")',
                                'success' => 'js:function(data){$("#view-page").html(data);}',
                            ),
                            'live' => false,
                        ),
                    ),
                ),
            ),
        ),
    ));
?>
