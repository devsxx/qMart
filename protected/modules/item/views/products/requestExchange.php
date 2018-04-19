<style>
.product-exchange-view.product_active {
	background-color: #2FDAB8 !important;
}

.product-exchange-view:hover {
	background-color: #80a3bb;
}

.product-exchange-view {
	background-color: #EDEDED;
	height: 140px;
	width: 140px;
}

.btn-area-exchange {
	text-align: center;
	margin-top:5px;
}
</style>

<div class='show-exchange-content'>
<?php if(!empty($ownItems)) {
	foreach($ownItems as $product):
	$image = Myclass::getProductImage($product->productId);
	if(!empty($image)) {
		$img = $product->productId.'/'.$image;
	} else {
		$img = 'default.jpeg';
	}
	?>

	<div id="product_view_<?php echo $product->productId; ?>"
		value="<?php echo $product->productId; ?>"
		class="product-exchange-view">
		<?php echo CHtml::image(Yii::app()->createAbsoluteUrl("/item/products/resized/155/".$img),'',array('width' => '200','height' =>'200')); ?>
		<div class="pro_title">
		<?php echo $product->name; ?>
		</div>
	</div>
	<?php
	endforeach; }
	else { ?>
	<div class="record-not-found col-md-12" style="height: 300px;">
	<?php echo Yii::t('app','You haven’t added any products yet.')?>
	</div>
	<?php
	}?>
</div>
<?php if(!empty($ownItems)) { ?>
<div class="btn-area-exchange col-md-12">
	<button id="createExchange" class="btn-choose-option btn-done"
		onclick="createExchange(<?php echo $mainProductId; ?>,<?php echo $requestTo; ?>)">
		<?php echo Yii::t('app','Create Exchange'); ?>
	</button>
</div>
<div class="option-error"></div>
<?php } ?>

<script>
$(".option-error").hide();
$('.product-exchange-view').click(function() {
    $(this).addClass('product_active').siblings().removeClass('product_active');
    $(".option-error").hide();
    $(".btn-area-exchange").show();
    $(".btn-area-exchange").focus();
});
</script>

