<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Report Items'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Report Items').' '.Yii::t('admin','List'); ?> </div>
				<!-- /.panel-heading -->
				<div class="panel-body">

				<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grids',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate'=>"function(){jQuery('#".CHtml::activeId($model, 'createdDate')."').datepicker({dateFormat : 'dd-mm-yy'})}",
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	 'htmlOptions' => array('class' => 'table-responsive'),
	'columns'=>array(

				array('name' =>'productId','filterHtmlOptions' => array('class' => 'small-input')),
				array('name' =>'name','value' => 'html_entity_decode($data->name)','htmlOptions' => array('style' => 'width:336px;word-break: break-all;')),
				array('name' =>'price','filterHtmlOptions' => array('class' => 'small-input')),

				array('name' =>'reportCount','filterHtmlOptions' => array('style' => 'width:50px')),
				array('name'=>'createdDate','value' => '$data->modDate','filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array('model'=>$model, 'attribute'=>'createdDate','options'=> array('dateFormat'=>'dd-mm-yy')), true),'filterHtmlOptions' => array('class' => 'small-input')),
				array(
			'class'=>'CButtonColumn', 
			'header' => Yii::t('admin','Action'),
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

<<style>
.update{ display: none;}

</style>
