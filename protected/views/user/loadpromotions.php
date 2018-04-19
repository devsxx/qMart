<?php 
if(isset($products[0]['product'])) {
foreach($products as $key=>$product) { 
	$image = Myclass::getProductImage($product['product']->productId);
	$product_id = $product['product']->productId;
	$pdtURL = Yii::app()->createAbsoluteUrl("/item/products/resized/300/".$product['product']->productId."/".$image); 
	?>
	<div class="promotion-product product-padding col-xs-12 col-sm-6 col-md-3 col-lg-3">
	<a href="javascript:void(0)" onclick="switchVisible_promotion(<?php echo $product['product']->productId; ?>);" class="promotionclick" id="promotiondiv<?php echo $product_id; ?>"><div class="image-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="prod-1" style="background: rgba(0, 0, 0, 0) url('<?php echo $pdtURL; ?>') no-repeat scroll center center / cover ;border: 1px solid #d0dbe5 !important; ">
	</div>	
	<div class="promotion-product-info-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	<div class="promotion-product-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo $product['product']->name; ?></div>
	</div></a>
	</div>
<?php } 
} else { 
	foreach($products as $key=>$product) {
		$image = Myclass::getProductImage($product->productId);
		$product_id = $product->productId;
		$pdtURL = Yii::app()->createAbsoluteUrl("/item/products/resized/300/".$product->productId."/".$image);
		?>
		<div class="promotion-product product-padding col-xs-12 col-sm-6 col-md-3 col-lg-3">
		<a href="javascript:void(0)" onclick="switchVisible_promotion(<?php echo $product->productId; ?>);" class="promotionclick" id="promotiondiv<?php echo $product_id; ?>"><div class="image-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="prod-1" style="background: rgba(0, 0, 0, 0) url('<?php echo $pdtURL; ?>') no-repeat scroll center center / cover ;border: 1px solid #d0dbe5 !important; ">
		</div>	
		<div class="promotion-product-info-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<div class="promotion-product-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo $product->name; ?></div>
		</div></a>
		</div>
	<?php } 
}?>
