<?php
/* @var $this ReportitemController */
/* @var $model Products */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'productId'); ?>
		<?php echo $form->textField($model,'productId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userId'); ?>
		<?php echo $form->textField($model,'userId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'category'); ?>
		<?php echo $form->textField($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subCategory'); ?>
		<?php echo $form->textField($model,'subCategory'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency'); ?>
		<?php echo $form->textField($model,'currency',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sizeOptions'); ?>
		<?php echo $form->textArea($model,'sizeOptions',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'productCondition'); ?>
		<?php echo $form->textField($model,'productCondition',array('size'=>13,'maxlength'=>13)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'createdDate'); ?>
		<?php echo $form->textField($model,'createdDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'likeCount'); ?>
		<?php echo $form->textField($model,'likeCount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'commentCount'); ?>
		<?php echo $form->textField($model,'commentCount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chatAndBuy'); ?>
		<?php echo $form->textField($model,'chatAndBuy'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exchangeToBuy'); ?>
		<?php echo $form->textField($model,'exchangeToBuy'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instantBuy'); ?>
		<?php echo $form->textField($model,'instantBuy'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'paypalid'); ?>
		<?php echo $form->textField($model,'paypalid',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shippingTime'); ?>
		<?php echo $form->textField($model,'shippingTime',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'latitude'); ?>
		<?php echo $form->textField($model,'latitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'longitude'); ?>
		<?php echo $form->textField($model,'longitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'likes'); ?>
		<?php echo $form->textField($model,'likes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'views'); ?>
		<?php echo $form->textField($model,'views'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'soldItem'); ?>
		<?php echo $form->textField($model,'soldItem'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reports'); ?>
		<?php echo $form->textField($model,'reports',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->