

<?php $i=0;
$colorArray = array('50405d', 'f1ed6e', 'bada55', '5eaba6', 'ab5e63', '5eab86', 'deba5e', 'de5e82',
				'5e82de');
foreach($products as $product):
$soldData = '';
echo $action;
$randKey = array_rand($colorArray);
$colorvalue = "#".$colorArray[$randKey];
$productId = $product->productId;
$image = Myclass::getProductImage($productId);

if(!empty($image)) {
	$img = $product->productId.'/'.$image;
	$img = Yii::app()->createAbsoluteUrl('media/item/'.$img);

	$imageSize = getimagesize($img);
	$imageWidth = $imageSize[0];
	$imageHeigth = $imageSize[1];
	if ($imageWidth > 300 && $imageHeigth > 300){
		$img = Yii::app()->createAbsoluteUrl("/item/products/resized/300/".$product->productId.'/'.$image);
	}
} else {
	$img = 'default.jpeg';
	$img = Yii::app()->createAbsoluteUrl('media/item/'.$img);
}

if($product->promotionType == '2'){
	$soldData = '<span class="item-urgent">'.Yii::t('app','Urgent').'</span>';
}elseif ($product->promotionType == '1') {
	$soldData = '<span class="item-ad">'.Yii::t('app','Ad').'</span>';
}elseif ($product->promotionType == '3') {
}

if ($product->quantity == 0 || $product->soldItem == 1){
	$soldData = '<div class="sold-out list abs-sold-out"> '.Yii::t('app','Sold Out').'</div>';
}
?>

<div class="profile-listing-product product-padding col-xs-12 col-sm-6 col-md-4 col-lg-4">
   <div class="image-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="prod-1" dataid="<?php echo $productId; ?>" style="background:url('<?php echo $img; ?>') no-repeat center center;background-size: cover;background-color:<?php echo $colorvalue; ?>;border-radius: 6px;">
   	<a style="text-decoration: none;" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view',array('id' => Myclass::safe_b64encode($product->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($product->name); ?>">
	<div class="product_view" style="height:100%">
		
			<div class="productimage"> <?php echo $soldData; ?> </div>
		
			
			</div>
			</a>
	</div>

</div>
			<?php $i++;
			endforeach; ?>





