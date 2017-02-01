<?php
$i=0;foreach ($subcategories as $subCat) {
   
    ?>
    <li>
        <label>
            <input type="checkbox" class="icheck search subcat" name="SearchMtMerchant[subcategory][<?php echo $i;?>]" value="<?php echo $subCat['id']?>">
            <?php echo Yii::t('servicesubcategory', $subCat['title']) ;?>
        </label>
    </li>
<?php $i++;

} ?>

