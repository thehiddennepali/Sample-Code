<?php
$session = Yii::$app->session;
$keyword = $session['keyword'];
$merchantid = $session['merchant_id'];

if (isset($merchantid)) {
    $merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantid]);
    
    $currencyCode = common\components\Helper::getCurrencyCode($merchant);
    
}?>
<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <div class="box_style_2">
            <h2 class="inner">
                <?php echo Yii::t('basicfield', 'Appointment confirmed!') ?>
                </h2>
            <div id="confirm">
                <i class="icon_check_alt2"></i>
                <h3><?php echo Yii::t('basicfield', 'Thank you!') ?></h3>
                <p>
                    <?php echo Yii::t('basicfield', 'For your appointment booking. Here is the summary of your appointment.')?>
                </p>
            </div>

            <h3><?php echo Yii::t('basicfield', 'Your booking') ?> <i class="icon_calendar pull-right"></i></h3>

            <hr>					
            <h4><?php echo Yii::t('basicfield', 'Services & Treatments') ?>
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
                            <?php echo Yii::t('basicfield', 'Subtotal') ?> 
                        </td>
                        <td>
                            <strong class="pull-right">
				<?php echo $currencyCode;?>
				    <?php echo number_format($subtotal, 2, '.', ''); ?></strong>
                        </td>
                    </tr>

                    <?php if (!empty($discount)) { ?>
                        <tr>
                            <td>
                                <?php echo Yii::t('basicfield', 'Coupon') ?>  <?php echo $couponPer; ?>
                            </td>
                            <td>
                                <strong class="pull-right"><?php echo $currencyCode;?>
				 <?php echo number_format($discount, 2, '.', ''); ?></strong>
                            </td>
                        </tr>

                    <?php } ?>
                    <tr>
                        <td class="total_confirm">
                            <?php echo Yii::t('basicfield', 'TOTAL') ?> 
                        </td>
                        <td class="total_confirm">
                            <span class="pull-right">
				<?php echo $currencyCode;?>
				    <?php echo number_format($total, 2, '.', ''); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>

                            <?php
                            $loyality = \frontend\models\Option::getValByName('website_loyalty_points');
                            $loyalityPoints = $total * $loyality;
                            ?>
                            <?php echo Yii::t('basicfield', 'Loyalty Points') ?> 
<!--                                <a href="#" class="tooltip-1" data-placement="top" title="" data-original-title=""><i class="icon_question_alt"></i></a>-->
<?php echo Yii::t('basicfield', 'For this appointment you receive {count} Loyalty Points', ['count' => $loyalityPoints]) ?> 

                        </td>
                    </tr>
                </tbody>
            </table>

            <hr class="styled">
            <div class="row">
                <div class="col-md-6 col-sm-3 col-xs-3">

                    <p><a href="#" alt="aondego terminverwaltung einfach gemacht"><img class="img-responsive" src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/logo-sign-800-bg.png" alt="aondego appointment management" border="0" /></a></p>
                </div>
                <div class="col-md-6 col-sm-3 col-xs-3">

                    <p><img class="img-responsive" src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/ssl.png" alt="aondego appointment management" border="0" /></p>
                </div>
            </div>
        </div>
    </div>
</div><!-- End row -->
