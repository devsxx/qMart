<?php
/* @var $this SitesettingsController */
/* @var $model Sitesettings */
/* @var $form CActiveForm */
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Default').' '.Yii::t('admin','Settings'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Default').' '.Yii::t('admin','Settings'); ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">

							<div class="form">
							<?php $form=$this->beginWidget('CActiveForm', array(
	                               'id'=>'sitesettings-form',
							// Please note: When you enable ajax validation, make sure the corresponding
							// controller action is handling ajax validation correctly.
							// There is a call to performAjaxValidation() commented in generated controller code.
							// See class documentation of CActiveForm for details on this.
	                              'enableAjaxValidation'=>true,
							      'htmlOptions' =>array('enctype' => 'multipart/form-data','onsubmit' => 'return defaultSettings()'),
							)); ?>


								<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

							<?php //echo $form->errorSummary($model); ?>
								<div class="form-group">
								<?php echo $form->labelEx($model,'sitename'); ?>
								<?php echo $form->textField($model,'sitename',array('class'=>'form-control','onkeypress'=>'return IsAlphaNumeric(event)')); ?>
								<?php echo $form->error($model,'sitename'); ?>
								</div>
								
								<div class="form-group">
								<?php echo $form->labelEx($model,'metaTitle'); ?>
								<?php echo $form->textField($model,'metaTitle',array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'metaTitle'); ?>
								</div>
								
								<div class="form-group">
								<?php echo $form->labelEx($model,'metaDescription'); ?>
								<?php echo $form->textField($model,'metaDescription',array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'metaDescription'); ?>
								</div>
								
								<div class="form-group">
								<?php echo $form->labelEx($model,'metaKeywords'); ?>
								<?php echo $form->textField($model,'metaKeywords',array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'metaKeywords'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'googleApiKey'); ?>
								<?php echo $form->textField($model,'googleapikey',array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'googleapikey'); ?>
								</div>								

								<div class="form-group">
								<?php echo $form->labelEx($model,'logo'); ?>
								<?php echo $form->fileField($model,'logo', array (
								'class' => 'filestyle',
								'data-input' => 'false',
								'tabindex' => '-1',
								)); ?>
								<br>
								<?php if(!empty($model->logo)){
									echo CHtml::image(Yii::app()->createAbsoluteUrl('media/logo/'.$model->logo),'Logo',array('height' => 40,'width' => '124'));
								} ?>
								<?php echo $form->error($model,'logo'); ?>
								</div>
								
								<div class="form-group">
								<?php echo $form->labelEx($model,'logoDarkVersion'); ?>
								<?php echo $form->fileField($model,'logoDarkVersion', array (
								'class' => 'filestyle',
								'data-input' => 'false',
								'tabindex' => '-1',
								)); ?><br>
								<?php if(!empty($model->logoDarkVersion)){
									echo CHtml::image(Yii::app()->createAbsoluteUrl('media/logo/'.$model->logoDarkVersion),'logoDarkVersion',array('height' => 40,'width' => '124'));
								} ?>
								<?php echo $form->error($model,'logoDarkVersion'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'default_userimage'); ?>
								<?php echo $form->fileField($model,'default_userimage', array (
								'class' => 'filestyle',
								'data-input' => 'false',
								'tabindex' => '-1',
								)); ?>
								<br>
								<?php if(!empty($model->default_userimage)){
									echo CHtml::image(Yii::app()->createAbsoluteUrl('media/user/default/'.$model->default_userimage),'Default User Image',array('height' => 75,'width' => '75'));
								} ?>
								<?php echo $form->error($model,'default_userimage'); ?>
								</div>
								
								<!--div class="form-group">
								<?php echo $form->labelEx($model,'searchDistance'); ?>
								<?php echo $form->textField($model,'searchDistance',array('class'=>'form-control','onkeypress'=>'return isNumber(event)')); ?>
								<?php echo $form->error($model,'searchDistance'); ?>
								</div-->
								
								<div class="form-group">
								<?php echo $form->labelEx($model,'searchList (Enter values separated by commas Eg: 5,4,3)'); ?>
								<?php echo $form->textField($model,'searchList',array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'searchList'); ?>
								</div>
								
								<div class="form-group">
								<?php echo $form->labelEx($model,'searchType'); ?>
									<select name="Sitesettings[searchType]" class="btn" id="searchType">
										
										<?php
										if($model->searchType=="miles")
										{
											echo '<option value="empty">'.Yii::t("admin","Select type").'</option>
										<option value="miles" selected>'.Yii::t("admin","Miles").'</option>
										<option value="kilometer">'.Yii::t("admin","Kilometer").'</option>';
										}
										else if($model->searchType=="kilometer")
										{
											echo '<option value="empty">'.Yii::t("admin","Select type").'</option>
										<option value="miles">'.Yii::t("admin","Miles").'</option>
										<option value="kilometer" selected>'.Yii::t("admin","Kilometer").'</option>';
										}
										else
										{
											echo '<option value="empty" selected>'.Yii::t("admin","Select type").'</option>
										<option value="miles">'.Yii::t("admin","Miles").'</option>
										<option value="kilometer">'.Yii::t("admin","Kilometer").'</option>';
										}
		
										?>
										
										
									</select>
									<div class="errorMessage searchListerror hidden" id="searchListerror"></div>
								</div>


								<div class="form-group">
								<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Save') : Yii::t('admin','Save'),array('class' => 'btn btn-success')); ?>
								</div>

								<?php $this->endWidget(); ?>

							</div>
							<!-- form -->
						</div>
					</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->
