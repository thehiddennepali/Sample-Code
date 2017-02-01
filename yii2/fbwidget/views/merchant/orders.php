<?php 
$price = 0;
if($orders){
    
foreach ($orders as $cat=>$order){
    
    foreach ($order as $key=>$value){
        $price += floatval($value['price']);
?>
<tr>
    <td>
        
        <?php if(Yii::$app->controller->id != 'checkout'){?>
        <a href="#0" class="remove_item add-to-cart"  data-id=<?php echo $cat?> data-key=<?php echo $key;?>>
            <i class="icon-edit"></i>
        </a> 
        <a href="#0" class="remove_item remove"  data-catid=<?php echo $cat?> data-key=<?php echo $key;?>>
            <i class="icon_minus_alt"></i>
        </a> 
        
        <?php }?>
        <strong><?php echo $value['qty']?>x</strong> 
        <?php echo '<b>'.$value['title'].'</b>';
        $time = $value['time_in_minutes'];
        ?>
        <p><b><?php echo Yii::t('basicfield', 'Date / Time')?> : </b><?php echo $value['order_date'] .' / ';
//        echo '<pre>';
//        print_r($value);
//        echo '</pre>';
        echo ($value['is_group'] == 1) ? $value['time_req'] : $value['free_time_list'];
        ?></p>
        <p><b><?php echo Yii::t('basicfield', 'Staff')?> : </b><?php echo frontend\models\Staff::findOne(['id'=>$value['staff_id']])->name;?></p>
        <p><b><?php echo Yii::t('basicfield', 'Duration')?> :</b> <?php echo $time;?> Min</p>
        <?php 
        
        $priceInd = floatval($value['price']);
        if(isset($value['addons_list'])){?>
        
        <p><b><?php echo Yii::t('basicfield', 'Extras')?></b></p>
        
        <?php foreach ($value['addons_list'] as $addons){
            
            $addon = \frontend\models\Addons::findOne(['id' => $addons]);
            
            ?>
        <p><?php echo $addon->name.' &nbsp '.$addon->time_in_minutes.' Min / €'.number_format($addon->price, 2, '.', '');?></p>
        <?php 
        $price += floatval($addon->price);
        $time += $addon->time_in_minutes;
        $priceInd += floatval($addon->price);
        }
        }?>
        <p><b><?php echo Yii::t('basicfield', 'Total Duration')?> : </b><?php echo $time;?> Min</p>
        
        
        
    </td>
    <td>
        <strong class="pull-right"><?php echo $value['currency']?>
		<?php echo number_format($value['price'], 2, '.', '');?></strong>
    </td>
</tr>
<?php }
}
}
$session = Yii::$app->session;
$session['subtotal'] = $price;
$session['total'] = $price;

?>


<?php 
$this->registerJs("
    $('.remove').on('click', function(event){
        event.preventDefault();
        
        var catid = $(this).data('catid');
        var key = $(this).data('key');
        
        var confirmdelete = confirm('Are you sure?');
        if(confirmdelete == true){
            $.ajax({
                type : 'post',
                url : '".Yii::$app->urlManager->createUrl('merchant/delete-order')."',
                data : {catid : catid , key : key},
                dataType : 'json',
                success : function(response){
                    console.log('response')
                    $('#orders').html(response.data);
                    $('#subtotal').html(response.subtotal);
                    $('#total').html(response.total);
                    $('#couponper').html(response.couponPer);
                    $('#discount').html(response.discount);
                    $('#appointment-coupone').val('');
                    $('#appointment-apply_coupon').iCheck('uncheck');
                
                }
        
            })
        }
        
        });
        ");

?>

