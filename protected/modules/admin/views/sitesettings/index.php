<?php
/* @var $this SitesettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sitesettings',
);

$this->menu=array(
	array('label'=>'Create Sitesettings', 'url'=>array('create')),
	array('label'=>'Manage Sitesettings', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('admin','Sitesettings');?></h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
