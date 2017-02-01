
<div class="box_style_2">

    <h4 class="nomargin_top">
	<?php echo Yii::t('basicfield', 'Delivery Options');?>
	 <i class="icon_clock_alt pull-right"></i></h4>
    
    <?php if($model->giftVoucherSetting->is_delivery_free == 1){?>
    <p>
	<?php echo Yii::t('basicfield', 'A shipping and handling fee of {fee} will apply if the voucher is delivered by regular mail to the recepient.', [
	    'fee' => $model->giftVoucherSetting->delivery_fee
	]);?>
	 </p>
    <?php }else if($model->giftVoucherSetting->is_delivery_free == 0){?>
    <p>
	<?php echo Yii::t('basicfield', 'The delivery of the voucher is free.')?>
	</p>
    <?php }?>
</div>	



<div id="cart_box">
    <h3><?php echo Yii::t('basicfield', 'Your Order');?> <i class="icon_cart pull-right"></i></h3>
    
    
	<div id="voucher-cart">
		<?php echo $this->renderAjax('/order/voucher-cart');
		$session = Yii::$app->session;
		?>
	    
	</div>


	<hr>					
	<table class="table table_summary">
	    <tbody>
		<tr>
		    <td>
			<?php echo Yii::t('basicfield', 'Subtotal')?>
			 <span class="pull-right">
			    <?php echo $currencycode;?>
			     
			    <span id="voucher-subtotal">
			    <?php echo $session['voucher-subtotal']?>
			    </span>
			</span>
		    </td>
		</tr>

		<tr>
		    <td class="total">
			<?php echo Yii::t('basicfield', 'TOTAL')?>
			 <span class="pull-right">
				 <?php echo $currencycode;?> 
			    <span id="voucher-total">
			    <?php echo $session['voucher-total']?>
			    </span>
			</span>
		    </td>
		</tr>
	    </tbody>
	</table>
	<form method="post">
		
		<button type="submit" class="btn_full">
		    <?php echo Yii::t('basicfield', 'Proceed to checkout')?>
		    </button>
	</form>
</div><!-- End cart_box -->