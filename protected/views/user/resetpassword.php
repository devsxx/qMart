<?php
/* @var $this UserController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Reset Password';
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
										<h2 class="login-header-text">Reset password</h2>
										<p class="login-sub-header-text">Enter your email address and we'll send you a link to reset your password.</p>
								</div>
									
									<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
								
										<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
											<div class="login-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<div class="login-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'resetpassword-form',
		//'enableAjaxValidation'=>true,
		'htmlOptions'=>array(
			'onsubmit'=>'return validreset()',
	),
	)); ?>

		<div class="form-group">
		<?php echo $form->labelEx($model,'resetpassword'); ?>
		<?php echo $form->passwordField($model,'resetpassword',array('class' => 'form-control','placeholder'=>'New Password')); ?>
		<div class="errorMessage" id="resetpassword_em_" style="display:none"></div>
		</div>
		<div class="form-group">
		<?php echo $form->labelEx($model,'confirmpassword'); ?>
		<?php echo $form->passwordField($model,'confirmpassword',array('class' => 'form-control','placeholder'=>'Confirm Password')); ?>
		<div class="errorMessage" id="confirmpassword_em_" style="display:none"></div>
		</div>
		<input type="hidden" value="<?php echo $model->userId; ?>" name="Resetpassword[user]"/>
		<div class="">
		<?php echo CHtml::submitButton(Yii::t('app','Reset Password'),array('class'=>'col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding login-btn')); ?>
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



