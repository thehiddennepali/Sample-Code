
<?php
$session = Yii::$app->session;
$keyword = $session['keyword'];
$merchantid = $session['merchant_id'];

if (isset($merchantid)) {
	$merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantid]);
	
	$merchantUrl = preg_replace('/\s+/', '', $merchant->service_name);
	$merchantUrl = strtolower($merchantUrl) . '-' . $merchant->merchant_id;
//	echo '<pre>';
//	print_r($merchant->giftVoucherSetting->attributes);
//	echo '</pre>';
	
	$currencyCode = common\components\Helper::getCurrencyCode($merchant);
}
?>


<!-- Content ================================================== -->
<div class="container margin_60_35">
    <div id="container_pin">
	<div class="row">

	    <?php $form = yii\widgets\ActiveForm::begin(['id' => 'gift-voucher-form']); ?>
	    
	    


	    <div class="col-md-8">
		<div class="box_style_2">
		    <h2 class="inner"><?php echo Yii::t('basicfield', 'Payment methods')?></h2>

		    <?php 
		    	$field = $form->field($addToCart, 'paymentMethod', ['options' => ['class' => 'form-group']]);
			$field->template = "{error}";  
			echo $field->textInput(['maxlength' => 255]);
		    
		    if (in_array(2, $merchant->giftVoucherSetting->payment)) { ?>
			    <div class="payment_select" id="paypal">
				<label>
				    
				    <input type="radio" value="2" name="AddToCart[paymentMethod]" class="icheck payment">
				    <?php echo Yii::t('basicfield', 'Pay with paypal')?>
				    <?php //echo $form->field($addToCart, 'paymentMethod')->radio(['class' => 'icheck','value'=> 3, 'label' => 'Pay with paypal'])?>
				</label>
			    </div>
			    <?php
		    }
		    if (in_array(1, $merchant->giftVoucherSetting->payment)) {
			    ?>
			    <div class="payment_select">
				<label>
				    <input type="radio" value="1" name="AddToCart[paymentMethod]" class="icheck payment">
				    <?php echo Yii::t('basicfield', 'Bank transfer')?>
				    
				    <?php //echo $form->field($addToCart, 'paymentMethod')->radio(['class' => 'icheck','value'=> 2, 'label' => 'Bank transfer'])?>
				    
				</label>
				<i class="icon_wallet"></i>
			    </div>

			<?php
			}
			if (in_array(0, $merchant->giftVoucherSetting->payment)) {
			    ?>
			    <div class="payment_select nomargin">
				<label>
				    
				    <input type="radio" value="0" name="AddToCart[paymentMethod]" class="icheck payment">
				    <?php echo Yii::t('basicfield', 'Pay cash on pickup')?>
				    
				    <?php //echo $form->field($addToCart, 'paymentMethod')->radio(['class' => 'icheck','value'=> 1, 'label' => 'Pay cash on pickup'])?>
				    
				</label>
				<i class="icon_wallet"></i>
			    </div>
			<?php } 
			

			
			?>
		</div><!-- End box_style_1 -->
		<div class="box_style_2">
		    <h2 class="inner"><?php echo Yii::t('basicfield', 'Delivery Options')?></h2>
			<?php 
			$field = $form->field($addToCart, 'deliveryOption', ['options' => ['class' => 'form-group']]);
			$field->template = "{error}";  
			echo $field->textInput(['maxlength' => 255]);
			
			if (in_array(0, $merchant->giftVoucherSetting->delivery_options)) { ?>
			    <div class="payment_select" id="pick-up">
				<label>
				    
				    <input type="radio" value="0" name="AddToCart[deliveryOption]" class="icheck delivery-option">Pick up
				    <?php //echo $form->field($addToCart, 'deliveryOption')->radio(['class' => 'icheck delivery-option','value'=> 1, 'label' => 'Pick up'])?>
				</label>
			    </div>

			<?php } if (in_array(1, $merchant->giftVoucherSetting->delivery_options)) {?>
		    <div class="payment_select" id="mail">
			<?php echo $this->render('shipping-address-billing', ['model' => $addressBilling, 'form' => $form, 'addToCart' => $addToCart]) ?>
<!--			<label>
			    <input type="radio" value="1" name="AddToCart[deliveryOption]" class="icheck delivery-option">Delivered to billing address
			    <?php //echo $form->field($addToCart, 'deliveryOption')->radio(['class' => 'icheck delivery-option','value'=> 2, 'label' => 'Delivered to billing address'])?>
			    
			</label>-->
			<i class="icon_wallet"></i>
		    </div>
		    <div class="payment_select nomargin" id="mail">

			<?php echo $this->render('shipping-address', ['model' => $addressShipping, 'form' => $form, 'addToCart' => $addToCart]) ?>

		    </div>
		    
			<?php }
			
			
			?>
		</div><!-- End box_style_1 -->
	    </div><!-- End col-md-6 -->

	    <div class="col-md-4">
		<div id="cart_box">
		    <h3>Your Order <i class="icon_cart pull-right"></i></h3>
				<?php echo $this->render('/order/voucher-cart') ?>


		    <hr>					
		    <table class="table table_summary">
			<tbody>
			    <tr>
				<td>
				    <?php echo Yii::t('basicfield' , 'Subtotal')?>
				     <span class="pull-right">
					<?php echo $currencyCode;?> 


					<?php echo \frontend\components\UrlHelper::numberFormat($session['voucher-subtotal']) ?></span>
				</td>
			    </tr>
			    
			    <?php 
			    $shippingFee = 0;
			    if(in_array(1, $merchant->giftVoucherSetting->delivery_options)){
				    $shippingFee = $merchant->giftVoucherSetting->delivery_fee;
				    
				    echo $form->field($addToCart, 'deliveryFee')->hiddenInput(['value'=> $merchant->giftVoucherSetting->delivery_fee]);
				    ?>
			    <tr>
				<td>
				    <?php echo Yii::t('basicfield' , 'Shipping & Handling Fee')?>
				    
				    <span class="pull-right">
					<?php echo $currencyCode;?> 
					
					<?php echo frontend\components\UrlHelper::numberFormat($merchant->giftVoucherSetting->delivery_fee);?>
				    </span>
				</td>
			    </tr>
			    <?php }?>
			    <tr>
				<td class="total">
				    <?php echo Yii::t('basicfield' , 'TOTAL')?>
				     <span class="pull-right">
					<?php echo $currencyCode;?> 
					    <?php 
				    $total = $shippingFee + $session['voucher-total'];
				    echo \frontend\components\UrlHelper::numberFormat($total) ?></span>
				</td>
			    </tr>
			</tbody>
		    </table>
		    
		    <i class="icon-spinner loading" aria-hidden="true" style="display: none"></i>
		    <button class="btn_full" href="javascript:void(0)" id="proceed-checkout">
			<?php echo Yii::t('basicfield' , 'Proceed to checkout')?>
			
		    </button>
		    
		    <a class="btn_full_outline" href="<?php echo Yii::$app->urlManager->createUrl(['merchant/gift-voucher', 'id' => $merchantUrl]) ?>">
			<i class="icon-right"></i> 
			<?php echo Yii::t('basicfield' , 'Cancel order - back to {merchantname}', [
			    'merchantname' => $merchant->service_name
			])?>
			
			</a>
		</div><!-- End cart_box -->
	    </div><!-- End col-md-3 -->
