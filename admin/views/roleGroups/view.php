<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel"  => "View Role Group",
                        "barType"   => "view",
                        "updateId"  => $model->id
                  )
           );

    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'role_group_name',
            array('name'  => 'Allowed Actions',
                  'type'  => 'html',
                  'value' => implode("<br/>", explode("||", $model->role)),
                ),
            'date_created',
        ),
    ));
?>
