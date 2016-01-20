<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'role-groups-form',
    'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'role_group_name'); ?>
        <?php echo $form->textField($model,'role_group_name',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'role_group_name'); ?>
    </div>

    <div class="row">
        <b>Permissions</b>
    </div>

    <?php
        $allowedActions = explode('||', $model->role);
        $actionsInfo    = AdminGlobals::getActionsInfo();
        $submodulesInfo = array();

        foreach($actionsInfo as $module => $submodules) {
            foreach($submodules as $submodule => $actions) {
                $tmp = str_replace(" ", "_", trim($submodule));
                $submodulesInfo[$module][$tmp] = $submodule;
            }
        }

        foreach($actionsInfo as $module => $modInfo) {
            $submodules = $submodulesInfo[$module];
            echo '<div class="row">';
            echo $form->labelEx($model,$module);
            echo CHtml::dropDownList($module, '', $submodules, array('onchange'=>'subMenuChange(this)'));
            echo '</div>';
            $count = 0;
            foreach($submodules as $key => $value) {
                $actions = $actionsInfo[$module][$value];
                if($count == 0)
                    echo "<div class='div_$key'>\n";
                else
                    echo "<div class='div_$key' style='display:none;'>\n";
                foreach($actions as $key=>$value) {
                    $chkBoxName = str_replace("/", "_", trim($key));
                    if(in_array($key, $allowedActions))
                        #echo CHtml::CheckBox('actions[]', 'checked', array('value'=>$key));
                        echo "<input name='actions[]' value='$key' type='checkbox' checked />";
                    else
                        echo "<input name='actions[]' value='$key' type='checkbox' />";
    ?>
<?php
                    echo $value;
                    echo "&nbsp;&nbsp;&nbsp;&nbsp";
                    echo "&nbsp;&nbsp;&nbsp;&nbsp\n";
                    $count++;
                }
                echo '</div>';
            }
            echo '<div class="row">';
            echo '</div>';
        }
    ?>

    <div class="row buttons">
    <?php
        $this->widget('application.widgets.AjaxFormSubmit',
                      array("newRecord" => $model->isNewRecord,
                            "modelId"   => $model->id
                      )
                );

    ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    function subMenuChange(selectElement) {
        var prevVal=$(selectElement).attr('previous');
        var newVal=$(selectElement).find(':selected').val();
        var prevDivClass = ".div_" + prevVal;
        var newDivClass = ".div_" + newVal;
        $(selectElement).attr('previous', newVal);
        $(prevDivClass).hide();
        $(newDivClass).show();
    }

    $(document).ready(function() {
<?php
        foreach($actionsInfo as $module => $submodules) {
            foreach($submodules as $submodule => $actions) {
                $prevValue = str_replace(" ", "_", trim($submodule));
                break;
            }
            echo "\t\t$(\"#$module\").attr(\"previous\", \"$prevValue\");\n";
        }
?>
    });

/*
    function checkAll(field){
        $(':checkbox[name^="cuisine_"]').each(function(index){
            this.checked=true;
        });
    }

    function uncheckAll(field){
        $(':checkbox[name^="cuisine_"]').each(function(index){
            this.checked=false;
        });
    }
*/
</script>
