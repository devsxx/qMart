<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */
/* @var $form CActiveForm */
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Set Top Currency'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>

	<div class="row">
		<div class="col-lg-12">
		<?php
		$flashMessages = Yii::app()->user->getFlashes();
		if ($flashMessages) {
			echo '<ul class="flashes">';
			foreach($flashMessages as $key => $message) {
				echo '<div class="flash-' . $key . '">' . $message . "<div class='alert-close pull-right'>X</div></div>";
			}
			echo '</ul>';
		}
		?>
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Add Priority'); ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">

							<div class="wide form">

							<?php $form=$this->beginWidget('CActiveForm', array(
'htmlOptions' => array('onsubmit' => 'return showTop()'),
							)); ?>

								<div class="form-group">
									<select name="Currencies[priority][]" id="priority1">
										<option><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>">
										<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="form-group">
									<select name="Currencies[priority][]"  id="priority2">
										<option><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>">
										<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<select name="Currencies[priority][]"  id="priority3">
										<option><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>">
										<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<select name="Currencies[priority][]"  id="priority4">
										<option><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>">
										<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<select name="Currencies[priority][]"  id="priority5">
										<option><?php echo Yii::t('admin','Select Currency'); ?></option>
										<?php foreach($currencies as $currency): ?>
										<option value="<?php echo $currency->id; ?>">
										<?php echo $currency->currency_name.' - '.$currency->currency_shortcode.' - '.$currency->currency_symbol; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>



								<div class="btn-block">
								<?php echo CHtml::submitButton('Set Priority',array('class' => 'btn btn-primary')); ?>
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


