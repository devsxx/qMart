<?php
if($paypalSettings['paypalType'] == 2){
	echo "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post' id='paypal-form'>";
}elseif($paypalSettings['paypalType'] == 1){
	echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' id='paypal-form'>";
}
$currency = explode('-',$productModel->currency);
?>

<input type="hidden" name="business" value="<?php echo $productModel->paypalid; ?>" />
<input type="hidden" name="charset" value="utf-8">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="upload" value="1">
<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="lc" value="UK" />
<input type="hidden" name="currency_code" value="<?php echo $currency[1]; ?>" />
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />

<?php
if ($productDetails['options'] == ''){
	$price = $productModel->price;
}else{
	$options = json_decode($productModel->sizeOptions, true);
	$optionDetails = $options[$productDetails['options']];
	if ($optionDetails['price'] != ''){
		$price = $optionDetails['price'];
	}else{
		$price = $productModel->price;
	}
}
?>
<input
	type="hidden" name="item_name"
	value="<?php echo $productModel->name; ?>">
<input
	type="hidden" name="quantity"
	value="<?php echo $productDetails['quantity']; ?>">
<input
	type="hidden" name="item_number"
	value="<?php echo $productModel->productId; ?>">
<input
	type="hidden" name="shipping"
	value="<?php echo $productDetails['shippingPrice']; ?>">
<input
	type="hidden" name="amount" value="<?php echo $price; ?>">
<input type='hidden'
	name='custom'
	value='<?php echo $userModel->email.
			"-_-".$productDetails['shippingId']."-_-".$productDetails['options']."-_-".
			$productDetails['couponId']; ?>' />
			<?php if ($productDetails['discount'] != 0){ ?>
<input
	type="hidden" name="discount_amount"
	value="<?php echo $productDetails['discount']; ?>">
<<?php } ?>
<!-- Enable override of buyers's address stored with PayPal .
<input type="hidden" name="address_override" value="1">
<input type="hidden" name="first_name" value="John">
<input type="hidden" name="last_name" value="Doe">
<input type="hidden" name="address1" value="345 Lark Ave">
<input type="hidden" name="city" value="San Jose">
<input type="hidden" name="state" value="CA">
<input type="hidden" name="zip" value="95121">
<input type="hidden" name="country" value="US">
 -->
<input
	type="hidden" name="cancel_return"
	value="<?php echo Yii::app()->createAbsoluteUrl('/canceled'); ?>">
<input
	type="hidden" name="return"
	value="<?php echo Yii::app()->createAbsoluteUrl('/success'); ?>">

<input
	type="hidden" name="notify_url"
	value="<?php echo Yii::app()->createAbsoluteUrl('/ipnprocess'); ?>" />
</form>

