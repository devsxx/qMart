<div class="invoice-popup-head">
	<p class="ltit">
	<?php echo Yii::t('app','Invoice'); ?>
	</p>
	<button type="button" class="ly-close" id="btn-browses">x</button>
</div>
<div class="invoice-popup">
	<div style="margin-left: 10px;" id="userdata">
		<h2 style="background: #EFEFEF; font-size: 18px; padding: 6px 10px;"
			class="inv-head">
			<?php echo Yii::t('app','Order ID'); ?>
			#
			<?php echo $invoiceData['invoices'][0]['invoiceNo']; ?>
			<?php echo Yii::t('admin','on'); ?>
			<?php echo date("m/d/Y",$invoiceData['invoices'][0]['invoiceDate']); ?>
		</h2>
		<p
			style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;"
			class="pay-status">
			<?php echo Yii::t('admin','Payment Method'); ?>
			:
			<?php echo ucfirst($invoiceData['invoices'][0]['paymentMethod']); ?>
		</p>
		<p
			style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;"
			class="pay-status">
			<?php echo Yii::t('admin','Payment Status'); ?>
			:
			<?php echo ucfirst($invoiceData['invoices'][0]['invoiceStatus']); ?>
		</p>
		<div
			style="border-bottom: 1px solid #DEDEDE; margin-bottom: 14px; padding-top: 14px;"
			class="inv-clear"></div>
		<div class="buyerdiv">
			<div style="display: inline-block; float: left; width: 50%;"
				class="buyerper">
				<span
					style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;"
					class="pay-status"><?php echo Yii::t('admin','Buyer Details'); ?> </span><br>
				<span style="font-size: 14px; font-weight: bold;" class="pay-to">
														<a class="userNameLink" href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($invoiceData['user']['userId'].'-'.rand(0,999)))); ?>">
														<?php echo $invoiceData['user']['username']; ?>
														</a>
				</span><br> <span
					style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;"
					class="pay-status"><?php echo Yii::t('admin','Email'); ?> : <?php echo $invoiceData['user']['email']; ?>
				</span>
			</div>
			<div style="display: inline-block; width: 50%;" class="inv-shipping">
				<span
					style="color: #8D8D8D; font-size: 12px; margin-bottom: 0px; margin-top: 12px;"
					class="pay-status"><?php echo Yii::t('admin','Shipping Address'); ?>
				</span><br>
				<?php echo $invoiceData['user']['username']; ?>
				,<br>
				<?php echo $shipping->address1; ?>
				,<br>
				<?php echo $shipping->address2; ?>
				,<br>
				<?php echo $shipping->city; ?>
				- 962,<br>
				<?php echo $shipping->state; ?>
				,<br>
				<?php echo $shipping->country; ?>
				,<br><?php echo Yii::t('app','Phone'); ?> :
				<?php echo $shipping->phone; ?>
			</div>
		</div>
		<div
			style="border-bottom: 1px solid #DEDEDE; margin-bottom: 14px; padding-top: 14px;"
			class="inv-clear"></div>
		<table style="border: 1px solid;" class="Item-details">
			<thead style="background-color: #D3D3D3; color: #4D4D4D;">
				<tr>
					<th style="font-size: 14px; text-align: center;">Sl no.</th>
					<th style="font-size: 14px; text-align: center;"><?php echo Yii::t('admin','Item Name'); ?>
					</th>
					<th style="font-size: 14px; text-align: center;"><?php echo Yii::t('admin','Item Quantity'); ?>
					</th>
					<th style="font-size: 14px; text-align: center;"><?php echo Yii::t('admin','Item Unitprice'); ?>
					</th>
					<th style="font-size: 14px; text-align: center;"><?php echo Yii::t('admin','Shipping fee'); ?>
					</th>
					<th style="font-size: 14px; text-align: center;"><?php echo Yii::t('admin','Total Price'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td
						style="font-size: 14px; padding: 6px; width: 145px; text-align: center;">1</td>
					<td
						style="font-size: 14px; padding: 6px; width: 145px; text-align: center;"><?php echo $invoiceData['orderitems'][0]['itemName']; ?>
					</td>
					<td
						style="font-size: 14px; padding: 6px; width: 145px; text-align: center;"><?php echo $invoiceData['orderitems'][0]['itemQuantity']; ?>
					</td>
					<td
						style="font-size: 14px; padding: 6px; width: 145px; text-align: center;"><?php echo $invoiceData['orderitems'][0]['itemunitPrice'].' '.$invoiceData->currency; ?>
					</td>
					<td
						style="font-size: 14px; padding: 6px; width: 145px; text-align: center;"><?php echo (int)$invoiceData['orderitems'][0]['shippingPrice'].' '.$invoiceData->currency; ?>
					</td>
					<td
						style="font-size: 14px; padding: 6px; width: 145px; text-align: center;"><?php $total = $invoiceData->totalCost;
						echo $total.' '.$invoiceData->currency; ?></td>
				</tr>
			</tbody>
		</table>
		<div style="margin-top: 12px; margin-left: 450px; width: 300px;">
			<table>
				<tbody>
					<tr>
						<td align="left" style="width: 200px;"><p class="gtotal"><?php echo Yii::t('admin','Item Total'); ?></p></td>
						<td style="width: 50px;"></td>
						<td align="right" style="width: 100px;"><p class="gtotal"
								style="text-align: right;">
								<b><?php echo $total-(int)$invoiceData->totalShipping.' '.$invoiceData->currency; ?>
								</b>
							</p></td>
					</tr>
					<?php if(!empty($invoiceData->discount)) { ?>
					<tr>
						<td align="left"><p class="gtotal"><?php echo Yii::t('admin','Discount Amount'); ?></p></td>
						<td style="width: 50px;"></td>
						<td align="right"><p class="gtotal" style="text-align: right;">
								<b><?php echo '(-) '.(int)$invoiceData->discount.' '.$invoiceData->currency; ?>
								</b>
							</p></td>
					</tr>
					<?php } ?>
					<tr>
						<td align="left"><p class="gtotal"><?php echo Yii::t('admin','Shipping fee'); ?></p></td>
						<td style="width: 50px;"></td>
						<td align="right"><p class="gtotal" style="text-align: right;">
								<b><?php echo (int)$invoiceData->totalShipping.' '.$invoiceData->currency; ?>
								</b>
							</p></td>
					</tr>

					<tr>
						<td colspan="2"><div
								style="border-top: 1px solid black; width: 300px; position: absolute; margin-top: -6px;"
								id="horizonal"></div></td>
					</tr>
					<?php $grandTotal = $total - $invoiceData->discount;?>
					<tr>
						<td align="left"><p class="gtotal"><?php echo Yii::t('admin','Grand Total'); ?></p></td>
						<td style="width: 50px;"></td>
						<td align="right"><p class="gtotal" style="text-align: right;">
								<b><?php echo $grandTotal.' '.$invoiceData->currency; ?> </b>
							</p></td>
					</tr>
					<tr>
						<td colspan="2"><div
								style="border-top: 1px solid black; width: 300px; position: absolute;"
								id="horizonal"></div></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
