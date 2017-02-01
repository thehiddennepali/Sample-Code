<?php 

$this->title = Yii::t('seo', $seo->title);
?>

<!-- SubHeader =============================================== -->
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_short.jpg" data-natural-width="1600" data-natural-height="850">
        <div id="subheader">
            <div id="sub_content">
             <h1><?php echo Yii::t('basicfield', 'Merchant Signup')?></h1>
	<p><?php echo Yii::t('basicfield', 'step')?> 1 of 4</p>
            </div><!-- End sub_content -->
        </div><!-- End subheader -->
    </section><!-- End section -->
    <!-- End SubHeader ============================================ -->

    <div id="position">
        <div class="container">
  <div class="container">
      <div class="row">
          
          <?php echo $this->render('sub_header')?>
      
        
        
      </div>
  </div> <!--container-->
        </div>
    </div><!-- Position -->


<!-- Content ================================================== -->
<div class="container margin_60_35">
    <div class="row">
        <?php $packages = \frontend\models\MtPackages::find()->where(['status' => 1])->all();
        
        foreach ($packages as $data){?>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">

            <!-- PRICE ITEM -->
            <div class="panel price panel-white">
                <div class="panel-heading arrow_box text-center">
                    <h3><?php echo $data->title;?></h3>
                </div>
                <div class="panel-body text-center">
                    <p class="lead" style="font-size:40px"><strong>€ <?php 
                    echo (!empty($data->promo_price)) ? $data->promo_price : $data->price;?>,-- / <?php echo Yii::t('basicfield', 'mth.')?></strong></p>
                </div> 
                <ul class="list-group list-group-flush text-center">
                    <li class="list-group-item"><i class="icon-ok text-success"></i> 
                        <?php echo $data->workers_limit;?> <?php echo Yii::t('basicfield', 'Staff')?></li>
                    <li class="list-group-item">
                        <i class="icon-ok text-success"></i>
                         <?php echo Yii::t('basicfield', 'Unlimited Services & Treatments')?>
                    </li>
                    <li class="list-group-item">
                        <i class="icon-ok text-success"></i> 
                            <?php echo Yii::t('basicfield', '10% Commission on appointments made via aondego portal')?>
                        
                    </li>
                    <li class="list-group-item">
                        <i class="icon-ok text-success"></i> 
                            <?php echo Yii::t('basicfield', 'No Commission on appointments via the own website')?>
                        
                    </li>						
                </ul>
                <div class="panel-footer">
                    <a class="btn btn-lg btn-block btn-default" href="<?php echo Yii::$app->urlManager->createUrl(['merchant/create', 'packageid'=>$data->package_id])?>">
                        <?php echo Yii::t('basicfield', 'SIGN UP NOW!')?></a>
                </div>
            </div>
            <!-- /PRICE ITEM -->


        </div>
        
        <?php }?>

  
    </div>


</div><!-- End container -->
<!-- End Content =============================================== -->
