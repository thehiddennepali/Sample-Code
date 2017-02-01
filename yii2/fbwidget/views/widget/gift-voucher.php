<?php 

$session = Yii::$app->session;
$keyword = $session['keyword'];
$merchantid = $session['merchant_id'];


    $merchantUrl = preg_replace('/\s+/', '', $model->service_name);
    $merchantUrl = strtolower($merchantUrl) . '-' . $model->merchant_id;

?>
<!-- Content ================================================== -->
<div class="container margin_60_35">
    <div class="row">



	<div class="col-md-8">

	    <div class="box_style_2">
		<h2 class="inner"><?php echo Yii::t('basicfield', 'Gift vouchers')?></h2>
		<div>



		    <div class="panel-body">
			<table class="table table-striped cart-list">
			    <thead>
				<tr>
				    <th>
					<?php echo Yii::t('basicfield', 'Gift vouchers')?>
				    </th>
				    <th>
					<?php echo Yii::t('basicfield', 'Price')?>
				    </th>
				    <th>
					<?php echo Yii::t('basicfield', 'Quantity')?>
				    </th>
				    <th>
					<?php echo Yii::t('basicfield', 'Buy now')?>
				    </th>
				</tr>
			    </thead>
			    <tbody>
				
				<?php foreach ($giftVoucher as $data){?>
				<tr>
				    <td>
					<h5><?php echo $data->name;?></h5>
					<?php if($data->type == 0){
						$totalPrice = $data->amount;
						?>
						<p>Value: 
						    <?php echo $currencycode;?>
							
							
							<?php echo $data->amount?> </p>
						<p> <?php echo Yii::t('basicfield', 'you can use this voucher on any service')?></p>
					<?php }else if($data->type == 1){
						$totalPrice = $data->serviceName->price;
						?>
						<p><?php 
						echo $data->serviceName->title;?></p>
					<?php }else if($data->type == 2){
						$categoryHasMerchant = $data->servicesName;
						
						if(!empty($categoryHasMerchant)){?>
							
							<?php 
							$totalPrice = 0;
							foreach ($categoryHasMerchant as $services){
								$totalPrice += $services->price;
								?>
								<p><?php echo $services->title;?></p>
							<?php }
						}
						?> 
						
					<?php }?>

				    </td>
				    <td>
					<strong><?php echo $currencycode;?> <?php echo $totalPrice;?></strong>
				    </td>
				    <td class="options">
					<a href="javascript:void(0)" class="add" data-type="add"> 
					    <i class="icon-plus-squared add" ></i> 
					    </a>
					    <input type="text" id="voucher_order" name="voucher_order" class="form-control1" value="0"> 
					    <a href="javascript:void(0)" class="add" data-type="sub"> 
					    <i class="icon-minus-squared add" data-type="sub"></i>
					    </a>
					
				    </td>
				    <td>

					<i style="display: inline-block;" class="icon-shopping-cart"></i>
					
					<i class="icon-spinner loading" aria-hidden="true" style="display: none"></i>
					<input type="submit" id="add-cart" class="btn_1 add_bottom_20 add-cart" value="Add to cart" 
					       data-voucherid="<?php echo $data->id?>"
					       data-price="<?php echo $totalPrice;?>"
					       data-title="<?php echo $data->name;?>"
					       />

				    </td>
				</tr>
				
				<?php }?>
				
			    </tbody>
			</table>
		    </div>




		</div>






	    </div><!-- End box_style_1 -->
	</div>
	<div class="col-md-4">
	    
	    <?php $appointment = \frontend\models\MtMerchant::hasServices($model);
	    
	    
	    if($appointment){
	    ?>
	    
	    <p>

		    <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/widgetview', 'id' => $session['merchant_id_widget']]) ?>" class="btn_6 add_bottom_15">
			<?php echo Yii::t('basicfield', 'Back to merchant appointment page'); ?>
		    </a>
	    </p>
	    
	    <?php }?>
	    
	    <?php echo $this->render('gift_voucher_right', [
		'model' =>$model,
		'currencycode' => $currencycode
	    ]);?>



	</div>
    </div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->


	


<?php 

$url = Yii::$app->urlManager->createUrl('order/voucher-cart');
$removeUrl = Yii::$app->urlManager->createUrl('order/voucher-remove');

$js = <<<SCRIPT
	
	$('body').on('click','.remove', function(){
	
		var confirmremove  = confirm('Are you sure you want to delete?');
	
		if(confirmremove == true){
			var voucherid = $(this).data('voucherid');

			$.ajax({
				type : 'post',
				url : '{$removeUrl}',
				data: {voucherid : voucherid},
				dataType : 'json',
				success : function(response){
					if(response.success == true){
						$('#voucher-cart').html(response.message);
						$('#voucher-subtotal').html(response.subtotal);
						$('#voucher-total').html(response.total);

					}

				}
			})
		}
	})
	$(".add").on("click", function(e){
		e.preventDefault();
		
		var obj = $(this);
		var input = obj.parent().find("#voucher_order");
		var output = input.val();
	
		if(obj.data('type') == 'add'){
			output = parseInt(output) + parseInt(1);
		}else if(obj.data('type') == 'sub'){
			if(output > 1){
				output = parseInt(output) - parseInt(1);
			}
		}
	
		input.val(output);
		
	
	})
	
	
	$('.add-cart').on('click', function(){
	
		var voucherid = $(this).data('voucherid');
		var price = $(this).data('price');
		var input = $(this).parent().parent().find("#voucher_order").val();
		var title = $(this).data('title');
		var spinner = $(this).parent().parent().find(".loading");
	
		if(input == 0){
			alert('Quantity cannot be zero.');	
		}else{
				
			spinner.show();		

			$.ajax({
				type : 'post',
				url : "{$url}",
				data : {voucherid: voucherid, price:price, qty:input, title: title},
				dataType : 'json',
				success :function (response){

					spinner.hide();

					if(response.success == true){
						$('#voucher-cart').html(response.message);
						$('#voucher-subtotal').html(response.subtotal);
						$('#voucher-total').html(response.total);

					}


				}
			})
		}
		
	})
	
SCRIPT;

$this->registerJs($js);

?>