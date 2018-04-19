<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Change Password';
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
				
			</div>
<?php
/* $flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
	echo '<ul class="flashes">';
	foreach($flashMessages as $key => $message) {
		echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
	}
	echo '</ul>';
} */
$user->userId = $model['userId'];
$user->name = $model['name'];
$user->userImage = $model['userImage'];
$user->mobile_status = $model['mobile_status'];
$user->facebookId = $model['facebookId'];
?>

<div class="row page-container profile-page-update">
	<div class="container exchange-property-container profile-vertical-tab-section">
		 <?php $this->renderPartial('application.modules.useractivity.views.useraction.profilemenu',array('user'=>$user)); ?> 

					<div class="tab-content col-xs-12 col-sm-9 col-md-9 col-lg-9">
							<div id="edit-prof" class="profile-tab-content tab-pane fade col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding active in">
							<div class="profile-tab-content-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<span><?php echo Yii::t('app','Change Password'); ?></span>
								<div class="change-pwd-btn pull-right col-xs-8 col-sm-3 col-md-3 col-lg-3 no-hor-padding"><a href="<?php echo Yii::app()->createAbsoluteUrl('user/profile'); ?>" id="element1" ><?php echo Yii::t('app','Back'); ?></a></div>
							</div>
							<div class="forgot-password-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="forgot-password-cnt" style="display:block;">
								<?php $form=$this->beginWidget('CActiveForm', array(
									'id'=>'users-change-password-form',
									'action'=>Yii::app()->createURL('/user/changepassword'),
									// Please note: When you enable ajax validation, make sure the corresponding
									// controller action is handling ajax validation correctly.
									// See class documentation of CActiveForm for details on this,
									// you need to use the performAjaxValidation()-method described there.
									'enableAjaxValidation'=>true,
									'enableClientValidation'=>true,
									'clientOptions'=>array(
										'validateOnSubmit'=>true,
									),
								    'htmlOptions' => array('enctype' => 'multipart/form-data'),
									)); ?>
								<div class="profile-input-fields col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding">
									
									<?php echo $form->passwordField($model,'existing_password',array('placeholder' => 'Enter your old password')); ?>
									<?php echo $form->error($model,'existing_password'); ?>
								</div>
								<div class="profile-input-fields col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding">
									
									<?php echo $form->passwordField($model,'password',array('placeholder' => 'Enter your new password')); ?>
									<?php echo $form->error($model,'password'); ?>
								</div>
								<div class="profile-input-fields col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding">
									
									<?php echo $form->passwordField($model,'confirm_password',array('placeholder' => 'Re-enter your new password')); ?>
									<?php echo $form->error($model,'confirm_password'); ?>
								</div>
								<div class="hor-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
								<div class="prof-save-btn col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="change-pwd-btn col-xs-4 col-sm-2 col-md-2 col-lg-2 no-hor-padding">
									<?php echo CHtml::submitButton(Yii::t('app','Save'),array('class'=>'password-change')); ?>
									</div>
									
								</div>
								<?php $this->endWidget(); ?>
							</div>
							
						</div>
	<!-- form -->
</div>
</div>
</div>
</div>
</div>
</div>

<style>
.password-change {
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
</style>
