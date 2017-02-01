<?php

use frontend\models\CategoryHasMerchant;
use yii\helpers\Html;
?>  



<div class="main_title">
    <h2 class="nomargin_top">
        <?php echo Yii::t('basicfield', "Choose from Categories")?></h2>
    <p>
        <?php echo Yii::t('basicfield', 'Just click on the category your are interested in')?>
        
    </p>
</div>

<div class="row">

    <?php
    $category = \frontend\models\MtServiceCategory::find()->where(['is_active' => 1])->orderBy('id desc')->all();
    $i = 1;
    foreach ($category as $data) {
        ?>

            <?php if ($i == 1) { ?>
            <div class="col-md-6">
            <?php }
            ?>

            <a data-toggle="modal" data-target="#category" href="#" class="strip_list category"  data-catid="<?php echo $data->id?>">
<!--                <div class="ribbon_1">Popular</div>-->
                <div class="desc">
                    <div class="thumb_strip  img-responsive">
    <!--                            <img src="img/beauty1.jpg" alt="">-->

                        <?php echo Html::img($data->behaviors['imageBehavior']->getImageUrl()) ?>
                    </div>

                    <h3><?php echo Yii::t('servicecategory', $data->title) ?></h3>

                    <div class="location">
                        <?php echo Yii::t('servicecategory', $data->description); ?>
                    </div>

                </div><!-- End desc-->
            </a><!-- End strip_list-->


            <?php if ($i % 3 == 0) { ?>    
            </div><!-- End col-md-6-->
            <div class="col-md-6">

                <?php
            }
            $i++;
        }
        ?>
    </div><!-- End row -->  
    
    
    
    <!-- Extras Modal -->
<div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-popup">
            
            <form method="post" action="<?php echo Yii::$app->urlManager->createUrl('merchant/refine-search')?>" name="review" id="review" class="popup-form">  
                <div id="custom-search-input">
                    <div class="input-group ">
                        <input type="text" class=" search-query" placeholder="<?php echo Yii::t('basicfield', 'Postal code / City')?>" id="search" name="SearchMtMerchant[keyword]" required>
                        <span class="input-group-btn">
                            <input type="submit" class="btn_search" value="submit">
                        </span>
                    </div>
                </div>
                
                <input id="categoryid" class="form-control form-white" type="hidden"  autofocus="" name="SearchMtMerchant[category][0]">	
                
            </form>
            
        </div>
    </div>
</div><!-- End modal -->


<?php 
$this->registerJs('
    $(".category").on("click", function(){
        var catid = $(this).data("catid");
        console.log(catid);
        $("#categoryid").val(catid);
    
        })');
?>
