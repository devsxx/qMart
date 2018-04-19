<?php
/* @var $this ExchangesController */
/* @var $model Exchanges */

$this->breadcrumbs=array(
	'Exchanges'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Exchanges', 'url'=>array('index')),
	array('label'=>'Manage Exchanges', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','Create Exchanges'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>