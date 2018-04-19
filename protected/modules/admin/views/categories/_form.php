<?php
/* @var $this CategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categories-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
 'enableAjaxValidation'=>true,
 'htmlOptions' => array('enctype' => 'multipart/form-data','onsubmit'=> 'return validateCategory()'),
)); ?>

	<p class="note">
	<?php echo Yii::t('admin' , 'Fields with'); ?>
		<span class="required"> * </span>
		<?php echo Yii::t('admin', 'are required.'); ?>
	</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="form-group">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('class'=>'form-control','onkeyup'=> 'return IsAlphaNumeric(event)')); ?>
	<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'parentCategory'); ?>
	<?php //echo $form->textField($model,'parentCategory'); ?>
	<?php if (!empty($parentCategory)){
		echo $form->dropDownList($model, 'parentCategory', $parentCategory, array('empty'=>Yii::t('admin','Select Parent category'),'id'=>'dropCat','onchange'=>'return dropCategory()','class'=>'form-control'));
	}else{
		echo $form->dropDownList($model, 'parentCategory', array(''=>Yii::t('admin','Select Parent category')), array('id'=>'dropCat','onchange'=>'return dropCategory()','class'=>'form-control'));
	}
	?>
	<?php echo $form->error($model,'parentCategory'); ?>
		<p><?php echo Yii::t('admin','Note: To create Parent Category,Leave this drop down Empty.'); ?></p>
	</div>

	<div class="form-group" id="catImage">
	<?php echo $form->labelEx($model,'image'); ?>
	<?php
	//echo $form->fileField($model,'image',array('class'=>'form-control','value'=>$model->image));
	echo $form->hiddenField($model,'image',array('id'=>'hiddenImage','value'=>$model->image)); ?>
	
	
<?php  $this->widget('CMultiFileUpload',
  array(
       'model'=>$model,
       'attribute' => 'image',
       'accept'=>'jpg|gif|png|bmp|',
       'denied'=> Yii::t('admin','Only images are allowed'), 
       'max'=>1,
       'remove'=>'[x]',
       'duplicate'=>Yii::t('admin','Already Selected'),

       )
        );?>
	<?php if(!$model->isNewRecord && !empty($model->image)):
	echo CHtml::image(Yii::app()->createAbsoluteUrl('media/category/'.$model->image),'',array('height' => 100,'width' => 100));
	endif;?>
	<?php echo $form->error($model,'image'); ?>
	</div>
<?php if(isset($model->parentCategory) && $model->parentCategory == 0 || !isset($model->parentCategory)) { ?>
	<div class="checkbox checkbox-custom " id="itemCondition">
	<?php 
	
	echo $form->checkBox($model, 'itemCondition', array('value'=>1, 'uncheckValue'=>0));
	echo $form->labelEx($model,'itemCondition');
	?>
	</div>
	<?php
	$sitepaymentmodes = Myclass::getSitePaymentModes();
	if($sitepaymentmodes['exchangePaymentMode'] == "1")
	{
	?>
	<div class="checkbox checkbox-custom" id="exchangetoBuy">
	<?php 
	
	echo $form->checkBox($model, 'exchangetoBuy', array('value'=>1, 'uncheckValue'=>0));
	echo $form->labelEx($model,'exchangetoBuy');
	?>
	</div>
	<?php
	}
	if($sitepaymentmodes['buynowPaymentMode'] == "1")
	{
	?>
	<div class="checkbox checkbox-custom" id="buyNow">
	<?php 
	
	echo $form->checkBox($model, 'buyNow', array('value'=>1, 'uncheckValue'=>0));
	echo $form->labelEx($model,'buyNow');
	?>
	</div>
	<?php
	}	
	?>
	
	<div class="checkbox checkbox-custom" id="myOffer">
	<?php 
	
	echo $form->checkBox($model, 'myOffer', array('value'=>1, 'uncheckValue'=>0));
	echo $form->labelEx($model,'myOffer');
	?>
	</div>
	<?php } else { ?>
	<div class="checkbox checkbox-custom " id="itemCondition" style='display:none;'>
	<?php 
	
	echo $form->checkBox($model, 'itemCondition', array('value'=>1, 'uncheckValue'=>0));
	echo $form->labelEx($model,'itemCondition');
	?>
	</div>
	<?php
	$sitepaymentmodes = Myclass::getSitePaymentModes();
	if($sitepaymentmodes['exchangePaymentMode'] == "1")
	{
	?>
	<div class="checkbox checkbox-custom" id="exchangetoBuy" style='display:none;'>
	<?php 
	
	echo $form->checkBox($model, 'exchangetoBuy', array('value'=>1, 'uncheckValue'=>0));
	echo $form->labelEx($model,'exchangetoBuy');
	?>
	</div>
	<?php
	}
	if($sitepaymentmodes['buynowPaymentMode'] == "1")
	{
	?>
	<div class="checkbox checkbox-custom" id="buyNow" style='display:none;'>
	<?php 
	
	echo $form->checkBox($model, 'buyNow', array('value'=>1, 'uncheckValue'=>0));
	echo $form->labelEx($model,'buyNow');
	?>
	</div>
	<?php
	}	
	?>
	
	<div class="checkbox checkbox-custom" id="myOffer" style='display:none;'>
	<?php 
	
	echo $form->checkBox($model, 'myOffer', array('value'=>1, 'uncheckValue'=>0));
	echo $form->labelEx($model,'myOffer');
	?>
	</div>
	<?php } ?>	
	<!--div class="checkbox checkbox-custom" id="contactSeller">
	<?php 
	echo $form->labelEx($model,'contactSeller');
	echo $form->checkBox($model, 'contactSeller', array('value'=>1, 'uncheckValue'=>0));
	?>
	</div-->
	
	<div class="form-group">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Create') : Yii::t('admin','Save'),array('class' => 'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- form -->
<script>
	$("#catImage").show();
	if ($("#dropCat").val() != "") {
		$("#catImage").hide();
	} else {
		$("#catImage").show();
	}
</script>
