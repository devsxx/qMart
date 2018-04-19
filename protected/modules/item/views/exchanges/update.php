<?php
/* @var $this ExchangesController */
/* @var $model Exchanges */

$this->breadcrumbs=array(
	'Exchanges'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Exchanges', 'url'=>array('index')),
	array('label'=>'Create Exchanges', 'url'=>array('create')),
	array('label'=>'View Exchanges', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Exchanges', 'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','Update Exchanges'); ?><?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>