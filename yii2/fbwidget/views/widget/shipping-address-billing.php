<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
		    <h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
			    <input type="radio" value="1" name="AddToCart[deliveryOption]" class="icheck delivery-option">
			    <?php echo Yii::t('basicfield', 'Delivered to billing address')?>
			    <?php //echo $form->field($addToCart, 'deliveryOption')->radio(['class' => 'icheck delivery-option','value'=> 3, 'label' => 'Delivered to shipping address'])?>
			    
			    <i class="icon_wallet pull-right"></i>
			</a>
		    </h4>
		</div>
	    
		<?php 
		$addressBook = frontend\models\MtAddressBook::findOne(['client_id' => Yii::$app->user->id, 'as_default' => 1]);
		if(!$addressBook || empty($addressBook->first_name)){
		?>
		<div id="collapseTwo" class="panel-collapse collapse">
			<div class="panel-body">
			    <h3><?php echo Yii::t('basicfield', 'Billing Address:') ?> </h3>

			    <div class="form-group">
				

				<?php echo $form->field($model, 'first_name')->textInput(['placeholder' => Yii::t('basicfield', 'First Name')]) ?>
				
			    </div>
			    <div class="form-group">
				<?php echo $form->field($model, 'last_name')->textInput(['placeholder' => Yii::t('basicfield','Last Name')]) ?>
			    </div>

			    <div class="form-group">
				<?php echo $form->field($model, 'street')->textInput(['placeholder' => Yii::t('basicfield','Your Full Address')]) ?>
			    </div>
			    <div class="row">
				<div class="col-md-6 col-sm-6">
				    <div class="form-group">
					<?php echo $form->field($model, 'zipcode')->textInput(['placeholder' => Yii::t('basicfield','Your Postal Code')]) ?>
				    </div>
				</div>
				<div class="col-md-6 col-sm-6">
				    <div class="form-group">
					<?php echo $form->field($model, 'city')->textInput(['placeholder' => Yii::t('basicfield','Your City')]) ?>
				    </div>
				</div>						
			    </div>


			    <div class="row">
				<div class="col-md-12">
				    
				    <?php echo $form->field($model, 'notevoucher')->textArea(['placeholder' => Yii::t('basicfield','Special request etc ...')]) ?>
				    
				</div>
			    </div>
<!--			    <hr>
			    <a class="btn_full" href="cart_2-voucher.html">Submit shipping address</a>-->

			</div>
		</div>
	    
		<?php }?>
	</div>
</div>
