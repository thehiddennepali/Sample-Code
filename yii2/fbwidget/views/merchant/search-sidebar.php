<?php 

use frontend\models\MtServiceCategory;
use yii\jui\DatePicker;



?>

<p>
    <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap"><?php echo Yii::t('basicfield', 'View on map');?></a>
</p>
<div id="filters_col">
    <a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt">
        <?php echo Yii::t('basicfield', 'Search Filters');?> <i class="icon-plus-1 pull-right"></i></a>
    <form id="search">
        
        
        
        <input type="hidden" name="SearchMtMerchant[keyword]" value="<?php echo $search; ?>">
        
        <div class="collapse" id="collapseFilters">
            
            
            <div class="filter_type">
                <h6><?php echo Yii::t('basicfield', 'Date');?></h6>
                <?php echo DatePicker::widget([
                    'name'  => 'SearchMtMerchant[date]',
                    'value'  => "",
                    'dateFormat' => 'dd-MM-yyyy',
                    'clientOptions' => [
                        'minDate' => 0,
                        'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { 
                                doRefineSearch();

                        }
                        '),
                    ],


                ]);?>
                <button type="button" id="clear"><?php echo Yii::t('basicfield', 'clear');?></button>
                
                <h6><?php echo Yii::t('basicfield', 'Distance');?></h6>
                <input type="text" id="range" value="" name="SearchMtMerchant[distance]">
                <h6><?php echo Yii::t('basicfield', 'Type');?></h6>
                <ul>

                    <?php
                    $categories = MtServiceCategory::find()->all();
                    ?>

                    <li>
                        <label>
                            <input type="checkbox" class="icheck category all-cat search" checked="checked" value="all">
                            <?php echo Yii::t('basicfield', 'All');?> 
<!--                            <small>(49)</small>-->
                        </label>
                    </li>

                    <?php 
                    
                    //print_r($selcategory);
                    //$i=0;
                    foreach ($categories as $category) { 
                        
                        ?>
                        <li>
                            <label>
                                <input type="checkbox"  <?php if(isset($selcategory) && $selcategory[0] == $category->id){ echo 'checked = "checked"';}?> class="icheck category" name="SearchMtMerchant[category][<?php echo $i;?>]" value="<?php echo $category->id;?>">
                                <?php echo Yii::t('servicecategory', $category->title); ?> 
<!--                                <small>(12)</small>-->
                            </label>
                            <i class="color_1"></i>
                        </li>

                    <?php 
                    //$i++;
                    } ?>
                </ul>
            </div>


            <div class="filter_type">
                <h6><?php echo Yii::t('basicfield', 'Options')?></h6>
                <ul class="nomargin sub-cat">

                    <?php
                    /*$subSql = 'SELECT * FROM mt_service_subcategory';
                    $querySubCat = Yii::$app->db->createCommand($subSql)->queryAll();
                    echo $this ->render('subcategory',['subcategories'=>$querySubCat]);*/
                    ?>

                </ul>
            </div>

            <div class="filter_type">
                <h6><?php echo Yii::t('basicfield', 'Rating')?></h6>
                <ul>
                    <li>
                        <label>
                            <input type="checkbox" class="icheck search" name="SearchMtMerchant[rating][0]" value="5">
                            <span class="rating">
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                            </span>
                        </label>
                    </li>
                    
                    <li>
                        <label>
                            <input type="checkbox" class="icheck search" name="SearchMtMerchant[rating][1]" value="4">
                            <span class="rating">
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                                <i class="icon_star"></i>
                            </span>
                        </label>
                    </li>
                    
                    <li>
                        <label>
                            <input type="checkbox" class="icheck search" name="SearchMtMerchant[rating][2]" value="3">
                            <span class="rating">
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                            </span>
                        </label>
                    </li>
                    
                    <li>
                        <label>
                            <input type="checkbox" class="icheck search" name="SearchMtMerchant[rating][3]" value="2">
                            <span class="rating">
                                <i class="icon_star voted"></i>
                                <i class="icon_star voted"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                            </span>
                        </label>
                    </li>
                    
                    <li>
                        <label>
                            <input type="checkbox" class="icheck search" name="SearchMtMerchant[rating][4]" value="1">
                            <span class="rating">
                                <i class="icon_star voted"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                            </span>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="filter_type">
                <h6>Price</h6>
                <input type="text" id="price" value="" name="SearchMtMerchant[price]">

            </div>
            
            <input name="SearchMtMerchant[listtype]" id="listtype" type="hidden">
            <input name="SearchMtMerchant[ranking]" id="ranking" type="hidden">

        </div><!--End collapse -->
    </form>
