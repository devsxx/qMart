<?php
/* @var $this UserController */
/* @var $data Users */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->userId), array('view', 'id'=>$data->userId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('postalcode')); ?>:</b>
	<?php echo CHtml::encode($data->postalcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userImage')); ?>:</b>
	<?php echo CHtml::encode($data->userImage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userstatus')); ?>:</b>
	<?php echo CHtml::encode($data->userstatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facebookId')); ?>:</b>
	<?php echo CHtml::encode($data->facebookId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('twitterId')); ?>:</b>
	<?php echo CHtml::encode($data->twitterId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('googleId')); ?>:</b>
	<?php echo CHtml::encode($data->googleId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notificationSettings')); ?>:</b>
	<?php echo CHtml::encode($data->notificationSettings); ?>
	<br />

	*/ ?>

</div>