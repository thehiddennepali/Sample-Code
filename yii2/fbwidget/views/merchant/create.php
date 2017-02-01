<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtMerchant */

$this->title = 'Create Mt Merchant';
$this->params['breadcrumbs'][] = ['label' => 'Mt Merchants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_short.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
        <div id="sub_content">
            <h1><?php echo Yii::t('basicfield', 'Merchant Signup')?></h1>
            <p><?php echo Yii::t('basicfield', 'step')?> 2 of 4</p>
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

    <div class="container">

        <div class="row">  
            <div class="col-md-8 border">
                <div class="box-grey round top-line-green">
                    
                    
                    <?php echo $this->render('_form', [
                        'model'=>$model,
                        'package' => $package])?>

               
                </div> <!--box-grey-->

            </div> <!--col-->

            <div class="col-md-4 border sticky-div">
                <div class="box-grey round" id="change-package-wrap">

                    <input type="hidden" value="/food/store/merchantsignup?do=step2&amp;package_id=" name="change_package_url" id="change_package_url" />              	<div class="section-label">
                        <a class="section-label-a">
                            <span class="bold">
                                <?php echo Yii::t('basicfield', 'Change Package')?></span>
                            <b></b>
                        </a>     
                    </div>    

                    <div class="top10">
                        
                        <?php echo Html::dropDownList('selected', $selectedpackage, 
                                \yii\helpers\ArrayHelper::map(\frontend\models\MtPackages::find()->all(), 'package_id', 'title'),
                                    [
                                    'class' => 'grey-fields full-width',
                                        
                                    'onchange'=>'
                                        var id = $(this).val();
                                        window.location.href="'.Yii::$app->urlManager->createUrl('merchant/create').'?packageid=" + id;
                                        
                                        ',
                                ])?>
                                

                    </div>
                    

                </div> <!--box-->
            </div> <!--col-->

        </div> <!--row--> 
    </div> <!--container-->  


</div><!-- End container -->
<!-- End Content =============================================== -->

