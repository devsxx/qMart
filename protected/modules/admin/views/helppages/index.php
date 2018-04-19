<?php
/* @var $this HelppagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Helppages',
);

$this->menu=array(
	array('label'=>'Create Helppages', 'url'=>array('create')),
	array('label'=>'Manage Helppages', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('admin','Helppages'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
