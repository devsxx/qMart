<?php
$colorArray = array('50405d', 'f1ed6e', 'bada55', '5eaba6', 'ab5e63', '5eab86', 'deba5e', 'de5e82',
			'5e82de');
foreach($products as $ownItem){
	$randKey = array_rand($colorArray);
	$colorvalue = "#".$colorArray[$randKey];
	$soldData = '';
	if ($ownItem->quantity == 0 || $ownItem->soldItem == 1){
		$soldData = '<div class="sold-out more-item-sold"><i class="fa fa-dollar"></i> '.Yii::t('app','Sold Out').'</div>';
	}
	if(!empty($ownItem->photos[0]->name)) {
		$moreFromImage = Yii::app()->createAbsoluteUrl("/item/products/resized/155/".$ownItem->productId."/".$ownItem->photos[0]->name);
	}else{
		$moreFromImage = Yii::app()->createAbsoluteUrl("/item/products/resized/155/".'default.jpeg');
	}
	$moreFromCurrency = Myclass::getCurrency($ownItem->currency);
	$moreFromPrice = $ownItem->price;
	$moreFromUrl = Yii::app()->createAbsoluteUrl("item/products/view",array('id' => Myclass::safe_b64encode($ownItem->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($ownItem->name);
	?>
<li>
	<div class="more-from-li">
		<a href="<?php echo $moreFromUrl; ?>"
			title="<?php echo $ownItem->name ?>">
			<div class="more-from-image" style="background-image: url('<?php echo $moreFromImage; ?>');background-color:<?php echo $colorvalue; ?>">
			<?php echo $soldData; ?>
			</div>
			<div class="more-from-details">
			<?php echo $moreFromCurrency." ".$moreFromPrice; ?>
			</div>
		</a>
	</div>
</li>
			<?php } ?>