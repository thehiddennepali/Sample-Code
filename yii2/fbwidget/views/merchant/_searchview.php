<?php 
//print_r($model->attributes);exit;
?>

<div class="strip_list last wow fadeIn" data-wow-delay="0.6s">
    <div class="row">
        <div class="col-md-9 col-sm-9">
            <div class="desc">
                <div class="thumb_strip img-responsive">
                    <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$model->id])?>">
                        
                        <?=  \yii\helpers\Html::img($model->behaviors['imageBehavior']->getImageUrl(),'image') ?>
                    </a>
                </div>
                <div class="rating">
                    <i class="icon_star voted"></i>
                    <i class="icon_star voted"></i><i class="icon_star voted"></i>
                    <i class="icon_star voted"></i><i class="icon_star"></i> 
                    (<small><a href="#0">98 reviews</a></small>)
                </div>
                <h3><a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$model->id])?>"><?php echo $model->service_name;?></a></h3>
                <div class="type">
                    
                    <?php 
                    
                    $sql = 'SELECT chm.category_id, ssc.*,sc.*  from category_has_merchant as chm 
                            LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                            LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
                            WHERE chm.merchant_id='.$model->id.' group by sc.id';
                    
                    $query = Yii::$app->db->createCommand($sql)->queryAll();
                    
                    
                        foreach ($query as $key=>$cat){
                            echo $cat['title'];
                            if((sizeof($query) - 1) > $key)
                                echo ' | ';
                        }
                    ?>
                    
                    
                </div>
                <div class="location">
                    <?php echo $model->address;?> <span class="opening">Täglich von 9 bis 19 Uhr</span>
                </div>
                <ul>
                    
                    
                    <?php if($model->categoryHasMerchants){
                        foreach ($model->categoryHasMerchants as $service){
                        ?>
                    <li><?php echo $service->title;?><i class="icon_check_alt2 ok"></i></li>
                    <?php 
                        }
                        }?>
                    
                </ul>
                <ul>
                    <?php if($model->addons){
                        foreach ($model->addons as $addon){?>
                            <li><?php echo $addon->name?><i class="icon-gift"></i></li>
                        <?php }
                        
                    }?>
                    
                </ul>
                <div class="box_style_3">
                    <p><button class="btn_1" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $model->id?>" aria-expanded="false" aria-controls="collapseExample">
                            Service & Leistungen
                        </button></p>
                    <div class="collapse" id="collapseExample<?php echo $model->id?>">
                        <table class="table table-striped cart-list">
                            <thead>
                                <tr>
                                    <th>
                                        Item
                                    </th>
                                    <th>
                                        Price
                                    </th>
                                    <th>
                                        Termin
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php if($model->categoryHasMerchants){
                                    foreach ($model->categoryHasMerchants as $service){
                                    ?>
                                <tr>
                                    <td>
                                        <h5><?php echo $service->title?></h5>
                                        <p>
                                            <?php echo $service->description;?>
                                        </p>
                                    </td>
                                    <td>
                                        <strong>ab € <?php echo $service->price;?></strong>
                                    </td>
                                    <td class="options">
                                        <a href="#0"><i class="icon_plus_alt2"></i></a>
                                    </td>
                                </tr>
                                
                                <?php }
                                
                                    }else{?>
                                <tr>
                                    <td colspan="3">No item added yet</td>
                                        
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
                    <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$model->id])?>" class="btn_1">Info & Termin buchen</a>
                </div>
            </div>
        </div>
    </div><!-- End row-->
</div><!-- End strip_list-->
