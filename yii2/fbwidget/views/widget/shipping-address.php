<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
		    <h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
			    <input type="radio" value="2" name="AddToCart[deliveryOption]" class="icheck delivery-option">Delivered to shipping address
			    <?php //echo $form->field($addToCart, 'deliveryOption')->radio(['class' => 'icheck delivery-option','value'=> 3, 'label' => 'Delivered to shipping address'])?>
			    
			    <i class="icon_wallet pull-right"></i>
			</a>
		    </h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse">
			<div class="panel-body">
			    <h3>Shipping Address: </h3>

			    <div class="form-group">
				

				<?php echo $form->field($model, 'first_name')->textInput(['placeholder' => 'First Name']) ?>
				
			    </div>
			    <div class="form-group">
				<?php echo $form->field($model, 'last_name')->textInput(['placeholder' => 'Last Name']) ?>
			    </div>

			    <div class="form-group">
				<?php echo $form->field($model, 'street')->textInput(['placeholder' => 'Your Full Address']) ?>
			    </div>
			    <div class="row">
				<div class="col-md-6 col-sm-6">
				    <div class="form-group">
					<?php echo $form->field($model, 'zipcode')->textInput(['placeholder' => 'Your Postal Code']) ?>
				    </div>
				</div>
				<div class="col-md-6 col-sm-6">
				    <div class="form-group">
					<?php echo $form->field($model, 'city')->textInput(['placeholder' => 'Your City']) ?>
				    </div>
				</div>						
			    </div>


			    <div class="row">
				<div class="col-md-12">
				    
				    <?php echo $form->field($model, 'notevoucher')->textArea(['placeholder' => 'Special request etc ...']) ?>
				    
				</div>
			    </div>
<!--			    <hr>
			    <a class="btn_full" href="cart_2-voucher.html">Submit shipping address</a>-->

			</div>
		</div>
	</div>
</div>
