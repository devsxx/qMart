<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Braintree').' '.Yii::t('admin','Payment Gateway'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Braintree').' '.Yii::t('admin','Configuration and Settings'); ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">

						<?php
						/* @var $this SitesettingsController */
						/* @var $model Sitesettings */
						/* @var $form CActiveForm */
						?>

							<div class="form">

							<?php
							$form=$this->beginWidget('CActiveForm', array(
								'id'=>'sitesettings-form',
								// Please note: When you enable ajax validation, make sure the corresponding
								// controller action is handling ajax validation correctly.
								// There is a call to performAjaxValidation() commented in generated controller code.
								// See class documentation of CActiveForm for details on this.
								'enableAjaxValidation'=>true,
								'clientOptions'=>array(
									'validateOnSubmit'=>true,
									'validateOnChange' => false,
									),
							)); ?>

								<p class="note">
								<?php echo Yii::t('admin' , 'Fields with'); ?>
									<span class="required"> * </span>
									<?php echo Yii::t('admin', 'are required.'); ?>
								</p>


								<div class="form-group">
									<?php echo $form->labelEx($model,'brainTreeType'); ?>
									<br>
									<div class="radio radio-custom">
	
										<?php echo $form->radioButtonList($model,'brainTreeType',array('1'=>'Live','2'=>'Sandbox'),array('value' => $model->brainTreeType,'style'=>'display:inline')); ?>
										<?php echo $form->error($model,'brainTreeType'); ?>
									</div>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'brainTreeMerchantId'); ?>
								<?php echo $form->textField($model,'brainTreeMerchantId',array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'brainTreeMerchantId'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'brainTreePublicKey'); ?>
								<?php echo $form->textField($model,'brainTreePublicKey', array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'brainTreePublicKey', array('style'=>'color:red')); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'brainTreePrivateKey'); ?>
								<?php echo $form->textField($model,'brainTreePrivateKey', array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'brainTreePrivateKey'); ?>
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
