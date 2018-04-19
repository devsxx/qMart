<?php if(empty($exchanges)){ 
	$empty_tap = " empty-tap ";
}else{
	$empty_tap = "";
	} ?>

<?php if(count($logModel) != '0') {
	foreach ($logModel as $log){ 
		$productModel = array();
		if($log->itemid != 0){
			$productModel = Myclass::getProductDetails($log->itemid);
		}
		$userModel = Myclass::getUserDetails($log->userid);
		if(!empty($userModel->userImage)){
			$userImage = Yii::app()->createAbsoluteUrl('user/resized/150/'.$userModel->userImage); 
		}else{ 
			$userImage = Yii::app()->createAbsoluteUrl('user/resized/150/default/'.Myclass::getDefaultUser()); 
		}
		$createdDate = date('jS M Y', $log->createddate);
?>
	<div class="notification-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<div class="notification-pro-pic-cnt">
		<?php if ($log->type != 'admin'){ ?>
			<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',
					array('id'=>Myclass::safe_b64encode($userModel->userId.'-'.rand(0,999)))); ?>"  target="_blank" 
					title="<?php echo $userModel->username; ?>">
				<div class="notification-prof-pic" id="notif-prof-1" style="background-image: url('<?php echo $userImage; ?>');"></div>
			</a>
		<?php }else{ ?>
			<a href="javascript:void(0);">
				<div class="notification-prof-pic" id="notif-prof-1" style="background-image: url('<?php echo $userImage; ?>');"></div>
			</a>
		<?php } ?>
		</div>
		<div class="notification-message-cnt">
			<div class="notification-message">
			<?php if ($log->type != 'admin'){ ?>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',
					array('id'=>Myclass::safe_b64encode($userModel->userId.'-'.rand(0,999)))); ?>"  title="_blank" 
					title="<?php echo $userModel->username; ?>">
					<?php echo $userModel->name; ?>
				</a> <?php echo Yii::t("app", $log->notifymessage); ?>
				<?php if (!empty($productModel)){ ?>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('item/products/view',
						array('id' => Myclass::safe_b64encode($productModel->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug(
						$productModel->name); ?>" class="notification-product-name" title="_blank">
					<?php echo $productModel->name; ?>
				</a>
				<?php } ?>
			<?php }else{ ?>
				<a href="javascript:void(0);">
					<?php echo Myclass::getSiteName()." "; ?>
				</a> <?php echo Yii::t("app", $log->notifymessage)." '".$log->message."'"; ?>
			<?php } ?>
			</div>
			<div class="notification-date"><?php echo $createdDate; ?></div>
		</div>
	</div>
<?php }
	} else { ?>
		<div class="modal-dialog modal-dialog-width">
			<div class="col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="margin-bottom:100px;">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="payment-decline-status-info-txt" style="margin: 8% auto 0;">
						<img src="<?php echo Yii::app()->createAbsoluteUrl("/images/empty-tap.jpg");?>">
						</br><span class="payment-red"><?php echo Yii::t('app','Sorry...');?></span> <?php echo Yii::t('app','You have no notification.');?>
					</div>
				</div>
			</div>
		</div>
		
<?php  } ?>
