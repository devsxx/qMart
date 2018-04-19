<?php
/* @var $this CurrenciesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Currencies',
);

$this->menu=array(
	array('label'=>'Create Currencies', 'url'=>array('create')),
	array('label'=>'Manage Currencies', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('admin','Currencies'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
