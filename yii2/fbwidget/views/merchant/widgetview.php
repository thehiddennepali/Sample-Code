<?php

use fbwidget\models\MtMerchant;
use yii\widgets\ActiveForm;
?> 
<div class="row">

    <div class="col-md-8">

        <div class="box_style_2">
	    <div style="display:none">
	    <?= yii\authclient\widgets\AuthChoice::widget([
			'baseAuthUrl' => ['merchant/auth']
		   ]) ?>
		
	    </div>

            <h2 class="inner"><?php echo Yii::t('basicfield', 'Services & Treatments')?></h2>
            <div>



                <!-- Tab panes -->




                <div class="panel-group" id="accordion">

                    <?php
                    $sqlCategoryhadMerchant = 'SELECT chm.category_id, ssc.*, sc.id as catid from category_has_merchant as chm 
                                        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                                        RIGHT JOIN  mt_service_category as sc ON ssc.category_id=sc.id
                                        WHERE chm.merchant_id=' . $model->merchant_id . ' group by sc.id';

                    $queryCathasMerchant = Yii::$app->db->createCommand($sqlCategoryhadMerchant)->queryAll();

                    if ($queryCathasMerchant) {
                        foreach ($queryCathasMerchant as $cat) {

                            $sqlCategoryMerchant = 'SELECT chm.category_id, ssc.*, sc.id as catid from category_has_merchant as chm 
                                        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                                        RIGHT JOIN  mt_service_category as sc ON ssc.category_id=sc.id
                                        WHERE chm.merchant_id=' . $model->merchant_id . ' and sc.id=' . $cat['catid'] . ' group by ssc.id';

                            $queryCatMerchant = Yii::$app->db->createCommand($sqlCategoryMerchant)->queryAll();

                            foreach ($queryCatMerchant as $service) {
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $service['id'] ?>">
                                                <?php echo Yii::t('servicesubcategory', $service['title']) ?>
                                                <i class="indicator icon_plus_alt2 pull-right"></i></a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne<?php echo $service['id'] ?>" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-striped cart-list">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <?php echo Yii::t('basicfield', 'Item') ?>
                                                        </th>
                                                        <th>
                                                            <?php echo Yii::t('basicfield', 'Price') ?>
                                                        </th>
                                                        <th>
                                                            <?php echo Yii::t('basicfield', 'Book now') ?>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $serviceSql = 'SELECT * FROM category_has_merchant WHERE category_id=' . $service['id'] . ' and merchant_id=' . $model->id;


                                                    $queryServices = Yii::$app->db->createCommand($serviceSql)->queryAll();
						    
						    $price = \common\components\Helper::getCurrencyCode($model);

                                                    if ($queryServices) {

                                                        foreach ($queryServices as $ser) {
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <h5><?php echo $ser['title'] ?></h5>
                                                                    <p><?php echo $ser['description']; ?></p>
                                                                </td>
                                                                <td>
                                                                    <strong><?php echo $price;?><?php echo $ser['price'] ?></strong>
                                                                </td>
                                                                <td class="options">
                                                                    <a href="javascript:void(0)"  class="add-to-cart" data-id='<?php echo $ser['id'] ?>'> <i class="icon_plus_alt2"></i></a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                    }
                    ?>
                </div>



            </div>



        </div>

    </div>






    <!-- End box_style_1 -->

    <div class="col-md-4">
	
	<?php $giftVoucher = \common\models\GiftVoucher::find()->where(['merchant_id' => $model->id])->count();

	$merchantUrl = preg_replace('/\s+/', '', $model->service_name);
	$merchantUrl = strtolower($merchantUrl) . '-' . $model->merchant_id;

	if($giftVoucher > 0){?>

	<div id="summary_review">
		<div class="row" id="rating_summary">


			<div class="col-md-12">
				<div id="general_rating">

					<div class="general_rating">
					<h4 class="nomargin_top">Gift voucher <i class="icon-gift pull-right"></i></h4>
					<p><?php echo $model->service_name;?> offers gift vouchers you can buy here.</p>
					<a class="btn_full" href="<?php echo Yii::$app->urlManager->createUrl(['widget/gift-voucher', 'id' => $model->id])?>">
					    Buy a gift voucher
					</a>
					</div>


				</div>
			</div>					


			<hr class="styled">
		</div>
	</div><!-- End summary_review -->

	<?php }?>

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
                            
                            if(!empty($queryVoucher)){
                             echo '<li><i class="icon-gift"></i> '.Yii::t('basicfield', 'Gutscheine').' <span  class="label label-success"><i class="icon_check_alt2 ok"></i> </span></li>';   
                            }
                            
                            if(!empty($queryLoyality) && $queryLoyality['is_active'] == 1){
                                echo '<li><i class="icon-heart"></i> '.Yii::t('basicfield', 'Treuepunkte').' <span  class="label label-success"><i class="icon_check_alt2 ok"></i> </span></li>';
                            }
                            
                            if(!empty($queryVoucher)){
                                
                                
                                echo '<li><i class="icon-euro"></i> '.Yii::t('basicfield', 'Aktion');
                                echo '<ul>';
                                foreach ($queryVoucher as $voucher){
                                    
                                    if($voucher['expiration'] >= date('Y-m-d')){
                                        $services = fbwidget\models\MtVoucher::getServices($voucher);
                                        
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
    <h3><?php echo Yii::t('basicfield', 'Terminbuchung')?> <i class="icon_calendar pull-right"></i></h3>
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
                                
<?php echo $form->field($appointment, 'employee')->dropDownList(yii\helpers\ArrayHelper::map(fbwidget\models\Staff::find()->where(['merchant_id' => $model->id])->all(), 'id', 'name')) ?>
                                
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
                <label><?php echo Yii::t('basicfield', 'Coupon ')?></label>
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
                    <?php echo Yii::t('basicfield', 'Subtotal');?> <span class="pull-right">
			
			<?php echo $price;?>
                        <span id="subtotal"><?php echo number_format($session['subtotal'], 2, '.', '') ;?></span>
                        </span>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo Yii::t('basicfield', 'Coupon');?> <span id="couponper">
			    <?php echo $session['couponPer'];?></span> 
                    <span class="pull-right" id="discount"><?php echo $price;?> <?php echo number_format($session['discount'], 2, '.', '');?></span>
                </td>
            </tr>
            <tr>
                <td class="total">
                    <?php echo Yii::t('basicfield', 'TOTAL');?> <span class="pull-right"><?php echo $price;?> 
                        <span id="total"><?php echo number_format($session['total'], 2, '.', '') ?></span></span>
                </td>
            </tr>
        </tbody>
    </table>
    <input type="submit" class="btn_full" value="<?php echo Yii::t('basicfield', 'Book your Appointment')?>">
    

<?php ActiveForm::end(); ?>
    
    <hr class="styled">
                        <div class="row">
                        <div class="col-md-6 col-sm-3 col-xs-3">

<p class="top-space"><a href="#" alt="aondego terminverwaltung einfach gemacht"><img class="img-responsive" src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/logo-sign-800-bg.png" alt="aondego appointment management" border="0" /></a></p>
</div>
<div class="col-md-6 col-sm-3 col-xs-3">

<p><img class="img-responsive space1" src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/ssl.png" alt="aondego appointment management" border="0" /></p>
</div>
</div>
</div><!-- End cart_box -->

</div>
</div><!-- End row -->


<div class="modal fade" id="extras" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<?php $this->registerJs('
            $(document).ready(function(){
            
            //if($( "#Img_carousel" ))
            //$( "#Img_carousel" ).sliderPro();
            
            $("body").on("click", ".add-to-cart", function(){
                $("#extras").find(".modal-content").empty();
                var serviceid = $(this).data("id");
                var key = $(this).data("key");
                var update = 0;
                console.log(key);
                if(key == "" && key != 0){
                    console.log("i mahere");
                    key = "";
                }else{
                    update = 1;
                }
                
                $.ajax({
                    type : "post",
                    url : "'.Yii::$app->urlManager->createUrl('merchant/service').'",
                    data : {serviceid : serviceid, key: key, update : update},
                    success : function(response){
                        $("#extras").find(".modal-content").html(response);
                        $("#extras").modal("show");
                        console.log()
                    }
                })
            })
            
        })')?>


<?php


if(!Yii::$app->user->id){
$this->registerJs("
	
	$(document).ready(function(){
		$('.facebook').trigger('click');
	       });
    ");

}

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

        })")
?>
