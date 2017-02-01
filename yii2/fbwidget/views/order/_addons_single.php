<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 07-Jun-16
 * Time: 21:45
 * @var Addon[] $addons
 */
?>
<div class="col-md-12">
<?php

$i=0;foreach($addons as  $val){
    
    $selected = (isset($selectedaddons) && $selectedaddons[$i]['id'] == $val->id ) ? "checked='checked'" : "";
    echo '<label ><input placeholder="Checkboxes" '.$selected.' class="single-checkbox-class" id="SingleOrder_addons_list_'.$val->id.'" value="'.$val->id.'" type="checkbox" data-price = "'.$val->price.'" data-time = "'.$val->time_in_minutes.'" name="AddToCart[addons_list]['.$i.']">'.$val->nameWithPriceAndTime.'</label>';
    $i++;
}?>
</div>

<?php 

$this->registerJs("$('.single-checkbox-class').on('change',function(){
    console.log('idsfd ')
    if(this.checked) {
        console.log(parseInt($('#find-min-val').val())+parseInt($(this).attr('data-time')));
        console.log(parseFloat($(this).attr('data-price')));
        $('.single-price').html(parseFloat($('.single-price').html())+parseFloat($(this).attr('data-price')))
        $('#find-min-val').val(parseInt($('#find-min-val').val())+parseInt($(this).attr('data-time')))
        $('.time-in-min').html(parseInt($('.time-in-min').html())+parseInt($(this).attr('data-time')))
    }else{
        $('.single-price').html(parseFloat($('.single-price').html())-parseFloat($(this).attr('data-price')))
        $('#find-min-val').val(parseInt($('#find-min-val').val())-parseInt($(this).attr('data-time')))
        $('.time-in-min').html(parseInt($('.time-in-min').html())-parseInt($(this).attr('data-time')))
    }
});")
?>