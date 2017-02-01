<?php

use frontend\models\MtMerchant;
use yii\widgets\ActiveForm;
?> 

<p>
    <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">
        <?php echo Yii::t('basicfield', 'View on map')?></a>
</p>
<?php $client_id =Yii::$app->user->id;
?>
<div id="summary_review">
    <div class="row" id="rating_summary">
        <div class="col-md-6">
            <div id="general_rating">
                <?php $count = \frontend\models\MtReview::find()->where(['merchant_id' => $model->merchant_id])->count();
                echo $count.' ';?> <?php echo Yii::t('basicfield', 'Reviews')?><br>
                <div class="rating">
                    <?php 
                    $sum = 0;
                    $sql = "select rating from mt_review where merchant_id = ".$model->merchant_id;
                    $query = Yii::$app->db->createCommand($sql)->queryAll();
                    foreach ($query as $data){
                        $sum += $data['rating'];
                    }
                    //echo $sum;
                    $avg = $sum / $count;
                    
                    for($i= 0; $i<=$avg; $i++){?>
                     <i class="icon_star voted"></i>
                    <?php }?>
                </div>
            </div>
        </div>
<?php if(Yii::$app->user->isGuest){ }
else{?>
        <div class="col-md-6">
            <div class="rating1">
                
                <a href="#" class="btn_1 add_bottom_15" data-toggle="modal" data-target="#myReview">
                    <?php echo Yii::t('basicfield', 'Leave a review')?>
                    
                </a>
                
            </div>

        </div>
<?php } ?>
    </div><!-- End row -->					
    <div class="col-md-12">
        <div id="general_rating">

            <div class="rating">
                <?php if(!empty($model->fb)){?>
                <a href="<?php echo $model->fb ?>" target="_blank" alt="Facebook" title="Facebook"><strong>
                        <i class="icon-facebook"></i></strong> </a>
                        
                <?php }?>
                        <?php if(!empty($model->gl)){?>
                <a href="<?php echo $model->gl ?>" target="_blank" alt="Google+" title="Google+"><strong><i class="icon-googleplus"></i></strong> </a>
                        <?php }?>
                <?php if(!empty($model->tw)){?>
                <a href="<?php echo $model->tw ?>" target="_blank" alt="Twitter" title="Twitter"><strong><i class="icon-twitter"></i></strong> </a>
                <?php }?>
                
                <?php if(!empty($model->yt)){?>
                <a href="<?php echo $model->yt ?>" target="_blank" alt="Youtube" title="Youtube"><strong><i class="icon-youtube-4"></i></strong> </a>
                <?php }?>
                
                <?php if(!empty($model->pr)){?>
                <a href="<?php echo $model->pr ?>" target="_blank" alt="Pinterest" title="Pinterest"><strong><i class="icon-pinterest-circled"></i></strong> </a>
                <?php }?>
                <?php if(!empty($model->it)){?>
                <a href="<?php echo $model->it ?>" target="_blank" alt="Instagramm" title="Instagramm"><strong><i class="icon-instagramm"></i></strong> </a>
                <?php }?>
            </div>


        </div>
    </div>					


    <hr class="styled">

</div><!-- End summary_review -->	

<?php 

    $voucher = 'SELECT * FROM mt_voucher WHERE merchant_id='.$model->merchant_id;
    $queryVoucher = Yii::$app->db->createCommand($voucher)->queryAll();



    $loyality = 'SELECT * FROM loyalty_points WHERE merchant_id=' . $model->merchant_id;
    $queryLoyality = Yii::$app->db->createCommand($loyality)->queryOne();



    if ( !empty($queryVoucher) || (!empty($queryLoyality) && $queryLoyality['is_active'] == 1)) {
        ?>

<div id="summary_review">
    <div class="row" id="rating_summary">


        <div class="col-md-12">
            <div id="general_rating">

                <div class="general_rating">
                    
                    
                    
                    <h4 class="nomargin_top">
                        <?php echo Yii::t('basicfield', 'Specials')?>
                         <i class="icon-diamond pull-right"></i></h4>

                        <ul class="opening_list">

                            <?php
                            
//                            if(!empty($queryVoucher)){
//                             echo '<li><i class="icon-gift"></i> '.Yii::t('basicfield', 'Gutscheine').' <span  class="label label-success"><i class="icon_check_alt2 ok"></i> </span></li>';   
//                            }
                            
                            if(!empty($queryLoyality) && $queryLoyality['is_active'] == 1){
                                echo '<li><i class="icon-heart"></i> '.Yii::t('basicfield', 'Loyalty Points').' <span  class="label label-success"><i class="icon_check_alt2 ok"></i> </span></li>';
                            }
                            
                            if(!empty($queryVoucher)){
                                
                                
                                echo '<li><i class="icon-euro"></i> '.Yii::t('basicfield', 'Coupon');
                                echo '<ul>';
                                foreach ($queryVoucher as $voucher){
                                    
                                    if($voucher['expiration'] >= date('Y-m-d')){
                                        
                                        
                                        $services = frontend\models\MtVoucher::getServices($voucher);
                                        
                                        echo '<li>';
                                        echo 'Coupon Code: '.$voucher['voucher_name'].'&nbsp';
                                        echo '<a href="#" class="tooltip-1" data-placement="top" title="" data-original-title="'.$services.'"><i class="icon_question_alt"></i></a>';
                                        echo '</li>';
                                    }
                                }
                                
                                echo '</ul></li>';
                            }
                            

                            
                            ?>

                        </ul>

<?php //} ?>
                </div>


            </div>
        </div>					


        <hr class="styled">
    </div>
</div><!-- End summary_review -->						
    <?php }?>
