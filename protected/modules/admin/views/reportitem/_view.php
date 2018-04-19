<?php
/* @var $this ReportitemController */
/* @var $data Products */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('productId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->productId), array('view', 'id'=>$data->productId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?php echo CHtml::encode($data->userId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category')); ?>:</b>
	<?php echo CHtml::encode($data->category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subCategory')); ?>:</b>
	<?php echo CHtml::encode($data->subCategory); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('currency')); ?>:</b>
	<?php echo CHtml::encode($data->currency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sizeOptions')); ?>:</b>
	<?php echo CHtml::encode($data->sizeOptions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productCondition')); ?>:</b>
	<?php echo CHtml::encode($data->productCondition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createdDate')); ?>:</b>
	<?php echo CHtml::encode($data->createdDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('likeCount')); ?>:</b>
	<?php echo CHtml::encode($data->likeCount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('commentCount')); ?>:</b>
	<?php echo CHtml::encode($data->commentCount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chatAndBuy')); ?>:</b>
	<?php echo CHtml::encode($data->chatAndBuy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exchangeToBuy')); ?>:</b>
	<?php echo CHtml::encode($data->exchangeToBuy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instantBuy')); ?>:</b>
	<?php echo CHtml::encode($data->instantBuy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paypalid')); ?>:</b>
	<?php echo CHtml::encode($data->paypalid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shippingTime')); ?>:</b>
	<?php echo CHtml::encode($data->shippingTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('latitude')); ?>:</b>
	<?php echo CHtml::encode($data->latitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('longitude')); ?>:</b>
	<?php echo CHtml::encode($data->longitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('likes')); ?>:</b>
	<?php echo CHtml::encode($data->likes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('views')); ?>:</b>
	<?php echo CHtml::encode($data->views); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('soldItem')); ?>:</b>
	<?php echo CHtml::encode($data->soldItem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reports')); ?>:</b>
	<?php echo CHtml::encode($data->reports); ?>
	<br />

	*/ ?>

</div>