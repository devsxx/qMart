<style>
.coupon-popup label {
	text-align: left;
	width: 100%;
}

.errorMessage {
	color: red;
	text-align: left;
}
</style>

<div class="page-container item-view">
	<div class="col-md-12">
		<div class="container listing-contianer" id="orders">
			<h1>
			<i class="fa fa-money"></i>
			<?php echo Yii::t('app','Coupons'); ?>
			<?php if ($itemCount > 0){ ?>
				<div class="btn btn-success pull-right" onclick="showcouponpopup()">
				<?php echo Yii::t('app','Generate Coupon'); ?>
				</div>
			<?php } ?>
			</h1>
			<ul id="tabs" class="nav nav-tabs nav-justified item-view-exchange"
				data-tabs="tabs">
				<li class="<?php if($type == 'item') echo 'active'; ?>"><a
					href="<?php echo Yii::app()->createAbsoluteUrl('coupons',array('type'=>'item')); ?>"><i
						class="fa fa-arrow-down"> </i> <?php echo Yii::t('app','Item Coupons'); ?>
				</a></li>
				<li class="<?php if($type == 'general') echo 'active'; ?>"><a
					href="<?php echo Yii::app()->createAbsoluteUrl('coupons',array('type'=>'general')); ?>">
						<i class="fa fa-arrow-up"> </i> <?php echo Yii::t('app','General Coupons'); ?>
				</a></li>
			</ul>
			<?php if(!empty($coupons)) { ?>
			<table class="myorderslist" style="background: #fff;">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo Yii::t('app','Coupon Code'); ?></th>
						<th><?php echo Yii::t('app','Coupon Value'); ?></th>
						<?php if($type == 'general') { ?>
						<th><?php echo Yii::t('app','Max Amount'); ?></th>
						<th><?php echo Yii::t('app','Start Date'); ?></th>
						<th><?php echo Yii::t('app','End Date'); ?></th>
						<?php } ?>
						<?php if($type == 'item') { ?>
						<th><?php echo Yii::t('app','Product Name'); ?></th>
						<?php } ?>
						<th><?php echo Yii::t('app','Created Date'); ?></th>
						<th><?php echo Yii::t('app','Disable'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach($coupons as $coupon): ?>
					<tr>
						<td><?php echo ++$i;; ?></td>
						<td><?php echo $coupon->couponCode; ?></td>
						<td><?php 
						if($type == 'item') {
							echo $coupon->currency.' '.$coupon->couponValue;
						}
						if($type == 'general') {
							echo $coupon->couponValue.' %';
						}
						?>
						</td>
						<?php if($type == 'general') { ?>
						<td><?php 
						
						echo $coupon->maxAmount > 0 ? $coupon->currency.' '.$coupon->maxAmount : Yii::t('app','Unlimited'); 
						?>
						</td>
						<td><?php 
						if($coupon->startDate != '0000-00-00')
						echo date("d-M-Y",strtotime($coupon->startDate));
						else
						echo Yii::t('app','NIL');?></td>
						<td><?php if($coupon->endDate != '0000-00-00') 
						echo date("d-M-Y",strtotime($coupon->endDate));
						else echo Yii::t('app','NIL');?></td>
						<?php } ?>
						<?php if($type == 'item') { ?>
						<td  width="40%"><?php echo $coupon->productName; ?></td>
						<?php } ?>
						<td><?php echo date("d-M-Y G:i A",strtotime($coupon->createdDate)); ?>
						</td>
						<td><?php if($coupon->status == 1) { 
							echo '<span class="btn btn-sm btn-success" style="cursor:pointer;line-height:12px;" 
							onclick=\'confirmModal("link", "useractivity/useraction/disableCoupon/id/","'.
							$coupon->id.'")\'>'.Yii::t('app','Disable').'</span>';
						} else {
							echo '<label class="label label-default"><i class="fa fa-times-circle"></i> '.Yii::t('app','Disabled').'</label>';
						} ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php $this->widget('CLinkPager',array('pages' => $pages));} else {
				echo '<div class="record-not-found">'.Yii::t('app','You haven’t generated any coupons yet.').'</div>';
			}?>
		</div>
	</div>
</div>
<div id="popup_container">
	<div id="show-coupon-popup" style="display: none;"
		class="popup ly-title update show-exchange-popup">
		<button type="button" class="ly-close" id="btn-browses">x</button>
		<div class="coupon-popup">
			<h3>
			<?php echo Yii::t('app','Generate Coupon'); ?>
			</h3>
			<hr>
			<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'coupon-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
 'action' => Yii::app()->createAbsoluteUrl('addcoupon'),
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
			),
    'htmlOptions' => array('enctype' => 'multipart/form-data','onsubmit' => 'return couponValidate()'), // ADD THIS
			)); ?>
			<?php //echo $form->errorSummary($model); ?>
			<?php echo $form->hiddenField($model,'couponType',array('value' => '2'));?>
			<?php echo $form->hiddenField($model,'sellerId',array('value' => Yii::app()->user->id));?>

			<div class="form-group">
			<?php echo $form->labelEx($model,'couponValue'); ?>
			<?php echo $form->textField($model,'couponValue',array('class' => 'form-control','onkeypress' => 'return isNumber(event)')); ?>
			<?php echo $form->error($model,'couponValue'); ?>
			</div>

			<div class="form-group">
			<?php echo $form->labelEx($model,'maxAmount'); ?>
			<?php echo $form->textField($model,'maxAmount',array('class' => 'form-control','onkeypress' => 'return isNumber(event)')); ?>
			<?php echo $form->error($model,'maxAmount'); ?>
			</div>

			<div class="form-group">
			<?php echo $form->labelEx($model,'startDate'); ?>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    		'model'=>$model,
			'attribute' => 'startDate',
    		'options'=>array(
    			'minDate'=>'0',
        	'showAnim'=>'fold',
		     'dateFormat' => 'yy-mm-dd',
			),
    		'htmlOptions'=>array(
	    	'class' => 'form-control',
		'autocomplete' => 'off',
			),
			));?>
			<?php echo $form->error($model,'startDate'); ?>
			</div>

			<div class="form-group">
			<?php echo $form->labelEx($model,'endDate'); ?>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    		'model'=>$model,
			'attribute' => 'endDate',
    		'options'=>array(
    			'minDate'=>'0',
        		'showAnim'=>'fold',
		     	'dateFormat' => 'yy-mm-dd',
			),
    		'htmlOptions'=>array(
		    	'class' => 'form-control',
				'autocomplete' => 'off',
			),
			));?>
			<?php echo $form->error($model,'endDate'); ?>
			</div>


			<div class="form-group buttons" style="text-align: center">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Generate Coupon') : Yii::t('app','Generate Coupon'),array('class'=>'btn btn-lg btn-success','id'=>'coupon-submit')); ?>
			</div>

			<?php $this->endWidget(); ?>

		</div>
	</div>
</div>