<div class="box_style_2">

    <h4 class="nomargin_top">
        <?php echo Yii::t('basicfield', 'Opening time')?>
        
        <i class="icon_clock_alt pull-right"></i></h4>
    <ul class="opening_list">

        <?php
        $sql = 'SELECT * FROM merchant_schedule_history where merchant_id=' . $model->id . ' order by id desc';
        $squerySchedule = Yii::$app->db->createCommand($sql)->queryOne();

        $schedule = MtMerchant::getSchedule($squerySchedule);

        $days = MtMerchant::$days;

        foreach ($schedule as $key => $value) {
            ?>

            <li><?php echo Yii::t('basicfield', $days[$key]); ?>

                <?php
                if (!empty($value)) {
                    echo '<span>';
                    foreach ($value as $sch) {
                        ?>
                        <?php echo $sch['time_from']; ?>-<?php echo $sch['time_to']; ?>
                    <?php
                    }
                    echo '</span>';
                } else {
                    echo '<span class="label label-danger">';
                    echo Yii::t('basicfield', 'Closed');
                    echo '</span >';
                }
                ?>

            </li>

    <?php }
?>

    </ul>

</div>

<div id="cart_box">

    <?php
    $form = ActiveForm::begin([
                //'action' => Yii::$app->urlManager->createUrl('checkout/index'),
                'id' => '',
                'options' => [
                    'class' => 'forms'
                ],
                'fieldConfig' => [
                    'template' => "{input}{error}",
                    'options' => [
                        'tag' => false
                    ]
                ]
    ]);
    ?>
    <h3><?php echo Yii::t('basicfield', 'Appointment Details')?> <i class="icon_calendar pull-right"></i></h3>
    <table class="table table_summary" id="orders">
        <tbody>

<?php
$session = Yii::$app->session;
echo $this->render('orders', ['orders' => $session['cart']]);


?>
            
            <?php echo $form->field($appointment, 'order')->hiddenInput() ?>

        </tbody>
    </table>


    <!--                <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Team</label>
                                
<?php echo $form->field($appointment, 'employee')->dropDownList(yii\helpers\ArrayHelper::map(frontend\models\Staff::find()->where(['merchant_id' => $model->id])->all(), 'id', 'name')) ?>
                                
                            </div>
                        </div>
                        <div class='col-sm-12'>
                            <div class="form-group">
                                <label>Datum und Uhrzeit</label>
                                <div class='input-group date' id='datetimepicker1'>
<?php echo $form->field($appointment, 'date_time') ?>
                                    <span class="input-group-addon">
                                        <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg"> <span class="icon_calendar"></span></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>-->

    

    <hr>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label><?php echo Yii::t('basicfield', 'Coupon')?></label>
<?php echo $form->field($appointment, 'coupone')->textInput(['placeholder' => Yii::t('basicfield', 'Apply Coupon')]) ?>

            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-md-12 col-sm-12">

            <label>
<?php echo $form->field($appointment, 'apply_coupon')->checkbox(['class' => 'icheck coupon',
    'label' => false,
    'data-merchanid' => $model->id
    ])->label(false) ?>
                <?php echo Yii::t('basicfield', Yii::t('basicfield', 'Apply Coupon'))?>
                </label>
        </div>
    </div>
    <hr>					
    <table class="table table_summary">
        <tbody>
            <tr>
                <td>
                    <?php echo Yii::t('basicfield', 'Subtotal');?> <span class="pull-right">€ 
                        <span id="subtotal"><?php echo number_format($session['subtotal'], 2, '.', '') ;?></span>
                        </span>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Yii::t('basicfield', 'Coupon');?> <span id="couponper"><?php echo $session['couponPer'];?></span> 
                    <span class="pull-right" id="discount">€ <?php echo number_format($session['discount'], 2, '.', '');?></span>
                </td>
            </tr>
            <tr>
                <td class="total">
                    <?php echo Yii::t('basicfield', 'TOTAL');?> <span class="pull-right">€ 
                        <span id="total"><?php echo number_format($session['total'], 2, '.', '') ?></span></span>
                </td>
            </tr>
        </tbody>
    </table>
    <input type="submit" class="btn_full" value="<?php echo Yii::t('basicfield', 'Book your Appointment')?>">
    

<?php ActiveForm::end(); ?>
</div><!-- End cart_box -->



<?php
$this->registerJs("
    $('.coupon').on('ifChecked ifUnchecked', function(){
        var checkornot = $(this).is(':checked');
        var coupon  = $('#appointment-coupone').val();
        var merchanid  = $(this).data('merchanid');
        console.log(checkornot);

        if(coupon === ''){
            var parent = $('#appointment-coupone').parent();
            parent.find('.help-block').html('Please enter coupon');

        }else{
            $.ajax({
                type : 'post',
                url : '" . Yii::$app->urlManager->createUrl('order/coupon') . "',
                data : {coupon : coupon, merchanid : merchanid, checkornot : checkornot},
                dataType : 'json',
                success : function(response){
                    console.log(response);
                    $('#total').html(response.total);
                    $('#discount').html(response.discount);
                    $('#couponper').html(response.couponPer);
                }
            })

        }

        })");
?>
       