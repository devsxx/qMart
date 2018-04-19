<?php
/* @var $this HelppagesController */
/* @var $model Helppages */

$this->breadcrumbs=array(
	'Helppages'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Helppages', 'url'=>array('index')),
	array('label'=>'Create Helppages', 'url'=>array('create')),
	array('label'=>'Update Helppages', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Helppages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Helppages', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('admin','View Helppages #'); ?><?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'page',
		'pageContent',
	),
)); ?>
