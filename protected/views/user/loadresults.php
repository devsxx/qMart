

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
	$promotions='1';
	$soldData = '<span class="item-urgent">'.Yii::t('app','Urgent').'</span>';
}elseif ($product->promotionType == '1') {
	$promotions='1';
	$soldData = '<span class="item-ad">'.Yii::t('app','Ad').'</span>';
}elseif ($product->promotionType == '3') {
	$promotions='0';
}

if ($product->quantity == 0 || $product->soldItem == 1){
	$soldData = '<div class="sold-out list abs-sold-out"> '.Yii::t('app','Sold Out').'</div>';
	$promotions='1';
}
?>
<div class="profile-listing-product product-padding col-xs-12 col-sm-6 col-md-4 col-lg-4">
   <div class="image-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="prod-1" dataid="<?php echo $productId; ?>" style="background:url('<?php echo $img; ?>') no-repeat center center;background-size: cover;background-color:<?php echo $colorvalue; ?>;border-radius: 6px;">
   <div class="imghoverproductlist"> <!--profile-listing-product-hover col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding-->
   	<div class="profile-listing-opacity-bg col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
	<div class="product_view">
		<a style="text-decoration: none;" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view',array('id' => Myclass::safe_b64encode($product->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($product->name); ?>">
			<div class="productimage" style="background-image: url('<?php echo $img; ?>');background-color:<?php echo $colorvalue; ?>;">
			<?php echo $soldData; ?>
			</div>
		</a>
		<?php if(Yii::app()->user->id == $product->userId) { ?>
		<?php  if($promotions == '1'){ ?>
		<div class="profile-listing-btn-cnt single-btn col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view',array(
					'id' => Myclass::safe_b64encode($product->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($product->name); ?>" 
					style = "margin-bottom: 10px;" 
					class="edit-listing-btn col-xs-offset-3 col-xs-6 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6 no-hor-padding">
			<?php echo Yii::t('app','View Listing');  ?>
			</a>
			<a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/update',array('id' => Myclass::safe_b64encode($product->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($product->name); ?>" class="edit-listing-btn col-xs-offset-3 col-xs-6 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6 no-hor-padding">
			<?php echo Yii::t('app','Edit Listing');  ?>
			</a>
		</div>
		<?php }else{ ?> 
			<div class="profile-listing-btn-cnt double-btn col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view',array(
					'id' => Myclass::safe_b64encode($product->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($product->name); ?>" 
					style = "margin-bottom: 10px;" 
					class="edit-listing-btn col-xs-offset-3 col-xs-6 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6 no-hor-padding">
			<?php echo Yii::t('app','View Listing');  ?>
			</a>
			<a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/update',array('id' => Myclass::safe_b64encode($product->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($product->name); ?>" class="edit-listing-btn col-xs-offset-3 col-xs-6 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6 no-hor-padding">
			<?php echo Yii::t('app','Edit Listing');  ?>
			</a>
			<a href="javascript:void(0);" onclick = "showListingPromotion('<?php echo $product->productId; ?>')"
				class="promote-btn col-xs-offset-3 col-xs-6 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6 no-hor-padding">
				<?php echo Yii::t('app','Promote');  ?>
			</a>
		</div>
		<?php }  }else{ ?>
			<div class="profile-listing-btn-cnt single-btn col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view',array('id' => Myclass::safe_b64encode($product->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($product->name); ?>" class="edit-listing-btn col-xs-offset-3 col-xs-6 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6 no-hor-padding">
			<?php echo Yii::t('app','View Listing');  ?>
			</a>
			</div>
		<?php } ?>
		<!-- <div class="pro_details"><div class="pro_title"><?php echo $product->name; ?></div>
			<div class="pro_price"><?php echo Myclass::getCurrency($product->currency).' '.$product->price; ?></div><div class="posted_by"><?php $userDetails = Myclass::getUserDetails($product->userId);
			if(!empty($userDetails->userImage)) {
				$image = 'user/resized/22x22/'.$userDetails->userImage;
			} else {
				$image = 'user/resized/22x22/default/'.Myclass::getDefaultUser();
			} ?>
			<a class="userNameLink" href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))); ?>"><?php echo CHtml::image(Yii::app()->createAbsoluteUrl($image)).' '.$userDetails->name; ?></a></div></div>-->
			
			</div>
		</div>
	</div>

</div>
			<?php $i++;
			endforeach; ?>





