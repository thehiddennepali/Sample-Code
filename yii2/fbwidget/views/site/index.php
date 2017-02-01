<?php 
$this->title = Yii::t('seo', $seo->title);
?>
<meta itemprop="name" content="<?php echo $seo->title?>">

<p itemprop="description" style="display: none"><?php echo $seo->meta_description;?></p>
<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" style="display: none">
  <span itemprop="ratingValue">5</span> stars -
  <span itemprop="reviewCount">5</span> reviews
</div>

<?php //echo Yii::$app->urlManager->baseUrl;exit;?>

<!-- SubHeader =============================================== -->
<section class="parallax-window" id="home" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_home.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">

        <?php echo $this->render('/layouts/includes/search') ?>

    </div><!-- End subheader -->
    <!--    <div id="count" class="hidden-xs">
            <ul>
                <li><span class="number"><?php echo frontend\models\MtMerchant::find()->count(); ?>
                    </span> Geschäfte</li>
                <li><span class="number">55350</span> Terminbuchungen</li>
                <li><span class="number"><?php echo frontend\models\Client::find()->count(); ?></span> Registrierte Benutzer</li>
            </ul>
        </div>-->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

<!-- Content ================================================== -->
<div class="container margin_60">

    <div class="main_title">
        <h2 class="nomargin_top" style="padding-top:0">
            <?php echo Yii::t('basicfield', 'Its as simple as this') ?>

        </h2>
        <p>
            <?php echo Yii::t('basicfield', 'In 4 Steps to your appointment') ?>

        </p>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="box_home" id="one">
                <span>1</span>
                <h3><?php echo Yii::t('basicfield', 'Search by address') ?></h3>
                <p>
                    <?php echo Yii::t('basicfield', 'Find all businesses available in your zone.') ?>
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box_home" id="two">
                <span>2</span>
                <h3><?php echo Yii::t('basicfield', 'Choose a business') ?></h3>
                <p>
                    <?php echo Yii::t('basicfield', 'We have more than 1000s of businesses online.') ?>
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box_home" id="four">
                <span>3</span>
                <h3><?php echo Yii::t('basicfield', 'Pick a date and time') ?></h3>
                <p>
                    <?php echo Yii::t('basicfield', 'with your favourite business and staff member.') ?>
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box_home" id="three">
                <span>4</span>
                <h3><?php echo Yii::t('basicfield', 'Pay by card or cash') ?></h3>
                <p>
                    <?php echo Yii::t('basicfield', "It's quick, easy and totally secure.") ?>
                </p>
            </div>
        </div>
    </div><!-- End row -->


</div><!-- End container -->

<div class="white_bg">
    <div class="container margin_60">

        <?php echo $this->render('most-popular'); ?>


    </div><!-- End container -->
</div><!-- End white_bg -->


<!-- End Content =============================================== -->

<!-- Footer ================================================== -->