<?php
/* @var $this UserController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange' => false,
		),
//'htmlOptions' => array('onsubmit'=> 'return adminsignform()'),
)); ?>

	<p class="note">
		<?php echo Yii::t('admin' , 'Fields with'); ?><span class="required"> * </span><?php echo Yii::t('admin', 'are required.'); ?> 
	</p>

	<?php //echo $form->errorSummary($model); ?>
	<div class="form-group">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('class' => 'form-control','onkeypress'=>'return IsAlphaNumeric(event)')); ?>
	<?php echo $form->error($model,'name'); ?>
	</div>
	
	<div class="form-group">
	<?php echo $form->labelEx($model,'username'); ?>
	<?php echo $form->textField($model,'username',array('class' => 'form-control','onkeypress'=>'return IsAlphaNumericnospace(event)')); ?>
	<?php echo $form->error($model,'username'); ?>
	</div>
	
	<div class="form-group">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email',array('class' => 'form-control')); ?>
	<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'password'); ?>
		<br>
		<div class="password-input">
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control pull-left','style'=>'width:298px')); ?>
		<?php echo CHtml::Button(Yii::t('admin','Generate Password'),array('onclick'=>"genpass('".$type."')",'style'=>'display:inline;','class'=>'btn btn-primary  pull-right')); ?>
		</div><br>
		<?php echo $form->error($model,'password',array('class' => 'errorMessage col-md-12','style' => 'padding:0')); ?>
	</div>
	<br>

	<div class="form-group">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Create') : Yii::t('admin','Save'),array('class' => 'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- form -->
<style>
.password-input input {
	height: 34px;
}
</style>
