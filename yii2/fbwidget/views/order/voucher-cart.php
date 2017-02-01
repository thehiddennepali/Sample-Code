<?php 

$session = Yii::$app->session;

$total = 0;
$subtotal = 0;

?>

<table class="table table_summary">
    <tbody>
	
	<?php if(!empty($session['Vouchercart'])){
		
		
		
	 foreach ($session['Vouchercart'] as $key=>$value){
		$subtotal += $value['price'];
		$total += $value['price'];
		?>
	
	<tr>
	    <td>
		
		<?php if(Yii::$app->controller->action->id == 'gift-voucher' || Yii::$app->controller->action->id == 'voucher-cart'){?>
		<a href="javascript:void(0)" class="remove_item remove" data-voucherid="<?php echo $key?>">
		    <i class="icon_minus_alt"></i>
		</a> 
		<?php }?>
		<strong><?php echo $value['qty'];?>x</strong> <?php echo $value['title']?> Value 
		<?php echo $value['currency'];?> 
			
			<?php echo \frontend\components\UrlHelper::numberFormat($value['price']);?>
	    </td>
	    <td>
		<strong class="pull-right">
		    <?php echo $value['currency'];?> 
			
			<?php echo \frontend\components\UrlHelper::numberFormat($value['price']);?></strong>
	    </td>
	</tr>
	
	
	<?php 
	}
	
	
	}else{?>
	<tr>
	    <td><?php echo Yii::t('basicfield', 'Cart is empty')?></td>
	</tr>
	
	<?php }
	
	$session = Yii::$app->session;
	$session['voucher-subtotal'] = $subtotal;
	$session['voucher-total'] = $total;
	?>


	
	
    </tbody>
</table>
