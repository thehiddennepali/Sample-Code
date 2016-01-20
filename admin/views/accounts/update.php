<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel" => "Update Account",
                        "barType"  => "update"
                  )
           );
    echo $this->renderPartial('_form', array('model'=>$model));
?>
