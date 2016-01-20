<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel"      => "Manage Accounts",
                        "barType"       => "admin",
                        "searchGridId"  => "accounts-grid",
                        "model"         => $model,
                  )
           );

    $this->widget('application.components.CGridView', array(
        'id'=>'accounts-grid',
        'dataProvider'=>$model->search(),
        'columns'=>array(
            'account_name',
            'login_name',
            'email',
            array('name'=>'role_group_id', 'value'=>'$data->role_groups->role_group_name'),
            'date_created',
            array(
                'class'=>'AjaxButtonColumn',
            ),
        ),
    ));
?>
