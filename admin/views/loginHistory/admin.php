<?php

    $this->widget('application.widgets.ViewBar',
        array("barLabel"     => "Manage Login History",
              "barType"      => "none",
              "searchGridId" => "login-history-grid",
              "model"        => $model,
        )
    );

    $this->widget('application.components.CGridView', array(
        'id' => 'login-history-grid',
        'dataProvider' => $model->search(),
        'columns' => array(
            array(
                'name'  => 'account_id',
                'value' => '$data->getRelated("accounts")->account_name',
                'type'  => 'raw'
            ),
            'login_time',
            'logout_time',
            'ip_address',
            'logout_reason',
        ),
    ));
?>
