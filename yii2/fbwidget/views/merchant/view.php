<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtMerchant */

$this->title = Yii::t('seorule', \frontend\models\MtMerchant::getSeo($model, $model->seo_title));


$sql = 'SELECT chm.category_id, ssc.*,sc.*  from category_has_merchant as chm 
        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
        LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
        WHERE chm.merchant_id=' . $model->merchant_id . ' group by sc.id';

$query = Yii::$app->db->createCommand($sql)->queryAll();
$session = Yii::$app->session;
$service = '';
$mservice = '';
foreach ($query as $key => $cat) {
    $service .= Yii::t('servicecategory', $cat['title']);
    $mservice .= Yii::t('servicecategory', $cat['title']);
    if ((sizeof($query) - 1) > $key) {
        $mservice .= ' | ';
        $service .= ' / ';
    }
}

echo "<script type = 'text/javascript'>";
echo "markersData = [];";
if (!empty($session['latlang'])) {
    echo "var lat = " . $model->gmap_latitude . ";";
    echo "var long = " . $model->gmap_altitude . ";";
}

$imageUrl = $model->behaviors['imageBehavior']->getImageUrl();

$merchantUrl = preg_replace('/\s+/', '', $model->service_name);
$merchantUrl = strtolower($merchantUrl) . '-' . $model->merchant_id;

echo "markersData[0] = {
    'name':'" . $model->service_name . "',
    'location_latitude' : " . $model->gmap_latitude . ", 
    'location_longitude' : " . $model->gmap_altitude . ",
    'map_image_url': '" . $imageUrl . "',
    'name_point': '" . $model->service_name . "',
    'type_point': '" . $service . "',
    'description_point': '" . $model->address . "<br>',
    'url_point': '" . Yii::$app->urlManager->createUrl(['merchant/view', 'id' => $merchantUrl]) . "'
    };";

echo "
        markersData  = {
        'merchant' : markersData
        };
    ";
echo 'console.log(markersData)';
echo "</script>";
?>

<!-- SubHeader =============================================== -->
<section class="parallax-window" data-parallax="scroll" 
         data-image-src="<?php echo $model->behaviors['imageBehavior2']->getImageUrl(); ?>" 
         data-natural-width="1600" data-natural-height="850"

         >
    <div id="subheader" itemscope itemtype="http://schema.org/LocalBusiness">
        <div id="sub_content">
            <div id="thumb">

                <?php echo Html::img($model->behaviors['imageBehavior']->getImageUrl(), ['itemprop' => 'image']) ?>

            </div>
            <div class="rating">
                <?php
                $ratingSql = 'SELECT ceil(AVG(rating)) as totalrating FROM mt_review where merchant_id=' . $model->merchant_id;
                $queryRating = Yii::$app->db->createCommand($ratingSql)->queryScalar();

                $ratingCountSql = 'SELECT count(*) as totalrating FROM mt_review where merchant_id=' . $model->merchant_id;
                $queryCountRating = Yii::$app->db->createCommand($ratingCountSql)->queryScalar();


                if ($queryRating != 0) {
                    for ($i = 1; $i <= $queryRating; $i++) {
                        ?>
                        <i class="icon_star voted"></i>
                        <?php
                    }
                }
                ?>


                <?php
                $j = 5 - $queryRating;
                if ($j != 0 && $j <= 5) {
                    for ($k = 1; $k <= $j; $k++) {
                        ?>
                        <i class="icon_star"></i> 
                        <?php
                    }
                }
                ?>
                <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                    (<small >


                        <span itemprop="reviewCount">
                            <?php echo $queryCountRating; ?> 
                        </span>
                        <span itemprop="ratingValue" style="display :none"><?php echo $queryRating; ?></span>

                        <?php echo Yii::t('basicfield', 'reviews') ?>


                    </small>)
                </div> 
            </div>

            <h1 itemprop="name"><?php echo $model->service_name; ?></h1>


            <em>
                <?php
                echo $mservice;
                ?>                   
            </em>
            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">

                <i class="icon_pin"></i> 

                <span itemprop="streetAddress"><?php echo $model->address ?></span>

                - <i class="icon-phone-squared"></i> 
                <a href="tel:+<?php echo $model->contact_phone ?>" target="_blank">
                    <span itemprop="telephone"><?php echo $model->contact_phone ?></span>
                </a>
            </div>
            <div><i class="icon-website-circled"></i> 
                <a href="<?php echo 'http://' . $model->url; ?>" target="_blank" itemprop="url" > 
                    <?php echo $model->url; ?></a></div>
        </div><!-- End sub_content -->
    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->
