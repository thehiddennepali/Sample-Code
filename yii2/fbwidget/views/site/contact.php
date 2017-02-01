 <!-- SubHeader =============================================== -->
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_short.jpg" data-natural-width="1600" data-natural-height="850">
        <div id="subheader">
            <div id="sub_content">
             <h1>Contacts</h1>
             <p>Qui debitis meliore ex, tollit debitis conclusionemque te eos.</p>
            </div><!-- End sub_content -->
        </div><!-- End subheader -->
    </section><!-- End section -->
    <!-- End SubHeader ============================================ -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="#0">Home</a></li>
                <li><a href="#0">Category</a></li>
                <li>Page active</li>
            </ul>
        </div>
    </div><!-- Position -->

<!-- Content ================================================== -->
<div class="container margin_60_35">
	<div class="row" id="contacts">
    	<div class="col-md-6 col-sm-6">
        	<div class="box_style_2">
            	<h2 class="inner">Customer service</h2>
                <?php echo \frontend\models\Option::getValByName('contact_content');?>
                </div>
    	</div>
        <div class="col-md-6 col-sm-6">
        	<div class="box_style_2">
            	<h2 class="inner">Restaurant Support</h2>
                
                <?php echo \frontend\models\Option::getValByName('m_contact_content');?>
                </div>
    	</div>
    </div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->