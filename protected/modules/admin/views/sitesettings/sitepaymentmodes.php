<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Site Payment Modes').' '.Yii::t('admin','Settings'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Transaction Modes and Configurations'); ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">

						<?php
						/* @var $this SitesettingsController */
						/* @var $model Sitesettings */
						/* @var $form CActiveForm */
						?>

							<div class="form">

							<?php
							$form=$this->beginWidget('CActiveForm', array(
	'id'=>'sitesettings-form',
							// Please note: When you enable ajax validation, make sure the corresponding
							// controller action is handling ajax validation correctly.
							// There is a call to performAjaxValidation() commented in generated controller code.
							// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange' => false,
		),
							)); ?>






								<div class="form-group">
								<?php echo $form->labelEx($model,'Exchange Transaction Mode'); ?>
									<br>
									<div class="radio radio-custom">
										<?php echo $form->radioButtonList($model,'exchangePaymentMode',array('0'=>'Disable','1'=>'Enable'),
												array('value' => $model->exchangePaymentMode,'style'=>'display:inline')); ?>
									</div>
									<?php echo $form->error($model,'exchangePaymentMode'); ?>
								</div>

								<div class="form-group">
									<?php echo $form->labelEx($model,'Buynow Transaction Mode'); ?>
									<br>
									<div class="radio radio-custom">
										<?php echo $form->radioButtonList($model,'buynowPaymentMode',array('0'=>'Disable','1'=>'Enable'),
												array('value' => $model->buynowPaymentMode,'style'=>'display:inline')); ?>
									</div>
									<?php echo $form->error($model,'buynowPaymentMode'); ?>
								</div>
								<input type="hidden" name="Sitesettings[scrowPaymentMode]" value="1">
								<!--div class="form-group">
									<?php echo $form->labelEx($model,'S-crow System'); ?>
									<br>
									<div class="radio radio-custom">
										<?php echo $form->radioButtonList($model,'scrowPaymentMode',array('0'=>'Disable','1'=>'Enable'),
												array('value' => $model->scrowPaymentMode,'style'=>'display:inline')); ?>
									</div>
									<?php echo $form->error($model,'scrowPaymentMode'); ?>
								</div-->

								<div class="form-group">
								<?php echo $form->labelEx($model,'cancelEnableStatus'); ?>
								<?php
								echo '<select name="Sitesettings[cancelEnableStatus]">';
								if($model->cancelEnableStatus == "processing")
								{
									echo '<option value="processing" selected>Processing</option>
										  <option value="shipped">Shipped</option>';
								}
								else
								{
									echo '<option value="processing">Processing</option>
										  <option value="shipped" selected>Shipped</option>';									
								}
								echo '</select>';
								?>
								<?php echo $form->error($model,'cancelEnableStatus'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'sellerClaimEnableDays'); ?>
								<?php echo $form->textField($model,'sellerClimbEnableDays', array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'sellerClimbEnableDays', array('style'=>'color:red')); ?>
								</div>

								<div class="form-group">
								<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Save') : Yii::t('admin','Save'),array('class' => 'btn btn-success')); ?>
								</div>

								<?php $this->endWidget(); ?>

							</div>
							<!-- form -->
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
