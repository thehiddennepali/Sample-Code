<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mt Merchants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-merchant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mt Merchant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'merchant_id',
            'service_name',
            'service_phone',
            'contact_name',
            'contact_phone',
            // 'contact_email:email',
            // 'country_code',
            // 'street:ntext',
            // 'city',
            // 'state',
            // 'post_code',
            // 'cuisine:ntext',
            // 'service',
            // 'free_delivery',
            // 'delivery_estimation',
            // 'username',
            // 'password',
            // 'activation_key',
            // 'activation_token',
            // 'status',
            // 'date_created',
            // 'date_modified',
            // 'date_activated',
            // 'last_login',
            // 'ip_address',
            // 'package_id',
            // 'package_price',
            // 'membership_expired',
            // 'payment_steps',
            // 'is_featured',
            // 'is_ready',
            // 'is_sponsored',
            // 'sponsored_expiration',
            // 'lost_password_code',
            // 'user_lang',
            // 'membership_purchase_date',
            // 'sort_featured',
            // 'is_commission',
            // 'percent_commission',
            // 'fixed_commission',
            // 'session_token',
            // 'commission_type',
            // 'seo_title',
            // 'seo_description',
            // 'seo_keywords',
            // 'url:url',
            // 'manager_username',
            // 'manager_password',
            // 'manager_extended',
            // 'fb',
            // 'tw',
            // 'gl',
            // 'yt',
            // 'it',
            // 'paypall_id',
            // 'paypall_pass',
            // 'gmap_altitude',
            // 'gmap_latitude',
            // 'gallery_id',
            // 'address',
            // 'vk',
            // 'pr',
            // 'is_purchase',
            // 'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
