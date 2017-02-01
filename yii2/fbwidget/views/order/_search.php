<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'client_id') ?>

    <?= $form->field($model, 'payment_type') ?>

    <?= $form->field($model, 'client_name') ?>

    <?php // echo $form->field($model, 'client_phone') ?>

    <?php // echo $form->field($model, 'client_email') ?>

    <?php // echo $form->field($model, 'order_time') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'staff_id') ?>

    <?php // echo $form->field($model, 'merchant_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'is_group') ?>

    <?php // echo $form->field($model, 'source_type') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'more_info') ?>

    <?php // echo $form->field($model, 'discounted_amount') ?>

    <?php // echo $form->field($model, 'discount_percentage') ?>

    <?php // echo $form->field($model, 'percent_commision') ?>

    <?php // echo $form->field($model, 'total_commission') ?>

    <?php // echo $form->field($model, 'commision_ontop') ?>

    <?php // echo $form->field($model, 'merchant_earnings') ?>

    <?php // echo $form->field($model, 'voucher_code') ?>

    <?php // echo $form->field($model, 'voucher_amount') ?>

    <?php // echo $form->field($model, 'voucher_type') ?>

    <?php // echo $form->field($model, 'voucher_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
