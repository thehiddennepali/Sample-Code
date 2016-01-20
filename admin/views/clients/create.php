<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel" => "Create Client",
                        "barType"  => "create"
                  )
           );
    echo $this->renderPartial('_form', array('model'=>$model, "account"=>$account, "preference"=>$preference));
?>
