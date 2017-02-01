    <?php

use dosamigos\datepicker\DatePicker;
use frontend\components\ImageBehavior;
use frontend\models\Staff;
use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
    
    $form = ActiveForm::begin(['id' => 'add-to-cart']); 
    
    
    ?>



<?=$form->field($addToCard, 'serviceid')->hiddenInput( ['value'=>$model->id])->label(false);?>


<div class="modal-header">
    
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">
        <?php echo Yii::t('basicfield', 'Please select')?>
        </h4>
</div>
<div class="modal-body">
    <div class="box_style_4">
        <h3 class="inner"><?php echo Yii::t('basicfield', 'Treatment')?></h3>
        <div class="row">

            <div class="col-sm-3">
                <?php echo Html::img(ImageBehavior::getImage($model->id, 'service'), ['class' => 'thumb_strip1 img-responsive']) ?>


            </div>

            <div class="col-sm-9">
                <h3><?php echo Yii::t('basicfield', $model->title); ?></h3>
                <div class="type">
                    <?php echo Yii::t('basicfield', $model->description); ?>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="box_style_4">
        <h3 class="inner">Dauer</h3>
        <div class="row" id="options_2">
            <div class="col-md-3">
                <label><?php echo $model->time_in_minutes ?> Min</label>
            </div>

        </div> Edn options 2 

    </div>-->
    <div class="box_style_4">
        
        <?php echo Html::hiddenInput('find-min-val',$model->time_in_minutes, ['id'=> 'find-min-val']);
        echo '<label class="control-label">'.Yii::t('basicfield', 'Order Date').'</label>';?>
        <?= DatePicker::widget([
        'model' => $addToCard,
        'attribute' => 'order_date',
        'template' => '{input}{addon}',
            'clientOptions' => [
                'startDate'=> "today",
                'autoclose' => true,
                'defaultDate' =>  'today',
                'minDate' => 'today',
                'format' => 'yyyy-mm-dd'
            ]
    ]);?>
        <?php /* $form->field($addToCard, 'order_date')->widget(DatePicker::classname(), [
            //'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'minDate' => 0,
                'showOn' => "button",
                'buttonImage' => "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
                'buttonImageOnly' => true
                
            ],
            
        ]) */?>
    </div>

    <div class="box_style_4">
        <?php  /*
        echo '<label class="control-label">'.Yii::t('basicfield', 'Time Req').'</label>';
        echo TimePicker::widget([
            'model' => $addToCard,
            'attribute' => 'time_req', 
            'value' => '11:24 AM',
            'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
                'minuteStep' => 15,
                
            ]
        ]);*/?>
        
        
    </div>
<div class="box_style_4">
    <input type="button" value="<?php echo Yii::t('basicfield', 'Find Staff')?>" id="find-staff" class="btn_1">
</div>

