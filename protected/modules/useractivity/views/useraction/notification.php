<?php 
$user->userId = $model['userId'];
$user->name = $model['name'];
$user->userImage = $model['userImage'];
$user->mobile_status = $model['mobile_status'];
$user->facebookId = $model['facebookId'];
   ?>

   <?php if(count($logModel) == '0'){ 
	$empty_tap = " empty-tap ";
}else{
	$empty_tap = "";
	} ?>
<script type="text/javascript">
var notifyOffset = 32;
var notifyLimit = 32;
</script>
<!--Notifications-->
<div class="container">
	<div class="row">		
		<div class="qMart-breadcrumb add-product col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			 <ol class="breadcrumb">
				<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"><?php echo Yii::t('app','Home'); ?></a></li>
				<li><a href="#"><?php echo Yii::t('app','Notification'); ?></a></li>					 
			 </ol>			
		</div>
		
	</div>
	<div class="row page-container">
		<div class="container exchange-property-container profile-vertical-tab-section">
			<?php $this->renderPartial('profilemenu',array('user'=>$user)); ?>
		<div class="tab-content col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<div id="notifications" class="profile-tab-content tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding active in <?php echo $empty_tap; ?>">				
				<div class="profile-tab-content-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<?php echo Yii::t('app','Notifications'); ?>
				</div>
				
				<div class="notification-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php 
					$this->renderPartial('notificationloadmore',array(
							'logModel'=>$logModel
					)); ?>
				</div>
				<?php if (count($logModel) == 32){ ?>
				<div class="load-more-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<?php echo CHtml::ajaxLink('<div class="load-more-icon"></div>
							<div class="load-more-txt">More Notifications</div>', array('notificationloadmore'),
							array(
							'beforeSend'=> 'js:function(){$(".load-more-cnt").hide();$(".qMart-loader").show();}',
							'data'=> 'js:{"notifyLimit": notifyLimit, "notifyOffset": notifyOffset}',
							'success' => 'js:function(response){ 
									$(".load-more-cnt").show();$(".qMart-loader").hide();
					         		var output = response.trim();
									if (output != 0) {
										notifyOffset = notifyOffset + notifyLimit;
										//$("#products").append(output);   
										$(".notification-cnt").append($.trim(output)); 
									} else {
										$(".qMart-loader").hide();
										$(".load-more-cnt").hide();
									}
							 }',
							)
						); ?>
				</div>
				<div class="qMart-loader">
					<div class="cssload-loader"></div>
				</div>
				<?php } ?>
			</div>
			</div>
		</div>
	</div>
</div>
