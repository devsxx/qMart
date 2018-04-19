<?php
/* @var $this ExchangesController */
/* @var $model Exchanges */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requestFrom'); ?>
		<?php echo $form->textField($model,'requestFrom'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requestTo'); ?>
		<?php echo $form->textField($model,'requestTo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mainProductId'); ?>
		<?php echo $form->textField($model,'mainProductId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exchangeProductId'); ?>
		<?php echo $form->textField($model,'exchangeProductId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->