<script>
var offset = 8;
var limit = 8;
</script>
<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Profile';
$this->breadcrumbs=array(
	'Profile',
);

?>
<?php 
	if(count($products) == 0)
		$empty_tap = " empty-tap ";
	else
		$empty_tap = "";
?>		
<div id="page-container" class="container">
<div class="row">		
				<div class="qMart-breadcrumb add-product col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					 <ol class="breadcrumb">
						<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"><?php echo Yii::t('app','Home'); ?></a></li>
						<li><a href="#"><?php echo Yii::t('app','Profile'); ?></a></li>					 
					 </ol>			
				</div>

<?php  $user->userId = $model['userId'];
$user->name = $model['name'];
$user->userImage = $model['userImage'];
$user->mobile_status = $model['mobile_status'];
$user->facebookId = $model['facebookId'];
	  //print_r($model); ?>

<div class="profile-vertical-tab-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php $this->renderPartial('application.modules.useractivity.views.useraction.profilemenu',array('user'=>$user)); ?>

					<div class="tab-content col-xs-12 col-sm-9 col-md-9 col-lg-9">
							<div id="promotions" class="profile-tab-content tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding active in <?php echo $empty_tap; ?>">	
							<div class="promotion-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="promotion-content">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<ul class="recent-activities-tab nav nav-tabs">
									  <li><?php echo CHtml::link(Yii::t('app','Urgent'),Yii::app()->createAbsoluteUrl('user/promotions',array('id'=>Myclass::safe_b64encode($user->userId.'-'.rand(0,999)))));  ?></li>
									  <li class="active"><a data-toggle="tab" href="#advertisement"><?php echo Yii::t('app','Advertisement'); ?></a></li>
									  <li><?php echo CHtml::link(Yii::t('app','Expired'),Yii::app()->createAbsoluteUrl('user/expiredPromotions',array('id'=>Myclass::safe_b64encode($user->userId.'-'.rand(0,999)))));  ?></li>
									</ul>
								</div>
								<div class="recent-activities-tab-content tab-content">
									<div id="urgent" class="tab-pane fade in active">
									<?php if(count($products) != 0) { ?>	
										<div id="products" class="profile-listing-product-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<!--product-->
											<?php $this->renderPartial('loadpromotions',compact('products')); ?>
										</div>
									<?php } else { ?>
										<div class="modal-dialog modal-dialog-width">
													<div class="col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="margin-bottom:100px;">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
															<div class="payment-decline-status-info-txt" style="margin: 8% auto 0;"><img src="<?php echo Yii::app()->createAbsoluteUrl("/images/empty-tap.jpg");?>"></br><span class="payment-red"><?php echo Yii::t('app','Sorry...'); ?></span> <?php echo Yii::t('app','Yet no product are here.'); ?></div>
														</div>
													</div>
												</div>
									<?php }  ?>
									</div>

									
								</div>
							
								<?php if(count($products) >= 8) { ?>
							<div class="load-more-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="qMart-loader" style="width: 60px;"><div class="cssload-loader"></div></div>
									<a class="loadmorenow load">
									<div class="load-more-icon"></div>
									<!-- <div class="load-more-txt">More Users</div> -->
								
								<?php if(count($products) >= 8) {
								if(Yii::app()->controller->action->id == 'advertisePromotions') { ?>
								<?php echo CHtml::ajaxButton(Yii::t('app','Load More'), array('advertisePromotions','id' =>Myclass::safe_b64encode($user->userId.'-'.rand(0,999))),
								array(
								'data'=> 'js:{"limit": limit, "offset": offset}',
								'beforeSend'=>'js:function(data){
									$(".qMart-loader").show(); 
									$(".load").hide();
								}',
								'success' => 'js:function(response){ 
									$(".qMart-loader").hide();
									$(".load").show(); 
						        		var output = response.trim();
								if (output) {
									offset = limit + offset;
									$("#products").append(output);   
								} else {
								       $(".load").html(Yii.t("app","No More Products")); 
								       //$(".load").hide();  
											 
								}
								}',
								)
								); ?>
								<?php } } ?> 
							</a>
							</div>


						<?php } ?>
							</div>
							
							<div class="promotion-details col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="promotion-details">
								<div class="profile-tab-content-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<span><?php echo Yii::t('app','Promotion Details') ?></span>
									<div class="exchange-back-link pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 no-hor-padding"><a href="#" onclick="switchVisible_promotionback();" id="element1"><?php echo Yii::t('app','Back') ?></a></div>
								</div>
								<div class="profile-listing-product-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<!--row 1-->
									<div class="promotions-details-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									</div>
								</div>
							</div>
						</div>


						
	</div>
	</div></div>

</div>
</div>
</div>


