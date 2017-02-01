<?php
namespace fbwidget\components;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 15-Feb-16
 * Time: 16:05
 */

class UrlHelper {

    public static function getSlugFromString($string, $space="-") {


            $string = utf8_encode($string);
            if (function_exists('iconv')) {
                $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
            }

            $string = preg_replace("/[^a-zA-Z0-9 \-]/", "", $string);
            $string = trim(preg_replace("/\\s+/", " ", $string));
            $string = strtolower($string);
            $string = str_replace(" ", $space, $string);

            return $string;
    }
    
    public static function numberFormat($number){
	    return number_format($number, 2, '.', '');
    }

} 