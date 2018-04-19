<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Help Pages'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Help Pages').' '.Yii::t('admin','List'); ?> </div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'helppages-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'itemsCssClass' => 'table table-striped table-bordered table-hover',
					'htmlOptions' => array('class' => 'table-responsive'),
					'columns'=>array(
						'id',
						'page',
						array(
							'class'=>'CButtonColumn',
							'header' => Yii::t('admin','Action'),
							'template'=>'{update}{view}{delete}',
							'buttons' => array(
								'delete' => array(
					            	'visible'=>'$data->id > 1',
								),
								'view' => array(
						            'visible'=>'false',
					        	),
								'update' => array(
						            'visible'=>'true',
					        	),
				        	),
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