<?php yii\widgets\ActiveForm::end(); ?>
	</div><!-- End row -->
    </div><!-- End container pin-->
</div><!-- End container -->
<!-- End Content =============================================== -->
<?php 

$paymentUrl  = Yii::$app->urlManager->createUrl('widget/voucher-payment');
$js = <<<SCRIPT
	
	$('.payment').on('ifChecked unChecked', function (){
		var value = $(this).val();
		console.log(value);
	
		if(value == 0){
			$('body #mail').hide();
			$('#pick-up').show();
			
		}else{
			$('body #mail').show();
			$('#pick-up').hide();
		}
	
	})
	
	$('#proceed-checkout').on('click', function(e){
		e.preventDefault();
		$('.loading').show();
		var obj = $(this);
		obj.prop("disabled",true);
	
		$('body .help-block').empty();
	
		$.ajax({
			type : 'post',
			url : '$url',
			data : $('#gift-voucher-form').serialize(),
			dataType : 'json',
			success  : function(response){
				
				if(response.success == true){
					obj.prop("disabled",false);
					if(response.payment == 2){
						window.open(
							response.data,
							'_blank' 
						      );
					}else{
						window.location.href = response.data;
					}
					
				
				}else{
					$('.loading').hide();
					obj.prop("disabled",false);
	
					$.each(response.message, function(key, val) {
						if(key == 'paymentMethod') key = 'paymentmethod';
						if(key == 'deliveryOption') key = 'deliveryoption';
						
						console.log($('.field-addtocart-'+key));
						$('.field-addtocart-'+key).find('.help-block').html(val);
						$('.field-addtocart-'+key).closest('.form-group').addClass('has-error');
	
						$('.field-shippingaddress-'+key).find('.help-block').html(val);
						$('.field-shippingaddress-'+key).closest('.form-group').addClass('has-error');
	
						$('.field-billingaddress-'+key).find('.help-block').html(val);
						$('.field-billingaddress-'+key).closest('.form-group').addClass('has-error');
					});
				}
				
			}
		})
		
       
	})
	
	
	$('.delivery-option').on('ifChecked unChecked', function(event){	
	
		var value = $(this).val();
		console.log(value);
	
		if(value == 2){
			$('#collapseTwo').hide();
			$('#collapseOne').show();
		}else if(value == 1)
		{
			$('#collapseOne').hide();
			$('#collapseTwo').show();
		}else{
			$('#collapseOne').hide();
			$('#collapseOne').hide();
		}

	})
SCRIPT;

$this->registerJs($js);

?>