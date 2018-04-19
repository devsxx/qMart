<?php
/* @var $this UserController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
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

<div class="slider container container-1 section_container">
	  <div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			  <!-- Bottom to top-->
			  <div class="row product_align_cnt">
				<div class="modal-dialog modal-dialog-width">
					<div class="login-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
						<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<h2 class="login-header-text"> <?php echo Yii::t('app','Login to'); ?><?php echo Myclass::getSiteName(); ?></h2>
								<p class="login-sub-header-text"><?php echo Yii::t('app','Signup or login to explore the great things available near you'); ?></p>
						</div>
							
							<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
						
								<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
									<div class="login-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php $form=$this->beginWidget('CActiveForm', array(
											'id'=>'login-form',
											'enableAjaxValidation'=>true,
										    'enableClientValidation'=>true,
									     	'clientOptions'=>array(
												'validateOnSubmit'=>true,
												'validateOnChange'=>false,
										    ),
											'htmlOptions' => array(
												'onSubmit' => 'return validsigninfrm()',
											),
										)); ?>
										<div class="login-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php echo $form->textField($model,'username',array('class'=>'popup-input', 'placeholder'=>Yii::t('app','Enter your email address'))); ?>
										<?php echo $form->error($model,'username'); ?>
										

										<?php echo $form->passwordField($model,'password',array('class'=>'popup-input', 'placeholder'=>Yii::t('app','Enter your password'))); ?>
										<?php echo $form->error($model,'password'); ?>
										
										</div>
										<?php echo CHtml::submitButton(Yii::t('app','Login'),array('class'=>'col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding login-btn')); ?>
										<div class="remember-pwd col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<div class="checkbox remember-me-checkbox ">
												  <label><input type="checkbox" name="sport[]" value="" class="cust_checkbox" /><?php echo Yii::t('app','Remember me'); ?></label>
											</div>										
											
											<?php $this->endWidget(); ?>
											<span class="remember-div">l</span>
											<a href="#" data-toggle="modal" data-target="#forgot-password-modal" data-dismiss="modal" class="forgot-pwd"><?php echo Yii::t('app','Forgot Password ?'); ?></a>										
										</div>
									</div>
												
								</div>	


								<?php if($socialLogin['facebook']['status'] == 'enable' || $socialLogin['twitter']['status'] == 'enable'
									|| $socialLogin['google']['status'] == 'enable'){ ?>
										<div class="login-div-line col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="left-div-line"></div>
											<div class="right-div-line"></div>
											<span class="login-or"><?php echo Yii::t('app','or');?></span>									
										</div>
									<div class="social-login col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php if($socialLogin['facebook']['status'] == 'enable'){ ?>
										<div class="facebook-login">
										<a href='<?php echo Yii::app()->createAbsoluteUrl("/user/socialLogin?provider=facebook"); ?>'
											title='Facebook'> <img
											src="<?php echo Yii::app()->createAbsoluteUrl("/images/design/facebook-login.png"); ?>"
										 alt="Facebook">
										</a>
										</div>
										<?php } ?>
										<?php if($socialLogin['twitter']['status'] == 'enable'){ ?>
										<div class="twitter-login">			
										<a
											href='<?php echo Yii::app()->createAbsoluteUrl("/user/socialLogin?provider=twitter"); ?>'
											title='Twitter'> <img
											src="<?php echo Yii::app()->createAbsoluteUrl("/images/design/twitter-login.png"); ?>"
											alt="Twitter">
										</a>
										</div>
										<?php } ?>
										<?php if($socialLogin['google']['status'] == 'enable'){ ?>
										<div class="googleplus-login">
										<a
											href='<?php echo Yii::app()->createAbsoluteUrl("/user/socialLogin?provider=google"); ?>'
											title='Google'> <img
											src="<?php echo Yii::app()->createAbsoluteUrl("/images/design/googleplus-login.png"); ?>"
											alt="Google">
										</a>
										</div>
										<?php } ?>
									</div>

									<?php } ?>								

											<div class="login-line-2 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
												<div class="new-signup col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													
													<span><?php echo Yii::t('app','Not a member yet ?'); ?></span><a class="signup-link" href="<?php echo Yii::app()->createAbsoluteUrl("/signup"); ?>"><?php echo Yii::t('app','click here'); ?></a>
												</div>
			
					</div>
				</div>	
			  </div>
			  <!-- end Bottom to top-->
		</div>
	</div>
</div>

<!-- <div class="before-login-container">
	<div class="form-header"><?php echo Yii::t('app','Login'); ?></div>

	<div class="form before-login-form">
	<!-- <?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableAjaxValidation'=>true,
	    'enableClientValidation'=>true,
     	'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange'=>false,
	    ),
		'htmlOptions' => array(
			'onSubmit' => 'return validsigninfrm()',
		),
	)); ?> 

		<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		</div>

		<div class="row rememberMe">
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		
		<?php echo $form->error($model,'rememberMe'); ?>
		</div>

		<div class="row buttons forgetpassword-form">
		<?php echo CHtml::submitButton(Yii::t('app','Login')); ?>
		<a href='<?php echo Yii::app()->createAbsoluteUrl("/forgotpassword"); ?>'
				title='Forget password'><?php echo Yii::t('app','Forgot Password'); ?>..?</a>
		</div>
		
		<div class="signup-link">
			<a href='<?php echo Yii::app()->createAbsoluteUrl("/signup"); ?>'
				title='Signup'><?php echo Yii::t('app','Not a member yet ? click here..'); ?></a>
		</div>

		<?php $this->endWidget(); ?>
	</div>
	<!-- form 
</div>
<script>
$("#submit").change(function(){
	
});
</script> -->
