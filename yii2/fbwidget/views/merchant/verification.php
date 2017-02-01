<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_short.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
        <div id="sub_content">
            <h1><?php echo Yii::t('basicfield', 'Merchant Signup')?></h1>
            <p><?php echo Yii::t('basicfield', 'step')?> 4 of 4</p>
        </div><!-- End sub_content -->
    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

<div id="position">
    <div class="sections section-grey2 section-orangeform ">

        <div class="container">     
            <div class="inner">        

                <div class="text-center bottom10">
                    <i class="ion-ios-checkmark-outline i-big-extra green-text"></i>
                </div>

                <h1><?php echo Yii::t('basicfield', 'Congratulation for signing up.!')?></h1>
                <div class="box-grey rounded">	  
                    <p class="text-center top15">           
                        <?php echo Yii::t('basicfield', 'Please check your email for bank deposit instructions  You will receive email once your merchant has been approved. Thank You.')?>	           
<!--                    <div class="top15">
                        <p class="text-center">           
                        <p><?php echo Yii::t('basicfield', 'You will receive email once your merchant has been approved. Thank You.')?>
                            </p>
                    </div>-->

                    <a href="<?php echo Yii::$app->homeUrl; ?>" 
                       class="top25 green-text block text-center"><i class="ion-ios-arrow-thin-left"></i> <?php echo Yii::t('basicfield', 'back to homepage')?></a>
                </div> <!--box-->        
            </div> <!--inner-->
        </div> <!--container--> 

    </div>
</div><!-- Position -->
