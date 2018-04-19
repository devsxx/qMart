<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */
/* @var $form CActiveForm */
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Set Top').' '.Yii::t('admin','Currency'); ?></h1>
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
				<div class="panel-heading"><?php echo Yii::t('admin','Add').' '.Yii::t('admin','Priority'); ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">

							<div class="wide form">

							<?php $form=$this->beginWidget('CActiveForm', array(
							'enableAjaxValidation' => true,
                            'htmlOptions'=> array('onsubmit' => 'return showTop()'),

							)); ?>

								<div class="form-group">
									<select name="Sitesettings[priority][]" id="priority1"  class="btn">
										<option value="empty"><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>"<?php if($currency->id == $topFive[0]) echo "selected"; ?> ">
										<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority1Error"></div>
								</div>


								<div class="form-group">
									<select name="Sitesettings[priority][]" id="priority2" class="btn">
										<option value="empty"><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>"
										<?php if($currency->id == $topFive[1]) echo "selected"; ?>>
											<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority2Error"></div>
								</div>
								<div class="form-group">
									<select name="Sitesettings[priority][]" id="priority3"  class="btn">
										<option value="empty"><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>"
										<?php if($currency->id == $topFive[2]) echo "selected"; ?>>
											<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority3Error"></div>
								</div>
								<div class="form-group">
									<select name="Sitesettings[priority][]" id="priority4" class="btn">
										<option value="empty"><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>"
										<?php if($currency->id == $topFive[3]) echo "selected"; ?>>
											<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority4Error"></div>
								</div>
								<div class="form-group">
									<select name="Sitesettings[priority][]" id="priority5" class="btn">
										<option value="empty"><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>"
										<?php if($currency->id == $topFive[4]) echo "selected"; ?>>
											<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority5Error"></div>
								</div>
								<div class="btn-block">
								<?php echo CHtml::submitButton(Yii::t('admin','Set').' '.Yii::t('admin','Priority'),array('class' => 'btn btn-success')); ?>
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
