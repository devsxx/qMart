							<!----------------------Order Details------------------->
						
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="order-details">
	<div class="profile-tab-content-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<span><?php echo Yii::t('app','Order Details'); ?></span>
		<div class="exchange-back-link pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 no-hor-padding"><a href="javascript:void(0);" onclick="hide_order_details();" id="element1"><?php echo Yii::t('app','Back'); ?></a></div>
	</div>
	<div class="sale-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<!--row 1-->
		<div class="promotions-details-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="promotions-left-content col-xs-12 col-sm-12 col-md-4 col-lg-4 no-hor-padding">
					<div class="promotions-prod-pic-container col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="promotion-detail-prod-pic"></div>
						<div class="order-detail-name-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php echo $model['orderitems'][0]['itemName']; ?><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php echo $model['orderitems'][0]['itemunitPrice'].' '.$model->currency; ?>
					</div>
					</div>
					</div>
				</div>
				<!--div class="print-icon pull-right"><a href=""><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/printer.png'); ?>"><br/><span class="print-txt">Print</span></a></div-->
				<div class="divider col-xs-12 col-sm-12 col-md-12 col-lg-12 "></div>
				
			<div class="promotion-details-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">												
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="promotions-type-cnt col-xs-12 col-sm-12 col-md-2 col-lg-2 no-hor-padding">
							<div class="promotions-type col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Seller name:'); ?></div>
							<?php $seller = Myclass::getUserDetails($model->sellerId); ?>
							<div class="padding-right-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<?php echo $seller->username; ?>
							</div>
						</div>	
						<div class="vertical-divider"></div>													
							<div class="paid-amt-cnt padding-right-10 col-xs-12 col-sm-12 col-md-2 col-lg-2 no-hor-padding">
								<div class="status col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Status :'); ?></div>
								<div class="status-txt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo $model->status; ?>
								</div>
							</div>														
							<div class="vertical-divider"></div>														
							<div class="paid-amt-cnt col-xs-12 col-sm-12 col-md-2 col-lg-2 no-hor-padding">
								<div class="paid-amt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Payment type:'); ?></div>
								<div class="paid-amt-txt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo $model['invoices'][0]['paymentMethod']; ?>
								</div>
							</div>
							<div class="vertical-divider"></div>														
							<div class="paid-amt-cnt col-xs-12 col-sm-12 col-md-12 col-lg-5 no-hor-padding">
								<div class="transaction-id col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Transaction Id :'); ?></div>
								<div class="transaction-id-txt padding-right-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo $model['invoices'][0]['paymentTranxid']; ?>
								</div>
							</div>
						</div>
						<div class="divider col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="upto-txt-cnt col-xs-12 col-sm-12 col-md-6 col-lg-2 no-hor-padding">
								<div class="upto col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Order date:'); ?> </div>
								<div class="upto-txt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo date("F d Y",$model->orderDate); ?>
								</div>
							</div>
							<div class="vertical-divider"></div>
							<div class="paid-amt-cnt upto-txt-cnt col-xs-12 col-sm-12 col-md-2 col-lg-2 no-hor-padding">
								<div class="upto col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Shipped date:'); ?></div>
								<div class="upto-txt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php if(!empty($trackingDetails)) { 
										if(!empty($trackingDetails->shippingdate)) {
											echo date("F d Y",$trackingDetails->shippingdate);
										}
										else
										{
											echo "__";
										}
									}
									else
									{
										echo "__";
									}
											?>
								</div>
							</div>
							<div class="vertical-divider"></div>
							<div class="paid-amt-cnt upto-txt-cnt col-xs-12 col-sm-12 col-md-3 col-lg-3 no-hor-padding">
								<div class="upto col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Delivery confirmed date:'); ?></div>
								<div class="upto-txt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php 
									if($model->statusDate != 0)
									{
										echo date("F d Y",$model->statusDate);
									}
									else
									{
										echo "__";
									}
									?>
								</div>
							</div>
						</div>
						<div class="divider col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="promotions-type-cnt col-xs-12 col-sm-12 col-md-2 col-lg-2 no-hor-padding">
							<div class="upto col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Item amount:'); ?></div>
							<div class="padding-right-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<?php echo $model['orderitems'][0]['itemunitPrice'].' '.$model->currency; ?>
							</div>
						</div>	
						<div class="vertical-divider"></div>													
							<div class="paid-amt-cnt padding-right-10 col-xs-12 col-sm-12 col-md-2 col-lg-2 no-hor-padding">
								<div class="upto col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Shipping fee:'); ?></div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo (int)$model->totalShipping.' '.$model->currency; ?>
								</div>
							</div>														
							<div class="vertical-divider"></div>	
							
							<div class="paid-amt-cnt padding-right-10 col-xs-12 col-sm-12 col-md-2 col-lg-2 no-hor-padding">
								<div class="upto col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Received fund:'); ?></div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php
										$received = $model->totalCost - $model->admincommission;
										echo $received.' '.$model->currency;
									?>
								</div>
							</div>														
							<div class="vertical-divider"></div>
																					
							<div class="paid-amt-cnt col-xs-12 col-sm-12 col-md-12 col-lg-5 no-hor-padding">
								<div class="transaction-id col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Shipping address:'); ?></div>
								<div class="transaction-id-txt padding-right-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php if(!empty($shipping)) { ?>
										<b><?php echo $shipping->name; ?> </b>,<br>
										<?php echo $shipping->address1; ?>
										,<br>
										<?php echo $shipping->address2; ?>
										,<br>
										<?php echo $shipping->city; ?>
										-
										<?php echo $shipping->zipcode; ?>
										,<br>
										<?php echo $shipping->state; ?>
										,<br>
										<?php echo $shipping->country; ?>
										,<br>Phone no. :
										<?php echo $shipping->phone; ?>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
						
						
					<div class="sale-info col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">													
						<div class="exchange-btn-cnt ">
						<?php if(!empty($trackingDetails)) { ?>
							<a data-target="#shipping-user-modal" data-toggle="modal" id="exc-success" class="xs-margin-top-10 xs-margin-0 exchange-btn" href=""><?php echo Yii::t('app','Shipping detail'); ?></a>
							<?php } ?>
							<a id="exc-accept" class="xs-margin-top-10 xs-margin-0 exchange-btn" href="<?php echo Yii::app()->baseUrl."/message/".Myclass::safe_b64encode($model->sellerId.'-0'); ?>">
							<?php echo Yii::t('app','Chat with seller'); ?>
							</a>														
						</div>
						<div class="sale-initiate-date pull-right"><?php echo Yii::t('app','Order total:'); ?> 
						<span class="bold">
							<?php echo $model->totalCost.' '.$model->currency;?>
						</span></div>
					</div>
																
						
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
					
					
					<!----------------------E O Order Details------------------->
