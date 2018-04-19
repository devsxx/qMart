<?php
/* @var $this ProductconditionsController */
/* @var $model Productconditions */

$this->breadcrumbs=array(
	'Productconditions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Productconditions', 'url'=>array('index')),
	array('label'=>'Create Productconditions', 'url'=>array('create')),
	array('label'=>'View Productconditions', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Productconditions', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('admin','Update Productconditions'); ?> <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>