<?php
/* @var $this ExchangesController */
/* @var $data Exchanges */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requestFrom')); ?>:</b>
	<?php echo CHtml::encode($data->requestFrom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requestTo')); ?>:</b>
	<?php echo CHtml::encode($data->requestTo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mainProductId')); ?>:</b>
	<?php echo CHtml::encode($data->mainProductId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exchangeProductId')); ?>:</b>
	<?php echo CHtml::encode($data->exchangeProductId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />


</div>