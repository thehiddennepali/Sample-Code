<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel" => "Update Client",
                        "barType"  => "update"
                  )
           );
    echo $this->renderPartial('_form', array('model'=>$model, 'account'=>$account, 'preference'=>$preference));
?>
