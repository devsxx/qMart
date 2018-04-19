<?php
/* @var $this TempaddressesController */
/* @var $model Tempaddresses */
/* @var $form CActiveForm */
?>

<div id="page-container" class="add-shipping">

	<h1><i class="fa fa-plus-square-o"></i> <?php echo Yii::t('app','Add Shipping'); ?>
	<a type="button" href="<?php echo Yii::app()->createAbsoluteUrl('shippingaddress'); ?>"
			class="btn-choose-option btn-done pull-right" id="btn-doneid" style="text-decoration:none;"> <i
			class="fa fa-arrow-left"> </i>
			<?php echo Yii::t('app','Back'); ?>
		</a>
		</h1>

	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'tempaddresses-addshipping-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
 //   'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>false,
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
		<?php echo $form->textField($model,'nickname',array('class' => 'form-control nickname','onkeypress' => 'return validateNumeric(this,event)')); ?>
		<?php echo $form->error($model,'nickname'); ?>
		</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class' => 'form-control','onkeypress' => 'return validateNumeric(this,event)')); ?>
		<?php echo $form->error($model,'name'); ?>
		</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->dropDownList($model, 'country', $countriesList, array('prompt'=>Yii::t('app','Select Country'),'class' => 'form-control')); ?>
		<?php //echo $form->textField($model,'country'); ?>
		<?php echo $form->error($model,'country'); ?>
		</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'address1'); ?>
		<?php echo $form->textField($model,'address1',array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'address1'); ?>
		</div>

		<div class="form-group">
		<?php echo $form->labelEx($model,'address2'); ?>
		<?php echo $form->textField($model,'address2',array('class' => 'form-control')); ?>
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
		<?php echo $form->textField($model,'phone',array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'phone'); ?>
		</div>


		<div class="row buttons"  style="text-align:center">
		<?php echo CHtml::submitButton(Yii::t('admin','Save'),array('class' => 'btn btn-lg btn-success')); ?>
		</div>

		<?php $this->endWidget(); ?>

	</div>
	<!-- form -->
</div>
<script>
$(function() {
    $('.nickname').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});
</script>