<?php

$this->context->menu = false;

$this->title = 'Orders';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Orders'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

    <h1><?= Yii::t('basicfield', 'Update')?> <?=Yii::t('basicfield','Order')?> <?php echo $model->id; ?></h1>

<?php echo $this->render('_form', array('model' => $model)); ?>