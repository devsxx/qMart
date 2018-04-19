<?php
/* @var $this NotificationsController */
/* @var $model Notifications */
/* @var $form CActiveForm */
?>



<h3>Email Notifications</h3>
<hr>
<div id="page-container">


	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notifications-notifications-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
	)); ?>


		<div class="form-group">
		<?php echo $form->checkBox($model,'live'); ?>
			&nbsp;<b> <?php echo Yii::t('app','When my HappySale is Live'); ?></b>
			<?php echo $form->error($model,'live'); ?>
		</div>

		<div class="form-group">
		<?php echo $form->checkBox($model,'comment'); ?>
			&nbsp;<b> <?php echo Yii::t('app','When someone comments on my HappySale'); ?></b>
			<?php echo $form->error($model,'comment'); ?>
		</div>

		<div class="form-group">
		<?php echo $form->checkBox($model,'message'); ?>
			&nbsp; <b> <?php echo Yii::t('app','When someone message you on HappySale'); ?></b>
			<?php echo $form->error($model,'message'); ?>
		</div>

		<div class="form-group">
		<?php echo $form->checkBox($model,'offer'); ?>
			&nbsp; <b> <?php echo Yii::t('app','When you receive offer on HappySale'); ?></b>
			<?php echo $form->error($model,'offer'); ?>
		</div>


		<div class="form-group">
		<?php echo CHtml::submitButton('Save',array('class' => 'btn btn-success')); ?>
		</div>

		<?php $this->endWidget(); ?>

	</div>
	<!-- form -->
</div>

