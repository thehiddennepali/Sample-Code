<?php
namespace fbwidget\components;

use Yii;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 16-Jun-16
 * Time: 19:03
 */

class CachedSingleOrder  {
    public static  function getOrdersByStaffAndDay($staff_id,$day)
    {
        $res = [];
        if($c = Yii::$app->cache->get($staff_id)){
            if(isset($c[$day])){
                foreach($c[$day] as $val){
                    $res[] = (object)$val;
                }
            }
        }
        return $res;
    }

    public static function getOrdersByStaffAndRange($staff_id, $range_start, $range_end)
    {
        $res = [];
        if($c = Yii::app()->cache->get($staff_id)){
            foreach($c as $key =>  $order){
                if($key>=$range_start && $key<=$range_end)
                foreach($order as $val){
                    $res[] = (object)$val;
                }
            }

        }
        return $res;
    }

    public static function deleteCacheByStaffDAteID($staff_id,$day,$id = 0)
    {
        $day = date('Y-m-d',strtotime($day));
        $res = [];
        if($c = Yii::app()->cache->get($staff_id)){
            if(isset($c[$day][$id])){
                unset($c[$day][$id]);
                Yii::app()->cache->set($staff_id,$c,3000);
            }
        }
        return $res;
    }

    public static function countGroupByDay($service_id,$date){
        if($c = Yii::app()->cache->get('g'.$service_id.strtotime($date))){
            return count($c);
        }else return 0;
    }

    public static function deleteGroupByDay($service_id,$date,$id = 0){
        if($c = Yii::app()->cache->get('g'.$service_id.strtotime($date))){
           if(isset($c[$id])){
               unset($c[$id]);
               Yii::app()->cache->set('g'.$service_id.strtotime($date),$c,3000);
           }
        }
    }
} 