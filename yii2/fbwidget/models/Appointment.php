<?php
namespace fbwidget\models;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Appointment extends \yii\base\Model{
    
    public $employee,
            $date_time,
            $first_at_home,
            $coupone,
            $apply_coupon,
            $order;
    
    public function rules(){
        
        return [
            //[['employee', 'date_time'], 'required'],
            [['employee', 'date_time','first_at_home', 'coupone', 'apply_coupon', 'order'], 'safe'],
        ];
    }
}

