<?php
/* @var $this ExchangesController */
/* @var $model Exchanges */

$this->breadcrumbs=array(
	'Exchanges'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Exchanges', 'url'=>array('index')),
	array('label'=>'Create Exchanges', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#exchanges-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('admin','Manage Exchanges'); ?></h1>

<p>
<?php echo Yii::t('admin','You may optionally enter a comparison operator'); ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
<?php echo Yii::t('admin','or'); ?> <b>=</b>) <?php echo Yii::t('admin','at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'exchanges-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'requestFrom',
		'requestTo',
		'mainProductId',
		'exchangeProductId',
		'status',
		/*
		'date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
