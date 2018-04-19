<?php
/* @var $this UserController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Forgot Password';
/* $this->breadcrumbs=array(
 'Login',
 ); */
?>

<?php
/* $flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
	echo '<ul class="flashes">';
	foreach($flashMessages as $key => $message) {
		echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
	}
	echo '</ul>';
} */
?>



	<!---------------------------------------------------- Forgot password  -------------------------------------------------------->
		<div class="slider container container-1 section_container">
			  <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					  <!-- Bottom to top-->
					  <div class="row product_align_cnt forgot-password-min">
						<div class="modal-dialog modal-dialog-width">
							<div class="login-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
								<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<h2 class="login-header-text">Forgot password</h2>
										<p class="login-sub-header-text">Enter your email address and we'll send you a link to reset your password.</p>
								</div>
									
									<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
								
										<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
											<div class="login-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<div class="login-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'forgetpassword-form',
		'enableAjaxValidation'=>true,
		'clientOptions'=>array(
												'validateOnSubmit'=>true,
												'validateOnChange'=>false,
										    ),
		'htmlOptions'=>array(
			'onsubmit'=>'return validforgot()',
	),
	)); ?>

		<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('class' => 'form-control forgetpasswords','placeholder'=>'Enter your email address')); ?>
		<?php echo $form->error($model,'emails'); ?>
		</div>

		<div class="">
		<?php echo CHtml::submitButton(Yii::t('app','Reset Password'),array('class'=>'col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding login-btn')); ?>
			<!--a href='<?php echo Yii::app()->createAbsoluteUrl("/user/login"); ?>'
				title='Back to Signin'><?php echo Yii::t('app','Back');?>...!</a-->
		</div>
		<?php $this->endWidget(); ?>																							
												</div>
											</div>
													
										</div>	
										
					
							</div>
						</div>	
					  </div>
					  <!-- end Bottom to top-->
				</div>
			</div>
		</div>
	
	<!---------------------------------------------------- E O Forgot password  -------------------------------------------------------->





