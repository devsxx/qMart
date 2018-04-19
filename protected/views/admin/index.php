<?php
/* @var $this AdminController */

$this->breadcrumbs=array(
	'Admin',
);
?>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="login-panel panel panel-default">
<?php
//MyClass::showFlash();
?>
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo Yii::t('admin','Please Sign In'); ?></h3>
			</div>
			<div class="panel-body">
<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'adminlogin-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
	    'clientOptions' => array(
	         'validateOnSubmit'=>true,
	         'validateOnChange'=>true,
	     )
)); ?>
					<fieldset>
						<div class="form-group">
							<?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'Username')); ?>
							<?php echo $form->error($model,'username',array('class'=>'login_error')); ?>
						</div>
						<div class="form-group">
							<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'Password')); ?>
							<?php echo $form->error($model,'password',array('class'=>'login_error')); ?>
						</div>
						<!-- <div class="checkbox">
							<label>
								<input name="remember" type="checkbox" value="Remember Me">Remember Me
							</label>
						</div> -->
						 <!-- Change this to a button or input when using this as a form -->
						<?php echo CHtml::submitButton(Yii::t('admin','Log In'),array('class'=>'btn btn-lg btn-success btn-block')); ?> 
					</fieldset>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
