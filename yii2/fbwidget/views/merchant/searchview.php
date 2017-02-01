<?php 



if(count($models) > 0){
$session = Yii::$app->session;   
    
echo "<script type = 'text/javascript'>";
echo "markersData = [];";

if(isset($session['latlang'])){
    echo "var lat = ".$session['latlang']['lat'].";";
    echo "var long = ".$session['latlang']['long'].";";
}
    
    $i=0;
    foreach ($models as $model){
        if(!empty($model['gmap_altitude']) && !empty($model['gmap_latitude'])){
            
            $sql = 'SELECT chm.category_id, ssc.*,sc.*  from category_has_merchant as chm 
                            LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                            LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
                            WHERE chm.merchant_id='.$model['merchant_id'].' group by sc.id';
                    
            $query = Yii::$app->db->createCommand($sql)->queryAll();

                $service = "";
                foreach ($query as $key=>$cat){
                    $service .= $cat['title'];
                    if((sizeof($query) - 1) > $key)
                        $service .= ' / ';
                }
                
                $merchantUrl = preg_replace('/\s+/', '',$model['service_name']);
                $merchantUrl = strtolower($merchantUrl).'-'.$model['merchant_id'];
                
                
                $imageUrl  = \frontend\components\ImageBehavior::getImage($model['merchant_id'], 'merchant');
        echo "markersData[$i] = {
                'name':'".$model['service_name']."',
                'location_latitude' : ".$model['gmap_latitude'].", 
                'location_longitude' : ".$model['gmap_altitude'].",
                'map_image_url': '".$imageUrl."',
                'name_point': '".$model['service_name']."',
                'type_point': '".$service."',
                'description_point': '".$model['address']."<br>',
                'url_point': '".Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$merchantUrl])."'
                };";
        $i++;
        }
    }
    
    echo "
        markersData  = {
        'merchant' : markersData
        };
    ";
    
    echo 'console.log(markersData)';
    echo "</script>";
    
    
    foreach ($models as $model){
        
        
        
        
    ?>

<div class="strip_list last wow fadeIn" data-wow-delay="0.6s">
    <div class="row">
        <div class="col-md-9 col-sm-9">
            <div class="desc">
                <div class="thumb_strip img-responsive">
                    
                    <?php $merchantUrl = preg_replace('/\s+/', '',$model['service_name']);
                    $merchantUrl = strtolower($merchantUrl).'-'.$model['merchant_id'];
                    
                    //print_r($merchantUrl);exit;
                    ?>
                    <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$merchantUrl])?>">
                        
                        <?php 
                            echo \yii\helpers\Html::img(\frontend\components\ImageBehavior::getImage($model['merchant_id'], 'merchant'))
 ?>
                    </a>
                </div>
                <div class="rating">
                    
                    <?php 
                    
                    $queryRating = 0;
                    if($model['merchant_id']){
                        $ratingSql = 'SELECT ceil(AVG(rating)) as totalrating FROM mt_review where merchant_id='.$model['merchant_id'];
                        $queryRating = Yii::$app->db->createCommand($ratingSql)->queryScalar();
                        
                        
                        $ratingCountSql = 'SELECT count(*) as totalrating FROM mt_review where merchant_id='.$model['merchant_id'];
                        $queryRatingCount = Yii::$app->db->createCommand($ratingCountSql)->queryScalar();
                        
                        
                        if($queryRating !=0 ){
                        for($i = 1; $i <= $queryRating ;$i++){
                    ?>
                    <i class="icon_star voted"></i>
                    <?php 
                        }
                        
                        }
                    }?>
                    
                    
                    <?php 
                    $j = 5 - $queryRating;
                    if($j !=0 && $j <= 5){
                        for($k=1; $k<=$j; $k++){?>
                    <i class="icon_star"></i> 
                    <?php }
                    }?>
                    (<small><a href="#0"><?php echo $queryRatingCount;?> <?php echo Yii::t('basicfield', 'reviews')?></a></small>)
                </div>
                <h3><a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$merchantUrl])?>">
                    <?php echo $model['service_name'];?></a></h3>
                <div class="type">
                    
                    <?php 
                    
                    $sql = 'SELECT chm.category_id, ssc.*,sc.*  from category_has_merchant as chm 
                            LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                            LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
                            WHERE chm.merchant_id='.$model['merchant_id'].' group by sc.id';
                    
                    $query = Yii::$app->db->createCommand($sql)->queryAll();
                    
                    
                        foreach ($query as $key=>$cat){
                            echo Yii::t('servicecategory',$cat['title']);
                            if((sizeof($query) - 1) > $key)
                                echo ' | ';
                        }
                    ?>
                    
                    
                </div>
                <div class="location">
                    <?php echo $model['address'];?> 
