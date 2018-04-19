<?php
/* @var $this CategoriesController */
/* @var $model Category */
/* @var $form CActiveForm */
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Urgent').' '.Yii::t('admin','Promotion'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<?php
	/* $flashMessages = Yii::app()->user->getFlashes();
	if ($flashMessages) {
		echo '<ul class="flashes">';
		foreach($flashMessages as $key => $message) {
			echo '<div class="flash-' . $key . '">' . $message . "<div class='alert-close pull-right'>X</div></div>";
		}
		echo '</ul>';
	} */
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Set').' '.Yii::t('admin','Price'); ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">

							<div class="wide form">

							<?php $form=$this->beginWidget('CActiveForm', array(
							'enableAjaxValidation' => true,
                            'htmlOptions'=> array('onsubmit' => 'return urgentpromotion()'),

							)); ?>
							
							<?php $placeholder = explode("-",$settings->promotionCurrency);?>
								<div class="form-group">
								<?php echo $promotionCurrency[0]; ?>
									<input type="text" class="form-control" maxlength="6" name="urgentprice" placeholder="<?php echo $placeholder[1];?>"id="urgentprice" value="<?php echo $settings->urgentPrice;?>"> 
									
									<div class="errorMessage" id="urgentpriceError"></div>
								</div>
								<div id="loading_img" style="display:none;text-align:center;">
								<img src="<?php echo Yii::app()->createAbsoluteUrl('images/loader.gif'); ?>" alt="Loading..." style="width: 30px; height: 30px;maergin-left: 88px;">
								</div>
							
							
							
						
								
								<div class="btn-block">
								<?php echo CHtml::submitButton(Yii::t('admin','Set').' '.Yii::t('admin','Price'),array('class' => 'btn btn-success')); ?>
								</div>
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

	<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
<script>

	
</script>
