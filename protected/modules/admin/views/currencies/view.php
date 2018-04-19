<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','View').' '.Yii::t('admin','Currency'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Currency').' '.Yii::t('admin','Details'); ?></div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Currencies'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Currencies', 'url'=>array('index')),
	array('label'=>'Create Currencies', 'url'=>array('create')),
	array('label'=>'Update Currencies', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Currencies', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Currencies', 'url'=>array('admin')),
);
?>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'currency_name',
		'currency_shortcode',
         'currency_symbol',
	),
));
?>
