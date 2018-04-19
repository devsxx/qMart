<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Signup';
$this->breadcrumbs=array(
	'Signup',
);
?>

<div class="slider container container-1 section_container">
			  <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					  <!-- Bottom to top-->
					  <div class="row product_align_cnt">
						<div class="modal-dialog modal-dialog-width">
							<div class="signup-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="signup-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<h2 class="signup-header-text"><?php echo Yii::t('app','Sign Up'); ?></h2>
									
								</div>
									<div class="sigup-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
								
										<div class="signup-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding " style="padding-bottom:0px">
											<div class="signup-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<?php $form=$this->beginWidget('CActiveForm', array(
												'id'=>'users-signup-form',
												'action'=>Yii::app()->createURL('/user/socialsignup'),
											// Please note: When you enable ajax validation, make sure the corresponding
											// controller action is handling ajax validation correctly.
											// See class documentation of CActiveForm for details on this,
											// you need to use the performAjaxValidation()-method described there.
											    'enableAjaxValidation' => true,
											    'enableClientValidation'=>true,
										     	'clientOptions'=>array(
													'validateOnSubmit'=>true,
													'validateOnChange'=>false,
											    ),
												'htmlOptions'=>array(
													'onsubmit'=> 'return signform()',
											        //'onchange' => 'return signform()',
												),
											)); ?>
												<div class="signup-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<?php echo $form->textField($model,'name',array('onkeypress' => 'return IsAlphaNumeric(event)','placeholder'=>'Enter your Name','class'=>'popup-input')); ?>
													<?php echo $form->error($model,'name',array('id'=>'Users_name_em_')); ?>

													<?php echo $form->textField($model,'username',array('onkeypress' => 'return IsAlphaNumeric(event)','placeholder'=>'Enter your Username','class'=>'popup-input')); ?>
													<?php echo $form->error($model,'username',array('id'=>'Users_username_em_')); ?>

													<?php echo $form->textField($model,'email',array('placeholder'=>'Enter your email address','class'=>'popup-input')); ?>
													<?php echo $form->error($model,'email',array('id'=>'Users_email_em_')); ?>

													<?php echo $form->passwordField($model,'password',array('placeholder'=>'Enter your Password','class'=>'popup-input')); ?>
													<?php echo $form->error($model,'password',array('id'=>'Users_password_em_')); ?>

													<?php echo $form->passwordField($model,'confirm_password',array('placeholder'=>'Confirm your Password','class'=>'popup-input')); ?>
													<?php echo $form->error($model,'confirm_password',array('id'=>'Users_confirm_password_em_')); ?>
													
												</div>
												<?php echo CHtml::submitButton(Yii::t('app','Sign Up'),array('class'=>' col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding login-btn')); ?>
												<?php echo $form->hiddenField($model,'facebookId'); ?>
												<?php echo $form->hiddenField($model,'facebookSession'); ?>
												<?php echo $form->hiddenField($model,'fbemail'); ?>
												<?php echo $form->hiddenField($model,'fbfirstName'); ?>
												<?php echo $form->hiddenField($model,'fblastName'); ?>
												<?php echo $form->hiddenField($model,'fbphone'); ?>
												<?php echo $form->hiddenField($model,'fbprofileURL');  ?>
												<?php echo $form->hiddenField($model,'twitterId'); ?>
												<?php echo $form->hiddenField($model,'googleId'); ?>
												<?php 
													if(!empty($imageURL)) {
														echo $form->hiddenField($model,'userImage',array('value'=>$imageURL)); 
													} else {
														echo $form->hiddenField($model,'userImage'); 
													}?>
												<?php $this->endWidget(); ?>
											</div>					
										</div>	
								
														<div class="user-login col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">				
															<span><?php echo Yii::t('app','Already a member?'); ?></span><a class="login-link" href="<?php echo Yii::app()->createAbsoluteUrl("/login"); ?>"><?php echo Yii::t('app','login'); ?></a>
														</div>
						
							</div>
						</div>
					  </div>
					  <!-- end Bottom to top-->
				</div>
			</div>
		</div>


