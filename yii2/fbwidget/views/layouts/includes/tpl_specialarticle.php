<?php  if($ShowCaption==1) echo '<div class="module-header">'.$Caption.'</div>'; ?>
<div class="module-body">
<?php

$criteria = new CDbCriteria;
$criteria->condition="Limits != ''";
$criteria->order="`Order`";
$rows = Article::model()->findAll($criteria);
echo '<ul>';
foreach($rows as $row)
echo  '<li>'.CHtml::link($row->Name, Yii::app()->createUrl('article/show', array('id' => $row->ID))).'</li>';
echo '</ul>';
?>
</div>