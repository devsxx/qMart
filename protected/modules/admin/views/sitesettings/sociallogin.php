<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php  echo Yii::t('admin','Site').' '.Yii::t('admin','Settings'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					 <?php  echo Yii::t('admin','Social Login').' '.Yii::t('admin','Details'); ?> 
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
	                         <?php $this->renderPartial('_form', array('model'=>$model,'scenario'=>$scenario)); ?>
						</div>
					</div><!-- /.row (nested) -->
				</div><!-- /.panel-body -->
			</div><!-- /.panel -->
		</div><!-- /.col-lg-12 -->
	</div><!-- /.row -->
</div><!-- /#page-wrapper -->