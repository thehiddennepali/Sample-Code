<?php

    
$this->title = 'Orders';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Orders'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Create';

?>

    <h1><?= Yii::t('basicfield', 'Create')?> <?=Yii::t('basicfield','Orders')?></h1>

<?php echo $this->render('_form', array('model' => $model)); ?>