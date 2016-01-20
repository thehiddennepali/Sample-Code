<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel" => "Create Role Group",
                        "barType"  => "create"
                  )
           );
    echo $this->renderPartial('_form', array('model'=>$model));
?>