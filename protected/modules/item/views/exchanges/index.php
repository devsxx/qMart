<style>
.no-more-exchanges {
	float: right;
	margin-right: 5px !important;
	padding: 0;
	display: inline-table;
	padding-bottom: 5px;
}
</style>
<?php  $user->userId = $model['userId'];
$user->name = $model['name'];
$user->userImage = $model['userImage'];
$user->mobile_status = $model['mobile_status'];
$user->facebookId = $model['facebookId'];
	  //print_r($model); ?>
<?php if(empty($exchanges)){ 
	$empty_tap = " empty-tap ";
}else{
	$empty_tap = "";
	} ?>
<div class="container profile-page-dev">
<div class="row">		
				<div class="qMart-breadcrumb add-product col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					 <ol class="breadcrumb">
						<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"><?php echo Yii::t('app','Home'); ?></a></li>
						<li><a href="#"><?php echo Yii::t('app','Profile'); ?></a></li>					 
					 </ol>			
				</div>
				
			</div>
<div class="row page-container">
	<div class="container exchange-property-container profile-vertical-tab-section">
		<?php $this->renderPartial('application.modules.useractivity.views.useraction.profilemenu',array('user'=>$user)); ?>
			<div class="item-properties tab-content col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<div id="exchange" class="profile-tab-content tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding active in <?php echo $empty_tap; ?>">
							<div class="exchange-rows col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="exchange-rows">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<ul class="recent-activities-tab nav nav-tabs">
									  <li class="<?php if($type == 'incoming') echo 'active'; ?>">
									  	<a href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges',array('type'=>'incoming')); ?>"><i class="fa fa-arrow-down"> </i> <?php echo Yii::t('app','Incoming Requests'); ?>
										</a>
									  </li>
									  <li class="<?php if($type == 'outgoing') echo 'active'; ?>">
									  	  <a href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges',array('type'=>'outgoing')); ?>"><i class="fa fa-arrow-up"> </i> <?php echo Yii::t('app','Outgoing Requests'); ?>
									      </a>
									  </li>
									  <li class="<?php if($type == 'success') echo 'active'; ?>">
									      <a href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges',array('type'=>'success')); ?>"><i class="fa fa-check-circle"> </i> <?php echo Yii::t('app','Successful Exchanges'); ?>
									  	  </a>
									  </li>
									  <li class="<?php if($type == 'failed') echo 'active'; ?>">
									     <a href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges',array('type'=>'failed')); ?>"><i class="fa fa-times-circle"> </i> <?php echo Yii::t('app','Failed Exchanges'); ?>
									      </a>
									   </li>
									</ul>
								</div>


			<?php if(!empty($exchanges)) {?>
			<div class="profile-listing-product-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<?php foreach($exchanges as $exchange): ?>
			<?php // $checkMainProduct = Myclass::checkSoldOut($exchange->mainProductId);
			//$checkExchangeProduct = Myclass::checkSoldOut($exchange->exchangeProductId);
			//if(!is_null($checkMainProduct) && !is_null($checkExchangeProduct)) {
			?>
				<div class="exchange-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="">
						<div class="exchange-status-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="exchange-status"><?php echo Yii::t('app','Current status :'); ?> 
						<?php if($exchange->status == 1) { ?>
								<span class="status-txt" id="status-accepted">
									<?php echo Yii::t('app','ACCEPTED'); ?>
								</span>
								<?php } elseif($exchange->status == 2) {?>
								<span class="status-txt">
									<?php echo Yii::t('app','DECLINED'); ?>
								</span>
								<?php } elseif($exchange->status == 3) {?>
								<span class="status-txt">
									<?php echo Yii::t('app','CANCELLED'); ?>
								</span>
								<?php } elseif($exchange->status == 4) { ?>
								<span class="status-txt" id="status-accepted">
									<?php echo Yii::t('app','SUCCESS'); ?>
								</span>
								<?php } elseif($exchange->status == 5) { ?>
								<span class="status-txt">
									<?php echo Yii::t('app','FAILED'); ?>
								</span>
								<?php } elseif($exchange->status == 6) { ?>
								<span class="status-txt" id="status-pending">
									<?php echo Yii::t('app','SOLD OUT'); ?>
								</span>
								<?php } else { ?>
								<span class="status-txt" id="status-pending">
									<?php echo Yii::t('app','PENDING'); ?>
								</span>
								<?php } ?>
						</div>

						<?php if($type != 'success' && $type != 'failed') {?>
							<div class="view-exchange pull-right"><a href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges/view',array('id'=>$exchange->slug)); ?>" onclick="switchVisible_exchange();" ><?php echo Yii::t('app','View Exchange'); ?><span class="viewmore-arrow">&gt;</span></a>
							</div>
							<?php } ?>
						</div>
						<div class="exchange-content-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							
							<!-- <div class="exchange-content-details"> -->
								<div class="exchange-left-content col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding">
								<?php $productDetails = $exchange->mainproduct;
								$productImage = $exchange->mainproduct->photos;
								if(!empty($productImage)) {
									$image = $productImage[0]->name;
								}
								$userDetails = $exchange->requestto; ?>
									<div class="prof-pic-container col-xs-12 col-sm-5 col-md-5 col-lg-5 no-hor-padding">
									<a style="text-decoration: none;" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view', 
												array('id' => Myclass::safe_b64encode($productDetails->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($productDetails->name); ?>" target="_blank">
									<?php $imgurl = Yii::app()->createAbsoluteUrl('item/products/resized/100/'.$exchange->mainProductId.'/'.$image);  ?>
									<?php if((!empty($image)) && (getimagesize($imgurl) !== false)){ ?>
										<img class="exchange-prof-pic" id="exchange-pic-1"
											src="<?php echo Yii::app()->createAbsoluteUrl(
											'item/products/resized/100/'.$exchange->mainProductId.'/'.
											$image); ?>"
											alt="<?php echo $productDetails->name; ?>" />
									<?php } else { ?>
										<img class="exchange-prof-pic" id="exchange-pic-1"
											src="<?php echo Yii::app()->createAbsoluteUrl("/item/products/resized/100/".'default.jpeg'); ?>"
											alt="<?php echo $productDetails->name; ?>" />
									<?php }?>
									</a>
									<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))); ?>">
										<div class="exchange-prof-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<?php echo $userDetails->name; ?>
										</div>
									</a>
									</div>
									<div class="exchange-content col-xs-12 col-sm-7 col-md-7 col-lg-7 no-hor-padding">
										<a href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view', 
												array('id' => Myclass::safe_b64encode($productDetails->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($productDetails->name); ?>" target="_blank">
											<div class="exchange-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<?php echo $productDetails->name; ?>
											</div>
										</a>

										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<?php if($productDetails->productCondition != '' && $productDetails->productCondition != '0'){ ?>
											<div class="col-xs-offset-4 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 used-status">
												<?php echo $productDetails->productCondition; ?>
											</div>
											<?php } ?>
											<div class="exchange-place col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<?php echo $productDetails->location; ?>
											</div>
										</div>
									</div>
								</div>

								<div class="exchange-arrow-cnt col-xs-12 col-sm-12 col-md-2 col-lg-2 no-hor-padding">
									<div class="exchange-arrow"></div>
								</div>

								<div class="exchange-right-content col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding">
								<?php $productDetails = $exchange->exchangeproduct;
								$productImage = $exchange->exchangeproduct->photos;
								if(!empty($productImage)) {
									$image = $productImage[0]->name;
								}
								$userDetails = $exchange->requestfrom; ?>
									<div class="prof-pic-container col-xs-12 col-sm-5 col-md-5 col-lg-5 no-hor-padding">
									<a style="text-decoration: none;" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view', 
												array('id' => Myclass::safe_b64encode($productDetails->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($productDetails->name); ?>" target="_blank">

										<?php $imgurl = Yii::app()->createAbsoluteUrl('item/products/resized/100/'.$productDetails->productId.'/'.$image);  ?>
										<?php if((!empty($image)) && (getimagesize($imgurl) !== false)){ ?>
											
										
										<img class="exchange-prof-pic" id="exchange-pic-1"
											src="<?php echo Yii::app()->createAbsoluteUrl(
											'item/products/resized/100/'.$productDetails->productId.'/'.
											$image); ?>"
											alt="<?php echo $productDetails->name; ?>" />
										<?php } else { ?>
										<img class="exchange-prof-pic" id="exchange-pic-1"
											src="<?php echo Yii::app()->createAbsoluteUrl("/item/products/resized/100/".'default.jpeg'); ?>"
											alt="<?php echo $productDetails->name; ?>" />
										<?php }?>
										</a>
										<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))); ?>">
											<div class="exchange-prof-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<?php echo $userDetails->name; ?>
											</div>
										</a>
									</div>
									<div class="exchange-content col-xs-12 col-sm-7 col-md-7 col-lg-7 no-hor-padding">
										<a style="text-decoration: none;" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view', 
												array('id' => Myclass::safe_b64encode($productDetails->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($productDetails->name); ?>" target="_blank">
											<div class="exchange-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<?php echo $productDetails->name; ?>
											</div>
										</a>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php if($productDetails->productCondition != '' && $productDetails->productCondition != "0"){ ?>
										<div class="col-xs-offset-4 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 used-status">
											<?php echo $productDetails->productCondition; ?>
										</div>
										<?php } ?>
										<div class="exchange-place col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<?php echo $productDetails->location; ?>
										</div>
										</div>
										
									</div>
								</div>
							<!-- </div> -->
						</div>
						<div class="exchange-info col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" >
						<div class="exchange-initiate-date">
								<?php echo Yii::t('app','Exchange Initiated on'); ?> :<?php echo date('dS M Y',$exchange->date);?>					
						</div>
						<div class="exchange-btn-cnt pull-right exchange-action-<?php echo $exchange->id; ?>">
							
									

							<?php if ($exchange->requestFrom == $userId  && $exchange->reviewFlagSender == 1 && $type == 'success'){
									
							
								$userDetails = $exchange->requestto;?>
									<div style="display:none;" onclick="showreviewpopup('<?php echo $exchange->id; ?>','<?php echo $userDetails->userId; ?>')" class="review-btn review-btn<?php echo $exchange->id; ?> buy-button"> 
										<?php echo Yii::t('app','Write Review');?></div>
							<?php } ?>
							
							<?php if ($exchange->requestTo == $userId  && $exchange->reviewFlagReceiver == 1 && $type == 'success'){
								
							$userDetails = $exchange->requestfrom;?>
									<div style="display:none;" onclick="showreviewpopup('<?php echo $exchange->id; ?>','<?php echo $userDetails->userId; ?>')" class="review-btn review-btn<?php echo $exchange->id; ?> buy-button"> 
										<?php echo Yii::t('app','Write Review');?></div>
							<?php } ?>
							
							<?php if($exchange->requestFrom == $userId && $type == 'outgoing') {
								$mCheck = Myclass::checkWhetherProductSold($exchange->mainProductId);
								$exCheck = Myclass::checkWhetherProductSold($exchange->exchangeProductId);
								if(!empty($mCheck) || !empty($exCheck)) { ?>
							<p class="sold-status">
								<label class="label-lg label-default"><?php echo Yii::t('app','ONE OF THE PRODUCTS IS SOLD'); ?>
								</label>
							</p>
							<span  class="exchange-btn" id="exc-pending" 
								onclick="sold(<?php echo $exchange->id; ?>)"
								style="font-size: 13px; float: none;text-decoration:none;"><?php echo Yii::t('app','OK'); ?></span>
								<?php } else {
									if($exchange->status == 1) { ?>
							<span type="button" class="exchange-btn" id="exc-failed"
								onclick='confirmModal("link","item/exchanges/success?id=", "<?php echo $exchange->id; ?>");'
								style="font-size: 13px; float: left;text-decoration:none;"> <?php echo Yii::t('app','SUCCESS'); ?>
							</span> 
							<span type="button" class="exchange-btn" id="exc-failed"
								onclick='confirmModal("link", "item/exchanges/failed?id=", "<?php echo $exchange->id; ?>")'
								style="font-size: 13px; float: right;text-decoration:none;"> <?php echo Yii::t('app','FAILED'); ?>
							</span>
							<?php } else { ?>
							<span class="exchange-btn" id="exc-failed"
								onclick='confirmModal("method", "cancel", "<?php echo $exchange->id; ?>");'
								style="font-size: 13px; float: left;text-decoration:none;"><?php echo Yii::t('app','CANCEL'); ?></span>
								<?php }
								}
						
							
							} ?>


							<?php if($exchange->requestTo == $userId && $type == 'incoming') {?>
							<?php $mCheck = Myclass::checkWhetherProductSold($exchange->mainProductId);
							$exCheck = Myclass::checkWhetherProductSold($exchange->exchangeProductId);
							if(!empty($mCheck) || !empty($exCheck)) { ?>
							<p class="sold-status">
								<label class="label-lg label-default"><?php echo Yii::t('app','ONE OF THE PRODUCTS IS SOLD'); ?></label>
							</p>
							<span  class="exchange-btn" id="exc-pending"
								onclick="sold(<?php echo $exchange->id; ?>)"
								style="font-size: 13px; float: none;text-decoration:none;"><?php echo Yii::t('app','OK'); ?></span>
								<?php } else {
									if($exchange->status == 1) { ?>
							<span type="button" class="exchange-btn" id="exc-success"
								onclick='confirmModal("link", "item/exchanges/success?id=", "<?php echo $exchange->id; ?>")'
								style="font-size: 13px; float: left;text-decoration:none;"> <?php echo Yii::t('app','SUCCESS'); ?>
							</span> 
							<span type="button" class="exchange-btn" id="exc-failed"
								onclick='confirmModal("link", "item/exchanges/failed?id=", "<?php echo $exchange->id; ?>")'
								style="font-size: 13px; float: right;text-decoration:none;"><?php echo Yii::t('app','FAILED'); ?>
							</span>
							<?php } else { ?>
							<span class="exchange-btn" id="exc-success" 
								onclick='confirmModal("method", "accept", "<?php echo $exchange->id; ?>");'
								style="font-size: 13px; float: left;;text-decoration:none;"><?php echo Yii::t('app','ACCEPT'); ?></span>
							<span  class="exchange-btn" id="exc-failed"
								onclick='confirmModal("method", "decline", "<?php echo $exchange->id; ?>");'
								style="font-size: 13px; float: right;text-decoration:none;"><?php echo Yii::t('app','DECLINE'); ?></span>
								<?php } }
							} ?>


							<?php if($type == 'failed' && $exchange->requestTo == $userId) { ?>
							<p class="no-more-exchanges no-more-<?php echo $exchange->id; ?>">
							<?php if($exchange->blockExchange == '0') { ?>
								<span class="exchange-btn" id="exc-failed"
									onclick='cancelExchange("<?php echo $exchange->id; ?>");'>	
									<?php echo Yii::t('app','Block Exchanges'); ?></span>

									<?php } else { ?>
								<span class="exchange-btn" id="exc-success"
									onclick='allowExchange("<?php echo $exchange->id; ?>");'>
									<?php echo Yii::t('app','Allow Exchanges'); ?></span>
									<?php } ?>
							</p>
							<?php }?>

						</div>
						
						</div>
					</div>
				</div>
				<?php  endforeach;  ?>

				<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

			</div>
		</div>
	</div>
	<?php
	$pages = Yii::app()->request->getParam('page');
	?>
	<?php } else { ?>
											<div class="modal-dialog modal-dialog-width">
													<div class="col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="margin-bottom:100px;">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
															<div class="payment-decline-status-info-txt" style="margin: 8% auto 0;"><img src="<?php echo Yii::app()->createAbsoluteUrl("/images/empty-tap.jpg");?>"></br><span class="payment-red"><?php echo Yii::t('app','Sorry...'); ?></span> <?php echo Yii::t('app','No Exchanges Found.'); ?></div>
														</div>
													</div>
												</div>
	<?php } ?>
	</div>
		</div></div></div></div>

	<div id="popup_container" style="display: none; opacity: 0;">
	<div id="review-user-popup" style="display: none;" class="popup ly-title update review-me-popup">
			<p class="ltit"><?php echo Yii::t('app','Users Review and Rating'); ?></p>
			<button type="button" class="ly-close" id="btn-browses">x</button>
			
			<div class="review-body-section">
				<div class="review-user-rating">
				  <div class="rating-title"><?php echo Yii::t('app','Give your Ratings');?>: </div>
					<i class="fa fa-2x  fa-star-o static-rating rating one" id="rateone" onclick="ratingClick('1');"></i>
					<i class="fa fa-2x  fa-star-o static-rating rating two" id="ratetwo" onclick="ratingClick('2');"></i>
					<i class="fa fa-2x  fa-star-o static-rating rating three" id="ratethree" onclick="ratingClick('3');"></i>
					<i class="fa fa-2x  fa-star-o static-rating rating four" id="ratefour" onclick="ratingClick('4');"></i>
					<i class="fa fa-2x  fa-star-o static-rating rating five" id="ratefive" onclick="ratingClick('5');"></i>
					<span class="current-rate">0</span> <?php echo Yii::t('app','Out of 5'); ?>
					<input type="hidden" id="rateval">
					<input type="hidden" id="reviewType" value="exchange">
					
				</div>
				
				<div class="review-user-textarea">
				<div class="rating-title"><?php echo Yii::t('app','Write your Review');?>: </div>
					<textarea class="review-textarea" rows="5" cols="48" id="contact-textarea" ></textarea>
					<div class="review-error error"></div>
				</div>
				
				<div class="review-btn-area">
				
					<div class="cancel-button close-contact"> <?php echo Yii::t('app','Cancel')?></div>
					<div onclick="saveReviewPopup()" class="send-button"> <?php echo Yii::t('app','Send'); ?> </div>
								
				</div>
			</div>
			<input type="hidden" class="review-sender" value="<?php echo Yii::app()->user->id; ?>" />
			<input type="hidden" class="review-receiver" value="" />
			<input type="hidden" class="exchangeid" value=""/>
	</div>
	</div>
