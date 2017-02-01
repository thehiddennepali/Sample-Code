<?php
$session = Yii::$app->session;
$keyword = $session['keyword'];
$merchantid = $session['merchant_id'];

if (isset($merchantid)) {
	$merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantid]);

	$merchantUrl = preg_replace('/\s+/', '', $merchant->service_name);
	$merchantUrl = strtolower($merchantUrl) . '-' . $merchant->merchant_id;
	
	$currencyCode = common\components\Helper::getCurrencyCode($merchant);
}
?>



<!-- Content ================================================== -->
<div class="container margin_60_35">
    <div class="row">
	<div class="col-md-offset-3 col-md-6">
	    <div class="box_style_2">
		<h2 class="inner"><?php echo Yii::t('basicfield', 'Order confirmed!') ?></h2>
		<div id="confirm">
		    <i class="icon_check_alt2"></i>
		    <h3><?php echo Yii::t('basicfield', 'Thank you!') ?></h3>
		    <p>
			<?php echo Yii::t('basicfield', 'For purchasing our voucher.') ?>
		    </p>
		</div>

		<h3>Your order <i class="icon_cart pull-right"></i></h3>
		<hr>
		
		<?php 
		
		?>
		<div class="row" id="options_2">
		    <div class="col-md-12 col-sm-12 col-xs-12">
			<i class="icon_calendar"></i> <?php echo Yii::t('basicfield', 'Delivered by:') ?></label>
			<?php 
				echo $order::$deliveryOption[$order->delivery_option];
			/*if($order->delivery_option == 0){
				return $order::$deli->client_name;   
			}else{
				return $order->address->first_name.' '.$order->address->last_name;
			}*/?>
		    </div>
		    
		    <?php if($order->delivery_option != 0 ){?>
		    <div class="col-md-12 col-sm-12 col-xs-12">
			<i class="icon_calendar"></i> <?php echo Yii::t('basicfield', 'Shipping address:') ?></label>
			<p><?php echo $order->address->first_name.' '.$order->address->last_name;?></p>
			<p><?php echo $order->address->street.', ', $order->address->city.', '.$order->address->zipcode;?></p>
		    </div>
		    
		    <div class="col-md-12 col-sm-12 col-xs-12">
			
			<i class="icon_calendar"></i> <?php echo Yii::t('basicfield', 'Note on the voucher:') ?>
			<?php echo $order->voucher_note;?>
			    
		    </div>
		    <?php }?>
		    
			

		</div><!-- Edn options 2 -->
		<hr>					
		<h4><?php echo Yii::t('basicfield', 'Voucher') ?></h4>
		<hr>
		<table class="table table_summary">
		    <tbody>
			<?php
			foreach ($cart as $key => $value) {
				
				?>

				<tr>
				    <td>

					<strong><?php echo $value['qty']; ?>x</strong> <?php echo $value['title'] ?> Value € <?php echo \frontend\components\UrlHelper::numberFormat($value['price']); ?>
				    </td>
				    <td>
					<strong class="pull-right">
					    <?php echo $value['currency']?>
						
						<?php echo \frontend\components\UrlHelper::numberFormat($value['price']); ?></strong>
				    </td>
				</tr>


				<?php }
			?>
			<tr>
			    <td>
				<hr>
			    </td>
			</tr>
			<tr>
			    <td>
				<?php echo Yii::t('basicfield', 'Subtotal') ?> 
			    </td>
			    <td>
				<strong class="pull-right">
				    <?php echo $currencyCode;?>
					<?php echo $subtotal?></strong>
			    </td>
			</tr>
			<tr>
			    <td>
				
				<?php echo Yii::t('basicfield', 'Shipping & Handling Fee') ?> 
				
			    </td>
			    <td>
				<strong class="pull-right">
				    <?php echo $currencyCode;?>
					<?php echo frontend\components\UrlHelper::numberFormat($order->delivery_fee)?></strong>
			    </td>
			</tr>
			<tr>
			    <td class="total_confirm">
				<?php echo Yii::t('basicfield', 'TOTAL') ?> 
			    </td>
			    <td class="total_confirm">
				
				<?php 
				$total = $order->delivery_fee + $session['voucher-total'];
				?>
				<span class="pull-right">
					<?php echo $currencyCode;?>
					<?php echo frontend\components\UrlHelper::numberFormat($total);?>
				</span>
			    </td>
			</tr>
			<tr>
			    <td>
				<?php 
				
				$merchantLoylitypoints = \frontend\models\LoyaltyPoints::findOne(['merchant_id' => $order->merchant_id]);
				if($merchantLoylitypoints->is_active == 1){
				$loyality = \frontend\models\Option::getValByName('website_loyalty_points');
                                    $loyalityPoints = $session['voucher-total']  * $loyality;
                                ?>
                                <?php echo Yii::t('basicfield','Loyalty Points')?> 
<!--                                <a href="#" class="tooltip-1" data-placement="top" title="" data-original-title=""><i class="icon_question_alt"></i></a>-->
                                <?php echo Yii::t('basicfield','For this voucher you receive {count} Loyalty Points', ['count'=> $loyalityPoints]);
				}?>
			    </td>
			</tr>
		    </tbody>
		</table>
	    </div>
	</div>
    </div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->
