<?php
/* @var $this SitesettingsController */
/* @var $model Sitesettings */
/* @var $form CActiveForm */
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Footer Settings'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo Yii::t('admin','Footer Settings'); ?> 
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-7">
	                         <div class="form">
							<?php $form=$this->beginWidget('CActiveForm', array(
								'id'=>'sitesettings-form',
								// Please note: When you enable ajax validation, make sure the corresponding
								// controller action is handling ajax validation correctly.
								// There is a call to performAjaxValidation() commented in generated controller code.
								// See class documentation of CActiveForm for details on this.
								'enableAjaxValidation'=>true,
							)); ?>

								<div class="form-group">
								<?php echo $form->labelEx($model,'facebookFooterLink'); ?>
								<?php echo $form->textField($model,'facebookFooterLink',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'facebookFooterLink'); ?>
								</div>
								<div class="form-group">
								<?php echo $form->labelEx($model,'googleFooterLink'); ?>
								<?php echo $form->textField($model,'googleFooterLink',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'googleFooterLink'); ?>
								</div>
								<div class="form-group">
								<?php echo $form->labelEx($model,'twitterFooterLink'); ?>
								<?php echo $form->textField($model,'twitterFooterLink',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'twitterFooterLink'); ?>
								</div>
								<div class="form-group">
								<?php echo $form->labelEx($model,'androidFooterLink'); ?>
								<?php echo $form->textField($model,'androidFooterLink',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'androidFooterLink'); ?>
								</div>
								<div class="form-group">
								<?php echo $form->labelEx($model,'iosFooterLink'); ?>
								<?php echo $form->textField($model,'iosFooterLink',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'iosFooterLink'); ?>
								</div>
								<div class="form-group">
								<?php echo $form->labelEx($model,'footerCopyRightsDetails'); ?>
								<?php echo $form->textField($model,'footerCopyRightsDetails',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'footerCopyRightsDetails'); ?>
								</div>
								<div class="form-group">
									<?php echo $form->labelEx($model,'tracking_code'); ?>
									<?php echo $form->textArea($model,'tracking_code',array('rows'=>6, 'cols'=>60)); ?>
									<?php echo $form->error($model,'tracking_code'); ?>
								</div>
								<div class="form-group">
								<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Save') : Yii::t('admin','Update'), 
										array('style'=>"height:34px;",'class' => 'btn btn-success')); ?>
								</div>
							
								<?php $this->endWidget(); ?>
							
							</div>
							<!-- form -->
						</div>
					</div><!-- /.row (nested) -->
				</div><!-- /.panel-body -->
			</div><!-- /.panel -->
		</div><!-- /.col-lg-12 -->
	</div><!-- /.row -->
</div><!-- /#page-wrapper -->

<style>
.password-input input {
	height: 34px;
}
</style>
