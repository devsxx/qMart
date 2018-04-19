<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
			<?php echo Yii::t('admin','View').' '.Yii::t('admin','Product Conditions'); ?>
			</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php echo Yii::t('admin','Product Conditions').' '.Yii::t('admin','Details'); ?>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'condition',
	),
)); ?>