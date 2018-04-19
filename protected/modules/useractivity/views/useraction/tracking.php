<style>
.errorMessage {
	color: red;
}
.page-header-tracking {
  margin-top:30px;
}

</style>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h6 class="page-header-tracking"></h6>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-md-8 shipping-confirm-container">
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php echo Yii::t('app','Add Tracking'); ?>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="containerdiv">
							<?php $seller = Myclass::getUserDetails($model->sellerId); ?>
								<span class="pay-status"><?php echo Yii::t('app','Order ID'); ?>
									: <?php echo $model->orderId?> </span> <span
									class="pay-to pull-right"><?php echo Yii::t('app','Status'); ?>
									: <b><?php echo ucfirst(Yii::t('app',$model->status)); ?> </b>
								</span><br>
								<div class="inv-clear"></div>
								<hr>
								<div class="buyerdiv" style="height: auto; overflow: hidden;">
									<div class="buyerper" style="width: 40%; float: left;">
										<span class="pay-status"><?php echo Yii::t('app','Buyer Details'); ?>
										</span><br> <span class="pay-to"><?php echo Yii::t('app','Name'); ?>
											: <?php echo $model['user']['username']; ?> <br> <br> <span
											class="pay-status"><b><?php echo Yii::t('app','Shipping Address'); ?>
													:</b> </span><br> <?php echo $shipping->address1; ?>,<br> <?php echo $shipping->address2; ?>,<br>
													<?php echo $shipping->city; ?> - <?php echo $shipping->zipcode; ?>,<br>
													<?php echo $shipping->state; ?>,<br> <?php echo $shipping->country; ?>,<br>
													<?php echo Yii::t('app','Phone'); ?> :<?php echo $shipping->phone; ?>
									
									</div>
								</div>
								<hr>
								<div class="inv-clear"></div>

								<div class="form">

								<?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'trackingdetails-form',
								// Please note: When you enable ajax validation, make sure the corresponding
								// controller action is handling ajax validation correctly.
								// See class documentation of CActiveForm for details on this,
								// you need to use the performAjaxValidation()-method described there.
                                'enableAjaxValidation'=>true,
								'htmlOptions' => array('onsubmit' => 'return validatetracking()','class' => 'form-horizontal'),
								)); ?>

									<!-- <p class="note">
									<?php echo Yii::t('admin' , 'Fields with'); ?>
										<span class="required"> * </span>
										<?php echo Yii::t('admin', 'are required.'); ?>
									</p>  -->

										<?php echo $form->hiddenField($tracking,'orderid',array('value' => $model->orderId)); ?>
										<?php echo $form->hiddenField($tracking,'status',array('value' => $model->status)); ?>
										<?php echo $form->hiddenField($tracking,'merchantid',array('value' => $model->userId)); ?>
										<?php echo $form->hiddenField($tracking,'buyername',array('value' => $model['user']['username'])); ?>
										<?php echo $form->hiddenField($tracking,'buyeraddress',array('value' => '<?php echo $shipping->address1; ?>,<br> <?php echo $shipping->address2; ?>,<br>
										<?php echo $shipping->city; ?> - <?php echo $shipping->zipcode; ?>,<br>
										<?php echo $shipping->state; ?>,<br> <?php echo $shipping->country; ?>,<br>Phone
											no. :<?php echo $shipping->phone; ?>')); ?>
									<div class="form-group">
										<label class="control-label col-md-3"><span style="color: red">*</span>
										<?php echo Yii::t('app','Shipment Date'); ?> : </label>
										<div class="col-md-8">
										<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                    'model'=>$tracking,
									'attribute' => 'shippingdate',

    								'options'=>array(
    									'minDate'=>'0',
       									 'showAnim'=>'fold',
										),
   								    'htmlOptions'=>array(
										 'class' => 'form-control',
									'value' => empty($tracking['shippingdate']) ? '' : date('m/d/Y',$tracking['shippingdate']),
										),
										));?>
										<?php echo $form->error($tracking,'shippingdate'); ?>

										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3"> <span
											style="color: red">*</span> <?php echo Yii::t('app','Shipment Method'); ?>
											:
										</label>
										<div class="col-md-4">
										<?php echo $form->textField($tracking,'couriername',array('class' => 'form-control','placeholder' => Yii::t('app','Enter the courier'))); ?>
										<?php echo $form->error($tracking,'couriername'); ?>
										</div>
										<div class="col-md-4">
										<?php echo $form->textField($tracking,'courierservice',array('class' => 'form-control','placeholder' => Yii::t('app','Shipping Service'))); ?>
										<?php echo $form->error($tracking,'courierservice'); ?>
										</div>
									</div>

									<!-- <div class="form-group">
										<label class="control-label col-md-3"> <span
											style="color: red">*</span> <?php echo Yii::t('app','Shipment Method'); ?>
											:
										</label>
										<div class="col-md-8">
										<?php echo $form->textField($tracking,'courierservice',array('class' => 'form-control','placeholder' => Yii::t('app','Shipping Service'))); ?>
										<?php echo $form->error($tracking,'courierservice'); ?>
										</div>
									</div>
									 -->
									<div class="form-group">
										<label class="control-label col-md-3"><span style="color: red">*</span>
										<?php echo Yii::t('app','Tracking ID'); ?> </label>
										<div class="col-md-8">
										<?php echo $form->textField($tracking,'trackingid',array('class' => 'form-control')); ?>
										<?php echo $form->error($tracking,'trackingid'); ?>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3">
										<?php echo Yii::t('app','Additional Notes'); ?> </label>
										<div class="col-md-8">
										<?php echo $form->textArea($tracking,'notes',array('class' => 'form-control','style'=>"",'cols'=>"15",'rows' => '10')); ?>
										<?php echo $form->error($tracking,'notes'); ?>
										</div>
									</div>
									<div class="btn-block" style="text-align: center;">
										<button class="btn btn-success" type="submit">
										<?php echo Yii::t('app','Add Tracking Details'); ?>
										</button>
										<a href="<?php echo Yii::app()->createAbsoluteUrl('sales'); ?>" class="btn btn-warning">
												<?php echo Yii::t('app','Cancel'); ?>	
										</a>
									</div>
									<?php $this->endWidget(); ?>

								</div>
								<!-- form -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>


		</script>