<!--                    <span class="opening">Täglich von 9 bis 19 Uhr</span>-->
                </div>
                
                <div>
                    <span class="opening"><?php echo Yii::t('basicfield', 'Opening Time')?></span>
                   <?php
                        $sql = 'SELECT * FROM merchant_schedule_history where merchant_id=' . $model['merchant_id'] . ' order by id desc';
                        $squerySchedule = Yii::$app->db->createCommand($sql)->queryOne();

                        $schedule = \frontend\models\MtMerchant::getSchedule($squerySchedule);

                        $days = \frontend\models\MtMerchant::$days;

                        foreach ($schedule as $key => $value) {
                            ?>
                            <?php
                                if (!empty($value)) {?>
                            <li><?php echo Yii::t('basicfield', $days[$key]); ?>

                                <?php 
                                    echo '<span>';
                                    foreach ($value as $sch) {
                                        ?>
                                        <?php echo $sch['time_from']; ?>-<?php echo $sch['time_to']; ?>
                                    <?php
                                    }
                                    echo '</span>';
                                
                                ?>

                            </li>
                            
                                <?php }?>

                    <?php }
                ?>
                    
                </div>
                <ul>
                    
                    
                    <?php 
                    
//                    $sqlCategoryhadMerchant = 'SELECT * FROM category_has_merchant where merchant_id='.$model['merchant_id'];
//                    $queryCathasMerchant = Yii::$app->db->createCommand($sqlCategoryhadMerchant)->queryAll();
//                    
                    $sqlCategoryhadMerchant = 'SELECT chm.category_id, ssc.*, sc.id as catid from category_has_merchant as chm 
                                        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                                        RIGHT JOIN  mt_service_category as sc ON ssc.category_id=sc.id
                                        WHERE chm.merchant_id=' . $model['merchant_id'] . ' group by sc.id';
                                
                    $queryCathasMerchant = Yii::$app->db->createCommand($sqlCategoryhadMerchant)->queryAll();
                    if($queryCathasMerchant){
                        
                        
                        foreach ($queryCathasMerchant as $cat){
                            
                            $sqlCategoryMerchant = 'SELECT chm.category_id, ssc.*, sc.id as catid from category_has_merchant as chm 
                            LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                            RIGHT JOIN  mt_service_category as sc ON ssc.category_id=sc.id
                            WHERE chm.merchant_id=' . $model['merchant_id']. ' and sc.id='.$cat['catid'].' group by ssc.id';

                            $queryCatMerchant = Yii::$app->db->createCommand($sqlCategoryMerchant)->queryAll();
                            foreach($queryCatMerchant as $service){
                        ?>
                    <li><?php echo Yii::t('servicesubcategory',$service['title']);?><i class="icon_check_alt2 ok"></i></li>
                    <?php 
                        }
                        }
                        }?>
                    
                </ul>
                
                <?php 
                $voucher = 'SELECT * FROM mt_voucher WHERE merchant_id='.$model['merchant_id'];
                $queryVoucher = Yii::$app->db->createCommand($voucher)->queryAll();
                
                
                
                $loyality = 'SELECT * FROM loyalty_points WHERE merchant_id='.$model['merchant_id'];
                $queryLoyality = Yii::$app->db->createCommand($loyality)->queryOne();
                
                
                if(!empty($queryVoucher) || (!empty($queryLoyality) && $queryLoyality[0]['is_active'] == 1)){
                    
                    
                    //print_r($queryVoucher);
                ?>
                <i class="icon-heart"></i> 
                <?php echo Yii::t('basicfield','Loyalty Points');?> 
                <span  class="label label-success">
                    <i class="icon_check_alt2 ok"></i> </span>
<!--                <ul>
                    <?php /*
                    $sqlAddons = 'SELECT name FROM addon where merchant_id='.$model['merchant_id'];
                    $queryAddon = Yii::$app->db->createCommand($sqlAddons)->queryAll();
                    
                    if($queryVoucher){
                        foreach ($queryVoucher as $voucher){?>
                            <li><?php echo $voucher['voucher_name']?><i class="icon-gift"></i></li>
                        <?php }
                        
                    }*/?>
                    
                </ul>-->
                <i class="icon-euro"></i> 
                <?php echo Yii::t('basicfield','Coupon');?>  
                <span  class="label label-success"><i class="icon_check_alt2 ok"></i> </span>
<!--                <span class='opening'>Loyality Points</span>
                <ul>
                    
                    <li>Count On Order  : <?php echo $queryLoyality['count_on_order']?></li>
                    <li>Count On Like  : <?php echo $queryLoyality['count_on_like]']?></li>
                    <li>Count On Comment  : <?php echo $queryLoyality['count_on_comment']?></li>
                    <li>Count On Rate  : <?php echo $queryLoyality['count_on_rate']?></li>
                </ul>-->
                <?php }?>
                <div class="box_style_3">
                    <p><button class="btn_1" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $model['merchant_id']?>" aria-expanded="false" aria-controls="collapseExample">
                            <?php echo Yii::t('basicfield', 'Services & Treatments')?>
                        </button></p>
                    <div class="collapse" id="collapseExample<?php echo $model['merchant_id']?>">
                        <table class="table table-striped cart-list">
                            <thead>
                                <tr>
                                    <th>
                                        <?php echo Yii::t('basicfield', 'Item')?>
                                    </th>
                                    <th>
                                        <?php echo Yii::t('basicfield', 'Price')?>
                                    </th>
                                    <th>
                                        <?php echo Yii::t('basicfield', 'Termin')?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php if($queryCathasMerchant){
                                    foreach ($queryCathasMerchant as $cat){
                                        
                                        $sqlCategoryMerchant = 'SELECT chm.category_id, chm.price, ssc.*, sc.id as catid from category_has_merchant as chm 
                                        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                                        RIGHT JOIN  mt_service_category as sc ON ssc.category_id=sc.id
                                        WHERE chm.merchant_id=' . $model['merchant_id']. ' and sc.id='.$cat['catid'].' group by ssc.id';

                                        $queryCatMerchant = Yii::$app->db->createCommand($sqlCategoryMerchant)->queryAll();
                                        foreach($queryCatMerchant as $service){
                                            
                                    ?>
                                <tr>
                                    <td>
                                        <h5><?php echo Yii::t('servicesubcategory', $service['title'])?></h5>
                                        <p>
                                            <?php echo Yii::t('servicesubcategory', $service['description']);?>
                                        </p>
                                    </td>
                                    <td>
                                        <strong>ab € <?php echo (isset($service['price']))?$service['price'] : 0;?></strong>
                                    </td>
                                    <td class="options">
                                        <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$merchantUrl])?>"><i class="icon_plus_alt2"></i></a>
                                    </td>
                                </tr>
                                
                                <?php }
                                    }
                                    }else{?>
                                <tr>
                                    <td colspan="3"><?php echo Yii::t('basicfield', 'No item added yet')?></td>
                                        
                                </tr>
                                
                                    <?php }?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <div class="go_to">
                <div>
                    <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$merchantUrl])?>" class="btn_1">
                        <?php echo Yii::t('basicfield', 'More Info & Appointment booking')?>
                        
                    </a>
                </div>
            </div>
        </div>
    </div><!-- End row-->
</div><!-- End strip_list-->

<?php 
    }
    
}else{
    echo Yii::t('basicfield','No result found.');
}
?>