<div class="paypal-form-container"></div>
<!--Add popup modal-->
	
		<div class="modal fade" id="post-your-list" role="dialog" data-backdrop="static" data-keyboard="false"> 
			<div class="modal-dialog post-list-modal-width">
				<div class="post-list-modal-content login-modal-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
						<div class="post-list-header login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="modal-header-text"><p class="login-header-text"><?php echo Yii::t('app','Repromote your listing!'); ?></p></div>
								<button data-dismiss="modal" class="close login-close" type="button" id="white">×</button>
						</div>
							
						<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
					
						<div class="post-list-cnt login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
							<div class="login-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="login-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="post-list-modal-heading"><?php echo Yii::t('app','Highlight your listing?'); ?></div>
								<div class="post-list-content"><?php echo Yii::t('app','qMart allows you to highlight your listing with two different options to reach 
								more number of buyers. You can choose the appropriate option for your listings. Urgent listings gets more leads 
								from buyers and featured listings shows at various places of the website to reach more buyers.'); ?></div>
								</div>
								<div class="post-list-tab-cnt">
									<ul class="post-list-modal-tab nav nav-tabs">
									  <li class="active"><a data-toggle="tab" href="#urgent"><?php echo Yii::t('app','Urgent'); ?></a></li>
									  <li><a data-toggle="tab" href="#promote"><?php echo Yii::t('app','Promote'); ?></a></li>
									</ul>
								</div>	
							</div>	
						</div>	
						<div class="post-list-tab-content  tab-content">
						  <div id="urgent" class="tab-pane fade in active">
							<p> <?php echo Yii::t('app','To make your ads instantly viewable you can go for Urgent ads, which gets highlighted at the top just for'); ?><?php $promoteCurrency = explode("-", $promotionCurrency);echo $promoteCurrency[1].$urgentPrice; ?>.</p>
							<div class="urgent-tab-left col-xs-12 col-sm-8 col-md-8 col-lg-8 no-hor-padding">
								<ul><div class="urgent-tab-heading"><?php echo Yii::t('app','Urgent tag Features:'); ?></div>
									<li><i class="modal-header-tick-icon"></i><span class="urgent-tab-left-list"><?php echo Yii::t('app','Viewable by all users on desktop and mobile'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="urgent-tab-left-list"><?php echo Yii::t('app','Displayed at the top of the page in search results'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="urgent-tab-left-list"><?php echo Yii::t('app','Displayed at the top of the page in search results'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="urgent-tab-left-list"><?php echo Yii::t('app','Higher visibility on the  website'); ?></span></li>
									<li class="stuff-post">
										<a class="btn post-btn" href="javascript:void(0);" onclick="promotionUpdate('urgent');"><?php echo Yii::t('app','Highlight now'); ?></a>
										<a  data-dismiss="modal" class="delete-btn promotion-cancel" href="javascript:void(0);"><?php echo Yii::t('app','Cancel'); ?></a>
										<div class="urgent-promote-error delete-btn"></div>
									</li>
								</ul>	
							</div>
							<div class="urgent-tab-right col-xs-12 col-sm-4 col-md-4 col-lg-4 no-hor-padding">
								<div class="urgent-right-circle-icon"></div>
							</div>
						  </div>
						  <div id="promote" class="tab-pane fade">
							<p><?php echo Yii::t('app','Promote your listings to reach more users than normal listings. The promoted listings will be shown at various places to attract the buyers easily.'); ?></p>
							<div class="tab-radio-button-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<?php foreach ($promotionDetails as $promotion){ ?>
								<div class="tab-radio-button col-xs-6 col-sm-6 col-md-3 col-lg-3 no-hor-padding">
									<div class="tab-radio-content">
										<label><input type="radio" name="optradio" onclick="updatePromotion('<?php echo $promotion->id; ?>')"></label>
										<div class="radio-tab-period"><?php echo $promotion->name; ?></div>
										<div class="radio-tab-price col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4">
											<?php echo $promotion->price; ?>
										</div>
										<div class="radio-tab-days"><?php echo $promotion->days; ?> <?php echo Yii::t('app','days'); ?></div>
									</div>	
								</div>
							<?php } ?>
							</div>
							<div class="promote-tab-left col-xs-12 col-sm-8 col-md-8 col-lg-8 no-hor-padding">
								<ul><div class="promote-tab-heading"><?php echo Yii::t('app','promote tag Features:'); ?></div>
									<li><i class="modal-header-tick-icon"></i><span class="promote-tab-left-list"><?php echo Yii::t('app','Viewable by all users on desktop and mobile'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="promote-tab-left-list"><?php echo Yii::t('app','Displayed at the top of the page in search results'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="promote-tab-left-list"><?php echo Yii::t('app','Displayed at the top of the page in search results'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="promote-tab-left-list"><?php echo Yii::t('app','Higher visibility on the  website'); ?></span></li>
									<li class="stuff-post">
										<a class="post-btn btn" href="javascript:void(0);" onclick="promotionUpdate('adds');"><?php echo Yii::t('app','Promote now'); ?></a>
										<a  data-dismiss="modal" class="delete-btn promotion-cancel" href="javascript:void(0);"><?php echo Yii::t('app','Cancel'); ?></a>
										<div class="adds-promote-error delete-btn"></div>
									</li>
								</ul>	
							</div>
							<div class="promote-tab-right col-xs-12 col-sm-4 col-md-4 col-lg-4 no-hor-padding">
								<div class="promote-right-circle-icon"></div>
							</div>
						  </div>
						</div>
				</div>
			</div>
			<input type="hidden" class="promotion-product-id" value="">
			<input type="hidden" name="Products[promotion][type]" value="" id="promotion-type">
			<input type="hidden" name="Products[promotion][addtype]" value="" id="promotion-addtype">
		</div>

