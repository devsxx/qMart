<?php
/* @var $this AdminController */

$this->breadcrumbs=array(
	'Admin',
);
?>

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
	<div class=" card-box">
    <div class="panel-heading text-center"> 
    <!-- <h3 class="text-center"> Sign In to </h3> -->
       <?php $logo = Myclass::getLogoDarkVersion();
		echo CHtml::image(Yii::app()->createAbsoluteUrl('media/logo/'.$logo)); ?>
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
			<?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>Yii::t('admin','Email'))); ?>
			<?php echo $form->error($model,'username',array('class'=>'login_error','style' => 'color:red')); ?>
			</div>
			<div class="form-group">
			<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>Yii::t('admin','Password'))); ?>
			<?php echo $form->error($model,'password',array('class'=>'login_error','style' => 'color:red')); ?>
			</div>

			<button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
		</fieldset>
		<?php $this->endWidget(); ?>
    </div>   
    </div>                              
</div>

        <script>
            var resizefunc = [];
        </script>

