<?php
/* @var $this ReportitemController */
/* @var $model Products */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Products', 'url'=>array('index')),
	array('label'=>'Manage Products', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('admin','Create Products'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>