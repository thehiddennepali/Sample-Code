<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SearchMtMerchant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mt-merchant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'merchant_id') ?>

    <?= $form->field($model, 'service_name') ?>

    <?= $form->field($model, 'service_phone') ?>

    <?= $form->field($model, 'contact_name') ?>

    <?= $form->field($model, 'contact_phone') ?>

    <?php // echo $form->field($model, 'contact_email') ?>

    <?php // echo $form->field($model, 'country_code') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'post_code') ?>

    <?php // echo $form->field($model, 'cuisine') ?>

    <?php // echo $form->field($model, 'service') ?>

    <?php // echo $form->field($model, 'free_delivery') ?>

    <?php // echo $form->field($model, 'delivery_estimation') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'activation_key') ?>

    <?php // echo $form->field($model, 'activation_token') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'date_modified') ?>

    <?php // echo $form->field($model, 'date_activated') ?>

    <?php // echo $form->field($model, 'last_login') ?>

    <?php // echo $form->field($model, 'ip_address') ?>

    <?php // echo $form->field($model, 'package_id') ?>

    <?php // echo $form->field($model, 'package_price') ?>

    <?php // echo $form->field($model, 'membership_expired') ?>

    <?php // echo $form->field($model, 'payment_steps') ?>

    <?php // echo $form->field($model, 'is_featured') ?>

    <?php // echo $form->field($model, 'is_ready') ?>

    <?php // echo $form->field($model, 'is_sponsored') ?>

    <?php // echo $form->field($model, 'sponsored_expiration') ?>

    <?php // echo $form->field($model, 'lost_password_code') ?>

    <?php // echo $form->field($model, 'user_lang') ?>

    <?php // echo $form->field($model, 'membership_purchase_date') ?>

    <?php // echo $form->field($model, 'sort_featured') ?>

    <?php // echo $form->field($model, 'is_commission') ?>

    <?php // echo $form->field($model, 'percent_commission') ?>

    <?php // echo $form->field($model, 'fixed_commission') ?>

    <?php // echo $form->field($model, 'session_token') ?>

    <?php // echo $form->field($model, 'commission_type') ?>

    <?php // echo $form->field($model, 'seo_title') ?>

    <?php // echo $form->field($model, 'seo_description') ?>

    <?php // echo $form->field($model, 'seo_keywords') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'manager_username') ?>

    <?php // echo $form->field($model, 'manager_password') ?>

    <?php // echo $form->field($model, 'manager_extended') ?>

    <?php // echo $form->field($model, 'fb') ?>

    <?php // echo $form->field($model, 'tw') ?>

    <?php // echo $form->field($model, 'gl') ?>

    <?php // echo $form->field($model, 'yt') ?>

    <?php // echo $form->field($model, 'it') ?>

    <?php // echo $form->field($model, 'paypall_id') ?>

    <?php // echo $form->field($model, 'paypall_pass') ?>

    <?php // echo $form->field($model, 'gmap_altitude') ?>

    <?php // echo $form->field($model, 'gmap_latitude') ?>

    <?php // echo $form->field($model, 'gallery_id') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'vk') ?>

    <?php // echo $form->field($model, 'pr') ?>

    <?php // echo $form->field($model, 'is_purchase') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
