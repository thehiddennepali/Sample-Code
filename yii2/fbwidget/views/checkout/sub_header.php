<div id="sub_content">
    <h1><?php echo Yii::t('basicfield', 'Book your appointment')?></h1>
    <div class="bs-wizard">
        <?php if(Yii::$app->controller->action->id == 'index'){
           $yourDetail = 'active'; 
           $payment = 'disabled';
           $finish = 'disabled';
        }else if(Yii::$app->controller->action->id == 'payment'){
           $yourDetail = 'complete'; 
           $payment = 'active';
           $finish = 'disabled';
        }else{
            $yourDetail = 'complete'; 
            $payment = 'complete';
            $finish = 'active';
            
            
        }?>
        
        <div class="col-xs-4 bs-wizard-step <?php echo $yourDetail?>">
            <div class="text-center bs-wizard-stepnum"><strong>1.</strong> 
                <?php echo Yii::t('basicfield', 'Your details')?></div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="cart.html" class="bs-wizard-dot"></a>
            
        </div>

        <div class="col-xs-4 bs-wizard-step <?php echo $payment?>">
            <div class="text-center bs-wizard-stepnum"><strong>2.</strong> <?php echo Yii::t('basicfield', 'Payment')?></div>
            <div class="progress"><div class="progress-bar"></div></div>
            
            <a href="#0" class="bs-wizard-dot"></a>
            
        </div>

        <div class="col-xs-4 bs-wizard-step <?php echo $finish?>">
            <div class="text-center bs-wizard-stepnum"><strong>3.</strong> <?php echo Yii::t('basicfield', 'Finish')?>!</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="cart_3.html" class="bs-wizard-dot"></a>
        </div>  
    </div><!-- End bs-wizard --> 
</div><!-- End sub_content -->