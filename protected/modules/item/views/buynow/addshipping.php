<?php
/* @var $this TempaddressesController */
/* @var $model Tempaddresses */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'tempaddresses-addshipping-form',
	'action' => Yii::app()->createAbsoluteUrl('item/buynow/addshipping'),
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// See class documentation of CActiveForm for details on this,
// you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	    'clientOptions' => array(
	         'validateOnSubmit'=>true,
	         'validateOnChange'=>true,
),
'htmlOptions' => array('onsubmit' => 'return validaddship()'),
)); ?>

	<p class="note">
	<?php echo Yii::t('admin' , 'Fields with'); ?>
		<span class="required"> * </span>
		<?php echo Yii::t('admin', 'are required.'); ?>
	</p>



	<div class="form-group">
	<?php echo $form->labelEx($model,'nickname'); ?>
	<?php echo $form->textField($model,'nickname',array('class' => 'form-control','onkeypress' => 'return validateNumeric(this,event)')); ?>
	<?php echo $form->error($model,'nickname'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('class' => 'form-control','onkeypress' => 'return validateNumeric(this,event)')); ?>
	<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'country'); ?>
	<?php echo $form->dropDownList($model, 'country', $countriesList, array('prompt'=>'Select Country','class' => 'form-control','onkeypress' => 'return validateNumeric(this,event)')); ?>
	<?php //echo $form->textField($model,'country'); ?>
	<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'address1'); ?>
	<?php echo $form->textField($model,'address1',array('class' => 'form-control','onkeypress' => 'return IsAlphaNumeric(event)')); ?>
	<?php echo $form->error($model,'address1'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'address2'); ?>
	<?php echo $form->textField($model,'address2',array('class' => 'form-control','onkeypress' => 'return IsAlphaNumeric(event)')); ?>
	<?php echo $form->error($model,'address2'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'city'); ?>
	<?php echo $form->textField($model,'city',array('class' => 'form-control','onkeypress' => 'return validateNumeric(this,event)')); ?>
	<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'state'); ?>
	<?php echo $form->textField($model,'state',array('class' => 'form-control','onkeypress' => 'return validateNumeric(this,event)')); ?>
	<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'zipcode'); ?>
	<?php echo $form->textField($model,'zipcode',array('class' => 'form-control','onkeypress' => 'return IsAlphaNumeric(event)')); ?>
	<?php echo $form->error($model,'zipcode'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'phone'); ?>
	<?php echo $form->textField($model,'phone',array('class' => 'form-control','onkeypress' => 'return isNumber(event)')); ?>
	<?php echo $form->error($model,'phone'); ?>
	</div>


	<div class="row buttons" style="text-align: center;">
	<?php echo CHtml::submitButton(Yii::t('app','Save'),array('class' => 'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- form -->
</div>
