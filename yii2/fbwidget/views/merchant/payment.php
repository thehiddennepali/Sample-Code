<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_short.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
        <div id="sub_content">
            <h1><?php echo Yii::t('basicfield', 'Merchant Signup')?></h1>
            <p><?php echo Yii::t('basicfield', 'step')?> 3 of 4</p>
        </div><!-- End sub_content -->
    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

<div id="position">
    <div class="container">
        <div class="container">
            <div class="row">

                <?php echo $this->render('sub_header') ?>



            </div>
        </div> <!--container-->
    </div>
</div><!-- Position -->

<div class="sections section-grey2 section-orangeform section-merchant-payment">

    <div class="container">

        <div class="row top30">    
            <div class="inner">       
                <h1><?php echo Yii::t('basicfield', 'Choose Payment option');?></h1>
                <div class="box-grey rounded">	  


                    <form class="uk-form uk-form-horizontal forms" >
                        <input type="hidden" value="merchantPayment" name="action" id="action" />				 <input type="hidden" value="store" name="currentController" id="currentController" />				 <input type="hidden" value="1f359de8c8133498abdf4ccd941b9156" name="token" id="token" />  


                        <div class="section-label">
                            <a class="section-label-a">
                                <span class="bold">
                                    <?php echo Yii::t('basicfield', 'Payment Information');?></span>
                                <b></b>
                            </a>
                            <span id="error-msg"></span>
                        </div>    


                        <div class="row top10">
                            <div class="col-md-9">
                                <?php echo \yii\helpers\Html::radio('payment', '', ['value' => 1, 'required'=>true, 'class' => ' payment_option payment']) ?><?php echo Yii::t('basicfield', 'Invoice');?>     </div> 
                        </div>



                        <div class="row top10">
                            <div class="col-md-9">
                                <?php echo \yii\helpers\Html::radio('payment', '', ['value' => 2,'required'=>true, 'class' => ' payment_option payment']) ?><?php echo Yii::t('basicfield', 'Paypal');?>     </div> 
                        </div>




                        <div class="top10">
                            <input type="button" value="<?php echo Yii::t('basicfield', 'Next');?>" class="green-button medium inline" id="next-payment">
                        </div>    

                    </form>

                    <!--CREDIT CART-->

                    <div class="credit_card_wrap" id="credit-card" style="display: none">    
                        

                            <div class="section-label">
                                <a class="section-label-a">
                                    <span class="bold">
                                        <?php echo Yii::t('basicfield', 'Credit Card information');?></span>
                                    <b></b>
                                </a>     
                            </div>    
                            <a href="javascript:;" class="cc-add orange-text">
                                [ <i class="ion-ios-compose-outline"></i> 
                                <?php echo Yii::t('basicfield', 'Add new card');?>]
                            </a>

                            <div class="section-label">
                                <a class="section-label-a">
                                    <span class="bold">
                                        <?php echo Yii::t('basicfield', 'select credit card below');?></span>
                                    <b></b>
                                </a>     
                            </div>    

                            <!--<ul class="uk-list uk-list-striped uk-list-cc">    
                                      
                            </ul>-->
                            <table class="table table-striped">
                                <tbody class="uk-list-cc"> 
                                    
                                    <?php 
                                    
                                    if(!empty($session['creditcard'])){
                                        echo $this->render('credit-card');
                                        
                                    }?>
                                </tbody>
                            </table>

                            <div class="cc-add-wrap" id="new-credit-card" style="display: none">
                                <p class="bold">New Card</p>
                                
                                <?php echo $this->render('/merchant-credit-card/_form', ['model'=> $creditCard])?>
                                

                            </div> <!--cc-add-wrap-->

                       
                    </div> <!--credit_card_wrap-->     
                    <!--END CREDIT CART-->




                </div> <!--box-grey-->
            </div> <!--inner-->    
        </div> <!--row-->

    </div> <!--container-->

</div> <!--sections-->


<?php
$this->registerJs(
        "$(document).ready(function(){
            
            $('#next-payment').click(function(e){
                e.preventDefault();
                $('#error-msg').empty();
                var selected = $('input[name=payment]:checked').val();
                
                console.log(selected);
                if( selected != undefined ){
                    var selectedcard = $('input[name=cc_id]:checked').val();
                    
                        /*if(selectedcard === undefined && selected == 1){
                        
                            $('#error-msg').html('Please select at least one credit card.');
                        }else{
                            
                        
                        }*/
                        
                         $.ajax({
                                type :  'post',
                                url : '".Yii::$app->urlManager->createUrl('merchant/final-payment')."',
                                data : {paymentType :selected, creditCard : selectedcard },
                                dataType : 'json',
                                success : function(response){
                                
                                    if(response.success == true){
                                        window.location.href = response.url;
                                    }else{
                                        $('#error-msg').html(response.msg);
                                    }
                                    console.log(response);
                                    
                                }
                                
                            })
                        
                    
                
                }else{
                    $('#error-msg').html('Please select at least one payment method');
                }
            })
            
            /*$('.payment').change(function(){
                var selected = $(this).val();
                console.log(selected);
                
                if(selected == 1){
                    $('#credit-card').show();
                }else{
                    $('#credit-card').hide();
                }
            })
            
            $('.cc-add').click(function(){
                $('#new-credit-card').show();
            })
            
            $('.save-credit-card').click(function(e){
                    e.preventDefault();
                    
                    var url = $(this).data('url');
                    var formid = $(this).data('formid');
                    
                    console.log(formid);
                    
                    
                    $.ajax({
                        type : 'post',
                        url : url,
                        data : $('#' + formid).serialize(),
                        success : function (response){
                        
                            $('body .help-block').remove();
                            if(response.success == true){
                                $('#new-credit-card').hide();
                                $('.uk-list-cc').append(response.view);
                            }
                            else{
                                $.each(response, function(key, val) {

                                    $('#'+key).after('<div class=\"help-block\">'+val+'</div>');

                                });
                            }
                        
                        }
                    })
                
                    })*/
        })"
)?>