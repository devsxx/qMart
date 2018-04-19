<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Payment').' '.Yii::t('admin','Settings'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Paypal').' '.Yii::t('admin','Settings'); ?></div>
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
							)); ?>

								<p class="note">
								<?php echo Yii::t('admin' , 'Fields with'); ?>
									<span class="required"> * </span>
									<?php echo Yii::t('admin', 'are required.'); ?>
								</p>



								<?php echo $form->labelEx($model,'paypalType'); ?>
								<div class="radio radio-custom">
								
									<br>

									<?php echo $form->radioButtonList($model,'paypalType',array('1'=>'Live','2'=>'Sandbox'),array('value' => $model->paypalType,'style'=>'display:inline')); ?>
									<?php echo $form->error($model,'paypalType'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'paypalEmailId'); ?>
								<?php echo $form->textField($model,'paypalEmailId',array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'paypalEmailId'); ?>
								</div>

								<!--div class="form-group">
								<?php echo $form->labelEx($model,'paypalApiUserId'); ?>
								<?php echo $form->textField($model,'paypalApiUserId', array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'paypalApiUserId', array('style'=>'color:red')); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'paypalApiPassword'); ?>
								<?php echo $form->textField($model,'paypalApiPassword', array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'paypalApiPassword'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'paypalApiSignature'); ?>
								<?php echo $form->textField($model,'paypalApiSignature', array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'paypalApiSignature'); ?>
								</div>
								<div class="form-group">
								<?php echo $form->labelEx($model,'paypalAppId'); ?>
								<?php echo $form->textField($model,'paypalAppId', array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'paypalAppId', array('style'=>'color:red')); ?>
								</div>
								
								<div class="form-group">
									<?php echo $form->labelEx($model,'paypalCcStatus'); ?>
									<?php echo $form->checkBox($model,'paypalCcStatus', array('value'=>1, 'uncheckValue'=>0)); ?>
								</div>
							
								<div class="form-group">
									<?php echo $form->labelEx($model,'paypalCcClientId'); ?>
									<?php echo $form->textField($model,'paypalCcClientId', array('class'=>'form-control')); ?>
									<?php echo $form->error($model,'paypalCcClientId', array('style'=>'color:red')); ?>
								</div>
							
								<div class="form-group">
									<?php echo $form->labelEx($model,'paypalCcSecret'); ?>
									<?php echo $form->textField($model,'paypalCcSecret', array('class'=>'form-control')); ?>
									<?php echo $form->error($model,'paypalCcSecret', array('style'=>'color:red')); ?>
								</div-->

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
