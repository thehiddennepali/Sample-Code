 <div class="container-fluid">
        <div class="row">
            <div class="col--md-4 col-sm-4 col-xs-4">
                <a href="<?php echo Yii::$app->homeUrl;?>" id="logo">
                <img src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/termin-logo-3.png" width="326" height="61" alt="" data-retina="true" class="hidden-xs">
                <img src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/logo_mobile-1.png" width="139" height="26" alt="" data-retina="true" class="hidden-lg hidden-md hidden-sm">
                </a>
            </div>
            <nav class="col--md-8 col-sm-8 col-xs-8">
            <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);">
                <span>Menu mobile</span></a>
            <div class="main-menu">
                <div id="header_menu">
                    <img src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/logo_mobile-1.png" width="139" height="26" alt="" data-retina="true">
                </div>
                <a href="#" class="open_close" id="close_in"><i class="icon_close"></i></a>
                 <ul>
                    <li class="submenu">
                    <a href="<?php echo Yii::$app->homeUrl;?>">
                        <?php echo Yii::t('basicfield', 'Home')?>
                        </a>

                    </li>
                    <li class="submenu">
                    <a href="<?php echo Yii::$app->urlManager->createUrl('merchant/sign-up');?>">
                        <?php echo Yii::t('basicfield', 'Merchant Registration')?>
                        
                    </a>

                    </li>
                    
                    
<!--                    <li><a href="list_page.html">Search</a></li>
                    <li class="submenu">
                    <a href="javascript:void(0);" class="show-submenu">Pages<i class="icon-down-open-mini"></i></a>
                    <ul>
                    <li><a href="detail_page_2.html">Business Page</a></li>
                    <li><a href="cart.html">Order step 1</a></li>
                    <li><a href="cart_2.html">Order step 2</a></li>
                    <li><a href="cart_3.html">Order step 3</a></li>
                    <li><a href="grid_list.html">Grid list</a></li>
                    <li><a href="contacts.html">Contacts</a></li>                        
                    <li><a href="about.html">About us</a></li>
                    <li><a href="faq.html">Faq</a></li>
					<li><a href="pricing.html">Pricing</a></li>
                    </ul>
                    </li>-->
                    
                        <?php if(Yii::$app->user->id){?>
                        <li>
                            <a href="<?php echo Yii::$app->urlManager->createUrl('client/dashboard')?>" >
                                <button class="btn_4">

                                <?php echo Yii::$app->user->identity->first_name;?>

                                </button>
                            </a>
                        </li>
                        <li>
                        <a href="<?php echo Yii::$app->urlManager->createUrl('site/logout')?>" data-method="post">
                            <button class="btn_5">
                                <?php echo Yii::t('basicfield', 'Logout')?>
                               
                            </button>
                        </a>
                        </li>
                        
                        <?php }else{?>
                        <li>
                                <a href="#0" data-toggle="modal" data-target="#login_2">
                                    <?php echo Yii::t('basicfield', 'Login')?>
                                </a>
                         </li>
                        <?php }?>
                   <li>
                    <div class="styled-select">
                        <select class="form-control" name="lang" id="lang">
                            <?php 
                            
                                $cookies = Yii::$app->request->cookies;
                                $current_language = $cookies->getValue('language');
                                
                                echo $current_language;
                                //exit;

                            $languages = \common\models\Language::find()->all();
                            foreach ($languages as $language){
                            ?>
                            <option value="<?php echo $language->code;?>" 
                                <?php if(isset($current_language) && $current_language == $language->code){ echo 'selected="selected"';}?> ><?php echo $language->name;?></option>
                            <?php }?>
                            
                            
							
                        </select>
                    </div>
                        </li>
                    
                </ul>
            </div><!-- End main-menu -->
            




            </nav>
		
        </div><!-- End row -->
    </div><!-- End container -->
    
    <?php 
    
    $this->registerJs('
    $("#lang").on("change", function(ev){
    console.log("i am here");
        var code = $(this).val();
        console.log(code);
        $.ajax({
            type : "post",
            url : "'.Yii::$app->urlManager->createAbsoluteUrl('site/language').'",
            data : {code : code},
            success :  function(response){
                if(response == true){
                    location.reload(); 
                }
            
            }
        
            })
        
        })');
    ?>
   