<?php

if($model['models']){
    foreach ($model['models'] as $data){
        $select = isset($selected) ? "checked : 'checked'" : "";
        echo '<input type="radio"  value="'.$data.'" '.$select.' name="AddToCart[time_req]"> '. $data;

    }
}else{
    echo 'No time avaiable for this date.';
}

