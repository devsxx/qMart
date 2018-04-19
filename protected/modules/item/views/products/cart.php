<?php //echo "<pre>";print_r($merchantList); ?>
<div class="cart-container">
<?php if($cartCount == 0){ ?>
	<h1><?php echo Yii::t('app','Your cart is empty'); ?></h1>
<?php }else{ ?>
	<div class='cart-title'>
		<h1><?php echo Yii::t('app','You have'); ?> <?php echo $cartCount; ?> <?php echo Yii::t('app','item(s) in your cart'); ?></h1>
		<div class='cart-details'>
			<?php foreach ($merchantList as $merchant){
				$merchantName = $merchant['merchantName'];
				$merchantId = $merchant['merchantId'];
				echo "<div class='shop".$merchantId."'>";
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
				echo "<div class='shop-sidebar'>";
					echo "<div class='ship-details'>";
						echo "";
					echo "</div>";
				echo "</div>";
				echo "</div>";
			} ?>
		</div>
	</div>
<?php } ?>
</div>

<style>
.item-row {
    float: left;
    margin-bottom: 20px;
    width: 100%;
}
.item-image {
    float: left;
    margin-right: 10px;
}
.item-details {
    float: left;
}
.item-details p {
    margin-bottom: 10px;
}
.item-quantity {
    display: inline-block;
    float: left;
    height: 100px;
}	
.item-total {
    float: left;
    font-size: 14px;
    font-weight: bold;
    height: 100px;
    padding: 0 15px;
}		
</style>