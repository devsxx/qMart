<?php
/* @var $this PromotionController */
/* @var $model Promotions */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promotions-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('admin','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('admin','are required.'); ?></p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('maxlength'=>'20','class'=>'form-control')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'days'); ?>
		<?php echo $form->textField($model,'days',array('maxlength'=>'4','class'=>'form-control')); ?>
		<?php echo $form->error($model,'days'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('placeholder'=>$placeholders,'maxlength'=>'6','class'=>'form-control')); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