<!--Shippping details for user popup-->
	
	<div class="modal fade" id="shipping-user-modal" role="dialog"> 
		<div class="modal-dialog modal-dialog-width">
			<div class="login-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
					<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="login-header-text"><?php echo Yii::t('admin','Tracking Details'); ?></h2>
							<button data-dismiss="modal" class="close login-close" type="button">×</button>							
					</div>
						
						<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
					
							<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
								<div class="login-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="login-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">

									<?php if(!empty($trackingDetails)) { ?>
									<div class="inv-shipping" style="width: 35%; float: left;">

										<?php if(!empty($trackingDetails->trackingid)) { 
											echo '<label class="margin-bottom-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
											echo Yii::t('app','Tracking ID'); 
											echo ':</label>';
											?>
										 <div class="padding-bottom-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo $trackingDetails->trackingid; ?> </div>
										<?php } ?>
										<br>
										<?php if(!empty($trackingDetails->shippingdate)) { 
											echo '<label class="margin-bottom-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
											echo Yii::t('app','Shipment Date'); 
											echo ':</label>';
											?>
										 <div class="padding-bottom-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo date("d-m-Y",$trackingDetails->shippingdate); ?>
										</div>
										<?php } ?>
										<br>
										<?php if(!empty($trackingDetails->couriername)) { 
											echo '<label class="margin-bottom-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
											echo Yii::t('admin','Logistic Name'); 
											echo ':</label>';
											?>
										 <div class="padding-bottom-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo $trackingDetails->couriername; ?> </div>
										<?php } ?>
										<br>
										<?php if(!empty($trackingDetails->courierservice)) { 
											echo '<label class="margin-bottom-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
											echo Yii::t('admin','Shipment Service'); 
											echo ':</label>';
											?>
										 <div class="padding-bottom-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo $trackingDetails->courierservice; ?> </div>
										<?php } ?>
										<br>
										<?php if(!empty($trackingDetails->notes)) { 
											echo '<label class="margin-bottom-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
											echo Yii::t('admin','Additional Notes');
											echo ':</label>'; 
											?>
										 <div class="padding-bottom-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo $trackingDetails->notes; ?> </div>
										<?php } ?>
										<br>

									</div>
									<?php } ?>
										</div>
									</div>									
								</div>											
							</div>			
			</div>
		</div>
	</div>
		
<!--E O Shippping details for user popup-->
					