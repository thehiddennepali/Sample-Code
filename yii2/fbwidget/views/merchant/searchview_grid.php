<?php $i = 1;
foreach ($models as $model) {
    if ($i == 1) {
        ?>       	

        <div class="row">
    <?php } ?>
        <div class="col-md-6 col-sm-6 wow zoomIn" data-wow-delay="0.1s">
            <a class="strip_list grid" href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$model['merchant_id']])?>">
                <div class="ribbon_1">Popular</div>
                <div class="desc">
                    <div class="thumb_strip responsive">
                        <?php echo \yii\helpers\Html::img(\frontend\components\ImageBehavior::getImage($model['merchant_id'], 'merchant'))?>
                    </div>
                    <div class="rating">
                        <i class="icon_star voted"></i>
                        <i class="icon_star voted"></i>
                        <i class="icon_star voted"></i>
                        <i class="icon_star voted"></i>
                        <i class="icon_star"></i>
                    </div>
                    <h3><?php echo $model['service_name'];?></h3>
                    <div class="type">
                        <?php 
                    
                    $sql = 'SELECT chm.category_id, ssc.*,sc.*  from category_has_merchant as chm 
                            LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                            LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
                            WHERE chm.merchant_id='.$model['merchant_id'].' group by sc.id';
                    
                    $query = Yii::$app->db->createCommand($sql)->queryAll();
                    
                    
                        foreach ($query as $key=>$cat){
                            echo $cat['title'];
                            if((sizeof($query) - 1) > $key)
                                echo ' | ';
                        }
                    ?>
                    </div>
                    <div class="location">
                        <?php echo $model['address'];?><br><span class="opening">Täglich von 9 bis 19 Uhr</span>
                    </div>
                    <ul>
                        <?php 
                    
                    $sqlCategoryhadMerchant = 'SELECT * FROM category_has_merchant where merchant_id='.$model['merchant_id'];
                    $queryCathasMerchant = Yii::$app->db->createCommand($sqlCategoryhadMerchant)->queryAll();
                    
                    if($queryCathasMerchant){
                        foreach ($queryCathasMerchant as $service){
                        ?>
                    <li><?php echo $service['title'];?><i class="icon_check_alt2 ok"></i></li>
                    <?php 
                        }
                        }?>
                    </ul>
                    
                    <?php 
                $voucher = 'SELECT count(*) FROM mt_voucher WHERE merchant_id='.$model['merchant_id'];
                $queryVoucher = Yii::$app->db->createCommand($voucher)->queryScalar();
                
                
                
                $loyality = 'SELECT * FROM loyalty_points WHERE merchant_id='.$model['merchant_id'];
                $queryLoyality = Yii::$app->db->createCommand($loyality)->queryOne();
                
                
                if(!empty($queryVoucher) || (!empty($queryLoyality) && $queryVoucher[0]['is_active'] == 1)){?>
                    <ul>
                         <?php 
                         
                         
                    $sqlAddons = 'SELECT name FROM addon where merchant_id='.$model['merchant_id'];
                    $queryAddon = Yii::$app->db->createCommand($sqlAddons)->queryAll();
                    
                    if($queryAddon){
                        foreach ($queryAddon as $addon){?>
                            <li><?php echo $addon['name']?><i class="icon-gift"></i></li>
                        <?php }
                        
                    }?>

                    </ul>
                    
                <?php }?>
                </div>
            </a><!-- End strip_list-->
        </div><!-- End col-md-6-->


        <?php if ($i % 2 == 0) { ?>    
        </div><!-- End row-->
        <div class="row">
        <?php } ?>

        <?php
        $i++;
    }
    ?>
            
