<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'client_id',
            'payment_type',
            'client_name',
            'client_phone',
            'client_email:email',
            'order_time',
            'category_id',
            'staff_id',
            'merchant_id',
            'create_time',
            'is_group',
            'source_type',
            'order_id',
            'price',
            'more_info',
            'discounted_amount',
            'discount_percentage',
            'percent_commision',
            'total_commission',
            'commision_ontop',
            'merchant_earnings',
            'voucher_code',
            'voucher_amount',
            'voucher_type',
            'voucher_id',
        ],
    ]) ?>

</div>
