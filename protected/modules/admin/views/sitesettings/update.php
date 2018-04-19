<?php
/* @var $this SitesettingsController */
/* @var $model Sitesettings */

$this->breadcrumbs=array(
	'Sitesettings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Sitesettings', 'url'=>array('index')),
	array('label'=>'Create Sitesettings', 'url'=>array('create')),
	array('label'=>'View Sitesettings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Sitesettings', 'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('admin','Update Sitesettings'); ?><?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>