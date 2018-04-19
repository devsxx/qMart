<?php
//echo "<pre>";print_r($shippingAddressesModel);die;
echo '<div class="revieworder-head">';
if($paypalSettings['paypalCcStatus'] == 1){ ?>
	<ul>
		<li class="revieworder-li active"><?php echo Yii::t('app','Review Order'); ?></li>
		<li class="paymentdetails-li"><?php echo Yii::t('app','Payment Method'); ?></li>
	</ul>
<?php }else{ ?>
	<ul>
		<li class="revieworder-li active"><?php echo Yii::t('app','Review Order'); ?></li>
	</ul>
<?php } ?>
</div>
<div class="revieworder-container">
	<div class="revieworder-details">
		<div class="shipping-address-container">
		<?php if(!empty($shippingAddressesModel)) { ?>
		<?php echo Yii::t('app','Select a address'); ?>
			: <select class='shipping-addresses' onchange='return shippingChange()'>
				<?php
				foreach ($shippingAddressesModel as $shippingAddresses){
					$nickName = $shippingAddresses->shippingaddressId.'-'.$shippingAddresses->nickname;
					$nicknameLabel = $shippingAddresses->nickname;
					$selected = '';
					if ($nicknameLabel == $shippingAddress->nickname)
					$selected = 'selected';
					echo "<option value='$nickName' $selected>$nicknameLabel</option>";
				}?>
			</select>
			<?php } else { echo '<span style="color:red">'.Yii::t('app',"You haven’t added any shipping address yet.").'</span>'; }?>
			<button class="btn btn-success pull-right" onclick="showcouponpopup()">
			<?php echo Yii::t('app','Add Shipping'); ?>
			</button>
			<br> <br>
			<?php  if(!empty($shippingAddress)) { ?>
			<div class="country-error" style="color: red"></div>
			<div class="address-details">
				<div class="address-view">
					<?php echo Yii::t('app','Address Details'); ?>
					:
				</div>
				<input type="text" value="<?php echo $shippingAddress->name; ?>"
					class="fullname" name="fullname" disabled> <input type="text"
					value="<?php echo $shippingAddress->address1; ?>" class="address1"
					name="address1" disabled> <input type="text"
					value="<?php echo $shippingAddress->address2; ?>" class="address2"
					name="address2" disabled>
				<div class="city-zip-container">
					<input type="text" value="<?php echo $shippingAddress->city; ?>"
						class="city" name="city" disabled> <input type="text"
						value="<?php echo $shippingAddress->zipcode; ?>" class="pincode"
						name="pincode" disabled>
				</div>
				<input type="text" value="<?php echo $shippingAddress->state; ?>"
					class="state" name="state" disabled> <input type="text"
					value="<?php echo $shippingAddress->country; ?>" class="country"
					name="country" disabled> <input type="text"
					value="<?php echo $shippingAddress->phone; ?>" class="phoneno"
					name="phoneno" disabled> <input type="hidden"
					value="<?php echo $shippingAddress->shippingaddressId; ?>"
					class="selected-shipping">
			</div>
			<!-- <div class="shipping-error">
			<?php echo $shippingEnable == 0 ? Yii::t('app',"Item cannot be shipped to your location") : ""; ?>
			</div> -->
	
			<?php } else { ?>
			<div class="address-details">
	
				<div class="address-view">
				<?php echo Yii::t('app','Address Details'); ?>
					:
				</div>
				<input type="text" value="" class="fullname" name="fullname" disabled>
				<input type="text" value="" class="address1" name="address1" disabled>
				<input type="text" value="" class="address2" name="address2" disabled>
				<div class="city-zip-container">
					<input type="text" value="" class="city" name="city" disabled> <input
						type="text" value="" class="pincode" name="pincode" disabled>
				</div>
				<input type="text" value="" class="state" name="state" disabled> <input
					type="text" value="" class="country" name="country" disabled> <input
					type="text" value="" class="phoneno" name="phoneno" disabled> <input
					type="hidden" value="" class="selected-shipping">
			</div>
			<?php }?>
	
			<div class="shipping-time-container">
				<p class="shipping-time">
				<?php echo Yii::t('app','Estimated delivery time'); ?>
				</p>
				<?php echo $reviewOrder['shippingTime']; ?>
			</div>
		</div>
		<div class="order-details-container">
			<div class="coupon-container">
				<input type="text"
					placeholder="<?php echo Yii::t('app','Enter Coupon Code'); ?>"
					class="couponCode"></input>
				<button type="button" class="btn btn-success"
					onclick="return applyCoupon()">
					<?php echo Yii::t('app',substr('Apply',0,5)); ?>
				</button>
				<div class="option-error pull-right"></div>
			</div>
			<div class="order-item-properties">
	
				<div class="seller-name">
					<a class="userNameLink"
						href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($reviewOrder['sellerId'].'-'.rand(0,999)))); ?>"><?php echo $reviewOrder['sellername']; ?>
					</a>
				</div>
				<div class="product-details">
					<div class="product-image">
						<a
							href='<?php echo Yii::app()->createAbsoluteUrl('item/products/view',array(
								'id'=>Myclass::safe_b64encode($reviewOrder['itemId'].'-'.rand(0,999)))).'/'.Myclass::productSlug($reviewOrder['name']); ?>'
							title="<?php echo $reviewOrder['name'];?>" target="_blank"> <img
							src="<?php echo Yii::app( )->getBaseUrl( )."/item/products/resized/70x70/".
								$reviewOrder['itemId']."/".$reviewOrder['productimage']; ?>"
							alt="<?php echo $reviewOrder['name'];?>">
						</a>
					</div>
	
					<div class="product-property">
						<ul>
							<li class="product-name"><?php echo $reviewOrder['name']; ?></li>
							<?php if($reviewOrder['option'] != '0'){ ?>
							<li class="product-option"><span class="title"><?php echo Yii::t('app','Size'); ?>:
							</span> <?php echo $reviewOrder['option']; ?> <input type="hidden"
								class="product-option-hidden"
								value="<?php echo $reviewOrder['option']; ?>">
							</li>
							<?php }else{ ?>
							<input type="hidden" class="product-option-hidden" value="">
							<?php } ?>
							<li class="product-qqty"><span class="title"><?php echo Yii::t('app','Quantity'); ?>:
							</span> <?php //echo $reviewOrder['cartquantity']; ?> <input
								type="hidden" class="product-quantity-hidden"
								value="<?php echo $reviewOrder['cartquantity']; ?>"> <select
								class='product-quantity' onchange='changeQuantity()'>
								<?php for($i=1; $i <= $reviewOrder['totalquantity']; $i++ ) {
									$selected = '';
									if ($i == $reviewOrder['cartquantity'])
									$selected = 'selected';
									echo "<option value='$i' $selected>$i</option>";
								} ?>
							</select>
							</li>
							<li class="product-price"><span class="title"><?php echo Yii::t('app','Unit Price'); ?>:
							</span> <?php echo $reviewOrder['price']." ".$reviewOrder['currency']; ?>
								<input type="hidden" class="product-unit-price"
								value="<?php echo $reviewOrder['price']; ?>">
							</li>
						</ul>
						<input type="hidden" class="review-order-seller-id"
							value="<?php echo $reviewOrder['sellerId']; ?>"> <input
							type="hidden" class="review-order-product-id"
							value="<?php echo $reviewOrder['itemId']; ?>"> <input
							type="hidden" class="sub-total-hidden"
							value="<?php echo $reviewOrder['price'] * $reviewOrder['cartquantity']; ?>">
						<input type="hidden" class="coupon-value-hidden" value=""> <input
							type="hidden" class="coupon-type-hidden" value=""> <input
							type="hidden" class="coupon-code-hidden" value=""> <input
							type="hidden" class="coupon-max-hidden" value="">
					</div>
				</div>
				<div class="product-summary">
					<input type="hidden" class="currency"
						value="<?php echo $reviewOrder['currency']; ?>" />
					<div class="product-sub-total">
					<?php echo Yii::t('app','Subtotal'); ?>
						: <span class="amnt product-item-total"> <?php echo $reviewOrder['price'] * $reviewOrder['cartquantity']." ".$reviewOrder['currency']; ?>
						</span>
					</div>
					<input type="hidden" class="product-sub-total-hidden"
						value="<?php echo $reviewOrder['price'] * $reviewOrder['cartquantity']; ?>" />
					<div class="product-shipping">
					<?php echo Yii::t('app','Shipping Cost'); ?>
						: <span class="amnt product-item-shippingcost"> <?php echo $reviewOrder['shippingCost']." ".$reviewOrder['currency']; ?>
						</span> <input type="hidden" class="item-shipping"
							value="<?php echo $reviewOrder['shippingCost']; ?>">
					</div>
					<div class="coupon-discount"></div>
					<input type="hidden" class="product-coupon-discount" value="0">
					<div class="product-grand-total">
					<?php echo Yii::t('app','Order Total'); ?>
						: <span class="amnt product-item-grandtotal"> <?php echo ($reviewOrder['price'] * $reviewOrder['cartquantity']) + $reviewOrder['shippingCost']." ".$reviewOrder['currency']; ?>
						</span>
					</div>
				</div>
			</div>
			<?php if(!empty($shippingAddressesModel)) { 
					if($paypalSettings['paypalCcStatus'] == 1){
						$checkoutFunction = "paymentMethod();";
					}else{
						$checkoutFunction = "checkout();";
					}
			?>
			<button class="check-out-button" id="check-out-button" onclick="<?php echo $checkoutFunction; ?>">
				<?php echo Yii::t('app','Proceed to payment'); ?>
			</button>
			<?php  } else { ?>
			<button class="check-out-button" id="check-out-button" disabled="true">
			<?php echo Yii::t('app','Proceed to payment'); ?>
			</button>
			<?php }//echo "<pre>";print_r($paypalSettings);  ?>
			<div class="payment-form"></div>
		</div>
	</div>
	<div class="payment-details">
		<div class="payment-side-menu">
			<ul>
				<li class="paypal-payment side-menu-1 side-menu active" data-page="1">
					<?php echo Yii::t('app','Paypal account'); ?>
				</li>
				<li class="credit-card-payment side-menu-2 side-menu" data-page="2">
					<?php echo Yii::t('app','Credit Card'); ?>
				</li>
			</ul>
		</div>
		<div class="payment-main">
			<div class="pay-with-paypal page-1">
				<p class="paypal-info"><?php echo Yii::t('app', 'Click the button below to proceed to pay with paypal'); ?></p>
				<button class="check-out-button" id="check-out-button" onclick="checkout();">
					<?php echo Yii::t('app','Checkout'); ?>
				</button>
			</div>
			<div class="credit-card-details page-2">
				<div class="card-type-label"><?php echo Yii::t('app','Pay with'); ?></div>
				<div class="card-type-option-container">
					<span class="card-type-view fa fa-circle-o visa" onclick="changeCard('visa');"> <?php echo Yii::t('app','Visa'); ?></span>
					<span class="card-type-view fa fa-circle-o mastercard" onclick="changeCard('mastercard');"> <?php echo Yii::t('app','Master Card'); ?></span>
					<span class="card-type-view fa fa-circle-o discover" onclick="changeCard('discover');"> <?php echo Yii::t('app','Discover'); ?></span>
					<span class="card-type-view fa fa-circle-o amex" onclick="changeCard('amex');"> <?php echo Yii::t('app','Amex'); ?></span>
				</div>
				<input type="hidden" class="card-type" value="" />
				<div class="card-type-error ccError"></div>
				<br>
				<input type="text" class="card-number" placeholder="Card Number" maxlength="16" onkeypress="return isNumber(event)" />
				<div class="card-number-error ccError"></div>
				<br><br>
				<input type="text" class="card-expiry" placeholder="Card Expiry MM/YYYY" />
				<img src='<?php echo Yii::app()->createAbsoluteUrl('images/ccv.jpg')?>' alt="CVV" class="cvv-img" />
				<input type="text" class="card-cvv" placeholder="CVV Number" maxlength="3" onkeypress="return isNumber(event)" />
				<br>
				<div class="card-expiry-error ccError"></div>
				<div class="card-cvv card-cvv-error ccError"></div>
				<br>
				<input type="text" class="card-first-name" placeholder="First name on Card" onkeypress="return isAlpha(event)" />
				<input type="text" class="card-last-name" placeholder="Last name on Card" onkeypress="return isAlpha(event)" />
				<div class="card-first-name card-first-name-error ccError"></div>
				<div class="card-last-name card-last-name-error ccError"></div>
				<br><br>
				<button class="check-out-button" id="check-out-button" onclick="return cardcheckout();">
					<?php echo Yii::t('app','Pay'); ?>
				</button>
			</div>
		</div>
	</div>
	<div id="popup_container">
		<div id="show-coupon-popup" style="display: none; width: 700px;"
			class="popup ly-title update show-exchange-popup">
			<p class="ltit">
			<?php echo Yii::t('app','Add Shipping'); ?>
			</p>
			<button type="button" class="ly-close" id="btn-browses">x</button>
			<div class="coupon-popup">
			<?php $this->renderPartial('addshipping',array('model' => new Tempaddresses,'countriesList' => $countriesList)); ?>
			</div>
		</div>
	</div>
</div>
			<?php $shippingRange = json_encode($itemShippings);
			$shippingCost = json_encode($itemShippingCost,true);
			?>
<input
	type="hidden" class="shipping-range-hidden"
	value=<?php echo $shippingRange; ?> />
<input
	type="hidden" class="shipping-cost-hidden"
	value=<?php echo $shippingCost; ?> />

<script>
$(document).ready(function() {
	var country = $(".country").val();
    checkRange(country);
});
</script>


<style>
.option-error {
	background-color: #FFFFFF;
	color: #DF2525;
	display: none;
	padding: 4px;
	position: absolute;
	z-index: 20;
	margin-top: 0;
}
.coupon-container button
{
	width:22%;
    overflow: hidden;
    text-overflow: ellipsis;	
}
</style>
