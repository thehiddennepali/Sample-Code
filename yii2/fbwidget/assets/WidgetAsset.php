<?php

namespace fbwidget\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class WidgetAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic',
        ['img/favicon.ico', 'type'=>'image/png', 'rel'=>"shortcut icon"],
        'css/animate.min.css',
        'css/menu.css',
        'css/style.css',
        'css/elegant_font/elegant_font.min.css',
        'css/fontello/css/fontello.min.css',
        'css/magnific-popup.css',
        'css/pop_up.css',
        'css/jquery.cookiebar.css',
        'css/ion.rangeSlider.css',
        'css/ion.rangeSlider.skinFlat.css',
        'css/skins/square/grey.css',
        'css/responsive.css',
        //'css/slider-pro.min.css',
        'css/jquery.bxslider.css'
        
    ];
    public $js = [
        'js/common_scripts_min.js',
        'js/functions.js',
        'js/ion.rangeSlider.js',
        'js/jquery.cookiebar.js',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyCZpettLYGwQxL4anPIYsRfJGa7ItzVEck',
        'js/map.js',
        'js/infobox.js',
        //'js/jquery.sliderPro.js',
        'https://cdn.socket.io/socket.io-1.4.5.js',
        'js/jquery.bxslider.min.js',
        
    ];
//    public $jsOptions = array(
//        //'position' => View::POS_HEAD // too high
//        //'position' => View::POS_READY // in the html disappear the jquery.jrac.js declaration
//        //'position' => View::POS_LOAD // disappear the jquery.jrac.js
//         'position' => \yii\web\View::POS_HEAD // appear in the bottom of my page, but jquery is more down again
//    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