<div class="box_style_4">
    <?php $items = [];?>
    
    <?php if($update == 1){
        
        $items = ArrayHelper::map(Staff::find()->where(['id'=>$updateArray['staff_id']])->all(), 'id', 'name');
    
        
        echo $form->field($addToCard, 'staff_id')->dropDownList($items, [
        'onchange'=>'
                $.ajax({
                    type : "post",
                    url : "'.Yii::$app->urlManager->createUrl('order/get-staff-free-time').'",
                    data : {staff_id:$(this).val(),
                    date_val:$("#addtocart-order_date").val(),
                    min_val:'.$model->time_in_minutes.'}, 
                    dataType : "json",
                    success : function(response){
                        $(".single-price").html($("#single-cat-price").val()); 
                        $("#SingleOrder_addons_list").html(response.add_ons);
                    console.log(response);
                        }
                });
            ']);
    }else{
        echo $form->field($addToCard, 'staff_id')->dropDownList($items, ['prompt'=>Yii::t('basicfield', 'Select Staff'),
        'onchange'=>'
                $.ajax({
                    type : "post",
                    url : "'.Yii::$app->urlManager->createUrl('order/get-staff-free-time').'",
                    data : {staff_id:$(this).val(),
                    date_val:$("#addtocart-order_date").val(),
                    min_val:'.$model->time_in_minutes.'}, 
                    dataType : "json",
                    success : function(response){
                        $(".single-price").html($("#single-cat-price").val()); 
                        $("#SingleOrder_addons_list").html(response.add_ons);
                    console.log(response);
                        }
                });
            ']) ?>
    
    <?php }?>
    
    
</div>

        <div ><?php echo Yii::t('basicfield', 'Time/Price')?>: 
            <span class="time-in-min">
                <?php echo ($model->time_in_minutes + $model->additional_time);?> 
            </span> / 
            <span class="single-price">
                <?php echo $model->price;?>
            </span>
        </div>

    <?php //if ($model->merchCatHasAddons) { ?>
        <div class="box_style_4">
            <h3 class="inner">Extras</h3>
            <div class="row" id="options_2">
                <span id="SingleOrder_addons_list"></span>
                <?php
//                echo '<pre>';
//                echo $update;
//                print_r($updateArray['addons_list']);
                
                if($update == 1 ){
                    
                    $staff = Staff::findOne(['id'=> $updateArray['staff_id']]);
                    
                    
                    echo $this->render('/order/_addons_single', ['addons' => $staff->addons,
                        'selectedaddons' => $updateArray['addons_list']]); }
                    ?>


            </div><!-- Edn options 2 -->
        </div>

    <?php //} ?>

<div class="box_style_4">
    <input type="button" value="<?php echo Yii::t('basicfield', 'Find Free Time Slot')?>" id="find-free-time" class="btn_1">
</div>

<?php 
$freeTimeListItem = [];
if($update == 1){
    
    echo Html::hiddenInput('key',$key);
    echo Html::hiddenInput('update',$update, ['id'=>'update']);
    
    foreach ($staff->getFreeTime($addToCard->order_date, $model->time_in_minutes, 0) as $name) {
                $freeTimeListItem[$name] = $name;
            }
            
            
    
}?>

<?php echo $form->field($model, 'memcache_key')->hiddenInput(array( 'id' => 'memcache_key'))->label(false); ?>
    
    <?= $form->field($addToCard, 'free_time_list')->dropDownList($freeTimeListItem,
            ['prompt'=>Yii::t('basicfield', 'Select Free Time Slot'),
                'onchange' =>"
                            $.ajax ({
                                'type' : 'POST',
                                'url' : '".Yii::$app->urlManager->createUrl('order/add-single-memcached-order')."',
                                'dataType' :'json',
                                'data' : {staff_id:$('#addtocart-staff_id').val(),date_val:$('#addtocart-order_date').val(),free_time_list:$('this').val(),min_val:$('#find-min-val').val(),u_id:$('#memcache_key').val(),update:$('#update').val()?$('#update').val():0},
                                'success' : function(data){
                                $('#memcache_key').val(data)
                                }
                                
                            
                            });",
        
        ]) ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn_3" data-dismiss="modal"><?php echo Yii::t('basicfield', 'Close')?></button>
    <button type="button" class="btn_2 addtocart"><?php echo Yii::t('basicfield', 'Add to Cart')?></button>
</div>
<?php ActiveForm::end(); ?>

<?php 


$this->registerJs("
    
    $('#addtocart-order_date').on('change', function(ev){
        $('#addtocart-staff_id').html('<option value=\"\">select</option>'); 
        $('#addtocart-free_time_list').html('<option value=\"\">select</option>'); 
        $('#SingleOrder_addons_list').html('');
    
    });
    
    $('.addtocart').on('click', function(){
        $('body .help-block').remove();
                $.ajax({
                    type : 'post',
                    url : '".Yii::$app->urlManager->createUrl('merchant/service')."',
                    data : $('#add-to-cart').serialize(),
                    dataType : 'json',
                    success : function(response){
                        if(response.success == true){
                            $('#extras').modal('hide');
                            $('#orders').html(response.data);
                            $('#subtotal').html(response.subtotal);
                            $('#total').html(response.total);
                            $('#couponper').html(response.couponPer);
                            $('#discount').html(response.discount);
                            $('#appointment-coupone').val('');
                            $('#appointment-apply_coupon').iCheck('uncheck');
                        
                        }else{
                            $.each(response.data, function(key, val) {
                                console.log(key);
                                $('#addtocart-'+key).after('<div class=\"help-block\">'+val+'</div>');
                                $('#addtocart-'+key).closest('.form-group').addClass('has-error');
                            });
                        }
                        
                        
                    
                    }
                })
            })
    
    $('#find-free-time').on('click', function(){
    
    $.ajax({
        type : 'post',
        url : '".Yii::$app->urlManager->createUrl('order/get-staff-free-time')."',
        data : {staff_id:$('#addtocart-staff_id').val(),
        date_val:$('#addtocart-order_date').val(),
        min_val:$('#find-min-val').val()}, 
        dataType : 'json',
        success : function(response){
            $('#addtocart-free_time_list').html(response.dd); 
            
        console.log(response);
            }
    });
    
    })
    
    $('#find-staff').on('click', function(event){
    console.log('i mahere');
    event.preventDefault()
    $.ajax('".Yii::$app->urlManager->createUrl('order/get-free-staff')."',
    {'data':{time_val:$('#addtocart-time_req').val(),
            date_val:$('#addtocart-order_date').val(),
            min_val:$('#find-min-val').val(),
            cat:".$model->id.",
            merchant_id:".$model->merchant_id.",
        },
    type:'post'})
    .done(function(data){
        $('#addtocart-staff_id').html(data);
        $('#addtocart-free_time_list').html('<option value=\"\">select</option>'); 
        $('#SingleOrder_addons_list').html('');
    });
        })
        
    



")
?>



