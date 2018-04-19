<?php 
$action = Yii::app()->controller->action->id;
$sitesetting = Myclass::getSitesettings();
$paymentmode = json_decode($sitesetting->sitepaymentmodes,true);

?>
<ul style="padding: 0;" class="profile-vertical-tab-container nav nav-tabs col-xs-12 col-sm-3 col-md-3 col-lg-3">
  <li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<div class="profile-icon-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="profile-page-profile-icon" style="background-image:url('<?php if(!empty($user->userImage)) {  echo Yii::app()->createAbsoluteUrl('user/resized/150/'.$user->userImage); }else{ echo Yii::app()->createAbsoluteUrl('user/resized/150/default/'.Myclass::getDefaultUser()); }?>');">
			<?php 
				if($action == 'profile') {
						$form=$this->beginWidget('CActiveForm', array(
								'action'=>Yii::app()->createURL('/user/profile'),
								//'accept' => 'image/*',
								// Please note: When you enable ajax validation, make sure the corresponding
								// controller action is handling ajax validation correctly.
								// See class documentation of CActiveForm for details on this,
								// you need to use the performAjaxValidation()-method described there.
								'enableAjaxValidation'=>true,
								'method' => 'POST',
							    	'htmlOptions' => array('id' => 'fileupload','enctype' => 'multipart/form-data'),
								)); ?>
							<div class="camera-edit-icon"></div>
							<!--<input type="file" id="userfile" name="XUploadForm[file]" accept=".png, .jpg, .jpeg" style="cursor: pointer; height: 40px; position: absolute; left: 94px; top: 65px; width: 33%; opacity: 0;" onchange="return on_submit();">		-->			
							<?php $allowedExtensions = ".jpg,.jpeg,.png,.JPG,.JPEG,.PNG"; 
							echo $form->fileField($model,'userImage',array('class' => 'form-control file-upload','onchange'=>'on_submit()','accept' => "'$allowedExtensions'")); ?>
							<div class="col-xs-4" style="display:none;"><?php echo CHtml::submitButton(Yii::t('app','Save'),array('class'=>'edit-profile')); ?></div>					
							</div>	
							<?php $this->endWidget(); 
				}
			?>
						
		</div>
		<div class="profile-details col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="profile-user-name"><?php echo ucfirst($user->name);?></div>
			<div class="profile-country-name"><?php echo $user->username; ?></div>
			<div class="seller-verification col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="col-xs-offset-4 col-sm-offset-3 col-md-offset-4 col-lg-offset-4">
					<?php if($user->mobile_status == '1') { ?>
						<div class="mobile-verification" id="verified" data-toggle="tooltip" title='<?php echo Yii::t('app','Mobile number Verified!')?>'></div>
					<?php } else { ?>
						<div class="mobile-verification" data-toggle="tooltip" title='<?php echo Yii::t('app','Mobile number is not Verified!')?>'></div>
					<?php } ?>
					<?php if(!empty($user->facebookId)) { ?>
						<div class="fb-verification" id="verified" data-toggle="tooltip" title='<?php echo Yii::t('app','Facebook account Verified!')?>'></div>
					<?php } else { ?>
						<div class="fb-verification" data-toggle="tooltip" title='<?php echo Yii::t('app','Facebook account is not Verified!')?>'></div>
					<?php } ?>
					<div class="mail-verification" id="verified" data-toggle="tooltip" title='<?php echo Yii::t('app','Mail Id Verified!')?>'></div>
				</div>	
			</div>
			</div>
		<?php $subActive = '';
			if(Yii::app()->controller->action->id == 'profiles')
			$subActive = 'active';
			else
			$subActive = ''; ?>
			<?php if(Yii::app()->controller->action->id == 'liked')
			$lactive = 'active';
			else
			$lactive = ''; ?>
			<?php if(Yii::app()->controller->action->id == 'review')
			$ractive = 'active';
			else
			$ractive = ''; ?>
			<?php if(Yii::app()->controller->action->id == 'follower')
			$factive = 'active';
			else
			$factive = ''; ?>
			<?php if(Yii::app()->controller->action->id == 'following')
			$f1active = 'active';
			else
			$f1active = ''; ?>	
			<?php if(Yii::app()->controller->action->id == 'notification')
			$notactive = 'active';
			else
			$notactive = ''; 
			if(Yii::app()->controller->action->id == 'advertisePromotions' || Yii::app()->controller->action->id == 'promotions')
			$promactive = 'active';
			else
			$promactive = '';
			
			if(Yii::app()->controller->action->id == 'index' || Yii::app()->controller->action->id == 'view')
			$exactive = 'active';
			else
			$exactive = ''; ?>


			<a style="background: transparent;">
			<?php if(Yii::app()->user->id == $user->userId) { ?>
				
			<?php }else { //var_dump($followerIds);
			if(!empty(Yii::app()->user->id) && $user->userstatus == 1) {
			if (!in_array($user->userId, $followerIds)) { ?>
			<div class="btn-follow btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding " id = "follow<?php echo $user->userId; ?>" onclick="getfollows(<?php echo $user->userId; ?>)"><span><?php echo Yii::t('app','Follow'); ?></span>
			</div> </div>
			<?php }else { ?>
			<div class="btn-follow btn-chat-with-seller col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id = "follow<?php echo $user->userId; ?>" onclick="deletefollows(<?php echo $user->userId; ?>)"><span><?php echo Yii::t('app','Following'); ?></span>
			</div> </div>
			<?php }
				}
			} ?>
			</a>

			
			
  </li>
  <?php  if(Yii::app()->user->id == $user->userId){ ?>
	  <li class="<?php echo $subActive; ?> col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	  <?php echo CHtml::link(Yii::t('app','My listing'),Yii::app()->createAbsoluteUrl('user/profiles',array('id'=>Myclass::safe_b64encode($user->userId.'-'.rand(0,999)))),array('class' => 'btn-category '.$subActive));  ?>
	  </li>
  <?php } else { ?>
  		<li class="<?php echo $subActive; ?> col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	  <?php echo CHtml::link(Yii::t('app','Listing'),Yii::app()->createAbsoluteUrl('user/profiles',array('id'=>Myclass::safe_b64encode($user->userId.'-'.rand(0,999)))),array('class' => 'btn-category '.$subActive));  ?>
	  </li>
  <?php } ?>
  <?php  if(Yii::app()->user->id == $user->userId){ ?>
  <li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding <?php echo $action == 'profile' ? "active" : ""; ?>">
	<a class="shop-button pull-right"
		href="<?php echo Yii::app()->createAbsoluteUrl('user/profile'); ?>"><?php echo Yii::t('app','Edit').' '.Yii::t('app','Profile'); ?>
	</a> 
  </li>
  <?php } ?>
   <li class="<?php echo $lactive.$factive.$f1active; ?> col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	<?php echo CHtml::link(Yii::t('app','Recent activities'),Yii::app()->createAbsoluteUrl('user/liked',array('id'=>Myclass::safe_b64encode($user->userId.'-'.rand(0,999)))),array('class' => ''.$lactive));  ?>
  </li>
 <?php  if(Yii::app()->user->id == $user->userId){ ?>
	<li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding <?php echo $promactive; ?>">
		<a  href="<?php echo Yii::app()->createAbsoluteUrl('user/promotions'); ?>">
			<?php echo Yii::t('app','Promotions'); ?><span class="ad-label pull-right"><?php echo Yii::t('app','AD'); ?></span>
		</a>
  	</li>
 	<?php $sitePaymentModes = Myclass::getSitePaymentModes(); if($sitePaymentModes['exchangePaymentMode'] == "1"){ ?>
	  <li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding <?php echo $exactive; ?>">
		<?php echo CHtml::link(Yii::t('app','My Exchange'),Yii::app()->createAbsoluteUrl('item/exchanges?type=incoming'),array('class' => ''.$exactive));  ?>
	  </li>
	<?php } ?>
 <?php } ?>
 <?php if(Yii::app()->user->id == $user->userId && $paymentmode['buynowPaymentMode'] == 1){ ?>
  <li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding <?php echo $action == 'orders' ? "active" : ""; ?>">
  	<?php echo CHtml::link(Yii::t('app','MY Orders & My Sales'),Yii::app()->createAbsoluteUrl('orders'),array('class' => ''.$notactive));  ?>
  </li>
 <?php } ?> 
 <?php  if(Yii::app()->user->id == $user->userId && $paymentmode['buynowPaymentMode'] == 1){ ?>
  <li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding <?php echo $action == 'shippingaddress' ? "active" : ""; ?>">
  	<?php echo CHtml::link(Yii::t('app','Address Book'),Yii::app()->createAbsoluteUrl('shippingaddress'),array('class' => ''.$notactive));  ?>
  </li>
 <?php } ?>  
 <?php  if(Yii::app()->user->id == $user->userId){ ?>
  <li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding <?php echo $action == 'notification' ? "active" : ""; ?>">
  	<?php echo CHtml::link(Yii::t('app','Notifications'),Yii::app()->createAbsoluteUrl('notification'),array('class' => ''.$notactive));  ?>
  </li>
 <?php } ?>
</ul>