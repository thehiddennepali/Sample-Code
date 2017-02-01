<h3>
    <?php echo Yii::t('basicfield', 'Your Order')?>
     <i class="icon_cart pull-right"></i></h3>
<?php echo $this->renderAjax('/order/voucher-cart');
$session = Yii::$app->session;

$merchantid = $session['merchant_id'];


if (isset($merchantid)) {
	$merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantid]);
	
	
	$merchantUrl = preg_replace('/\s+/', '', $merchant->service_name);
	$merchantUrl = strtolower($merchantUrl) . '-' . $merchant->merchant_id;

}
		?>


<hr>					
<table class="table table_summary">
	<tbody>
	    <tr>
		<td>
		    <?php echo Yii::t('basicfield', 'Subtotal')?>
		     <span class="pull-right">€ 
			<span id="voucher-subtotal">
			<?php echo \frontend\components\UrlHelper::numberFormat($session['voucher-subtotal'])?>
			</span>
		    </span>
		</td>
	    </tr>

	    <tr>
		<td class="total">
		    <?php echo Yii::t('basicfield', 'TOTAL')?>
		     <span class="pull-right">€ 
			<span id="voucher-total">
			<?php echo \frontend\components\UrlHelper::numberFormat($session['voucher-total'])?>
			</span>
		    </span>
		</td>
	    </tr>
	</tbody>
</table>
<a class="btn_full" href="javascript:void(0)" id="checkout">
    <?php echo Yii::t('basicfield', 'Proceed to checkout')?>
    </a>
<a class="btn_full_outline" href="<?php echo Yii::$app->urlManager->createUrl(['widget/gift-voucher', 'id' => $merchant->id]) ?>">
    <i class="icon-right"></i> Cancel order - back to <?php echo $merchant->service_name?></a>


<?php 

$url = Yii::$app->urlManager->createUrl('widget/voucher');

$js = <<<SCRIPT

	$('#checkout').on('click', function(){
        console.log($('#checkout-form'));
        $('body .help-block').remove();
        $.ajax({
            type : 'post',
            url : '$url',
            data : $('#checkout-form').serialize(),
            dataType : 'json',
            success : function(response){
            
                if(response.success == true){
                    window.location.href = response.data;

                }else{
                    $.each(response.data, function(key, val) {
                        console.log(key);
                        $('#client-'+key).after('<div class=\"help-block\">'+val+'</div>');
                        $('#client-'+key).closest('.form-group').addClass('has-error');
                    });
                }
            }
        
            })
    })
    
SCRIPT;

$this->registerJs($js);

?>