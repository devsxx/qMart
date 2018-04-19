<?php
/* @var $this ProductsController */
/* @var $model Products */
$sitePaymentModes = Myclass::getSitePaymentModes();
?>
<?php if(!empty($photoModel[0]->name)) {
	$this->fbimg = Yii::app()->createAbsoluteUrl("/item/products/resized/250x250/".$model->productId."/".$photoModel[0]->name);
} else {
	$this->fbimg = Yii::app()->createAbsoluteUrl("/item/products/resized/250x250/".'default.jpeg');
}
$soldData = '';
if ($model->quantity == 0 || $model->soldItem == 1){
	$soldData = '<div class="sold-out item-view"><i class="fa fa-dollar"></i> '.Yii::t('app','Sold Out').'</div>';
}

$userDet = Myclass::getUserDetails($model->userId);

if(!empty($photoModel[0]->name)) {
	$viewImageURL = Yii::app()->createAbsoluteUrl("/media/item/".$model->productId."/".$photoModel[0]->name);
} else {
	$viewImageURL = Yii::app()->createAbsoluteUrl("/item/products/resized/500/".'default.jpeg');
} ?>

		<div class="container">
		  <div class="row">
			<div class="product-left-container col-xs-12 col-sm-12 col-md-8 col-lg-8">
	
				<!----Mobile slider---->
				<div id="carousel-example-generic" class="mobile-product-slide carousel slide" data-ride="carousel" data-interval="false">
					
					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
					  <div class="product-image item active" id="prod-img-1" data-thumb="0" style="background: rgba(0, 0, 0, 0) url('<?php echo $viewImageURL; ?>') no-repeat scroll center center / cover;  background-size: auto 100% !important;"></div>
					  <?php $slide_photoModel = $photoModel;
						$mob_photoModel = array_splice($slide_photoModel, 1);
						foreach($mob_photoModel as $phts) {
							$moreProductURL = Yii::app()->createAbsoluteUrl("/media/item/".$model->productId."/".$phts->name);
					 ?>
					  <div class="product-image item" id="prod-img-1" data-thumb="0" style="background: rgba(0, 0, 0, 0) url('<?php echo $moreProductURL; ?>') no-repeat scroll center center / cover ;  background-size: auto 100% !important;"></div>
					 <?php } ?>
					  
					</div>
					<?php //echo "<pre>"; print_r($photoModel); die; ?>
					<!-- Controls -->
					<?php if(count($photoModel) > 1) { ?>
						<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						  <span class="thmb-slider-arrow-left"></span>
						  <span class="sr-only"><?php echo Yii::t('app','Previous'); ?></span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						  <span class="thmb-slider-arrow-right"></span>
						  <span class="sr-only"><?php echo Yii::t('app','Next'); ?></span>
						</a>
					<?php } ?>
				 </div>
				 <!----E O mobile slider---->
			
				<div id="carousel" class="non-mobile-product-slide carousel slide" data-ride="carousel" data-interval="false">
					<div class="carousel-inner product-img">
						  <div class="product-image item active" id="prod-img-1" data-thumb="0" style="background: rgba(0, 0, 0, 0) url('<?php echo $viewImageURL; ?>') no-repeat scroll center center;  background-size: auto 100% !important; margin-top:10px; margin-bottom:10px;"></div>
						   
						  <?php foreach($photoModel as $phts) {
							$moreProductURL = Yii::app()->createAbsoluteUrl("/media/item/".$model->productId."/".$phts->name);
					 	?>
					  <div class="product-image item" id="prod-img-1" data-thumb="0" style="background: rgba(0, 0, 0, 0) url('<?php echo $moreProductURL; ?>') no-repeat scroll center center;  background-size: auto 100% !important; margin-top:10px;"></div>
					 	<?php } ?>
					  					  
					</div>

				</div> 
				<?php if(count($photoModel) > 1) { ?>
				<div class="product-thmb-slider clearfix">
					 <div id="thumbcarousel" class="carousel slide" data-interval="false">
					  <div class="slider-fix-left"></div>
					  <div class="slider-fix-right"></div>
					  <div class="carousel-inner">
					   <div class="item active">
						<?php foreach($photoModel as $key=>$phts) {
							$key = $key + 1;
							//$moreProductURL = Yii::app()->createAbsoluteUrl("/media/item/".$model->productId."/".$phts->name);
							$moreProductURL = Yii::app()->createAbsoluteUrl('/item/products/resized/125/'.$phts->productId.'/'.$phts->name);
					 	?>
						<div data-target="#carousel" data-slide-to="<?php echo $key; ?>" class="col-sm-2 col-lg-2 thumb-cnt thumb "><div class="product-image" id="prod-thmb-img-1" style="background: rgba(0, 0, 0, 0) url('<?php echo $moreProductURL; ?>') no-repeat scroll center center / cover ;"></div></div>
						<?php } ?>
						
					   </div><!-- /item --> 
					  <?php if(count($photoModel) > 6) { //echo "<pre>"; print_r($photoModel); die;
							$totalmodel = (ceil(count($photoModel) / 6 )) - 1;
							$i = 6;
						for($a=0; $a<$totalmodel; $a++) {		
						?>
						   <div class="item">
							<?php 
								$next_slide_photoModel = $photoModel;
								
								$sec_photoModel = array_slice($next_slide_photoModel,$i, 6,true);
								
								$itmcount = $i + 5; 
								for($j=$i; $j<=$itmcount; $j++) {
								//foreach($sec_photoModel as $phts) {
									//$moreProductURL = Yii::app()->createAbsoluteUrl("/media/item/".$model->productId."/".$phts->name);
									$moreProductURL = Yii::app()->createAbsoluteUrl('/item/products/resized/125/'.$sec_photoModel[$j]->productId.'/'.$sec_photoModel[$j]->name);
								$k = $j + 1;
					 		?>
							<div data-target="#carousel" data-slide-to="<?php echo $k; ?>" class="col-sm-2 col-lg-2 thumb-cnt thumb "><div class="product-image" id="prod-thmb-img-1" style="background: rgba(0, 0, 0, 0) url('<?php echo $moreProductURL; ?>') no-repeat scroll center center / cover ;"></div></div>
							<?php  
								} 
								$i = $i + 6;
								
							?>
						   </div><!-- /item -->
					  <?php } ?>
					  
					  <?php } ?>
					  </div><!-- /carousel-inner -->
					  <?php if(count($photoModel) > 6) { ?>
						  <a class="thmb-slider-bg-left left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
						   <span class="thmb-slider-arrow-left"></span>
						  </a>
						  <a class="thmb-slider-bg-right right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
						   <span class="thmb-slider-arrow-right"></span>
						  </a>
					 <?php } ?>
					 </div> <!-- /thumbcarousel -->
				</div><!-- /clearfix -->
				<?php } ?>
				
				<div class="mobile-product-details col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="product-page-right-top-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="product-details col-xs-10 col-sm-10 col-md-10 col-lg-10 no-hor-padding">
								<div class="product-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo $model->name; ?></div>
								<div class="product-price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Myclass::getCurrency($model->currency).' '. $model->price; ?></div>
							</div>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 no-hor-padding">
								<div id="mobile_favs">
								<?php
								if(empty($fav))
									echo CHtml::link('<div class="product-like col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pull-right"></div>','javascript:void(0)',array('onclick' => 'mobile_like('.$model->productId.')'));
								else
									echo CHtml::link('<div class="product-like col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pull-right" id="liked"></div>','javascript:void(0)',array('onclick' => 'mobile_dislike('.$model->productId.')'));
								?>
								</div>
								<div class="like-counter col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><span id="mobile_like_counter"><?php echo $model->likes.'</span> '.Yii::t('app','likes'); ?></div>
								
							</div>
						</div>
					
						<div class="used-status-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<?php if(!empty($model->productCondition)) { ?>
								<div class="used-status"><?php echo $model->productCondition; ?></div>
							<?php } ?>
							<div class="days-reviews-counter"><?php echo Myclass::getElapsedTime($model->createdDate).' '.Yii::t('app','ago'); ?> <span>|</span> <span><?php echo $model->views; ?><?php echo Yii::t('app',' views'); ?></span></div>
						</div>
						
						<?php if($model->instantBuy != '0' && $sitePaymentModes['buynowPaymentMode'] == 1){ ?>
							<div class="shipping-cost-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="shipping-icon"></div>
								<div class="shipping-cost product-location">
									<?php echo Yii::t('app','Shipping Cost')." : ".Myclass::getCurrency($model->currency).$model->shippingCost; ?>
								</div>
							</div>
						<?php } ?>
					
						<div class="product-location-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="location-grey"></div>
							<div class="product-location"><?php echo $model->location; ?></div>
						</div>
						<input type="hidden" value="<?php echo $model->userId; ?>"
						class="product-user-id" /> <input type="hidden"
						value="<?php echo $model->location; ?>" class="product-location-name" />
						<input type="hidden" value="<?php echo $model->latitude; ?>"
						class="product-location-lat" /> <input type="hidden"
						value="<?php echo $model->longitude; ?>"
						class="product-location-long" /> <input type="hidden"
						class="price-option-hidden"
						value="<?php echo Myclass::getCurrency($model->currency); ?>" /> <input
						type="hidden" class="product-price-hidden"
						value="<?php echo $model->price; ?>" />
						<div class="product-address-map col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<!--<iframe class="map-location" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.981439797375!2d78.12887091420681!3d9.935501992895396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b06df970b004121%3A0x19575d843fba74f1!2sHitasoft+Technology+Solutions+P.LTD!5e0!3m2!1sen!2sin!4v1463666763983" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
							<div id="mobile_map_canvas" class="map-location" style="width: 600; height: 450"></div>
						</div>
						<?php 
						$logUserid = Yii::app()->user->id;
						$sellerId = $userModel->userId;	
						?>
						<?php if($logUserid != $sellerId) { 
							if(empty($logUserid)) { ?>
								<a href="<?php echo Yii::app()->createAbsoluteUrl('login/'); ?>"><div class="btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><img src="<?php echo Yii::app()->createAbsoluteUrl('images/chat-with-seller-icon.png'); ?>" alt="chat-icon"><span><?php echo Yii::t('app','Chat with seller'); ?></span></div>
								</div></a>
								<?php if($model->instantBuy != '0' && $sitePaymentModes['buynowPaymentMode'] == 1) { ?>
									<a href="<?php echo Yii::app()->createAbsoluteUrl('login/'); ?>"><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo Yii::t('app','Buy now'); ?>
									</div></a>
								<?php } ?>
								<?php if($model->myoffer == '0') { ?>
									<a href="<?php echo Yii::app()->createAbsoluteUrl('login/'); ?>"><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo Yii::t('app','Make an offer'); ?>
									</div></a>
								<?php } ?>
								<?php if($model->exchangeToBuy != '0' && $sitePaymentModes['exchangePaymentMode'] == 1) { ?>
									<a href="<?php echo Yii::app()->createAbsoluteUrl('login/'); ?>" ><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo Yii::t('app','Exchange to buy'); ?>
									</div></a>
								<?php } ?>
							<?php } else { ?>
								<a href="" data-toggle="modal" data-target="#chat-with-seller-modal"><div class="btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><img src="<?php echo Yii::app()->createAbsoluteUrl('images/chat-with-seller-icon.png'); ?>" alt="chat-icon"><span><?php echo Yii::t('app','Chat with seller'); ?></span></div>
								</div></a>
								<?php if($model->instantBuy != '0' && $sitePaymentModes['buynowPaymentMode'] == 1) { ?>
									<?php $cartDataURL = Myclass::cart_encrypt($model->productId."-0", 'joy*ccart'); ?>
									<a href="<?php echo Yii::app()->createAbsoluteUrl('revieworder/'.$cartDataURL); ?>">
										<div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<?php echo Yii::t('app','Buy now'); ?>
										</div>
									</a>
								<?php } ?>
								<a href="" data-dismiss="modal" data-toggle="modal" data-target="#offer-modal"><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo Yii::t('app','Make an offer'); ?>
								</div></a>
								<?php if($model->exchangeToBuy != '0' && $sitePaymentModes['exchangePaymentMode'] == 1) { ?>
									<a href="" data-dismiss="modal" data-toggle="modal" data-target="#exchange-modal"><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo Yii::t('app','Exchange to buy'); ?>
									</div></a>
								<?php } ?>
							<?php }  ?>
							
						<?php } else { ?>
							<a href="<?php echo Yii::app()->createAbsoluteUrl('item/products/update',array('id' => Myclass::safe_b64encode($model->productId.'-'.rand(0,999)))); ?>" ><div class="btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<?php echo Yii::t('app','Edit Item'); ?>
						</div></div></a>
						<?php } ?>
					</div>	
				</div>
				
				<!--tab section-->
				<div class="tab-section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<ul class="tab-section-tabs nav nav-tabs">
					  <li class="active"><a data-toggle="tab" href="#desc"><?php echo Yii::t('app','Description'); ?></a></li>
					  <li><a data-toggle="tab" href="#comment"><?php echo Yii::t('app','Comments'); ?></a></li>
					  <?php   if (Yii::app()->user->id != $model->userId){ ?>
					  <li class="pull-right">
					  <?php 
						$reportedUsers = json_decode($model->reports, true);
						//echo "roja".$reportedUsers;die;
						if (in_array(Yii::app()->user->id, $reportedUsers)){ ?>
							<a id = "unreportflag" onclick = "reportflag()" class="exclamatory-cnt item-report" href="javascript:;"><span class="report-active exclamatory-icon-active"></span><span class="report-text"><?php echo Yii::t('app','Undo reporting'); ?></span></a>
						<?php }else{ ?>
							<a id = "reportflag" class="exclamatory-cnt item-report" href="javascript:;"><span class="report-active exclamatory-icon"></span><span class="report-text"><?php echo Yii::t('app','Report inappropriate'); ?></span></a>
						<?php } ?>
					</li>
					<?php } ?>
					</ul>

					<div class="tab-section-content tab-content" style="word-break:break-all;">
					  <div id="desc" class="tab-pane fade in active">
						<div class="comment-text-cnt more">
							<?php   if(strlen($model->description) > 500) {
									$desc = substr($model->description,0,500);
									echo nl2br($desc); ?><span class="ellipses">...&nbsp&nbsp</span>
									<?php 
									$desclength = strlen($model->description);
									$moredesc = substr($model->description,500,$desclength);
									?>
									<span class="moredesc" style="display:none;"><?php echo nl2br($moredesc); ?></span>
									
									<a class="morelink showmoredesc" href="javascript:;" onClick="showmoredesc()"><?php echo Yii::t('app','More Info'); ?></a>
									<a class="morelink hidemoredesc" href="javascript:;" onClick="lessmoredesc()" style="display:none;"><?php echo Yii::t('app','Less Info'); ?></a>
								<?php
								} else {
									$desc = $model->description;
									echo nl2br($desc);
								} 
								?>
						</div>
						
					  </div>
					  <div id="comment" class="tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						 <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						  <textarea class="comment-text-area form-control commenter-text" rows="5" id="comment" onkeyup="limitText(120);" placeholder="<?php echo Yii::t('app','Type your message')?>" maxlength="120"></textarea>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="character-left"><p> <?php echo Yii::t('app','You have'); ?><span id="countdown">120</span> <?php echo Yii::t('app','character left.'); ?></p></div>
							<div class="post-comment col-xs-12 pull-right"><a class="upload-btn" id="post-comment" href="javascript: void(0)" onClick="postcomment()" style="color:#fff;"><?php echo Yii::t('app','Post Comment'); ?></a></div>
						<input type="hidden" name="logindetails" class="logindetails" value="<?php echo $user; ?>" />
						<?php $commentCount = count($commentModel); ?>
						<input type="hidden" id="commentCount" value="<?php echo $commentCount; ?>">
						
						</div>
						<div class="comment-error" style="float:right;color: red;font-size: 12px; "></div>
						<div class="comment-section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<?php if(!empty($commentModel)) {
								$min_commentModel =  array_slice($commentModel,0,3);
								foreach ($min_commentModel as $comment){
								$userDetails = Myclass::getUserDetails($comment->userId); ?>
								<div class="comment col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="cmt-1">
								
								<?php
									if(!empty($userDetails->userImage)) {
										$user_profile = Yii::app()->createAbsoluteUrl('user/resized/40x40/'.$userDetails->userImage);
									} else {
										$user_profile = Yii::app()->createAbsoluteUrl('user/resized/40x40/default/'.Myclass::getDefaultUser());
									}
								?>
								
									<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))); ?>"><div class="comment-profile-default icon col-xs-2 col-sm-2 col-md-1 col-lg-1 no-hor-padding" style="background: rgba(0, 0, 0, 0) url('<?php echo $user_profile; ?>') no-repeat scroll center center / cover; border-radius:20px; "></div></a>
									<div class="comment-content icon col-xs-10 col-sm-10 col-md-11 col-lg-11 no-hor-padding">
										<div class="comment-user-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))); ?>"><?php echo $userDetails->name; ?></a></div>
										<div class="comment-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<p><?php echo $comment->comment; ?></p>
											<div class="comment-timing-detail col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<p><?php echo Myclass::getElapsedTime($comment->createdDate).' '.Yii::t('app','ago'); ?></p>
											</div>
										</div>									
									</div>
								</div>
								<?php } 
							} else { ?>
								<div class="empty-comment">
								<?php echo Yii::t('app','Be the first one to comment on this product.')?>
								</div>
							<?php } ?>
							




						
						<?php if(count($commentModel) > 3) { ?>
							
							
							<?php
								$max_commentModel =  array_slice($commentModel,3);
								foreach ($max_commentModel as $comment){
								$userDetails = Myclass::getUserDetails($comment->userId); ?>
								<div class="comment view_more_comnts col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="cmt-1" style="display:none;">
								
								<?php
									if(!empty($userDetails->userImage)) {
										$user_profile = Yii::app()->createAbsoluteUrl('user/resized/40x40/'.$userDetails->userImage);
									} else {
										$user_profile = Yii::app()->createAbsoluteUrl('user/resized/40x40/default/'.Myclass::getDefaultUser());
									}
								?>
								
									<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))); ?>"><div class="comment-profile-default icon col-xs-2 col-sm-2 col-md-1 col-lg-1 no-hor-padding" style="background: rgba(0, 0, 0, 0) url('<?php echo $user_profile; ?>') no-repeat scroll center center / cover; border-radius:20px; "></div></a>
									<div class="comment-content icon col-xs-10 col-sm-10 col-md-11 col-lg-11 no-hor-padding">
										<div class="comment-user-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))); ?>"><?php echo $userDetails->name; ?></a></div>
										<div class="comment-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<p><?php echo $comment->comment; ?></p>
											<div class="comment-timing-detail col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<p><?php echo Myclass::getElapsedTime($comment->createdDate).' '.Yii::t('app','ago'); ?></p>
											</div>
										</div>									
									</div>
								</div>
								<?php } ?>
							<?php } ?>
						</div>	
						<?php if(count($commentModel) > 3) { ?>
							<div class="view-all-comment view-more-comnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="javascript:;" onClick="showmorecomment()"><?php echo Yii::t('app','View all comments'); ?></a></div>
							<div class="view-all-comment hide-more-comnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="display:none;"><a href="javascript:;" onClick="hidemorecomment()"><?php echo Yii::t('app','Hide the comments'); ?></a></div>
						<?php } ?>
						
					  </div>
					</div>
					<?php   if (Yii::app()->user->id != $model->userId){
						$reportedUsers = json_decode($model->reports, true); ?>
					<div class="mobile-report-div col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<?php
					if (in_array(Yii::app()->user->id, $reportedUsers)){ ?>
						
							<a href="javascript:;" id = "mob_unreportflag" onclick = "reportflag()" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding mob-item-report">
								<span class="col-xs-4 col-sm-4 no-hor-padding"><span class="report-mob-active exclamatory-icon-active pull-right"></span></span>
								<span class="mob-report-text col-xs-8 col-sm-8 no-hor-padding"><?php echo Yii::t('app','Undo reporting'); ?></span>
							</a>
						
					<?php } else { ?>
						
							<a href="javascript:;" id = "mob_reportflag" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding mob-item-report">
								<span class="col-xs-4 col-sm-4 no-hor-padding"><span class="report-mob-active exclamatory-icon pull-right"></span></span>
								<span class="mob-report-text col-xs-8 col-sm-8 no-hor-padding"><?php echo Yii::t('app','Report inappropriate'); ?></span>
							</a>
						
					<?php }  ?>
					</div>
					<?php }  ?>
				</div>
				
			</div> 
			
			<div class="product-right-container col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="product-page-right-top-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="product-details col-xs-12 col-sm-12 col-md-10 col-lg-10 no-hor-padding">
							<div class="product-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo $model->name; ?></div>
							<div class="product-price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Myclass::getCurrency($model->currency).' '. $model->price; ?></div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 no-hor-padding">
							<div id="favs">
								<?php
								if(empty($fav))
									echo CHtml::link('<div class="product-like col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pull-right"></div>','javascript:void(0)',array('onclick' => 'like('.$model->productId.')'));
								else
									echo CHtml::link('<div class="product-like col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pull-right" id="liked"></div>','javascript:void(0)',array('onclick' => 'dislike('.$model->productId.')'));
								?>
							</div>
							<div class="like-counter col-xs-12 col-sm-12 col-md-12 col-lg-11 no-hor-padding" style="margin-left:11px; text-align:center;"><span id="like_counter"><?php echo $model->likes.'</span> '.Yii::t('app','likes'); ?></div>
							
						</div>
					</div>
				
					<div class="used-status-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php if(!empty($model->productCondition)) { ?>
							<div class="used-status"><?php echo $model->productCondition; ?></div>
						<?php } ?>
						<div class="days-reviews-counter"><?php echo Myclass::getElapsedTime($model->createdDate).' '.Yii::t('app','ago'); ?> <span>|</span> <span><?php echo $model->views; ?> <?php echo Yii::t('app','views'); ?></span></div>
					</div>
						
					<?php if($model->instantBuy != '0' && $sitePaymentModes['buynowPaymentMode'] == 1){ ?>
						<div class="shipping-cost-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="shipping-icon"></div>
							<div class="shipping-cost product-location">
								<?php echo Yii::t('app','Shipping Cost')." : ".Myclass::getCurrency($model->currency).$model->shippingCost; ?>
							</div>
						</div>
					<?php } ?>
				
					<div class="product-location-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="location-grey"></div>
						<div class="product-location"><?php echo $model->location; ?></div>
					</div>
				
					<div class="product-address-map col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<!--<iframe class="map-location" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.981439797375!2d78.12887091420681!3d9.935501992895396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b06df970b004121%3A0x19575d843fba74f1!2sHitasoft+Technology+Solutions+P.LTD!5e0!3m2!1sen!2sin!4v1463666763983" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
						<div id="map_canvas" class="map-location" style="width: 600; height: 450"></div>
					</div>
				
					<?php 
						$logUserid = Yii::app()->user->id;
						$sellerId = $userModel->userId;	
					?>
					<?php if($logUserid != $sellerId) { 
						if(empty($logUserid)) { ?>
							<a href="<?php echo Yii::app()->createAbsoluteUrl('login/'); ?>"><div class="btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><img src="<?php echo Yii::app()->createAbsoluteUrl('images/chat-with-seller-icon.png'); ?>" alt="chat-icon"><span><?php echo Yii::t('app','Chat with seller'); ?></span></div>
							</div></a>
							<?php if($model->instantBuy != '0' && $sitePaymentModes['buynowPaymentMode'] == 1 && $model->quantity > 0 && $model->soldItem != 1) { ?>
								<a href="<?php echo Yii::app()->createAbsoluteUrl('login/'); ?>">
									<div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo Yii::t('app','Buy now'); ?>
									</div>
								</a>
							<?php } ?>
							<?php if($model->myoffer == '0') { ?>
								<a href="<?php echo Yii::app()->createAbsoluteUrl('login/'); ?>" ><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo Yii::t('app','Make an offer'); ?>
								</div></a>
							<?php } ?>
							<?php if($model->exchangeToBuy != '0' && $sitePaymentModes['exchangePaymentMode'] == 1) { ?>
								<a href="<?php echo Yii::app()->createAbsoluteUrl('login/'); ?>"><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo Yii::t('app','Exchange to buy'); ?>
								</div></a>
							<?php } ?>
						<?php } else { ?>
							<a href="" data-dismiss="modal" data-toggle="modal" data-target="#chat-with-seller-modal"><div class="btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><img src="<?php echo Yii::app()->createAbsoluteUrl('images/chat-with-seller-icon.png'); ?>" alt="chat-icon"><span><?php echo Yii::t('app','Chat with seller'); ?></span></div>
							</div></a>
							<?php if($model->instantBuy != '0' && $sitePaymentModes['buynowPaymentMode'] == 1 && $model->quantity > 0 && $model->soldItem != 1) { ?>
								<?php $cartDataURL = Myclass::cart_encrypt($model->productId."-0", 'joy*ccart'); ?>
								<a href="<?php echo Yii::app()->createAbsoluteUrl('revieworder/'.$cartDataURL); ?>">
									<div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo Yii::t('app','Buy now'); ?>
									</div>
								</a>
							<?php } ?>
							<?php if($model->myoffer == '0') { ?>
								<a href="" data-dismiss="modal" data-toggle="modal" data-target="#offer-modal"><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo Yii::t('app','Make an offer'); ?>
								</div></a>
							<?php } ?>
							<?php if($model->exchangeToBuy != '0' && $sitePaymentModes['exchangePaymentMode'] == 1) { ?>
								<a href="" data-dismiss="modal" data-toggle="modal" data-target="#exchange-modal"><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo Yii::t('app','Exchange to buy'); ?>
								</div></a>
							<?php } ?>
						<?php } ?> 
						
					<?php } else { ?>
						<a href="<?php echo Yii::app()->createAbsoluteUrl('item/products/update',array('id' => Myclass::safe_b64encode($model->productId.'-'.rand(0,999)))); ?>" ><div class="btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php echo Yii::t('app','Edit Item'); ?>
					</div></div></a>
					<?php } ?>
				</div>	
				
				<div class="product-page-right-bottom-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="about-the-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php echo Yii::t('app','About the seller'); ?>
					</div>
					
					<div class="seller-details col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="col-xs-5 col-sm-2 col-md-4 col-lg-4 no-hor-padding">
								<?php
								if(!empty($userModel->userImage)) {
									$seller_profile = Yii::app()->createAbsoluteUrl('user/resized/85/'.$userModel->userImage);
								} else {
									$seller_profile = Yii::app()->createAbsoluteUrl('user/resized/85/default/'.Myclass::getDefaultUser());
								}
								?>
								<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userModel->userId.'-'.rand(0,999)))); ?>"><div class="seller-prof-pic" style="background: rgba(0, 0, 0, 0) url('<?php echo $seller_profile; ?>') no-repeat scroll center center / cover ;"></div></a>
								<?php if($userModel->mobile_status == '1' && !empty($userModel->facebookId)) { ?>
									<div class="seller-verified-icon"></div>
								<?php } ?>
							</div>
							<div class="col-xs-7 col-sm-10 col-md-8 col-lg-8 no-hor-padding">
								<div class="seller-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userModel->userId.'-'.rand(0,999)))); ?>"><?php echo $userModel->name; ?></a></div>
								<div class="seller-verification col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php if($userModel->mobile_status == '1') { ?>
										<div class="mobile-verification" id="verified" data-toggle="tooltip" title="<?php echo Yii::t('app','Mobile number Verified!');?>"></div>
									<?php } else { ?>
										<div class="mobile-verification" data-toggle="tooltip" title="<?php echo Yii::t('app','Mobile number is not Verified!');?>"></div>
									<?php } ?>
									<?php if(!empty($userModel->facebookId)) { ?>
										<div class="fb-verification" id="verified" data-toggle="tooltip" title="<?php echo Yii::t('app','Facebook account Verified!');?>"></div>
									<?php } else { ?>
										<div class="fb-verification" data-toggle="tooltip" title="<?php echo Yii::t('app','Facebook account is not Verified!');?>"></div>
									<?php } ?>
									<div class="mail-verification" id="verified" data-toggle="tooltip" title="<?php echo Yii::t('app','Mail Id Verified!');?>"></div>
								</div>
							</div>							
						</div>
						
						<div class="seller-qMart-detail col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="product-counter-container col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userModel->userId.'-'.rand(0,999)))); ?>"><div class="btn-product-counter">
									<div class="counter"><?php echo $itemCount; ?></div>
									<div class="counter-label"><?php echo Yii::t('app','Item(s)'); ?></div>
								</div></a>	
							</div>
							
							<div class="product-counter-container col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<a href="<?php echo Yii::app()->createAbsoluteUrl('user/following',array('id' => Myclass::safe_b64encode($userModel->userId.'-'.rand(0,999)))); ?>"><div class="btn-product-counter">
									<div class="counter following-count"><?php echo $followingCount; ?></div>
									<div class="counter-label"><?php echo Yii::t('app','Following(s)'); ?></div>
								</div></a>	
							</div>

							<div class="product-counter-container col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<a href="<?php echo Yii::app()->createAbsoluteUrl('user/follower',array('id' => Myclass::safe_b64encode($userModel->userId.'-'.rand(0,999)))); ?>"><div class="btn-product-counter">
									<div class="counter follower-count"><?php echo $followerCount; ?></div>
									<div class="counter-label"><?php echo Yii::t('app','Follower(s)'); ?></div>
								</div></a>	
							</div>	
						</div>
						<?php
						if(empty($logUserid)) { ?>
							<a href="<?php echo Yii::app()->createAbsoluteUrl('login'); ?>" ><div class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="margin-top:20px;">
								<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><span id="sellerfollow<?php echo $sellerId; ?>" style="color:#515e6a;"><?php echo Yii::t('app','Follow'); ?></span></div>
								</div>
								</a>

						<?php } else { 
						    if($logUserid != $sellerId) { 
							echo '<input type="hidden" value="1" id="seller_follow">';
							if(empty($checkFollow)) { ?>
								<a href="javascript:;" onclick="getfollows(<?php echo $sellerId; ?>)" id="follow<?php echo $sellerId; ?>" class="btn-make-an-offer col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="margin-top:20px;">
								<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><span id="sellerfollow<?php echo $sellerId; ?>" style="color:#515e6a;"><?php echo Yii::t('app','Follow'); ?></span></div>
								</a>
							<?php } else { ?>
								<a href="javascript:;" onclick="deletefollows(<?php echo $sellerId; ?>)" id="follow<?php echo $sellerId; ?>" class="btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="border:1px solid #2bc248;">
								<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><span id="sellerfollow<?php echo $sellerId; ?>"><?php echo Yii::t('app','Following'); ?></span></div>
								</a>
							<?php } ?>
						<?php } else { ?>
							<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profile'); ?>" ><div class="btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><span><?php echo Yii::t('app','Edit Profile'); ?></span></div>
							</div></a>
						<?php }
					       }   ?>
					</div>
				</div>

			</div> <!-- /col-sm-6 -->
		  </div> <!-- /row -->
		  
		  
		  <!------------------------------Modals---------------------------------->
		  <!--chat with seller modal-->
	
			<div class="modal fade" id="chat-with-seller-modal" role="dialog" tabindex='-1'> 
				<div class="modal-dialog modal-dialog-width">
					<div class="chat-seller-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="to-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<button data-dismiss="modal" class="close chat-with-seller-close" type="button">×</button>
							<?php
							if(!empty($userModel->userImage)) {
								$seller_profile = Yii::app()->createAbsoluteUrl('user/resized/85/'.$userModel->userImage);
							} else {
								$seller_profile = Yii::app()->createAbsoluteUrl('user/resized/85/default/'.Myclass::getDefaultUser());
							}
							?>
							<div class="to-prof-pic-cnt col-xs-3 col-sm-2 col-md-2 col-lg-2 no-hor-padding"><a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userModel->userId.'-'.rand(0,999)))); ?>"><div class="to-prof-pic" style="background: rgba(0, 0, 0, 0) url('<?php echo $seller_profile; ?>') no-repeat scroll center center / cover ;"></div></a>
							</div>
							<div class="to-prof-content col-xs-9 col-sm-10 col-md-10 col-lg-10 no-hor-padding">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','To:'); ?></div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userModel->userId.'-'.rand(0,999)))); ?>"><?php echo $userModel->username; ?></a></div>
							</div>
						</div>	
						
						<div class="messgage-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<textarea class="contact-textarea chat-modal-text-area form-control" maxlength="500" rows="5" placeholder="<?php echo Yii::t('app','Type your message')?>" id="contact-textarea" onkeyup="keyban_msg(event)" onkeydown="keyHandler(event)"></textarea>
							<input type="hidden" class="contact-sender" value="<?php echo Yii::app()->user->id; ?>" /> 
							<input type="hidden" class="contact-receiver" value="<?php echo $userModel->userId; ?>" />
							<div class="option-error contactme-error" style="color:red;"></div>
							<div class="send-btn-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="help-text col-xs-12 col-sm-9 col-md-9 col-lg-9 no-hor-padding"><span><i class="info-icon"></i></span><?php echo Yii::t('app','You and other person takes the complete responsibility of what is discussed here.'); ?></div>
								<div class="send-btn-container col-xs-12 col-sm-3 col-md-3 col-lg-3 no-hor-padding"><a href="javascript:;" onclick="contactMePopup()" >
									<div class="send-btn seller-chat-btn" data-dismiss="modal"><?php echo Yii::t('app','Send'); ?></div></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
				
		<!--E O chat with seller modal-->
		
		<!--chat with seller success modal-->
	
			<div class="modal fade" id="chat-with-seller-success-modal" role="dialog" tabindex='-1'> 
				<div class="modal-dialog modal-dialog-width">
					<div class="success-modal col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						
						<button onclick="close_popup();" class="close success-modal-close" type="button">×</button>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="success-icon"></div></div>
							<div class="sent-text"><?php echo Yii::t('app','Message sent'); ?></div>
						</div>
					</div>
				</div>
			</div>
				<?php
				$userDetails = Myclass::getUserDetails(Yii::app()->user->id);
				?>
		<!--E O chat with seller success modal-->
		<input type="hidden" value="<?php echo $userDetails->username ?>" id="MyOfferForm_name">
		<input type="hidden" value="<?php echo $userDetails->email; ?>" id="MyOfferForm_email">
		<input type="hidden" value="<?php echo $userDetails->phone; ?>" id="MyOfferForm_phone">
		<!--offer modal-->
			<div class="modal fade" id="offer-modal" role="dialog" tabindex='-1'> 
				<div class="modal-dialog modal-dialog-width">
					<div class="login-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
							<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<h2 class="login-header-text"><?php echo Yii::t('app','Make an offer'); ?></h2>
									<button data-dismiss="modal" class="close login-close" type="button">×</button>
							</div>
					
								<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
							
								<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
									<div class="ask-price-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										 <?php echo Yii::t('app','Ask price'); ?><span><?php echo Myclass::getCurrency($model->currency).' '. $model->price; ?></span>
									</div>
									<div class="offer-price-section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<div class="offer-price-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"> <?php echo Yii::t('app','Your  offer Price :'); ?></div>
										<div class="offer-price-txt-field-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php 
										$currency = explode('-',$model->currency);
									?>
											<div class="offer-text-field-label col-xs-1 col-sm-1 col-md-1 col-lg-1 no-hor-padding"><?php echo $currency[0]; ?></div>
											<div class="offer-text-field col-xs-11 col-sm-11 col-md-11 col-lg-11 no-hor-padding">
												<input type="text" class="my-offer-rate" maxlength="9" id="MyOfferForm_offer_rate" placeholder="<?php echo Yii::t('app','Enter price')?>" onkeypress="return isNumber(event)" onkeyup="myOfferRate()">
												<div class="message-error" style="color: red;position:relative;text-align:left;"></div>
											</div>		
											
										</div>
										<textarea class="offer-modal-text-area form-control" rows="5" id="MyOfferForm_message" placeholder="<?php echo Yii::t('app','Type your message')?>" maxlength="500"></textarea>
										<div class="send-btn-container col-xs-12 col-sm-3 col-md-3 col-lg-3 no-hor-padding pull-right"><a href="javascript:;" onClick="myoffer()"><div class="send-btn offer-send-btn"><?php echo Yii::t('app','Send'); ?></div></a></div>
										<div id="errorMessage" style="color: red"></div>
									</div>		
								</div>	
				
					</div>
				</div>
			</div>
		<!--E O offer modal-->	
		
		<!--offer success modal-->
	
			<div class="modal fade" id="offer-success-modal" role="dialog" tabindex='-1'> 
				<div class="modal-dialog modal-dialog-width">
					<div class="success-modal col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						
						<button onClick="close_popup()" class="close success-modal-close" type="button">×</button>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="success-icon"></div></div>
							<div class="sent-text"><?php echo Yii::t('app','Your Offer sent'); ?></div>
						</div>
					</div>
				</div>
			</div>
				
		<!--E O offer success modal-->
		
		<!--Exchange modal-->
			<div class="modal fade" id="exchange-modal" role="dialog" tabindex='-1'> 
				<div class="modal-dialog exchange-modal-dialog-width modal-dialoType your messageType your messageg-width">
					<div class="login-modal-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
							<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"
									<h2 class="login-header-text"><?php echo Yii::t('app','Exchange to buy'); ?></h2>
									<button data-dismiss="modal" class="close login-close" type="button">×</button>
							</div>
								
								<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
							
							<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="exchange-product-grid-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php if(!empty($ownItems)) {
									foreach($ownItems as $product):
									$image = Myclass::getProductImage($product->productId);
									if(!empty($image)) {
										$img = Yii::app()->createAbsoluteUrl('/item/products/resized/155/'.$product->productId.'/'.$image);
									} else {
										$img = 'default.jpeg';
									} 
									?>
									<div class="exchange-product-grid <?php echo "exchange".$product->productId; ?> col-xs-6 col-sm-4 col-d-4 col-lg-4">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<div class="exchange-product" style="background: rgba(0, 0, 0, 0) url('<?php echo $img; ?>') no-repeat scroll center center / cover ; cursor:pointer; border-right: 1px solid #d0dbe5; border-top: 1px solid #d0dbe5; border-left: 1px solid #d0dbe5;" onClick="selectExchangeproduct(<?php echo $product->productId; ?>)">
											<input type="hidden" value="" id="exchange_product_id">
											</div>											
											<div class="exchange-product-name"><?php echo $product->name; ?></div>
										</div>
									</div>	
									<?php
									endforeach; 
									} else {
										echo Yii::t('app','You haven’t added any products yet.');
									}
									?>									
								</div>	
									<?php if(!empty($ownItems)) { ?>
									<div class="create-exchange-btn send-btn-container col-xs-12 col-sm-3 col-md-3 col-lg-3 no-hor-padding"><a href="javascript:;" onclick="createExchange(<?php echo $model->productId; ?>,<?php echo $model->userId; ?>)"><div class="send-btn"><?php echo Yii::t('app','Create Exchange'); ?></div></a></div>
									<?php } ?>
									<div class="option-error" style="display:none;"></div>
							</div>	
				
					</div>
				</div>
			</div>
		<!--E O Exchange modal-->	
		
		
		<!----------------------------E O Modals---------------------------------->  
		
		<!--Recently viewed products-->
	   <?php if(!empty($logUserid) && !empty($recentlyprodcts)) { ?>
		    <div class="product-row row recently-viewed-container">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="recently-viewed-heading col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php echo Yii::t('app','Recently Viewed Products'); ?></div>
					<div class="recently-viewed col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php foreach($recentlyprodcts as $recents) {
							$image = Myclass::getProductImage($recents->productId);
							$pdtURL = Yii::app()->createAbsoluteUrl("/item/products/resized/300/".$recents->productId."/".$image);
							?>
							<div class="product-padding col-xs-12 col-sm-6 col-md-3 col-lg-3">
									<a href="<?php echo Yii::app()->createAbsoluteUrl("/products/view/".Myclass::safe_b64encode($recents->productId.'-'.rand(0,999)).'/'.Myclass::productSlug($recents->name)); ?>"><div class="image-container col-xs-12 col-sm-12 col-md-12 col-lg-12" id="prod-5" style="background: rgba(0, 0, 0, 0) url('<?php echo $pdtURL; ?>') no-repeat scroll center center / cover ;">
										<span class="day-count"><?php echo Myclass::getElapsedTime($recents->createdDate).' '.Yii::t('app','ago'); ?></span>
										<?php if($recents->promotionType == '1') { ?>
											<span class="item-ad"><?php echo Yii::t('app','Ad'); ?></span>
										<?php } ?>
									</div></a>						
									<div class="rate-section-2 col-xs-12 col-sm-12 no-hor-padding">
										<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<?php echo Myclass::getCurrency($recents->currency).' '. $recents->price; ?>
										</div>
										<div class="item-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php	$count = strlen($recents->name);
											if($count > 30){
												$itmName = substr($recents->name,0,30).'...';
											} else {
												$itmName = $recents->name;
											}
											?>
											<a href="<?php echo Yii::app()->createAbsoluteUrl("/products/view/".Myclass::safe_b64encode($recents->productId.'-'.rand(0,999)).'/'.Myclass::productSlug($recents->name)); ?>"><?php echo $itmName; ?></a>						
										</div>
										<?php
											$location = explode(',',$recents->location); 
										?>
											<span class="item-location col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo $location[0]; ?></span>
									</div>
							</div>
						<?php } ?>
					
					</div>
				</div>
			</div>
		<?php } ?>
		<!--Popular products-->
	    <div class="product-row row popular-product-container">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="recently-viewed-heading col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php echo Yii::t('app','Popular Products'); ?></div>
				<div class="recently-viewed col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<?php
						if($count_popularadditems > 1) {
							$popular_position[] = RAND(0,1);
							$popular_position[] = RAND(2,3);
						} else if($count_popularadditems == '0') {
							//$popular_position[] = '';
						} else {
							$popular_position[] = RAND(0,3);
						}
					
					?>
					<?php foreach($popularitems as $key=>$populars) {
						if(in_array($key,$popular_position)) {
							if($count_popularadditems > 1) {
								$popularadditems = array_slice($popularadditems,0,2);
								$popularadd[$popular_position[0]] = $popularadditems[0];
								$popularadd[$popular_position[1]] = $popularadditems[1];
							} else {
								$popularadditems = $popularadditems;
								$popularadd[$popular_position[0]] = $popularadditems[0];
							}
							//echo $position_set1; echo '<pre>'; echo 'ji'; echo $key; die;
							//foreach($popularadd as $key=>$popularadd) {
							$image = Myclass::getProductImage($popularadd[$key]->productId);
							$pdtURL = Yii::app()->createAbsoluteUrl("/item/products/resized/300/".$popularadd[$key]->productId."/".$image); ?>
							<div class="product-padding col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<a href="<?php echo Yii::app()->createAbsoluteUrl("/products/view/".Myclass::safe_b64encode($popularadd[$key]->productId.'-'.rand(0,999)).'/'.Myclass::productSlug($popularadd[$key]->name)); ?>"><div class="image-container col-xs-12 col-sm-12 col-md-12 col-lg-12" id="prod-5" style="background: rgba(0, 0, 0, 0) url('<?php echo $pdtURL; ?>') no-repeat scroll center center / cover ;">
									<span class="day-count"><?php echo Myclass::getElapsedTime($popularadd[$key]->createdDate).' '.Yii::t('app','ago'); ?></span>
									<span class="item-ad">Ad</span>
								</div></a>						
								<div class="rate-section-2 col-xs-12 col-sm-12 no-hor-padding">
									<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo Myclass::getCurrency($popularadd[$key]->currency).' '. $popularadd[$key]->price; ?>
									</div>
									<div class="item-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php	$count = strlen($popularadd[$key]->name);
											if($count > 30){
												$itmName = substr($popularadd[$key]->name,0,30).'...';
											} else {
												$itmName = $popularadd[$key]->name;
											}
											?>
										<a href="<?php echo Yii::app()->createAbsoluteUrl("/products/view/".Myclass::safe_b64encode($popularadd[$key]->productId.'-'.rand(0,999)).'/'.Myclass::productSlug($popularadd[$key]->name)); ?>"><?php echo $itmName; ?></a>						
									</div>
									<?php
										$location = explode(',',$popularadd[$key]->location); 
									?>
										<span class="item-location col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo $location[0]; ?></span>
								</div>
							</div>
						<?php   //}
						} else { 
							$image = Myclass::getProductImage($populars->productId);
							$pdtURL = Yii::app()->createAbsoluteUrl("/item/products/resized/300/".$populars->productId."/".$image); ?>
							<div class="product-padding col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<a href="<?php echo Yii::app()->createAbsoluteUrl("/products/view/".Myclass::safe_b64encode($populars->productId.'-'.rand(0,999)).'/'.Myclass::productSlug($populars->name)); ?>"><div class="image-container col-xs-12 col-sm-12 col-md-12 col-lg-12" id="prod-5" style="background: rgba(0, 0, 0, 0) url('<?php echo $pdtURL; ?>') no-repeat scroll center center / cover ;">
									<span class="day-count"><?php echo Myclass::getElapsedTime($populars->createdDate).' '.Yii::t('app','ago'); ?></span>
									
								</div></a>						
								<div class="rate-section-2 col-xs-12 col-sm-12 no-hor-padding">
									<div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo Myclass::getCurrency($populars->currency).' '. $populars->price; ?>
									</div>
									<div class="item-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php	$count = strlen($populars->name);
											if($count > 30){
												$itmName = substr($populars->name,0,30).'...';
											} else {
												$itmName = $populars->name;
											}
											?>
										<a href="<?php echo Yii::app()->createAbsoluteUrl("/products/view/".Myclass::safe_b64encode($populars->productId.'-'.rand(0,999)).'/'.Myclass::productSlug($populars->name)); ?>"><?php echo $itmName; ?></a>						
									</div>
									<?php
										$location = explode(',',$populars->location); 
									?>
										<span class="item-location col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo $location[0]; ?></span>
								</div>
							</div>
						<?php }

						} ?>
					
					
				</div>
			</div>
		</div>
		  	
	<div class="product-container col-md-6">
		<div class="purchase-details">
			<!-- <div class="quantity" style="display: inline-block; width: 200px;">Quantity: <select class="item-qty">
			<option value=''>Select quantity</option>
			<?php for($i=1;$i<=$model->quantity;$i++){
				echo '<option value="'.$i.'">'.$i.'</option>';
			}?>
		</select></div> -->
			<?php if($model->sizeOptions != ''){
				echo '<input type="hidden" value="1" class="item-option"/>';
			}else{
				echo '<input type="hidden" value="0" class="item-option"/>';
				$cartDataURL = Myclass::cart_encrypt($model->productId."-0", 'joy*ccart');
				echo '<input type="hidden" value="'.$cartDataURL.'" class="item-cartdata"/>';
			}?>
			<!-- <div class="add-cart-container"
				style="display: inline-block; width: 200px; text-align: right;">
				<button class='add-cart' onclick='addToCart()'>Add to cart</button>
			</div> -->
			<div class="carterror" style="color: red"></div>
		</div>

		<input type="hidden" value="<?php echo $model->productId; ?>"
			class="item-id" />


	</div>
	<div id="popup_container">
	<?php if ($model->chatAndBuy == 1) { ?>
		<div id="contact-me-popup" style="display: none;"
			class="popup ly-title update contact-me-popup">
			<p class="ltit">
			<?php echo Yii::t('app','Contact me'); ?>
			</p>
			<button type="button" class="ly-close" id="btn-browses">x</button>
			<div class="contact-me-content">
				<div class="contact-top">
					<div class="contact-top-left">
						<div class="contact-user-image">
						<?php $userImage = Myclass::getUserDetails($model->userId);
						if(!empty($userImage->userImage)) {
							echo CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/'.$userImage->userImage),$userImage->username,array('height'=>40,'width' => 40));
						} else {
							echo CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/default/'.Myclass::getDefaultUser()),$userImage->username,array('height'=>40,'width' => 40));
						} ?>
						</div>
						<div class="contact-to-details">
						<?php echo Yii::t('app','To'); ?>
							:<br> <span class="to-user"><a class="userNameLink"
								href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userImage->userId.'-'.rand(0,999)))); ?>"><?php echo $userImage->name; ?>
							</a> </span>
						</div>
					</div>
				</div>
				<div class="contact-message">
					<input type=hidden name=lastkey id=lastkey>
					<textarea class="contact-textarea" rows="4" cols="12"
						id="contact-textarea" onkeyup="keyban(event)"
						onkeydown="keyHandler(event)"></textarea>
					<input type="hidden" class="contact-sender"
						value="<?php echo Yii::app()->user->id; ?>" /> <input
						type="hidden" class="contact-receiver"
						value="<?php echo $userImage->userId; ?>" />
					<div class="option-error contactme-error"></div>
				</div>
				<div class="contact-buttons-area">
					<div class="cancel-button close-contact">
					<?php echo Yii::t('app','Cancel'); ?>
					</div>
					<div class="send-button" onclick="contactMePopup()">
					<?php echo Yii::t('app','Send'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div id="show-coupon-popup" style="display: none;"
			class="popup ly-title update show-exchange-popup">
			<p class="ltit">
			<?php echo Yii::t('app','Generate Coupon'); ?>
			</p>
			<button type="button" class="ly-close" id="btn-browses">x</button>
			<div class="coupon-popup">
				<div class='generate-coupon-container'>
					<label class="control-label"><?php echo Yii::t('app','Coupon Value'); ?>
					<?php echo '('.Myclass::getCurrency($model->currency).')'; ?>
						: </label> <input type="text" class="couponValue" id="couponValue"
						onkeypress="return isNumber(event)" maxlength=9 />
					<div class="option-error"></div>
					<div class="btn-area">
						<button type="button" class="btn-choose-option btn-done"
							id="btn-doneid"
							onclick="generateCoupon('<?php echo $model->productId; ?>','<?php echo $model->userId; ?>','<?php echo $model->price; ?>','<?php echo Myclass::getCurrency($model->currency); ?>')">
							<?php echo Yii::t('app','Generate Coupon'); ?>
						</button>
					</div>
				</div>
				<div class="coupon-code"></div>
				<p class="new-coupon-link">
				<?php echo Yii::t('app','Generate New Coupon'); ?>
					?
				</p>
			</div>
		</div>
		<?php if($model->exchangeToBuy == 0) { ?>
		<div id="show-exchange-popup" style="display: none;"
			class="popup ly-title update show-exchange-popup">
			<p class="ltit">
			<?php echo Yii::t('app','Exchange to Buy'); ?>
			</p>
			<button type="button" class="ly-close" id="btn-browses">x</button>
			<?php $this->renderPartial('requestExchange',array('mainProductId' => $model->productId,'ownItems'=> $ownItems,'requestTo'=>$model->userId),false,true); ?>
		</div>

		<?php } ?>
		<?php if ($model->instantBuy == 1 && $model->sizeOptions != ''){ ?>
		<div id="choose-option-popup" style="display: none;"
			class="popup ly-title update choose-option-popup">
			<p class="ltit">
			<?php echo Yii::t('app','Choose a option'); ?>
			</p>
			<button type="button" class="ly-close" id="btn-browses">x</button>
			<div class='choose-option-content'>
			<?php $options = json_decode($model->sizeOptions, true);
			//echo "<pre>";print_r($options);
			echo '<div class="quantity" style="display: inline-block; width: 200px;">'.Yii::t('app','Options').':
							<select class="item-qty" onchange="selectedOptionPrice();">';
			//echo '<option value="">'.Yii::t('app','Select a Option').'</option>';
			$i = 0;
			foreach ($options as $optionkey => $option){

				if ($option['quantity'] != 0){
					$value = Myclass::cart_encrypt($model->productId."-".$option['option'], 'joy*ccart');
					if ($option['price'] != 0){
						if($i == 0) {
							$price = $option['price'];
							$i++;
						}
						echo '<option value="'.$value.'" pricetag="'.$option['price'].'">'.$option['option'].'</option>';
					}else{
						$price = $model->price;
						echo '<option value="'.$value.'" pricetag="'.$model->price.'">'.$option['option'].'</option>';
					}
				}
			}
			echo '</select></div>';
		 ?>
				<div class="option-price">
				<?php echo Yii::t('app','Price'); ?>
					:
					<?php echo Myclass::getCurrency($model->currency); ?>
					<span class="option-price-value"><?php echo $price; ?> </span>
				</div>
			</div>
			<div class="btn-area">
				<button type="button" class="btn-choose-option btn-done"
					id="btn-doneid" onclick="optionCheck();">
					<?php echo Yii::t('app','Proceed to Checkout'); ?>
				</button>
				<div class="option-error"></div>
			</div>
		</div>
		<?php } ?>
	</div>

</div>
<script>
var offset = 13;
var limit = 12;
var totalMoreImage = <?php echo count($photoModel) - 7; ?>;
var currentRightClick = 0;
var currentLeftClick =  <?php echo count($photoModel) - 7; ?>;
var currentPosition = 0;
</script>
		
<script type="text/javascript">
$(".offer-form").hide();
   (function(d){
    var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
    p.type = 'text/javascript';
    p.async = true;
    p.src = '//assets.pinterest.com/js/pinit.js';
    f.parentNode.insertBefore(p, f);
   }(document));
     (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
     
     !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

</script>

<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>

<script>
$(document).ready(function() {
	mapView();
});
</script>
<style>
.message-error {
	background-color: #FFFFFF;
	color: #DF2525;
	display: none;
	padding: 5px;
	position: absolute;
	z-index: 20;
	text-align: center;
	width: 328px;
	font-size: 13px;
}
body {
	padding-right:0px !important;
}
.modal-open .modal {
	overflow:hidden !important;
}
.footer {
    margin-top: 0px !important;
}
</style>
