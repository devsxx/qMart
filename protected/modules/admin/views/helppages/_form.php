<?php
/* @var $this HelppagesController */
/* @var $model Helppages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'helppages-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange' => false,
		),
     'htmlOptions' => array('enctype' => 'multipart/form-data','onsubmit'=> 'return validateHelppage()'),
)); ?>

	<p class="note"><?php echo Yii::t('admin','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('admin','are required.'); ?></p>

	<?php if($model->id == 1) echo '<p class="note"><span class="required">'.Yii::t('admin','This page will be linked in the Email Terms & Policy Link').'.</span></p>'; ?>
	
	<?php //echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'page'); ?>
		<?php echo $form->textField($model,'page',array('class'=>'form-control','size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'page'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'pageContent'); ?>
		<?php //echo $form->textArea($model,'pageContent',array('rows'=>6, 'cols'=>60)); ?>
		<?php $this->widget('application.extensions.extckeditor.ExtCKEditor', array(
			'model'=>$model,
			'attribute'=>'pageContent', // model atribute
			'language'=>Yii::app()->language,
			'editorTemplate'=>'full', // Toolbar settings (full, basic, advanced)
			'htmlOptions' => array(
			'class' => 'ckeditor form-control',
			'id' => 'Helppages_pageContent',
			),
			)); ?>
		<?php echo $form->error($model,'pageContent'); ?>
	</div>

	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Create') : Yii::t('admin','Save'),array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->