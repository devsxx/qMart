<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php echo Yii::t('app','View Order'); ?>
					<button id="btn-browses" class="ly-close" type="button">x</button>
					<button onclick="hide_order_details();"><?php echo Yii::t('app','Back'); ?></button>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="containerdiv">
								<div class="payment-on">
									<h2 style="font-size: 15px; padding: 0;margin-top: 0;" class="inv-head">
										<?php echo Yii::t('app','Order ID'); ?>
										#
										<?php echo $model['invoices'][0]['invoiceNo']; ?>
										<?php echo Yii::t('admin','on'); ?>
										<?php echo date("m/d/Y",$model['invoices'][0]['invoiceDate']); ?>
									</h2>
								</div>
								<div class="payment-details" style="float:right;">
									<p style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; 
										margin-top: 0px;" class="pay-status">
										<?php echo Yii::t('admin','Payment Method'); ?>
										:
										<?php echo ucfirst($model['invoices'][0]['paymentMethod']); ?>
									</p>
									<p style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; 
										margin-top: 12px;" class="pay-status">
										<?php echo Yii::t('admin','Payment Status'); ?>
										:
										<?php echo ucfirst($model['invoices'][0]['invoiceStatus']); ?>
									</p>
								</div>
							<?php $seller = Myclass::getUserDetails($model->sellerId); ?>
								<span class="pay-status"><?php echo Yii::t('app','Payment to'); ?>
								</span><br> <span class="pay-to"> <a class="userNameLink"
									href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($seller->userId.'-'.rand(0,999)))); ?>"><b><?php echo $seller->username; ?>
									</b>
								</a>
								</span><br> <span class="pay-status"><?php echo Yii::t('app','Email'); ?>
									: <?php echo $seller->email; ?> </span>
								<div class="inv-clear"></div>
								<hr>
								<div class="buyerdiv" style="height: auto; overflow: hidden;">
									<div class="buyerper" style="width: 30%; float: left;">
										<span class="pay-status"><?php echo Yii::t('app','Buyer Details'); ?>
										</span><br> <span class="pay-to">
										<b>
										<a class="userNameLink" href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($model['user']['userId'].'-'.rand(0,999)))); ?>"><?php echo $model['user']['username']; ?></a>
										</b> </span><br> <span class="pay-status"><?php echo Yii::t('app','Email :'); ?> <?php echo $model['user']['email']; ?>
										</span>
									</div>

									<?php if(!empty($shipping)) { ?>
									<div class="inv-shipping" style="width: 35%; float: left;margin-left: 20px;">
										<span class="pay-status"><?php echo Yii::t('app','Shipping Address'); ?>
										</span><br> <b><?php echo $shipping->name; ?> </b>,<br>
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
										,<br><?php echo Yii::t('app','Phone no. :'); ?>
										<?php echo $shipping->phone; ?>
									</div>
									<?php } ?>
									<?php if(!empty($trackingDetails)) { ?>
									<div class="inv-shipping" style="width: 35%; float: left;">
										<span class="pay-status"><?php echo Yii::t('admin','Tracking Details'); ?>
										</span><br> <br>

										<?php if(!empty($trackingDetails->trackingid)) { echo Yii::t('app','Tracking ID'); ?>
										: <b><?php echo $trackingDetails->trackingid; ?> </b>
										<?php } ?>
										<br>
										<?php if(!empty($trackingDetails->shippingdate)) { echo Yii::t('app','Shipment Date'); ?>
										: <b><?php echo date("d-m-Y",$trackingDetails->shippingdate); ?>
										</b>
										<?php } ?>
										<br>
										<?php if(!empty($trackingDetails->couriername)) { echo Yii::t('admin','Logistic Name'); ?>
										: <b><?php echo $trackingDetails->couriername; ?> </b>
										<?php } ?>
										<br>
										<?php if(!empty($trackingDetails->courierservice)) { echo Yii::t('admin','Shipment Service'); ?>
										: <b><?php echo $trackingDetails->courierservice; ?> </b>
										<?php } ?>
										<br>
										<?php if(!empty($trackingDetails->notes)) { echo Yii::t('admin','Additional Notes'); ?>
										: <b><?php echo $trackingDetails->notes; ?> </b>
										<?php } ?>
										<br>

									</div>
									<?php } ?>
								</div>
								<hr>
								<div class="inv-clear"></div>
								<table
									class="tablesorter table table-striped table-bordered table-condensed">
									<thead>
										<tr>
											<th>Sl no.</th>
											<th><?php echo Yii::t('app','Item Name'); ?></th>
											<th><?php echo Yii::t('app','Item Quantity'); ?></th>
											<th><?php echo Yii::t('app','Item Unitprice'); ?></th>
											<th><?php echo Yii::t('app','Shipping fee'); ?></th>
											<th><?php echo Yii::t('app','Total Price'); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td><?php echo $model['orderitems'][0]['itemName']; ?>
											</td>
											<td><?php echo $model['orderitems'][0]['itemQuantity']; ?>
											</td>
											<td><?php echo $model['orderitems'][0]['itemunitPrice'].' '.$model->currency; ?>
											</td>
											<td><?php echo (int)$model->totalShipping.' '.$model->currency; ?>
											</td>
											<?php $totalCost =  $model->totalCost; ?>
											<td><?php echo $totalCost.' '.$model->currency; ?>
											</td>
										</tr>
									</tbody>
								</table>
								<div style="margin-top: 12px; width: 300px;" class="pull-right">
									<table>
										<tbody>
											<tr>
												<td align="left" style="width: 200px;"><p class="gtotal">
												<?php echo Yii::t('app','Item Total'); ?>
													</p></td>
												<td style="width: 50px;"></td>
												<td align="right" style="width: 100px;"><p
														class="gtotal invoice-amnt">
														<b><?php echo $totalCost - $model->totalShipping.' '.$model->currency; ?>
														</b>
													</p>
												</td>
											</tr>
											<?php if(!empty($model->discount)) { ?>
											<tr>
												<td align="left"><p class="gtotal">
												<?php echo Yii::t('app','Discount Amount'); ?>
													</p>
												</td>
												<td style="width: 50px;"></td>
												<td align="right"><p class="gtotal invoice-amnt">
														<b>(-) <?php echo $model->discount.' '.$model->currency; ?>
														</b>
													</p>
												</td>
											</tr>
											<?php } ?>
											<tr>
												<td align="left"><p class="gtotal">
												<?php echo Yii::t('app','Shipping fee'); ?>
													</p>
												</td>
												<td style="width: 50px;"></td>
												<td align="right"><p class="gtotal invoice-amnt">
														<b><?php echo (int)$model->totalShipping.' '.$model->currency; ?>
														</b>
													</p>
												</td>
											</tr>
											<!-- <tr>
												<td align="left"><p class="gtotal">Tax</p></td>
												<td style="width: 50px;"></td>
												<td align="right"><p class="gtotal">
														<b>99.95 EUR</b>
													</p></td>
											</tr> -->
											<tr>
												<td colspan="2"><div id="horizonal"
														style="border-top: 1px solid black; width: 300px; position: absolute; margin-top: -6px;"></div>
												</td>
											</tr>
											<tr>
												<td align="left"><p class="gtotal">
												<?php echo Yii::t('app','Grand Total'); ?>
													</p>
												</td>
												<td style="width: 50px;"></td>
												<td align="right"><p class="gtotal invoice-amnt">
														<b><?php echo $totalCost - $model->discount.' '.$model->currency; ?>
														</b>
													</p>
												</td>
											</tr>
											<tr>
												<td colspan="2"><div id="horizonal"
														style="border-top: 1px solid black; width: 300px; position: absolute;"></div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>