</div><!--End filters col-->


<?php
$this->registerJs("
    
    function doRefineSearch(){
            $.ajax({
                    type : 'post',
                    url : '".Yii::$app->urlManager->createUrl('merchant/refine-search')."',
                    data : $('#search').serialize(),
                    dataType : 'json',
                    success :  function(response){
                    
                            
                            /*if(response.price){
                            console.log('i  am here');
                                console.log(response.price);
                                var slider = $('#price').data('ionRangeSlider');
                                
                                slider.update({
                                    min: 0,
                                    max: response.price,
                                    from: 0,
                                    to:response.price,
                                });
                                
                                
                            }*/

                            $('#search-view').html(response.html);

                        }

                    })
        }
        
    $('#clear').on('click', function(){
        $('.hasDatepicker').val('');
        doRefineSearch();
    });
        
    $('#sort_rating').on('change', function(){
        var value = $(this).val();
        $('#ranking').val(value);
        console.log(value);
        doRefineSearch();
    })
    
    $('body').on('click', '#grid-view', function(){
        var listtype = $(this).data('listtype');
        $('#listtype').val(listtype);
        doRefineSearch();
        if(listtype == 'grid'){
            $( this ).replaceWith( '<a href=\'javascript:void(0)\' class=\'bt_filters\' id=\'grid-view\' data-listtype=\'\'><i class=\'icon-list\'></i></a>');
        }else{
            $( this ).replaceWith( '<a href=\'javascript:void(0)\' class=\'bt_filters\' id=\'grid-view\' data-listtype=\'grid\'><i class=\'icon-list\'></i></a>');
        }
    })
    
    $('input.category').on('ifChecked ifUnchecked', function(event){
        var value = $(this).val();
        console.log(value);
        
        
        /*if(value != 'all'){
            $('input.all-cat').iCheck('uncheck');
        }else{
            $('input.category').iCheck('uncheck');
        }*/
        

       
        
        $.ajax({
            type : 'post',
            url : '".Yii::$app->urlManager->createUrl('merchant/get-subcategory')."',
            data : $('#search').serialize()+'&sel='+value,
            success :  function(response){
                
                $('.sub-cat').html(response);
                //$('input.subcat').iCheck();
                $('input.subcat').iCheck({
                    checkboxClass: 'icheckbox_square-grey',

                });
                
                $.ajax({
                    type : 'post',
                    url : '".Yii::$app->urlManager->createUrl('merchant/refine-search')."',
                    data : $('#search').serialize(),
                    dataType : 'json',
                    success :  function(response){
                    
                            /*if(response.price){
                                var slider = $('#price').data('ionRangeSlider');
                                
                                slider.update({
                                    min: 0,
                                    max: response.price,
                                    from: 0,
                                    to:response.price,
                                });
                            }*/

                            $('#search-view').html(response.html);

                        }

                    })
                
                
            
            }
            
        })
      });
      
        $('body').on('ifChecked ifUnchecked', 'input.search', function(){
            $.ajax({
                    type : 'post',
                    url : '".Yii::$app->urlManager->createUrl('merchant/refine-search')."',
                    data : $('#search').serialize(),
                    dataType : 'json',
                    success :  function(response){
                    
                            /*if(response.price){
                                var slider = $('#price').data('ionRangeSlider');
                                
                                slider.update({
                                    min: 0,
                                    max: response.price,
                                    from: 0,
                                    to:response.price,
                                });
                            }*/

                            $('#search-view').html(response.html);

                        }

                    })
            
        })
    
    
    
    $(function () {
		 'use strict';
        $('#range').ionRangeSlider({
            hide_min_max: true,
            keyboard: true,
            min: 0,
            max: 25,
            from: ".$distance.",
            to:5,
            type: 'single',
            step: 1,
            prefix: 'Km ',
            grid: true,
            onFinish: function ( obj ) {
                doRefineSearch();
                
                
              }
        });
        
        $('#price').ionRangeSlider({
            hide_min_max: true,
            keyboard: true,
            min: 0,
            max: 1000,
            from: 0,
            to:1000,
            type: 'double',
            step: 10,
            prefix: '€ ',
            grid: true,
            onFinish: function ( obj ) {
                doRefineSearch();
                
                
              }
        });
        
        
    });
        ")
?>