<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Profile';
$this->breadcrumbs=array(
	'Profile',
);

?>

<div id="page-container" class="container">
<div class="row">		
				<div class="qMart-breadcrumb add-product col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					 <ol class="breadcrumb">
						<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"><?php echo Yii::t('app','Home'); ?></a></li>
						<li><a href="#"><?php echo Yii::t('app','Profile'); ?></a></li>					 
					 </ol>			
				</div>

				<div class="modal fade" id="mobile-otp" role="dialog" aria-hidden="true"> 
						<div class="modal-dialog modal-dialog-width">
							<div class="chat-seller-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="otp-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<button onClick="close_otp()" class="close chat-with-seller-close" type="button">×</button>
									<div class="otp-modal-content col-xs-9 col-sm-10 col-md-10 col-lg-10 no-hor-padding">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Enter One Time Password'); ?></div>
									</div>
								</div>	
						
								<div class="messgage-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="otp-message col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','One Time Password (OTP) has been sent to your mobile'); ?> <span class="mob_code"></span><?php echo Yii::t('app',', please enter the same here to login.'); ?></div>
									<div class="profile-input-fields col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><input type="text" placeholder="Enter your OTP code" id="otp_code" maxlength="10"></div>
									<div class="otp-message"><?php echo Yii::t('app','Please enter this code:'); ?> <span class="rand_code"></span></div>
									<p id="verification_error" class="errorMessage"></p>
									<div class="verify-otp-btn col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<div class="change-pwd-btn col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="javascript:;" onClick="verify_otp()" id="verify_text"><?php echo Yii::t('app','Verify'); ?></a></div><div class="otp-error"><?php echo Yii::t('app','OTP code does not match'); ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
<?php

$user->userId = $model['userId'];
$user->name = $model['name'];
$user->userImage = $model['userImage'];
$user->mobile_status = $model['mobile_status'];
$user->facebookId = $model['facebookId'];

?>

