<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
			<?php echo CHtml::link('<i class="fa fa-plus"></i> '.Yii::t('admin','Add').' '.Yii::t('admin','Product Conditions'),Yii::app()->createAbsoluteUrl('admin/productconditions/create'),array('class' => 'btn btn-success','style' => 'float:right;  margin-top:0px')); ?>

			<?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Product Conditions')?>
			</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php echo Yii::t('admin','Product Conditions').' '.Yii::t('admin','List')?>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'productconditions-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'columns'=>array(
				array('name' =>'id','filterHtmlOptions' => array('class' => 'small-input')),
				array('name' =>'condition','filterHtmlOptions' => array('class' => 'small-input')),
				array(
			'class'=>'CButtonColumn',
				'header' => Yii::t('admin','Actions'),
				'afterDelete'=>'function(link,success,data){ if(success) {$(".userinfo").html(data); setTimeout(function() { $(".userinfo").fadeOut(); },3000); } }',

				),
				),
				)); ?>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
