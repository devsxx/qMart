<?php 
$i=0;


$colorArray = array('50405d', 'f1ed6e', 'bada55', '5eaba6', 'ab5e63', '5eab86', 'deba5e', 'de5e82',
				'5e82de');
?>

<?php if (!isset($_POST['loadMore']) && !isset($_GET['loadData'])){ ?>
<!----------------------------- Staggered grid -------------------------------->
<input type="hidden" id="catrest" value="<?php echo $catrest; ?>" />
		<?php if ((isset($locationReset) && $locationReset == 0) && ($catrest == 0)){ ?>
		<div class="row show-world-wide" style="display: none;">
		<?php }else{ ?>		
		<div class="row show-world-wide">
		<?php } ?>
			<div class="no-item col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<div><?php //echo $catrest; ?>
					<span class="no-item-text col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php if(isset($locationReset) && $locationReset == 1 && $catrest == 0){ ?>
						<?php echo Yii::t('app','Sorry! No item this location'); ?>.
					<?php }elseif($catrest == 1){ ?>
						<?php echo Yii::t('app','Sorry! No item found'); ?>.
					<?php } ?>
					</span>
					<span class="world-wide col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo Yii::t('app','We are showing world wide'); ?>
					</span>
					<div class="back-botton col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>" class="back-btn">
							<?php echo Yii::t('app','Home'); ?>
						</a>
					</div>
				</div>				 			
			</div>			
		</div>
		
		<div class="slider container section_container">
			  <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Bottom to top-->
					  <div class="row product_align_cnt">
						<div id="fh5co-main">

							<div id="fh5co-board" data-columns>
		
							
<?php } ?>	
<?php if(!isset($_GET['loadData']) && (!empty($category) || !empty($search))) { ?>

<!-- <div class="col-md-12 category_button"> -->
<?php	//foreach($subcats as $subcat):
//echo "<pre>"; print_r($category);die;
$searchUrl = "";
if(!empty($search)){
	$searchUrl = "?search=".$search;
}
$categoryName = Myclass::getCategoryName($category);
?>
	<div>
	<div class="item categories">
		<div class="grid cs-style-3 no-hor-padding">
		<?php if(!empty($subcats)) { ?>
			<div class="categories-list col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			
				<ul><span class="for-sale-heading"><?php echo $categoryName; ?></span>
				<?php foreach($subcats as $subcat): 
				$subactive = "";$subIcon = "";
				$subcategoryUrl = Yii::app()->createAbsoluteUrl('/category/'.$category.'/'.$subcat->slug).$searchUrl;
				if($subcategory == $subcat->slug){
				$subactive = "active";
				$subcategoryUrl = Yii::app()->createAbsoluteUrl('/category/'.$category).$searchUrl;
				$subIcon = "<i class='fa fa-times-circle'></i> ";
				}?>
					<li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a class=" btn-lg btn-category <?php echo $subactive; ?>" href="<?php echo $subcategoryUrl; ?>"><?php echo $subcat->name; ?></a></li>
				<?php endforeach; ?>
				</ul>
				
			</div>
			<?php } ?>
			<div class="categories-filter-list col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<span class="for-sale-heading"><?php echo Yii::t('app','Search Only'); ?></span>
				<div class="checkbox col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<?php $urgentCheck = ""; if(isset($urgent) && $urgent == 1) $urgentCheck = "checked";?>
				  <label><input type="checkbox" name="sport[]" value="" <?php echo $urgentCheck; ?> class="cust_checkbox urgent" onclick="promotionsearch('urgent');" /><?php echo Yii::t('app','Urgent'); ?></label>
				</div>
				<div class="checkbox col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				 <?php $adsCheck = ""; if(isset($ads) && $ads == 1) $adsCheck = "checked";?>
				  <label><input type="checkbox" name="sport[]" value="" <?php echo $adsCheck; ?> class="cust_checkbox ads" onclick="promotionsearch('ads');" /><?php echo Yii::t('app','Popular'); ?></label>
				</div>
			</div>										
			
			<div class="categories-menu-list categories-list col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<ul><span class="for-sale-heading"><?php echo Yii::t('app','Other Categories'); ?></span>
				<?php 
				$categoryId[] = Myclass::getCategoryId($category);
				$categorypriority = Myclass::getCategory();
				//echo "<pre>"; print_r($categorypriority); die;
				foreach($categorypriority as $key => $categorypriority):
				if($categorypriority != "empty"){ 
					if(!in_array($categorypriority->categoryId,$categoryId)) {
						//$getcatdet = Myclass::getCatDetails($categorypriority);
						$categoryUrl = Yii::app()->createAbsoluteUrl('/category/'.$categorypriority->slug).$searchUrl;
						?>
							<li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="<?php echo $categoryUrl; ?>"><?php echo $categorypriority->name; ?></a></li>
						<?php 
					}
				}
				endforeach;
				?>
				</ul>
			</div>	
			
		</div>	
	</div>
	</div>
	<?php //endforeach; ?>
<!-- </div> -->

	<?php  } ?>
	
