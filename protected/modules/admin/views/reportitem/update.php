<?php
/* @var $this ReportitemController */
/* @var $model Products */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->name=>array('view','id'=>$model->productId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Products', 'url'=>array('index')),
	array('label'=>'Create Products', 'url'=>array('create')),
	array('label'=>'View Products', 'url'=>array('view', 'id'=>$model->productId)),
	array('label'=>'Manage Products', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('admin','Update Products'); ?> <?php echo $model->productId; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>