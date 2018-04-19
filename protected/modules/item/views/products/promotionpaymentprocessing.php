<?php
if($paypalSettings['paypalType'] == 2){
	echo "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post' id='paypal-form'>";
}elseif($paypalSettings['paypalType'] == 1){
	echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' id='paypal-form'>";
}
$currency = $promotionCurrency;
?>

<input type="hidden" name="business" value="<?php echo $paypalSettings['paypalEmailId']; ?>" />
<input type="hidden" name="charset" value="utf-8">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="upload" value="1">
<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="lc" value="UK" />
<input type="hidden" name="currency_code" value="<?php echo $currency; ?>" />
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />

<input type="hidden" name="item_name" value="Product Promotion">
<input type="hidden" name="item_number" value="<?php echo $_POST['productId']; ?>">
<input type="hidden" name="amount" value="<?php echo $price; ?>">
<input type='hidden' name='custom' value='<?php echo $customField; ?>' />
			
<input
	type="hidden" name="cancel_return"
	value="<?php echo Yii::app()->createAbsoluteUrl('/canceled'); ?>">
<input
	type="hidden" name="return"
	value="<?php echo Yii::app()->createAbsoluteUrl('/success'); ?>">

<input
	type="hidden" name="notify_url"
	value="<?php echo Yii::app()->createAbsoluteUrl('/promotionipnprocess'); ?>" />
</form>
