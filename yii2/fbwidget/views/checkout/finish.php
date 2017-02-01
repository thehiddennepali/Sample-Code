<?php 
$session = Yii::$app->session;
$keyword = $session['keyword'];
$merchantid = $session['merchant_id'];

if(isset($merchantid)){
    $merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantid]);
    
    $merchantUrl = preg_replace('/\s+/', '', $merchant->service_name);
    $merchantUrl = strtolower($merchantUrl) . '-' . $merchant->merchant_id;
}
?>

<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_cart.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">

        <?php echo $this->render('sub_header'); ?>

    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

<div id="position">
    <div class="container">
        <ul>
            <li><a href="<?php echo Yii::$app->homeUrl;?>">
                    <?php echo Yii::t('basicfield','Home')?></a></li>
                <li><a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/search','Merchant[search]' => $keyword])?>">Search</a></li>
                <li>
                    <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/view', 'id'=> $merchantUrl])?>">
                    <?php echo $merchant->service_name;?>
                    </a>
                </li>
                <li><?php echo Yii::t('basicfield','Finish')?></li>
        </ul>
    </div>
</div><!-- Position -->

<!-- Content ================================================== -->
<div class="container margin_60_35">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="box_style_2">
                <h2 class="inner">
                    <?php echo Yii::t('basicfield', 'Appointment confirmed!')?>
                    </h2>
                <div id="confirm">
                    <i class="icon_check_alt2"></i>
                    <h3><?php echo Yii::t('basicfield','Thank you!')?></h3>
                    <p>
                        <?php echo Yii::t('basicfield', 'For your appointment booking. Here is the summary of your appointment.')?>
                        
                    </p>
                </div>

                <h3><?php echo Yii::t('basicfield', 'Your booking')?> <i class="icon_calendar pull-right"></i></h3>

                <hr>					
                <h4><?php echo Yii::t('basicfield', 'Services & Treatments')?>
                    </h4>
                <hr>
                <table class="table table_summary">
                    <tbody>

                        <?php echo $this->render('/merchant/orders', ['orders' => $orders]); ?>

                        <tr>
                            <td>
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo Yii::t('basicfield','Subtotal')?> 
                            </td>
                            <td>
                                <strong class="pull-right">€ <?php echo number_format($subtotal, 2, '.', '');?></strong>
                            </td>
                        </tr>
                        
                        <?php if(!empty($discount)){?>
                        <tr>
                            <td>
                                <?php echo Yii::t('basicfield','Coupon')?>  <?php echo $couponPer;?>
                            </td>
                            <td>
                                <strong class="pull-right">€ <?php echo number_format($discount, 2, '.', '');?></strong>
                            </td>
                        </tr>
                        
                        <?php }?>
                        <tr>
                            <td class="total_confirm">
                                <?php echo Yii::t('basicfield','TOTAL')?> 
                            </td>
                            <td class="total_confirm">
                                <span class="pull-right">€ <?php echo number_format($total, 2, '.', '');?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                
                                <?php $loyality = \frontend\models\Option::getValByName('website_loyalty_points');
                                    $loyalityPoints = $total  * $loyality;
                                ?>
                                <?php echo Yii::t('basicfield','Loyalty Points')?> 
<!--                                <a href="#" class="tooltip-1" data-placement="top" title="" data-original-title=""><i class="icon_question_alt"></i></a>-->
                                <?php echo Yii::t('basicfield','For this appointment you receive {count} Loyalty Points', ['count'=> $loyalityPoints])?> 
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->