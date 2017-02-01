<?php 
$session = Yii::$app->session;
$keyword = $session['keyword'];
$merchantid = $session['merchant_id'];

if(isset($merchantid)){
    $merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantid]);
}
?>

<!-- SubHeader =============================================== -->
<section class="parallax-window"  id="short"  data-parallax="scroll" data-image-src="img/sub_header_cart.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
    	<?php echo $this->render('sub_header')?>
	</div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="<?php echo Yii::$app->homeUrl;?>"><?php echo Yii::t('basicfield','Home');?></a></li>
                <li><a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/search','Merchant[search]' => $keyword])?>">Search</a></li>
                <li>
                    <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=> $merchant->id])?>">
                    <?php echo $merchant->service_name;?>
                    </a>
                </li>
                <li><?php Yii::t('basicfield','Payment');?></li>
            </ul>
        </div>
    </div><!-- Position -->
    
<!-- Content ================================================== -->
<div class="container margin_60_35">
	<div id="container_pin">
		<div class="row">
			<div class="col-md-3">
			<?php //echo $this->render('left_bar') ?>
                        </div><!-- End col-md-3 -->
            
			<div class="col-md-5">
                            <div class="box_style_2">
                                    <h2 class="inner"><?php Yii::t('basicfield','Payment methods');?></h2>
                                    <form id="payment-form">
                                    <div class="payment_select" id="paypal">
                                            <label><input type="radio" value="0" name="payment_method" class="icheck"><?php echo Yii::t('basicfield','Pay with paypal');?></label>
                                    </div>
                                    <div class="payment_select nomargin">
                                        <label><input type="radio" value="1" name="payment_method" class="icheck" checked="checked"><?php echo Yii::t('basicfield','Pay with cash');?></label>
                                            <i class="icon_wallet"></i>
                                    </div>
                                    </form>
                            </div><!-- End box_style_1 -->
			</div><!-- End col-md-6 -->
            
			<div class="col-md-4">
                            <div id="cart_box">
				<?php echo $this->render('right_bar'); ?>
                                
                                <div class="row" id="options_2">
                                    <span id="error-msg" style="display :none">
                                        <?php echo Yii::t('basicfield','Please check the agree with the general terms.')?> 
                                    </span>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label><input type="radio" value="" id="agree" name="option_2" class="icheck" >
                                                    <a href="<?php echo Yii::$app->urlManager->createUrl(['mt-custom-page/view', 'slug'=> 'term-and-condition'])?>" target="_blank">
                                                    <?php echo Yii::t('basicfield', 'I agree with the general terms')?>
                                                    </a>
                                                </label>
                                        </div>

                                </div><!-- Edn options 2 -->
                                <hr>	
                                
                                <a class="btn_full" href="javascript:void(0)" id="proceed-checkout" >
                                    <?php echo Yii::t('basicfield', 'Proceed Checkout')?>
                                </a>
                            </div>
			</div><!-- End col-md-3 -->
            
		</div><!-- End row -->
	</div><!-- End container pin-->
</div><!-- End container -->
<!-- End Content =============================================== -->
