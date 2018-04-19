<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Admin Create Products'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Create Product'); ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
						<?php $this->renderPartial('_form', array('model'=>$model, 'parentCategory'=>$parentCategory,'subCategory'=>$subCategory,
				'photos' => $photos, 'shippingTime' => $shippingTime, 'countryModel' => $countryModel, 
				'topCurs' => $topCurs,'currencies' => $currencies)); ?>
						</div>
					</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->
