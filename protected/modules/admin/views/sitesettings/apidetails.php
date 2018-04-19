<?php
/* @var $this SitesettingsController */
/* @var $model Sitesettings */
/* @var $form CActiveForm */
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Site Settings'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo Yii::t('admin','API Settings'); ?> 
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-7">
	                         <div class="form">
							<?php $form=$this->beginWidget('CActiveForm', array(
								'id'=>'sitesettings-form',
								// Please note: When you enable ajax validation, make sure the corresponding
								// controller action is handling ajax validation correctly.
								// There is a call to performAjaxValidation() commented in generated controller code.
								// See class documentation of CActiveForm for details on this.
								'enableAjaxValidation'=>true,
							)); ?>

								<div class="form-group">
								<?php echo $form->labelEx($model,'apiUsername'); ?>
								<?php echo $form->textField($model,'apiUsername',array('class' => 'form-control','onkeypress'=>'return IsAlphaNumeric(event)')); ?>
								<?php echo $form->error($model,'apiUsername'); ?>
								</div>
							
								<div class="form-group">
								<?php echo $form->labelEx($model,'apiPassword'); ?>
									<br>
									<div class="password-input">
									<?php echo $form->passwordField($model,'apiPassword',array('class'=>'form-control pull-left','style'=>'width:298px')); ?>
									<input type="text" class="form-control" id="show_apipassword" value="<?php echo $model->apiPassword; ?>" style="width:298px;display:none;float:left;">
									<a href="javascript:void(0);" class="" onclick="return showapipassword();" style="position: relative; top: 6px; padding: 10px 6px;">
										<i class="show-button fa fa-eye fa-fw"></i>
									</a>
									<?php echo CHtml::Button(Yii::t('admin','Generate Password'),array('onclick'=>"generateapipassword()",'style'=>'display:inline;','class'=>'btn btn-primary  pull-right')); ?>
									<div class="credentials-action">
									<?php if ($makeDefault == 0) {
										echo "<a href='".Yii::app()->createAbsoluteUrl('admin/sitesettings/restorapikey')."' 
											class='btn btn-success' style='margin-top: 10px;'>".Yii::t('admin','Restore Default')."</a>";
									}?>
									</div>
									</div>
									<?php echo $form->error($model,'apiPassword'); ?>
								</div>
							
								<div class="form-group">
								<?php echo CHtml::submitButton($makeDefault == 1 ? Yii::t('admin','Save & Make default') : 
										Yii::t('admin','Save as new'), array('style'=>"height:34px;",'class' => 'btn btn-success')); ?>
								</div>
							
								<?php $this->endWidget(); ?>
							
							</div>
							<!-- form -->
						</div>
					</div><!-- /.row (nested) -->
				</div><!-- /.panel-body -->
			</div><!-- /.panel -->
		</div><!-- /.col-lg-12 -->
	</div><!-- /.row -->
</div><!-- /#page-wrapper -->

<style>
.password-input input {
	height: 34px;
}
</style>
