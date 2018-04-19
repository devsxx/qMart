<?php //echo "<pre>";print_r($sales[0]->seller);die; ?>
<div class="page-container item-view">
	<div class="col-md-10 my-orders-container">
		<div class="container listing-contianer" id="sales">

			<h1>
			<i class="fa fa-briefcase"></i>
			<?php echo Yii::t('app','My Sales'); ?>
			</h1>
			<?php if(!empty($sales)) { ?>
			<div class="layout-container">
			<?php foreach($sales as $order){
				$productId = $order['orderitems'][0]['productId'];
				$check = Products::model()->findByPk($productId);
				if(!empty($check)) {
					$productImage = $order['orderitems'][0]->product->photos[0]->name;
				}
				$productName = $order['orderitems'][0]['itemName'];
				$productQuanity = $order['orderitems'][0]['itemQuantity'];
				$productVarient = $order['orderitems'][0]['itemSize'];
				$orderPrice = $order['orderitems'][0]['itemPrice'];
				$orderTotal = $order['totalCost'];
				$orderTotalShipping = (int)$sales[0]['totalShipping']; ?>
				<div class="single-layout">
					<div class="header">
						<div class="btn-group navbar-form">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo Yii::t('app','More Actions'); ?><span
								class="caret"></span> </a>
							<ul class="dropdown-menu">
							<?php if($order->status == 'pending') { ?>
								<li><a style="cursor: pointer"
									onclick="changeSalesStatus('processing','<?php echo $order->orderId; ?>')"><?php echo Yii::t('app','Mark Process'); ?>
								</a>
								</li>
								<?php } if($order->status == 'pending' || $order->status == 'processing') { ?>
								<li><a style="cursor: pointer"
									href="<?php echo Yii::app()->createAbsoluteUrl('shippingconfirm/'.Myclass::safe_b64encode($order->orderId.'-0')); ?>"><?php echo Yii::t('app','Mark as Shipped'); ?>
								</a></li>
								<?php } if($order->status == 'delivered') { ?>
								<!-- <li><a href="javascript:void(0);" disabled="true">Add Tracking</a> -->
								</li>
								<?php } else { ?>
								<li><a
									href="<?php echo Yii::app()->createAbsoluteUrl('tracking/'.Myclass::safe_b64encode($order->orderId.'-0'));?>"><?php echo Yii::t('app','Add Tracking'); ?>
								</a></li>
								<?php } ?>
								<li><a
									onclick="showinvoicepopup(<?php echo $order->orderId; ?>)"><?php echo Yii::t('app','View Invoice'); ?>
								</a>
								</li>
								<li><a
									href="<?php echo Yii::app()->createAbsoluteUrl('message/'.Myclass::safe_b64encode($order->userId.'-0'));?>"><?php echo Yii::t('app','Contact Buyer'); ?>
								</a></li>
							</ul>

						</div>
						<div class="product-order-number">
							<p class="order-id">
								<?php echo Yii::t('app','Order ID'); ?>: <span class="show-status"><?php echo $order['invoices'][0]['invoiceNo']; ?>
								</span>
							</p>
						</div>
					</div>
					<div class="content">
						<div class="image-div">
						<a style="text-decoration: none;" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view', 
									array('id' => Myclass::safe_b64encode($productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($productName); ?>" target="_blank">
							<?php if(!empty($check)) { ?>
							<img
								src='<?php echo Yii::app()->createAbsoluteUrl("/item/products/resized/100/".$productId."/".$productImage); ?>'
								title='<?php echo $productName;?>' />
								<?php } else { ?>
							<img
								src='<?php echo Yii::app()->createAbsoluteUrl("/item/products/resized/100/".'default.jpeg'); ?>'
								title='<?php echo $productName;?>' />
								<?php } ?>
							</a>
						</div>
						<div class="product-details">
							<p class="product-name">
							<?php echo $productName; ?>
							</p>
							<p class="product-qty">
							<?php echo Yii::t('app','Quantity'); ?>
								: <span class="quantity"><?php echo $productQuanity; ?> </span>
							</p>
							<?php if ($productVarient != ""){ ?>
							<p class="product-qty varient-option">
							<?php echo Yii::t('app','Option'); ?>
								: <span class="quantity"><?php echo $productVarient; ?> </span>
							</p>
							<?php } ?>
						</div>
						<div class="product-cost-details">
							<p class="product-amount">
							<?php echo Yii::t('app','Total Cost'); ?>
								:
								<?php echo $orderPrice.' '.$order->currency ; ?>
							</p>
							<p class="product-amount">
							<?php echo Yii::t('app','Shipping'); ?>
								:
								<?php echo $orderTotalShipping.' '.$order->currency ; ?>
							</p>
							<?php if ($order['discountSource'] != ""){ $orderTotal -= $order['discount']; ?>
							<p class="product-offer">
							<?php echo Yii::t('app','Coupon'); ?>
								: <span class="coupon-code"><?php echo $order->discountSource; ?>
								</span>
							</p>
							<p class="product-offer-value">
							<?php echo Yii::t('app','Coupon Value'); ?>
								: <span class="coupon-amnt"><?php echo $order['discount']; ?> </span>
							</p>
							<?php } ?>
						</div>
						<div class="product-order-status">
							<p class="status">
							<?php echo Yii::t('app','Order Status'); ?>
								: <span class="show-status"><?php echo Yii::t('app',$order->status); ?>
								</span>
							</p>
							<?php if(!empty($order->statusDate)) { ?>
							<p class="status-date">
							<?php echo Yii::t('app','Delivered On'); ?>
								: <span class="show-status"><?php echo date('dS M Y',$order->statusDate) ; ?>
								</span>
							</p>
							<?php } ?>
						</div>

					</div>
					<div class="footer">
						<p class="seller-details">
						<?php $userDetail = Myclass::getUserDetails($order->userId); ?>
							<?php echo Yii::t('app','Buyer'); ?>: <span class="seller-name"><a class="userNameLink" href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetail->userId.'-'.rand(0,999)))); ?>"><?php echo $userDetail->name; ?></a>
						</p>
						<p class="order-date">
						<?php echo Yii::t('app','Date'); ?>
							: <span class="date-details"><?php echo date('dS M Y',$order->orderDate); ?>
							</span>
						</p>
						<p class="order-total">
						<?php echo Yii::t('app','order total'); ?>
							: <span class="order-total-amnt"><?php echo $orderTotal.' '.$order->currency; ?>
							</span>
						</p>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php $this->widget('CLinkPager',array('pages' => $pages)); } else {
				echo '<div class="record-not-found">'.Yii::t('app','You haven’t performed any sales yet.').'</div>';
			}?>
		</div>
	</div>
</div>
			<?php
			$pages = Yii::app()->request->getParam('page');
			?>
<input
	type="hidden" class="page-value-hidden" value="<?php echo $pages; ?>" />
<div id="popup_container">
	<div id="show-exchange-popup"
		style="display: none; width: 800px; overflow-y: hidden; height: auto; margin-bottom: 20px;"
		class="popup ly-title update show-invoice-popup"></div>
</div>
