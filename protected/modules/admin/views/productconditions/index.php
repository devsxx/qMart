<?php
/* @var $this ProductconditionsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Productconditions',
);

$this->menu=array(
	array('label'=>'Create Productconditions', 'url'=>array('create')),
	array('label'=>'Manage Productconditions', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('admin','Productconditions'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
