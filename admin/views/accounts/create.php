<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel" => "Create Account",
                        "barType"  => "create"
                  )
           );
    echo $this->renderPartial('_form', array('model'=>$model));
?>