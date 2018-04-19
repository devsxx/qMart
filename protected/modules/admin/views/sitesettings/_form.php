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
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

	<?php //echo $form->errorSummary($model); ?>

	<?php if ($scenario == 'emailsettings'){ ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'smtpEmail'); ?>
		<?php echo $form->textField($model,'smtpEmail',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'smtpEmail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'smtpPassword'); ?>
		<?php echo $form->textField($model,'smtpPassword',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'smtpPassword'); ?>
	</div>
	
	<?php }elseif($scenario == 'sociallogin'){ ?>
	
	<div class="checkbox checkbox-custom">
		<?php echo $form->checkBox($model,'facebookstatus', array('value'=>1, 'uncheckValue'=>0)); ?>
		<?php echo $form->labelEx($model,'facebookstatus'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'facebookappid'); ?>
		<?php echo $form->textField($model,'facebookappid', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'facebookappid', array('style'=>'color:red')); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'facebooksecret'); ?>
		<?php echo $form->textField($model,'facebooksecret', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'facebooksecret', array('style'=>'color:red')); ?>
	</div>

	<div class="checkbox checkbox-custom">
		
		<?php echo $form->checkBox($model,'twitterstatus', array('value'=>1, 'uncheckValue'=>0)); ?>
		<?php echo $form->labelEx($model,'twitterstatus'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'twitterappid'); ?>
		<?php echo $form->textField($model,'twitterappid', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'twitterappid'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'twittersecret'); ?>
		<?php echo $form->textField($model,'twittersecret', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'twittersecret'); ?>
	</div>

	<div class="checkbox checkbox-custom">
		
		<?php echo $form->checkBox($model,'googlestatus', array('value'=>1, 'uncheckValue'=>0)); ?>
		<?php echo $form->labelEx($model,'googlestatus'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'googleappid'); ?>
		<?php echo $form->textField($model,'googleappid', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'googleappid'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'googlesecret'); ?>
		<?php echo $form->textField($model,'googlesecret', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'googlesecret'); ?>
	</div>

	<?php } ?>
	
	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Save') : Yii::t('admin','Save'),array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->