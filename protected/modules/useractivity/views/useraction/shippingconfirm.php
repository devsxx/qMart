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
			<h4 class="page-header-tracking"></h4>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-md-8 shipping-confirm-container">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('app','Mark as Shipped'); ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="containerdiv">
							<?php $seller = Myclass::getUserDetails($model->sellerId); ?>
								<span class="pay-status"><?php echo Yii::t('app','Order ID'); ?> : <?php echo $model->orderId?>
								</span> <span class="pay-to pull-right"><?php echo Yii::t('app','Status')?> : <b><?php echo ucfirst(Yii::t('app',$model->status)); ?>
								</b>
								</span><br>
								<div class="inv-clear"></div>
								<hr>
								<div class="buyerdiv" style="height: auto; overflow: hidden;">
									<div class="buyerper" style="width: 40%; float: left;">
										<span class="pay-status"><?php echo Yii::t('app','Buyer Details'); ?></span><br> <span
											class="pay-to"><?php echo Yii::t('app','Name'); ?> : <?php echo $model['user']['username']; ?>
											<br> <br> <span class="pay-status"><b><?php echo Yii::t('app','Shipping Address'); ?> :</b>
										</span><br> <?php echo $shipping->address1; ?>,<br> <?php echo $shipping->address2; ?>,<br>
										<?php echo $shipping->city; ?> - <?php echo $shipping->zipcode; ?>,<br>
										<?php echo $shipping->state; ?>,<br> <?php echo $shipping->country; ?>,<br><?php echo Yii::t('app','Phone'); ?> :<?php echo $shipping->phone; ?>
									
									</div>
								</div>
								<hr>
								<div class="inv-clear"></div>
								<div class="form">
									<form class="form-horizontal" method="post" onsubmit="return shippingConfirmValidation()">
										<div class="form-group">
											<label class="control-label col-md-3"> <span style="color: red">*</span><?php echo Yii::t('app','Subject'); ?> : </label>
											<div class="col-md-6">
												<input type="text" name="subject" id="subject"
													class="form-control"></input>
												<div class="empty-error-sub" style="color: red;"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3"> <span style="color: red">*</span><?php echo Yii::t('app','Message'); ?> : </label>
											<div class="col-md-6">
												<textarea name="message" cols="60" id="message"></textarea>
												<div class="empty-error-msg" style="color: red;"></div>
											</div>
										</div>
										<div class="btn-block" style="text-align: center;">
											<button type="submit" id="send" class="btn btn-success"><?php echo Yii::t('app','Confirm'); ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>