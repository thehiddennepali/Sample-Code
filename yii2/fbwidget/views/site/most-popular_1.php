<?php 
use frontend\models\CategoryHasMerchant;
use yii\helpers\Html;
?>  



<div class="main_title">
            <h2 class="nomargin_top">Choose from Most Popular</h2>
            <p>
                Cum doctus civibus efficiantur in imperdiet deterruisset.
            </p>
        </div>
        
        <div class="row">
            
            <?php $services = CategoryHasMerchant::find()->orderBy('id desc')->limit(6)->all();
                $i=1;foreach ($services as $data){
            ?>
            
            <?php if($i == 1){?>
            <div class="col-md-6">
            <?php }
            
            
            ?>
               
                <a href="detail_page_2.html" class="strip_list">
                <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip  img-responsive">
<!--                            <img src="img/beauty1.jpg" alt="">-->
                            
                            <?php 
                            
                            echo  Html::img($data->behaviors['imageBehavior']->getImageUrl()) ?>
                        </div>
                        <div class="rating">
                            <i class="icon_star voted"></i>
                            <i class="icon_star voted"></i>
                            <i class="icon_star voted"></i>
                            <i class="icon_star voted"></i>
                            <i class="icon_star"></i>
                        </div>
                        <h3><?php echo $data->title?></h3>
                        <div class="type">
                            <?php echo $data->category->category->title.' | '.$data->category->title.' | '.$data->category->title?>  
                        </div>
                        <div class="location">
                            <?php echo $data->merchant->address?> <span class="opening">Täglich von 9:00 Uhr</span>
                        </div>
                        <ul>
                            <li>Haarentfernung<i class="icon_check_alt2 ok"></i></li>
                            <li>Maniküre<i class="icon_check_alt2 ok"></i></li>
                        </ul>
                    </div><!-- End desc-->
                </a><!-- End strip_list-->
               
                
            <?php if( $i % 3 == 0){?>    
            </div><!-- End col-md-6-->
            <div class="col-md-6">
            
                <?php 
            }
            $i++;
            }?>
        </div><!-- End row -->   
        