<?php 
if((!empty($products) && count($products) > 0) || (!empty($adsProducts) && count($adsProducts) > 0)){
	$productDetails = array();
	$adsIndex = 0;$adsPosition = rand(1,3);
	$currentRow = 0;
	if(count($products) < count($adsProducts)){
		$productSwap = $products;
		$products = $adsProducts;
		$adsProducts = $productSwap;
	}
	foreach($products as $productKey => $product):
		$productContent = "";
		$currentRow++;
		if($currentRow == 5)
			$currentRow = 1;
		//echo "<pre>";print_r($product);die;
		if($currentRow == $adsPosition && !empty($adsProducts[$adsIndex])){
			$adsproduct = $adsProducts[$adsIndex];
			//echo "<pre>";print_r($adsproduct->productId);die;
			$soldData = '';
			$randKey = array_rand($colorArray);
			$colorvalue = "#".$colorArray[$randKey];
			$image = Myclass::getProductImage($adsproduct->productId);
			if(!empty($image)) {
				$img = $adsproduct->productId.'/'.$image;
				$img = Yii::app()->createAbsoluteUrl('media/item/'.$img);
			
				$imageSize = getimagesize($img);
				$imageWidth = $imageSize[0];
				$imageHeigth = $imageSize[1];
				if ($imageWidth > 300 && $imageHeigth > 300){
					$img = Yii::app()->createAbsoluteUrl("/item/products/resized/300/".$adsproduct->productId.'/'.$image);
				}
			} else {
				$img = 'default.jpeg';
				$img = Yii::app()->createAbsoluteUrl('media/item/'.$img);
			}
			/* if ($adsproduct->quantity == 0 || $adsproduct->soldItem == 1){
				$soldData = '<div class="sold-out list"><i class="fa fa-dollar"></i> '.Yii::t('app','Sold Out').'</div>';
			} */
			
			$now = time(); // or your date as well
			$your_date = $adsproduct->createdDate; //strtotime("2010-01-01");
			//$datediff = $now - $your_date;
			$days = Myclass::getElapsedTime($your_date);
			//echo floor($datediff/(60*60*24));
			
			$productContent .= '<div>'; ?>
							
							
							
			<?php 
			$productContent .= '<div class="item product">';
			$productContent .= '<div class="grid cs-style-3 no-hor-padding">';
			$productContent .= '<div class="image-grid col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
			$productContent .= '<a href="'.Yii::app()->createAbsoluteUrl('item/products/view',array('id' => Myclass::safe_b64encode($adsproduct->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($adsproduct->name).'" class="fh5co-board-img">';
			$productContent .= '<div class="item-img productimage" style="/*background-image: url(\''.$img.'\');*/ background-color:'.$colorvalue.'">';
			//$productContent .= $soldData;
			$productContent .= '<img src="'.$img.'" alt="img"><span class="day-count">'.$days.' ago</span></div></a>';	
			if ($adsproduct->quantity == 0 || $adsproduct->soldItem == 1){
				$productContent .= '<span class="sold-out">'.Yii::t('app','Sold Out').'</span>';
			}elseif($adsproduct->promotionType == 2){
				$productContent .= '<span class="item-urgent">'.Yii::t('app','Urgent').'</span>';
			}elseif ($adsproduct->promotionType == 1){
				$productContent .= '<span class="item-ad">'.Yii::t('app','Ad').'</span>';
			}
			$productContent .= '<div class="rate_section pro_details">
											<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pro_price">';
									$productContent .= Myclass::getCurrency($adsproduct->currency).' '.$adsproduct->price;
								$productContent .= '</div>
											<div class="item-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pro_title">
												<a href="'.Yii::app()->createAbsoluteUrl('item/products/view',array('id' => Myclass::safe_b64encode($adsproduct->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($adsproduct->name).'">'.$adsproduct->name.'</a>';						
							$productContent .= '</div>';
											$productuser_det = Myclass::getUserDetails($adsproduct->userId);
							$productContent .= '<span class="item-location col-xs-12 col-sm-12 col-md-12 col-lg-12 ">'.$adsproduct->location.'</span>
										</div>
									</div>
								</div>	
							</div>
						</div>	';
			if($adsIndex < count($adsProducts)){
				$adsIndex += 1;
				$adsPosition = rand(1,3);
			}
			if(!isset($_GET['loadData'])){
				echo $productContent;
			}else{
				$productDetails[] = $productContent;
			}
			$productContent = "";
		}
		$soldData = '';
		$randKey = array_rand($colorArray);
		$colorvalue = "#".$colorArray[$randKey];
		$image = Myclass::getProductImage($product->productId);
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
		if ($product->quantity == 0 || $product->soldItem == 1){
			$soldData = '<span class="sold-out">'.Yii::t('app','Sold Out').'</span>';
		}
	
		$now = time(); // or your date as well
		$your_date = $product->createdDate; //strtotime("2010-01-01");
		//$datediff = $now - $your_date;
		$days = Myclass::getElapsedTime($your_date);
		//echo floor($datediff/(60*60*24));
		
		$productContent .= '<div>'; ?>
		
		
		
		<?php 
		$productContent .= '<div class="item product">';
		$productContent .= '<div class="grid cs-style-3 no-hor-padding">';
		$productContent .= '<div class="image-grid col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
		$productContent .= '<a href="'.Yii::app()->createAbsoluteUrl('item/products/view',array('id' => Myclass::safe_b64encode($product->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($product->name).'" class="fh5co-board-img">';
		$productContent .= '<div class="item-img productimage" style="/*background-image: url(\''.$img.'\');*/ background-color:'.$colorvalue.'">';
		$productContent .= $soldData;
		$productContent .= '<img src="'.$img.'" alt="img"><span class="day-count">'.$days.' ago</span></div></a>';	
		if($product->promotionType == 2){
			$productContent .= '<span class="item-urgent">'.Yii::t('app','Urgent').'</span>';
		}elseif ($product->promotionType == 1){
			$productContent .= '<span class="item-ad">'.Yii::t('app','Ad').'</span>';
		}
		$productContent .= '<div class="rate_section pro_details">
										<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pro_price">';
								$productContent .= Myclass::getCurrency($product->currency).' '.$product->price;
							$productContent .= '</div>
										<div class="item-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pro_title">
											<a href="'.Yii::app()->createAbsoluteUrl('item/products/view',array('id' => Myclass::safe_b64encode($product->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($product->name).'">'.$product->name.'</a>';						
						$productContent .= '</div>';
										$productuser_det = Myclass::getUserDetails($product->userId);
						$productContent .= '<span class="item-location col-xs-12 col-sm-12 col-md-12 col-lg-12 ">'.$product->location.'</span>
									</div>
								</div>
							</div>	
						</div>
					</div>	';
						
						
					
		$i++;
		if(!isset($_GET['loadData'])){
			echo $productContent;
		}else{
			$productDetails[] = $productContent;
		}
	endforeach;?>
<?php if (!isset($_POST['loadMore']) && !isset($_GET['loadData'])){ ?>
						</div>
						</div>
					  </div>
					  <!-- end Bottom to top-->
					  	
				</div>
			</div>
		</div>
		<input type="hidden" value="<?php echo $category; ?>" class="category-filter"/>
		<input type="hidden" value="<?php echo $subcategory; ?>" class="subcategory-filter"/>
		<input type="hidden" value="<?php echo $search; ?>" class="search-filter"/>
		<input type="hidden" value="<?php echo $urgent; ?>" class="urgent-filter"/>
		<input type="hidden" value="<?php echo $ads; ?>" class="ads-filter"/>
<!---------------------------------------------------- E O Staggered grid -------------------------------------------------------->
<?php }elseif (isset($_GET['loadData'])){
	echo json_encode($productDetails);
} ?>	
	<?php 
$total = count($products) + count($adsProducts);
 ?>
		<?php if($total >= 32 && !isset($_GET['loadData']) && !isset($_POST['loadMore'])) { ?>
		<div class="more-listing col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										  
		<?php echo CHtml::ajaxLink('<img src="'.Yii::app()->createAbsoluteUrl('images/design/load-more.png').'" alt="img"><div class="list-text">More listing</div>', array('loadresults','search' => $search,'category'=>$category,'subcategory' => $subcategory,'lat' => $lat, 'lon' => $lon),
		array(
		'beforeSend'=> 'js:function(){$(".more-listing").hide();$(".qMart-loader").show();}',
		'data'=> 'js:{"limit": limit, "offset": offset, "loadData": 1,"adsOffset": adsoffset,"urgent": urgent,"ads": ads}',
		'success' => 'js:function(response){ 
				//var grid = document.querySelector("#fh5co-board");
				var grid = document.querySelector("#fh5co-board");
				//$(".more-listing").remove();
				$(".more-listing").show();$(".qMart-loader").hide();
         		var output = response.trim();
				var contentData = eval($.trim(output));
				if (output) {
					offset = offset + limit;
					adsoffset = adsoffset + 8;
					//$("#products").append(output);   
					//$("#fh5co-board").append($.trim(output)); 
					//salvattore.recreateColumns(grid);
					for(var i = 0; i < contentData.length; i++){
			            var item = document.createElement("div");
						salvattore["append_elements"](grid, [item]);
						item.outerHTML = contentData[i];
					}
				} else {
					$(".qMart-loader").hide();
					$(".more-listing").hide();
				}
		 }',
		)
		); ?>
		</div>
		<div class="qMart-loader">
			<div class="cssload-loader"></div>
		</div>
		<?php }
}elseif(!isset($loadMore) && isset($_POST['loadMore']) && !isset($_GET['loadData'])){ ?>
	<div class="row">		
		<div class="no-item col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			<div>
				<span class="no-item-text col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php echo Yii::t('app','Sorry! No item this location'); ?>.
				</span>
				<span class="world-wide col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php echo Yii::t('app','We are showing world wide'); ?>
				</span>
				<div class="back-botton col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>" class="back-btn">
						<?php echo Yii::t('app','Back'); ?>
					</a>
				</div>
			</div>				 			
		</div>			
	</div>
	<!-- <div class="no-more" style="min-height: 320px;margin-top:3%">
		<div class="paypal-success" style="margin: 0 auto;">
			<div class="paypal-success-icon fa fa-exclamation-triangle"
				style="color: #2FDAB8; font-size: 40px;"></div>
			<br>
			<div class="not-found-message"><?php echo Yii::t('app','No Items Found.'); ?></div>
			<a class="btn btn-primary sell-button"
					href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"> <i
				class="fa fa-home" style="font-size: 20px;"> </i> <?php echo Yii::t('app','Back To Home Page'); ?>
				</a>
		</div>
	</div> -->
<?php } ?>
					      
				