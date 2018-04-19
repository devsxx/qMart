<?php
/* @var $this PromotionController */
/* @var $model Promotions */
?>


<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','View').' '.Yii::t('admin','Promotion'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Promotion').' '.Yii::t('admin','Details'); ?></div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Promotions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Promotions', 'url'=>array('index')),
	array('label'=>'Create Promotions', 'url'=>array('create')),
	array('label'=>'Update Promotions', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Promotions', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Promotions', 'url'=>array('admin')),
);
?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'days',
		'price',
	),
));
?>