<?php
$session = Yii::$app->session;
$keyword = $session['keyword'];
?>
<div id="position">
    <div class="container">
        <ul>
            <li><a href="<?php echo Yii::$app->homeUrl; ?>">

                    <?php echo Yii::t('basicfield', 'Home') ?></a></li>
            <li><a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/search', 'Merchant[search]' => $keyword]) ?>">Search</a></li>
            <li><?php echo $model->service_name; ?></li>
        </ul>
    </div>
</div><!-- Position -->

<div class="collapse" id="collapseMap">
    <div id="map" class="map"></div>
</div><!-- End Map -->

<!-- Content ================================================== -->
<div class="container margin_60_35" >

    <div class="row">
        <div class="rating">

            <a href="<?php echo Yii::$app->urlManager->createUrl(['merchant/search', 'Merchant[search]' => $keyword]) ?>" class="btn_6 add_bottom_15">
                <?php echo Yii::t('basicfield', 'Back to search results'); ?>
            </a>
        </div>
    </div>
    <div class="row">



        <div class="col-md-8">

            <div class="box_style_2">
                <h2 class="inner">
                    <?php echo Yii::t('basicfield', 'Services & Information') ?>
                </h2>

<!--                <ul class="bxslider">
                    <li><img src="http://bxslider.com/images/home_slides/houses.jpg" /></li>
                    <li><img src="http://bxslider.com/images/home_slides/houses.jpg" /></li>
                    <li><img src="http://bxslider.com/images/home_slides/houses.jpg" /></li>
                </ul>-->
                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                                <?php echo Yii::t('basicfield', 'Services & Treatments') ?>

                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                                <?php echo Yii::t('basicfield', 'Gallery') ?>

                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">
                                <?php echo Yii::t('basicfield', 'Information') ?>

                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">
                                <?php echo Yii::t('basicfield', 'Reviews') ?>

                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">


                            <h3 class="inner">
                                <?php echo Yii::t('basicfield', 'Services & Treatments') ?>
                            </h3>


                            <div class="panel-group" id="accordion">

                                <!--                                    <div itemscope itemtype="http://schema.org/Service">
                                      <meta itemprop="serviceType" content="Home cleaning" />
                                      <span itemprop="provider" itemscope itemtype="http://schema.org/LocalBusiness">
                                        <span itemprop="name">ACME Home Cleaning</span>
                                      </span>
                                      offers a variety of services in
                                      <span itemprop="areaServed" itemscope itemtype="http://schema.org/State">
                                        <span itemprop="name">Massachusetts</span>, including
                                      </span>
                                      <ul itemprop="hasOfferCatalog" itemscope itemtype="http://schema.org/OfferCatalog">
                                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/OfferCatalog">
                                          <span itemprop="name">House cleaning</span>
                                          <ul itemprop="itemListElement" itemscope itemtype="http://schema.org/OfferCatalog">
                                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/Offer">
                                              <div itemprop="itemOffered" itemscope itemtype="http://schema.org/Service">
                                                <span itemprop="name">Apartment light cleaning</span>
                                                <span itemprop="position">Apartment light cleaning</span>
                                                <span itemprop="url">Apartment light cleaning</span>
                                              </div>
                                            </li>
                                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/Offer">
                                              <div itemprop="itemOffered" itemscope itemtype="http://schema.org/Service">
                                                <span itemprop="name">House light cleaning up to 2 bedrooms</span>
                                              </div>
                                            </li>
                                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/Offer">
                                              <div itemprop="itemOffered" itemscope itemtype="http://schema.org/Service">
                                                <span itemprop="name">House light cleaning 3+ bedrooms</span>
                                              </div>
                                            </li>
                                          </ul>
                                        
                                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/OfferCatalog">
                                          <span itemprop="name">One-time services</span>
                                          <ul itemprop="itemListElement" itemscope itemtype="http://schema.org/OfferCatalog">
                                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/Offer">
                                              <div itemprop="itemOffered" itemscope itemtype="http://schema.org/Service">
                                                <span itemprop="name">Window washing</span>
                                              </div>
                                            </li>
                                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/Offer">
                                              <div itemprop="itemOffered" itemscope itemtype="http://schema.org/Service">
                                                <span itemprop="name">Carpet deep cleaning</span>
                                              </div>
                                            </li>
                                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/Offer">
                                              <div itemprop="itemOffered" itemscope itemtype="http://schema.org/Service">
                                                <span itemprop="name">Move in/out cleaning</span>
                                              </div>
                                            </li>
                                          </ul>
                                        </li>
                                      </ul>
                                    </div>-->

                                <?php
                                $sqlCategoryhadMerchant = 'SELECT chm.category_id, ssc.*, sc.id as catid from category_has_merchant as chm 
                                        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                                        RIGHT JOIN  mt_service_category as sc ON ssc.category_id=sc.id
                                        WHERE chm.merchant_id=' . $model->merchant_id . ' and chm.is_active=1 group by sc.id';

                                $queryCathasMerchant = Yii::$app->db->createCommand($sqlCategoryhadMerchant)->queryAll();

                                if ($queryCathasMerchant) {
                                    foreach ($queryCathasMerchant as $cat) {

                                        $sqlCategoryMerchant = 'SELECT chm.category_id, ssc.*, sc.id as catid from category_has_merchant as chm 
                                        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                                        RIGHT JOIN  mt_service_category as sc ON ssc.category_id=sc.id
                                        WHERE chm.merchant_id=' . $model->merchant_id . ' and sc.id=' . $cat['catid'] . ' and chm.is_active=1 group by ssc.id';

                                        $queryCatMerchant = Yii::$app->db->createCommand($sqlCategoryMerchant)->queryAll();

                                        foreach ($queryCatMerchant as $service) {
                                            ?>
                                            <div class="panel panel-default" >
                                                <div class="panel-heading" >

                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $service['id'] ?>">



                                                            <?php echo Yii::t('servicesubcategory', $service['title']) ?>
                                                            <i class="indicator icon_plus_alt2 pull-right"></i>
                                                        </a>
                                                    </h4>

                                                </div>
                                                <div id="collapseOne<?php echo $service['id'] ?>" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <table class="table table-striped cart-list">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <?php echo Yii::t('basicfield', 'Item') ?>
                                                                    </th>
                                                                    <th>
                                                                        <?php echo Yii::t('basicfield', 'Price') ?>
                                                                    </th>
                                                                    <th>
                                                                        <?php echo Yii::t('basicfield', 'Book now') ?>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                $serviceSql = 'SELECT * FROM category_has_merchant WHERE category_id=' . $service['id'] . ' and is_active=1 and merchant_id=' . $model->id;


                                                                $queryServices = Yii::$app->db->createCommand($serviceSql)->queryAll();

                                                                if ($queryServices) {

                                                                    foreach ($queryServices as $ser) {
                                                                        ?>

                                                                        <tr >
                                                                            <td >

                                                                                <h5><?php echo $ser['title'] ?></h5>
                                                                                <p><?php echo $ser['description']; ?></p>

                                                                            </td>
                                                                            <td>
                                                                                <strong>€ <?php echo $ser['price'] ?></strong>
                                                                            </td>
                                                                            <td class="options">
                                                                                <a href="javascript:void(0)"  class="add-to-cart" data-id='<?php echo $ser['id'] ?>'> <i class="icon_plus_alt2"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>


                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <?php
                            $gallery = $model->behaviors['galleryBehavior']->getGallery();
                            if ($gallery->galleryPhotos) {
                                ?>

                                <ul class="bxslider">
                                    <?php foreach ($gallery->galleryPhotos as $photo) { 
//                                        echo '<pre>';
//                                        print_R($photo->attributes);
                                        ?>
                                        <li>
                                            <img src="<?php echo $photo->getPreview()?>" alt="" title="<?php echo $photo->name?>">
                                        </li>

                                    <?php }
                                    ?>
                                </ul>


                            <?php } ?>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="messages">                    
                            <h3><?php echo Yii::t('basicfield', 'Information') ?></h3>
                            <p>
                                <?php echo Yii::t('basicfield', $model->description); ?>
                            </p></div>

                        <div role="tabpanel" class="tab-pane" id="settings">
                            <?php
                            $sql = "select * from mt_review where merchant_id=" . $model->id;
                            $query = Yii::$app->db->createCommand($sql)->queryAll();
                            $query = frontend\models\MtReview::find()->where(['merchant_id' => $model->id])->all();

//                        echo '<pre>';
//                        print_r($query);
//                        exit;
                            if ($query) {
                                foreach ($query as $data) {

                                    //echo'hello';
                                    ?>

                                    <div class="review_strip_single">
                                        <?php if ($data->client) { ?>
                                            <img src="<?php echo $data->client->behaviors['imageBehavior']->getImageUrl() ?>" alt="" class="img-circle" height="75" width="75">
                                        <?php } ?>
                                        <small> - <?php echo date('d F Y', strtotime($data['date_created'])); ?> -</small>
                                        <h4><?= $data->name; ?> </h4>
                                        <p>
                                            "<?= $data->review; ?>"
                                        </p>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="rating">
                                                    <?php for ($i = 0; $i <= $data->food_review; $i++) { ?>
                                                        <i class="icon_star voted"></i>
                                                    <?php } ?>
                                                </div>
                                                <?php echo Yii::t('basicfield', 'Preis') ?>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="rating">
                                                    <?php for ($i = 0; $i <= $data->price_review; $i++) { ?>
                                                        <i class="icon_star voted"></i>
                                                    <?php } ?>
                                                </div>
                                                <?php echo Yii::t('basicfield', 'Ambiente') ?>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="rating">
                                                    <?php for ($i = 0; $i <= $data->punctuality_review; $i++) { ?>
                                                        <i class="icon_star voted"></i>
                                                    <?php } ?>
                                                </div>
                                                <?php echo Yii::t('basicfield', 'Mitarbeiter') ?>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="rating">
                                                    <?php for ($i = 0; $i <= $data->courtesy_review; $i++) { ?>
                                                        <i class="icon_star voted"></i>
                                                    <?php } ?>
                                                </div>
                                                <?php echo Yii::t('basicfield', 'Sauberkeit') ?>
                                            </div>

                                        </div>
                                    </div>


                                <?php
                                }
                            }
                            ?>

                        </div>

                    </div>

                </div>






            </div><!-- End box_style_1 -->
        </div>
        <div class="col-md-4">

            <?php
            echo $this->render('view_right_bar', ['model' => $model,
                'appointment' => $appointment])
            ?>
        </div>
    </div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->





<!-- Register modal -->   
<div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="review" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-popup">
            <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
            
<?php echo $this->render('/mt-review/_form', ['model' => $review, 'merchant' => $model]); ?> 
            <!--            <form method="post" action="assets/review_restaurant.php" name="review" id="review" class="popup-form">  
                            <div class="login_icon"><i class="icon_comment_alt"></i></div>
                            <input name="restaurant_name" id="restaurant_name" type="hidden" value="Mexican Taco Mex">	
                            <div class="row" >
                                <div class="col-md-6">
                                    <input name="name_review" id="name_review" type="text" placeholder="Name" class="form-control form-white">			
                                </div>
                                <div class="col-md-6">
                                    <input name="email_review" id="email_review" type="email" placeholder="Your email" class="form-control form-white">
                                </div>
                            </div> End Row  
            
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control form-white" name="food_review" id="food_review">
                                        <option value="">Preis</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>                            </div>
                                <div class="col-md-6">
                                    <select class="form-control form-white"  name="price_review" id="price_review">
                                        <option value="">Ambiente</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>End Row     
            
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control form-white"  name="punctuality_review" id="punctuality_review">
                                        <option value="">Mitarbeiter</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>                       </div>
                                <div class="col-md-6">
                                    <select class="form-control form-white"  name="courtesy_review" id="courtesy_review">
                                        <option value="">Sauberkeit</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>End Row      
                            <textarea name="review_text" id="review_text" class="form-control form-white" style="height:100px" placeholder="Write your review"></textarea>
                            <input type="text" id="verify_review" class="form-control form-white" placeholder="Are you human? 3 + 1 =">
                            <input type="submit" value="Submit" class="btn btn-submit" id="submit-review">
                        </form>-->
            <div id="message-review"></div>
        </div>
    </div>
</div><!-- End Register modal -->  
<!-- Extras Modal -->
<div class="modal fade" id="extras" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<!-- End modal -->   
<!--<style>
    .bx-viewport{min-height:200px;}
</style>-->



<?php $this->registerJs('
            $(document).ready(function(){
            
//            $(".bxslider").bxSlider({
//                adaptiveHeight : false
//            });
            
            $("a[href=\"#profile\"]").one("shown.bs.tab", function (e) {
                //console.log("i ma ere");
                $(".bxslider").bxSlider({
                    mode: "fade",
//                    pagerCustom: "#bx-pager",
//                   adaptiveHeight: true,
//                    slideWidth: 300,
                    captions: true
                  });
            });
            
            //if($( "#Img_carousel" ))
            //$( "#Img_carousel" ).sliderPro();
            
            $("body").on("click", ".add-to-cart", function(){
                $("#extras").find(".modal-content").empty();
                var serviceid = $(this).data("id");
                var key = $(this).data("key");
                var update = 0;
                console.log(key);
                if(key == "" && key != 0){
                    console.log("i mahere");
                    key = "";
                }else{
                    update = 1;
                }
                
                $.ajax({
                    type : "post",
                    url : "' . Yii::$app->urlManager->createUrl('merchant/service') . '",
                    data : {serviceid : serviceid, key: key, update : update},
                    success : function(response){
                        $("#extras").find(".modal-content").html(response);
                        $("#extras").modal("show");
                        console.log()
                    }
                })
            })
            
        })') ?>


