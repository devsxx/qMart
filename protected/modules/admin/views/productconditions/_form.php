<?php
/* @var $this ProductconditionsController */
/* @var $model Productconditions */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productconditions-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('admin' , 'Fields with'); ?>
		<span class="required"> * </span>
		<?php echo Yii::t('admin', 'are required.'); ?></p>


	<div class="form-group">
		<?php echo $form->labelEx($model,'condition'); ?>
		<?php echo $form->textField($model,'condition',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'condition'); ?>
	</div>

	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Create') : Yii::t('admin','Save'),array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->