    <?php

use frontend\components\ImageBehavior;
use kartik\time\TimePicker;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
    
    $form = ActiveForm::begin(['id' => 'add-to-cart']); 
    

    if(empty($model->time_in_minutes)) $model->time_in_minutes = 0;
    ?>



<?=$form->field($addToCard, 'serviceid')->hiddenInput( ['value'=>$model->id])->label(false);?>

<?=$form->field($addToCard, 'staff_id')->hiddenInput( ['value'=>$model->staff_id])->label(false);?>


<div class="modal-header">
    
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">
        <?php echo Yii::t('basicfield', 'Please select')?></h4>
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
        
        <?php echo Html::hiddenInput('find-min-val',0); ?>
        <?php /* $form->field($addToCard, 'order_date')->widget(DatePicker::classname(), [
            //'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'minDate' => 0,
                'showOn' => "button",
                'buttonImage' => "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
                'buttonImageOnly' => true,
                'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { 
                        $.ajax({
                            type : "post",
                            url : "'.Yii::$app->urlManager->createUrl('order/get-group-time').'",
                            data :$("#add-to-cart").serialize(),
                            success : function(response){
                                $("#time-req").html(response);
                                }
                        })

                }
                '),
            ],
            
        ]) */?>
        <?php echo '<label class="control-label">'.Yii::t('basicfield', 'Order Date').'</label>'; ?>
        <?= DatePicker::widget([
        'model' => $addToCard,
        'attribute' => 'order_date',
        'template' => '{input}{addon}',
            'clientOptions' => [
                'startDate'=> "today",
                'autoclose' => true,
                'defaultDate' =>  'today',
                'minDate' => 'today',
                'format' => \common\components\Helper::dateFormat($merchant)
                
            ]
    ]);?>
    </div>

    <div class="box_style_4">
        <?php  
        echo '<label class="control-label">'.Yii::t('basicfield', 'Time Req').'</label>';
        ?>
        
        <?php if($update == 1){
            
            echo Html::hiddenInput('key',$key);
            echo Html::hiddenInput('update',$update);
                $dStart = strtotime($addToCard->order_date);
                
                $k = 0;
                \frontend\components\GroupScheduleHelper::init(strtotime("+$k day", $dStart), $addToCart->serviceid, $model);
                $dayGroupSchedule = \frontend\components\GroupScheduleHelper::getDateSchedule(strtotime("+$k day", $dStart), $addToCard->serviceid, $model);
                
                echo  $this->render('/order/group_time', ['model' =>$dayGroupSchedule, 'selected' => $updateArray['time_req'] ]);
        }?>
        <?=$form->field($addToCard, 'time_req')->hiddenInput()->label(false);?>
        <div id="time-req"></div>
        
        
        
    </div>




        <div >Time/Price: 
            <span class="time-in-min">
                <?php echo $model->time_in_minutes?> 
            </span> / 
            <span class="single-price">
                <?php echo $model->price;?>
            </span>
        </div>

        <?php echo $form->field($addToCard, 'no_of_seats');?>

    <?php //if ($model->merchCatHasAddons) { ?>
        <div class="box_style_4">
            <h3 class="inner">Extras</h3>
            <div class="row" id="options_2">
                <span id="SingleOrder_addons_list"></span>
                <?php 
                
                echo $this->render('/order/_addons_single', ['addons' => $model->addons, 'selectedaddons'=>$updateArray['addons_list']]);
                /*foreach ($model->merchCatHasAddons as $addon) { 
                   
                    ?>
                    <div class="col-md-12">
                        <label>
                            <input type="radio" name="AddToCart[extra]" class="icheck" value="<?php echo $addon->addon->id; ?>">
                            <?php echo $addon->addon->name; ?></label>
                    </div>

                <?php } */?>


            </div><!-- Edn options 2 -->
        </div>

    <?php //} ?>


<div class="modal-footer">
    <button type="button" class="btn_3" data-dismiss="modal"><?php echo Yii::t('basicfield', 'Close')?></button>
    <button type="button" class="btn_2 addtocart"><?php echo Yii::t('basicfield', 'Add to Cart')?></button>
</div>
<?php ActiveForm::end(); ?>

<?php 


$this->registerJs("
    
    $('#addtocart-order_date').on('change', function(ev){
        $.ajax({
            type : 'post',
            url : '".Yii::$app->urlManager->createUrl('order/get-group-time')."',
            data :$('#add-to-cart').serialize(),
            success : function(response){
                $('#time-req').html(response);
                }
        })
        
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
        min_val:".$model->time_in_minutes."}, 
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
            min_val:".$model->time_in_minutes.",
            cat:".$model->id.",
            merchant_id:".$model->merchant_id.",
        },
    type:'post'})
    .done(function(data){
        $('#addtocart-staff_id').html(data)
    });
        })
        
    $('.single-checkbox-class').on('change',function(){
    console.log('idsfd ')
    if(this.checked) {
        console.log($('.single-price').html());
        console.log(parseFloat($(this).attr('data-price')));
        $('.single-price').html(parseFloat($('.single-price').html())+parseFloat($(this).attr('data-price')))
        $('.find-min-val').val(parseInt($('.find-min-val').val())+parseInt($(this).attr('data-time')))
        $('.time-in-min').html(parseInt($('.time-in-min').html())+parseInt($(this).attr('data-time')))
    }else{
        $('.single-price').html(parseFloat($('.single-price').html())-parseFloat($(this).attr('data-price')))
        $('.find-min-val').val(parseInt($('.find-min-val').val())-parseInt($(this).attr('data-time')))
        $('.time-in-min').html(parseInt($('.time-in-min').html())-parseInt($(this).attr('data-time')))
    }
});



")
?>



