<?php  $user->userId = $model['userId'];
$user->name = $model['name'];
$user->userImage = $model['userImage'];
$user->mobile_status = $model['mobile_status'];
$user->facebookId = $model['facebookId'];?>
		<!--exchange history modal-->
	
			<div class="modal fade" id="exchange-history-modal" role="dialog"> 
				<div class="modal-dialog modal-dialog-width">
					<div class="chat-seller-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="otp-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<button data-dismiss="modal" class="close chat-with-seller-close" type="button">×</button>
							<div class="otp-modal-content col-xs-9 col-sm-10 col-md-10 col-lg-10 no-hor-padding">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Exchange History'); ?></div>
							</div>
						</div>	
						
						
							<div id="exchangeHistory"></div>
						
					</div>
				</div>
			</div>
				
		<!--E O exchange history modal-->


<div class="container">
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
	<div class="tab-content col-xs-12 col-sm-9 col-md-9 col-lg-9">
	<div id="exchange" class="profile-tab-content tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding active in">
		<div class="profile-tab-content-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<?php echo Yii::t('app','Exchange Request Details'); ?>
			<div class="exchange-back-link pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 no-hor-padding">
			<?php if($exchange->requestFrom != Yii::app()->user->id){ ?>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges?type=incoming'); ?>"><?php echo Yii::t('app','Back'); ?></a>
			<?php }else{ ?>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges?type=outgoing'); ?>"><?php echo Yii::t('app','Back'); ?></a>
			<?php } ?>
			</div>
		</div>
		<div class="profile-listing-product-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="exchange-content-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="exchange-left-content col-xs-12 col-sm-12 col-md-4 col-lg-4 no-hor-padding">
				<?php $mainProductImage = Myclass::getProductImage($exchange->mainProductId);
				$exchangeProductImage = Myclass::getProductImage($exchange->exchangeProductId); ?>
					<a class="prof-pic-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view',array(
							'id'=>Myclass::safe_b64encode($exchange->mainProductId.'-'.rand(0,999)))).'/'.Myclass::productSlug($mainProduct->name); ?>">
						
						<div class="exchange-detail-prof-pic" style="
						<?php if(!empty($mainProductImage)) { ?> 
						background: url('<?php echo Yii::app()->createAbsoluteUrl('item/products/resized/250/'.$exchange->mainProductId.'/'.$mainProductImage); ?>') no-repeat;
						<?php } else { ?> 
						background: url('<?php echo Yii::app()->createAbsoluteUrl('item/products/resized/250/default.jpeg'); ?>') no-repeat;
						<?php } ?>
						background-repeat: no-repeat;background-position: center center;background-size: cover;"></div>
						
						<div class="exchange-prod-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php echo $mainProduct->name; ?></div>

					</a>
				</div>
				<div class="exchange-detail-arrow-cnt col-xs-12 col-sm-12 col-md-4 col-lg-4 no-hor-padding"><div class="exchange-arrow"></div></div>
				<div class="exchange-right-content col-xs-12 col-sm-12 col-md-4 col-lg-4 no-hor-padding">
					<a class="prof-pic-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"
						href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view',array(
							'id'=>Myclass::safe_b64encode($exchange->exchangeProductId.'-'.rand(0,999)))).'/'.Myclass::productSlug($exchangeProduct->name); ?>">

						<div class="exchange-detail-prof-pic" style="
						<?php if(!empty($exchangeProductImage)) { ?>
						background: url('<?php echo Yii::app()->createAbsoluteUrl('item/products/resized/250/'.$exchange->exchangeProductId.'/'.$exchangeProductImage); ?>') no-repeat;
						<?php } else { ?> 
						background: url('<?php echo Yii::app()->createAbsoluteUrl('item/products/resized/250/default.jpeg'); ?>') no-repeat;
						<?php } ?>
						background-repeat: no-repeat;background-position: center center;background-size: cover;"></div>
						
						<div class="exchange-prod-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php echo $exchangeProduct->name; ?></div>

					</a>
				</div>
			</div>

			<div class="exchange-details-info col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="exchange-btn-cnt pull-right">
			<?php
			$mCheck = Myclass::checkWhetherProductSold($exchange->mainProductId);
			$exCheck = Myclass::checkWhetherProductSold($exchange->exchangeProductId);
			if(!empty($mCheck) || !empty($exCheck)) { ?>
				<p class="sold-status">
					<label class="label-lg label-default"><?php echo Yii::t('app','ONE OF THE PRODUCTS IS SOLD'); ?></label>
				</p>
				<a type="button" class="exchange-btn" id="exc-pending"
					href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges/sold',array('id'=>$exchange->id)); ?>"
					class="btn-choose-option btn-lg btn-success" id="btn-doneid"> <?php echo Yii::t('app','OK'); ?>
				</a>
				<?php } else {
					if($exchange->status == 1) {
						?>
				<span type="button" class="exchange-btn" id="exc-success"
					onclick='confirmModal("link","item/exchanges/success?id=", "<?php echo $exchange->id; ?>");'
					class="btn-choose-option btn-done" id="btn-doneid"> <?php echo Yii::t('app','SUCCESS'); ?>
				</span>&nbsp;
				<span type="button" class="exchange-btn" id="exc-failed"
					onclick='confirmModal("link", "item/exchanges/failed?id=", "<?php echo $exchange->id; ?>")'
					class="btn-choose-option btn-danger" id="btn-doneid"> <?php echo Yii::t('app','FAILED'); ?>
				</span>
				<?php }/* elseif($exchange->status == 2) {?>
				<label class="label-lg label-danger" style="font-size: 20px;">DECLINED</label>
				<?php } elseif($exchange->status == 3) {?>
				<label class="label-lg label-warning">CANCELLED</label>
				<?php } elseif($exchange->status == 4) { ?>
				<label class="label-lg label-success">SUCCESS</label>
				<?php } elseif($exchange->status == 5) { ?>
				<label class="label-lg label-danger">FAILED</label>
				<?php } elseif($exchange->status == 6) { ?>
				<label class="label-lg label-default">SOLD OUT</label>
				<?php }*/else {
				if($exchange->requestFrom == Yii::app()->user->id) { ?>
				<span type="button" class="exchange-btn" id="exc-pending"
					onclick='confirmModal("link", "item/exchanges/cancel/id/", "<?php echo $exchange->id; ?>")'
					class="btn-choose-option btn-danger" id="btn-doneid"> <?php echo Yii::t('app','CANCEL'); ?>
				</span>
				<?php } else {?>
				<span type="button" class="exchange-btn" id="exc-success"
					onclick='confirmModal("link", "item/exchanges/accept/id/", "<?php echo $exchange->id; ?>")'
					class="btn-choose-option btn-done" id="btn-doneid"> <?php echo Yii::t('app','ACCEPT'); ?>
				</span>&nbsp; 
				<span type="button" class="exchange-btn" id="exc-failed"
					onclick='confirmModal("link", "item/exchanges/decline/id/", "<?php echo $exchange->id; ?>")'
					class="btn-choose-option btn-danger" id="btn-doneid"> <?php echo Yii::t('app','DECLINE'); ?>
				</span>
				<?php } ?>
				<?php }
				} ?>
				</div>
				<div class="exchange-history">
					<a href="" onclick="showexchangehistory('<?php echo $exchange->slug; ?>')" data-dismiss="modal" data-toggle="modal" data-target="#exchange-history-modal"><img src="<?php echo Yii::app()->createAbsoluteUrl('images/reload-icon.png'); ?>" width="16px" height="16px" alt="reload-icon"><?php echo Yii::t('app','View exchange history'); ?></a>
				</div>
			</div>
			<div class="exchange-message-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="exchange-message-header-txt-cnt pull-right">
					<img src="<?php echo Yii::app()->createAbsoluteUrl('images/message-icon.png'); ?>" width="24px" height="18px" alt="message-icon"><?php echo Yii::t('app','Message'); ?>
				</div>
			</div>
			<div class="exchange-message-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			
			</div>
			</div></div></div>
		</div>
	</div>
</div>
<script>

function exchangeChat() {
	$.ajax({
     type:'POST',
     url: '<?php echo Yii::app()->createAbsoluteUrl('item/exchanges/message',array('sourceId' => $exchange->id,'from'=>$exchange->requestFrom,'to' =>$exchange->requestTo)); ?>',
     data : {sourceId  : <?php echo $exchange->id; ?>},
     success : function(data) {
           $(".exchange-message-cnt").html(data);
         }
		});	
}
exchangeChat();
</script>
