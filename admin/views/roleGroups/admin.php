<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel"      => "Manage Role Groups",
                        "barType"       => "admin",
                        "searchGridId"  => "role-group-grid",
                        "model"         => $model,
                  )
           );

    $this->widget('application.components.CGridView', array(
        'id' => 'role-group-grid',
        'dataProvider' => $model->search(),
        'columns' => array(
            'role_group_name',
            'date_created',
            array(
                'class' => 'AjaxButtonColumn',
            ),
        ),
    ));
?>
