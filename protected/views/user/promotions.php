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
									  <li class="active"><a data-toggle="tab" href="#urgent"><?php echo Yii::t('app','Urgent'); ?></a></li>
									  <li><?php echo CHtml::link(Yii::t('app','Advertisement'),Yii::app()->createAbsoluteUrl('user/advertisePromotions',array('id'=>Myclass::safe_b64encode($user->userId.'-'.rand(0,999)))));  ?></li>
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
															<div class="payment-decline-status-info-txt" style="margin: 8% auto 0;"><img src="<?php echo Yii::app()->createAbsoluteUrl("/images/empty-tap.jpg");?>"></br><span class="payment-red">Sorry...<?php echo Yii::t('app','Promotion Type :'); ?></span> <?php echo Yii::t('app','Yet no product are here.'); ?></div>
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
								if(Yii::app()->controller->action->id == 'promotions') { ?>
								<?php echo CHtml::ajaxButton(Yii::t('app','Load More'), array('promotions','id' =>Myclass::safe_b64encode($user->userId.'-'.rand(0,999))),
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
									<span><?php echo Yii::t('app','Promotion Details'); ?></span>
									<div class="exchange-back-link pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 no-hor-padding"><a href="#" onclick="switchVisible_promotionback();" id="element1"><?php echo Yii::t('app','Back'); ?></a></div>
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


