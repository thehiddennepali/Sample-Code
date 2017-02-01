<?php
$session = Yii::$app->session;
?>


<?php foreach ($session['creditcard'] as $key=>$value){?>

<tr>
    <td><?php echo $value['credit_card_number']?></td>
    <td>
        <input class="cc_id" type="radio" value="<?php echo $key?>" name="cc_id">
    </td>
</tr>
<?php } ?>