<div class="row page-container profile-page-update">
	<div class="container exchange-property-container profile-vertical-tab-section">
		<?php $this->renderPartial('application.modules.useractivity.views.useraction.profilemenu',array('user'=>$user,'model'=>$model)); ?>

					<div class="tab-content col-xs-12 col-sm-9 col-md-9 col-lg-9">
							<div id="edit-prof" class="profile-tab-content tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding active in">
							<div class="profile-tab-content-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<span><?php echo Yii::t('app','Profile'); ?></span>
								<div class="change-pwd-btn pull-right col-xs-8 col-sm-3 col-md-3 col-lg-3 no-hor-padding"><a href="<?php echo Yii::app()->createAbsoluteUrl('user/changepassword'); ?>" id="element1" ><?php echo Yii::t('app','Change Password'); ?></a></div>
							</div>

							
							<div class="edit-profile-form col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="edit-profile-form">
								<?php $form=$this->beginWidget('CActiveForm', array(
								'id'=>'users-profile-form',
								'action'=>Yii::app()->createURL('/user/profile'),
								// Please note: When you enable ajax validation, make sure the corresponding
								// controller action is handling ajax validation correctly.
								// See class documentation of CActiveForm for details on this,
								// you need to use the performAjaxValidation()-method described there.
								'enableAjaxValidation'=>true,
								'enableClientValidation'=>true,
							    	'htmlOptions' => array('enctype' => 'multipart/form-data','onsubmit'=>'return profileVal()'),
								)); ?>
								<div class="profile-text-label col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding"><?php echo Yii::t('app','Name'); ?><span class="mandotory-field">*</span></div>
								<div class="profile-input-fields col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding">
								<?php echo $form->textField($model,'name',array('class' => 'form-control','onkeypress' => 'return IsAlphaNumeric(event)')); ?>
								<?php echo $form->error($model,'name'); ?></div>
								<div class="profile-text-label col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding"><?php echo Yii::t('app','Username'); ?><span class="mandotory-field">*</span></div>
								<div class="profile-input-fields col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding">
								<?php echo $form->textField($model,'username',array('class' => 'form-control','onkeypress' => 'return IsAlphaNumeric(event)','readonly'=>true)); ?>
								<?php echo $form->error($model,'username'); ?>								
								</div>
								<div class="profile-label-verification col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding"><span><?php echo Yii::t('app','Verifications'); ?></span><span class="question-circle" data-toggle="tooltip" title="To be a verified seller, please add your mobile number, email address and connect with your facebook. Buyers will be more interested to talking to the verified users."></span></div>
								<div class="profile-email profile-text-label col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding"><?php echo Yii::t('app','Email'); ?><span class="mandotory-field">*</span></div>
								
								<div class="profile-input-fields col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding">
								<?php echo $form->textField($model,'email',array('class' => 'form-control','readonly'=>true)); ?>
								<?php echo $form->error($model,'email'); ?>
								</div>
								<div class="hor-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
								<div class="profile-text-bold profile-text-label col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding"> <?php echo Yii::t('app','Phone number :'); ?></div>
								<div class="profile-email-txt profile-text-label col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo Yii::t('app','Get verified your phone number to become the trustworthy seller'); ?>
								</div>
								<?php if($model->mobile_status != '1') { ?>
									<div class="profile-email-txt add-phone col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="javascript:void(0)" id="add-phone" onclick="switchVisible_addphone();"><?php echo Yii::t('app','+ Add your mobile number'); ?></a></div>								
								<?php } ?>
								<div class="profile-mobile-details col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="profile-mobile-details">
									<div class="profile-input-fields col-xs-12 col-sm-12 col-md-4 col-lg-4 no-hor-padding"><input type="text" value="" placeholder="Enter your mobile number" onkeypress="return isNumber(event)" maxlength="15" id="mobile_number"></div>
									<span class="mobile-error" id="mobile-error"><?php echo Yii::t('app','Enter your mobile number'); ?></span>
									<!--<div class="profile-dropdown dropdown col-xs-12 col-sm-12 col-md-3 col-lg-2 no-hor-padding">
										<div class="drop-down-div dropdown-toggle" type="button" data-toggle="dropdown">Select Country
										  <span class="qMart-caret caret pull-right"></span></div>
										  <ul class="dropdown-menu col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<li><a href="#">India</a></li>
											<li><a href="#">America</a></li>
											<li><a href="#">Australia</a></li>
										  </ul>
									</div>-->
									<div class="verify-via-sms-btn col-xs-12 col-sm-3 col-md-3 col-lg-2 no-hor-padding">
										<div class="change-pwd-btn col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="javascript:;" onClick="mobile_verification()"><?php echo Yii::t('app','Verify via sms'); ?></a></div>
									</div>	
								</div>
								<input type="hidden" id="verify_mobile_number" value="<?php echo $model->phone; ?>">
								<?php if($model->mobile_status == '1') { 
									$mobile_verify = 'style="display:block;"';
								} else {
									$mobile_verify = 'style="display:none;"';
								}
								?>
									<div class="profile-email-txt profile-text-label col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="mobile-verification" <?php echo $mobile_verify; ?>>		
								
										<div class="profile-tab-tick-icon"></div>
										<div class="verified-txt">.( <?php echo Yii::t('app','Your mobile has been verified'); ?><span id="n_number"><?php echo $model->phone; ?></span>)</div>
										<div class="change-txt"><a href="javascript:void(0)" id="add-phone" onclick="switchVisible_addphone();"><?php echo Yii::t('app','Change'); ?></a></div>
								
									</div>
								<?php if(empty($model->facebookId)) { 
									$fb_verify = '';
								} else {
									$fb_verify = 'style="display:none;"';
								}
								?>	
								<div class="hor-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
								<div class="profile-text-bold profile-text-label col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding"><?php echo Yii::t('app','Facebook :'); ?> </div>
								<div class="profile-email-txt profile-text-label col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									 <?php echo Yii::t('app','Let your facebook users know that you are available here upon verifying your facebook account.'); ?> <a href="javascript:;" onclick="return popitup('Facebook');" id="fb_verify" <?php echo $fb_verify; ?>><?php echo Yii::t('app','Verify your facebook account.'); ?></a>         

								</div>
								<?php if(!empty($model->facebookId)) { 
									$facebook_verify = 'style="display:block;"';
								} else {
									$facebook_verify = 'style="display:none;"';
								}
								?>	
								<div class="facebook-verification profile-email-txt profile-text-label col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" <?php echo $facebook_verify; ?>>		
								
									<div class="profile-tab-tick-icon"></div>
									<div class="verified-txt"><?php echo Yii::t('app','Your facebook account has been verified.'); ?></div>
								
								</div>
								<div class="facebook-verification-failure profile-email-txt profile-text-label col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="display:none;">		
								
									<div class="profile-tab-cancel-icon"></div>
									<div class="verified-txt" style="color:#ff0000;"><?php echo Yii::t('app','Something is wrong. Your facebook account is not verified.'); ?></div>
								
								</div>
								<div class="hor-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
								<div class="prof-save-btn col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="change-pwd-btn col-xs-4 col-sm-2 col-md-2 col-lg-2 no-hor-padding">
									<?php echo CHtml::submitButton(Yii::t('app','Save'),array('class'=>'edit-profile')); ?>
									</div>
								</div>
								<?php $this->endWidget(); ?>	
							</div>
							
						</div>
	<!-- form -->


						
	</div>
	</div></div>
</div>
</div>
</div>
</div>

<script>

function switchVisible_addphone() {
            if (document.getElementById('add-phone')) {

                if (document.getElementById('add-phone').style.display == 'none') {
                    document.getElementById('add-phone').style.display = 'block';
                    document.getElementById('profile-mobile-details').style.display = 'none';
                }
                else {
                    document.getElementById('add-phone').style.display = 'none';
                    document.getElementById('profile-mobile-details').style.display = 'block';
                    document.getElementById('mobile-error').style.display = 'none';
                }
            }
}
</script>

<style>
.edit-profile {
    background-color: #2bc248 !important;
    border-radius: 4px !important;
    color: #ffffff !important;
    float: left !important;
    font-family: fsalbert-regular !important;
    padding-bottom: 10px !important;
    padding-top: 10px !important;
    text-align: center !important;
    width: 100% !important;
    margin-top:0px !important;
}
.file-upload{
	cursor: pointer; 
	height: 40px; 
	position: absolute; 
	left: 94px; 
	top: 65px; 
	width: 33%; 
	opacity: 0;
}
.footer {
    margin-top: 0px !important;
}
</style>
<script>
function on_submit() {
	$('#fileupload').submit();
}
</script>
