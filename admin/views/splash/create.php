<?php
    $this->widget('application.widgets.ViewBar',
                  array("barLabel" => "Generate Splash Url",
                        "barType"  => "none"
                  )
           );
    echo $this->renderPartial('_form', array('model'=>$model, 'properties'=>$properties, 'propertyGroups'=>$propertyGroups));
?>
