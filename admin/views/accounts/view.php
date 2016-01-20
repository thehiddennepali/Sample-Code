<?php
$this->widget('application.widgets.ViewBar',
                  array("barLabel"  => "View Account",
                        "barType"   => "view",
                        "updateId"  => $model->id
                  )
           );
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'account_name',
        'login_name',
        'password',
        array('name' =>'role_group_id', 'value'=>$model->role_groups->role_group_name),
        'date_created',
        'email',
    ),
));
?>
