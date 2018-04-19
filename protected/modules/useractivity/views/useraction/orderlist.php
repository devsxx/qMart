<div class="btn-area">
	<a type="button"
		href="<?php echo Yii::app()->createAbsoluteUrl('addshipping'); ?>"
		class="btn-choose-option btn-done pull-right" id="btn-doneid"> <i
		class="fa fa-plus"></i> <?php echo ' ADD SHIPPING'; ?>
	</a><br>
	<div class="option-error"></div>
</div>



<?php if(empty($address)) {
	echo '<h1 align="center">You haven’t added any shipping address yet.</h1>';
} else { ?>
<table class="chart">
	<thead>
		<tr>
			<th><?php echo Yii::t('app','Default'); ?></th>
			<th><?php echo Yii::t('app','Nickname'); ?></th>
			<th><?php echo Yii::t('app','Address'); ?></th>
			<th><?php echo Yii::t('app','Phone'); ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($address as $add): ?>
		<tr class="shipping">
			<td><?php $userDefaultAddress = Myclass::getDefaultShippingAddress($add->userId);
			if($add->shippingaddressId == $userDefaultAddress)
			echo 'Default';
			else
			echo CHtml::link('Default',Yii::app()->createAbsoluteUrl('useractivity/useraction/default',array('id'=>$add->shippingaddressId,'userid' => $add->userId)));
			?>
			</td>
			<td
				style="width: 115px; max-width: 110px; overflow: hidden; word-wrap: break-word;"><b><?php echo $add->nickname; ?>
			</b>
			</td>
			<td style="width: 250px;">
				<div style="width: 250px; overflow: hidden;" class="shipaddrcont">
				<?php echo $add->address1; ?>
					<br>
					<?php echo $add->address2; ?>
					<br>
					<?php echo $add->city; ?>
					<br>
					<?php echo $add->country; ?>
				</div>
			</td>
			<td><?php echo $add->phone; ?></td>
			<td class="btns"><?php echo CHtml::link('<i class="fa fa-pencil"></i>',Yii::app()->createAbsoluteUrl('useractivity/useraction/addshipping',array('id'=>$add->slug))); ?>
			<?php echo CHtml::link('<i class="fa fa-times"></i>',Yii::app()->createAbsoluteUrl('useractivity/useraction/delete',array('id'=>$add->slug)),array('onclick'=>'return confirm("Are you sure you want to remove?")')); ?>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
		<?php } ?>



