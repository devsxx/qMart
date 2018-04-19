<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'currencies-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
     'htmlOptions' => array('enctype' => 'multipart/form-data','onsubmit'=> 'return validateCurrency()'),
)); ?>

	<p class="note">
	<?php echo Yii::t('admin' , 'Fields with'); ?>
		<span class="required"> * </span>
		<?php echo Yii::t('admin', 'are required.'); ?>
	</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="form-group">
	<?php echo $form->labelEx($model,'currency_shortcode'); ?>
	<?php $currency = Myclass::getCurrencyList();?>
	<?php if(!empty($selected)) {
		$selected = $model->currency_symbol.'-'.$model->currency_name;
	} else {
		$selected = '';
	}?>
	<?php echo $form->dropDownList($model,'currency_shortcode',$currency,array('class'=>'form-control','onchange' => 'dropDownCur(this.value)','empty'=>Yii::t('admin','Select Currency'),'id'=>'curshortcode','options' => array($selected=>array('selected'=>true)))); ?>
	<?php echo $form->error($model,'currency_shortcode'); ?>
	</div>
	<?php echo $form->hiddenField($model,'currency_shortcode',array('class'=>'form-control','id'=>'shortcode')); ?>

	<div class="form-group">
	<?php echo $form->labelEx($model,'currency_name'); ?>
	<?php echo $form->textField($model,'currency_name',array('class'=>'form-control','id'=>'currencyname','readonly'=>true)); ?>
	<?php echo $form->error($model,'currency_name'); ?>
	</div>
	<div class="form-group">
	<?php echo $form->labelEx($model,'currency_symbol'); ?>
	<?php echo $form->textField($model,'currency_symbol',array('class'=>'form-control','id'=>'currencysymbol','readonly'=>true)); ?>
	<?php echo $form->error($model,'currency_symbol'); ?>
	</div>

	<!--   <div class="form-group">
		<?php echo $form->labelEx($model,'currency_image'); ?>
		<?php echo $form->hiddenField($model,'currency_image'); ?>
		<?php echo $form->fileField($model,'currency_image',array('class'=>'form-control')); ?>
		<?php if(!$model->isNewRecord): 
		echo CHtml::image(Yii::app()->createAbsoluteUrl('media/currency/'.$model->currency_image),'image',array('width' => 75, 'height' => 75)); 
		endif;?>
		<?php echo $form->error($model,'currency_image'); ?>
	</div>  -->

	<div class="form-group">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Create') : Yii::t('admin','Save'),array('class' => 'btn btn-success')); 
	?>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- form -->
<script>
function dropDownCur(value,label) {
	var shortcode = $('#curshortcode :selected').text(); 
	var currencyName = value.split("-");
	$("#shortcode").val(shortcode);
	$("#currencysymbol").val(currencyName[0]);
	$("#currencyname").val(currencyName[1]);
}
</script>
