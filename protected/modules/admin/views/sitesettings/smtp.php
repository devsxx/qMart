<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
			<?php echo Yii::t('admin','Email').' '.Yii::t('admin','Settings'); ?>
			</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php echo Yii::t('admin','SMTP').' '.Yii::t('admin','Settings'); ?>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">

						<?php
						/* @var $this SitesettingsController */
						/* @var $model Sitesettings */
						/* @var $form CActiveForm */
						?>

							<div class="form">

							<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sitesettings-form',
							// Please note: When you enable ajax validation, make sure the corresponding
							// controller action is handling ajax validation correctly.
							// There is a call to performAjaxValidation() commented in generated controller code.
							// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	    'clientOptions' => array(
	         'validateOnSubmit'=>true,
	         'validateOnChange'=>true,
							)
							)); ?>

								<p class="note">
								<?php echo Yii::t('admin' , 'Fields with'); ?>
									<span class="required"> * </span>
									<?php echo Yii::t('admin', 'are required.'); ?>
								</p>

								<div class="checkbox checkbox-custom">
								
								<?php echo $form->checkBox($model,'smtpEnable', array('value'=>1, 'uncheckValue'=>0)); ?>
								<?php echo $form->labelEx($model,'smtpEnable'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'smtpPort'); ?>
								<?php echo $form->textField($model,'smtpPort',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'smtpPort'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'smtpHost'); ?>
								<?php echo $form->textField($model,'smtpHost',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'smtpHost'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'smtpEmail'); ?>
								<?php echo $form->textField($model,'smtpEmail',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'smtpEmail'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'smtpPassword'); ?>
								<?php echo $form->passwordField($model,'smtpPassword',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'smtpPassword'); ?>
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
