<?php
/* @var $this SitesettingsController */
/* @var $model Sitesettings */

$this->breadcrumbs=array(
	'Sitesettings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Sitesettings', 'url'=>array('index')),
	array('label'=>'Manage Sitesettings', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('admin','Create Sitesettings'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>