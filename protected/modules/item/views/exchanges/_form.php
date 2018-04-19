<?php
/* @var $this ExchangesController */
/* @var $model Exchanges */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'exchanges-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app','are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'requestFrom'); ?>
		<?php echo $form->textField($model,'requestFrom'); ?>
		<?php echo $form->error($model,'requestFrom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requestTo'); ?>
		<?php echo $form->textField($model,'requestTo'); ?>
		<?php echo $form->error($model,'requestTo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mainProductId'); ?>
		<?php echo $form->textField($model,'mainProductId'); ?>
		<?php echo $form->error($model,'mainProductId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exchangeProductId'); ?>
		<?php echo $form->textField($model,'exchangeProductId'); ?>
		<?php echo $form->error($model,'exchangeProductId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->