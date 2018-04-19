<?php
/* @var $this ReportitemController */
/* @var $model Products */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'products-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('admin','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('admin','are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'userId'); ?>
		<?php echo $form->textField($model,'userId'); ?>
		<?php echo $form->error($model,'userId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->textField($model,'category'); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subCategory'); ?>
		<?php echo $form->textField($model,'subCategory'); ?>
		<?php echo $form->error($model,'subCategory'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency'); ?>
		<?php echo $form->textField($model,'currency',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'currency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sizeOptions'); ?>
		<?php echo $form->textArea($model,'sizeOptions',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'sizeOptions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'productCondition'); ?>
		<?php echo $form->textField($model,'productCondition',array('size'=>13,'maxlength'=>13)); ?>
		<?php echo $form->error($model,'productCondition'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'createdDate'); ?>
		<?php echo $form->textField($model,'createdDate'); ?>
		<?php echo $form->error($model,'createdDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'likeCount'); ?>
		<?php echo $form->textField($model,'likeCount'); ?>
		<?php echo $form->error($model,'likeCount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'commentCount'); ?>
		<?php echo $form->textField($model,'commentCount'); ?>
		<?php echo $form->error($model,'commentCount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'chatAndBuy'); ?>
		<?php echo $form->textField($model,'chatAndBuy'); ?>
		<?php echo $form->error($model,'chatAndBuy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exchangeToBuy'); ?>
		<?php echo $form->textField($model,'exchangeToBuy'); ?>
		<?php echo $form->error($model,'exchangeToBuy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instantBuy'); ?>
		<?php echo $form->textField($model,'instantBuy'); ?>
		<?php echo $form->error($model,'instantBuy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paypalid'); ?>
		<?php echo $form->textField($model,'paypalid',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'paypalid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shippingTime'); ?>
		<?php echo $form->textField($model,'shippingTime',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'shippingTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'latitude'); ?>
		<?php echo $form->textField($model,'latitude'); ?>
		<?php echo $form->error($model,'latitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'longitude'); ?>
		<?php echo $form->textField($model,'longitude'); ?>
		<?php echo $form->error($model,'longitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'likes'); ?>
		<?php echo $form->textField($model,'likes'); ?>
		<?php echo $form->error($model,'likes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'views'); ?>
		<?php echo $form->textField($model,'views'); ?>
		<?php echo $form->error($model,'views'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'soldItem'); ?>
		<?php echo $form->textField($model,'soldItem'); ?>
		<?php echo $form->error($model,'soldItem'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reports'); ?>
		<?php echo $form->textField($model,'reports',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'reports'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->