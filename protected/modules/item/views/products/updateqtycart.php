<?php 
if ($cartCount != 0){
	foreach ($merchantList as $merchant){
		$merchantName = $merchant['merchantName'];
		$merchantId = $merchant['merchantId'];
		echo "<div class='merchant-details'>Order form $merchantName</div>";
		echo "<div class='merchant-item'>";
		foreach ($merchantItemList[$merchantId] as $cartItem){
			echo "<div class='item-row'>";
				echo "<div class='item-image'>";
					echo '<img src="'.Yii::app( )->getBaseUrl( )."/item/products/resized/100x100/".
	$cartItem['itemId']."/".$cartItem['productimage'].'" alt="'.$cartItem['name'].'">';
				echo "</div>";
				echo "<div class='item-details'>";
					echo "<p class='item-name'>{$cartItem['name']}</p>";
					echo "<p class='item-option'>Option: {$cartItem['option']}</p>";
					echo "<p class='item-seller'>Seller: {$cartItem['sellername']}</p>";
					echo "<p class='item-shipping'>Shipping: {$cartItem['shippingTime']}</p>";
				echo "</div>";
				echo "<div class='item-quantity'>";
					echo "Qty: <select class='cart-qty-{$cartItem['itemId']}' 
							onchange='updatecart($merchantId, {$cartItem['itemId']})'>";
					for($i=1;$i<=$cartItem['totalquantity'];$i++){
						$select = '';
						if ($i == $cartItem['cartquantity'])
							$select="selected";
						echo "<option $select value='$i'>$i</option>";
					}
					echo "</select>";
				echo "</div>";
				
				echo "<div class='item-total'>";
					echo "<p class='item-price'>".$cartItem['price'] * $cartItem['cartquantity']."</p>";
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";
		echo "</div>";
	}
}else{
	echo "false";
}