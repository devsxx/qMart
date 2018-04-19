<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Categories')?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Categories').' '.Yii::t('admin','List')?></div>
				<!-- /.panel-heading -->
				<div class="panel-body">


				<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate'=>"function(){jQuery('#".CHtml::activeId($model, 'createdDate')."').datepicker({dateFormat : 'dd-mm-yy'})}",
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'columns'=>array(
				array('name' =>'categoryId','filterHtmlOptions' => array('class' => 'small-input')),
				array('name'=>'name','filterHtmlOptions' => array('class' => 'small-input')),
				array('name'=>'createdDate','value' => '$data->modDate','filterHtmlOptions' => array('class' => 'small-input'),'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array('model'=>$model, 'attribute'=>'createdDate','options'=> array('dateFormat'=>'dd-mm-yy')), true),),
				array('name'=>'parentCategory','value' => '$data->catName','filter'=>false,'filterHtmlOptions' => array('class' => 'small-input')),
				array(
			'class'=>'CButtonColumn',
				'header' => Yii::t('admin','Actions'),
				'afterDelete'=>'function(link,success,data){ if(success) {  $(".userinfo").show(); $(".userinfo").html(data); setTimeout(function() { $(".userinfo").fadeOut(); },3000); } }',
				
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
