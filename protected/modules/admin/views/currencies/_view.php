<?php
/* @var $this CurrenciesController */
/* @var $data Currencies */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_name')); ?>:</b>
	<?php echo CHtml::encode($data->currency_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_shortcode')); ?>:</b>
	<?php echo CHtml::encode($data->currency_shortcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_image')); ?>:</b>
	<?php echo CHtml::encode($data->currency_image); ?>
	<br />


</div>