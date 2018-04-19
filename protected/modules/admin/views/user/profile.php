<?php
/* @var $this UserController */
/* @var $model Users */
/* @var $form CActiveForm */
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
			<?php echo Yii::t('admin','Admin').' '.Yii::t('admin','Profile'); ?>
			</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
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
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php echo Yii::t('admin','Edit').' '.Yii::t('admin','Profile'); ?>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">



							<div class="form">

							<?php $form=$this->beginWidget('CActiveForm', array(
	                        'id'=>'users-form',
							// Please note: When you enable ajax validation, make sure the corresponding
							// controller action is handling ajax validation correctly.
							// There is a call to performAjaxValidation() commented in generated controller code.
							// See class documentation of CActiveForm for details on this.
                         	'enableAjaxValidation'=>true,
							'htmlOptions' => array('onsubmit' => 'return validateProfile()')
							)); ?>

								<p class="note">
								<?php echo Yii::t('admin' , 'Fields with'); ?>
									<span class="required"> * </span>
									<?php echo Yii::t('admin', 'are required.'); ?>
								</p>


								<div class="form-group">
								<?php echo $form->labelEx($model,'name'); ?>
								<?php echo $form->textField($model,'name',array('class' => 'form-control','onkeypress'=>'return IsAlphaNumeric(event)')); ?>
								<?php echo $form->error($model,'name'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'email'); ?>
								<?php echo $form->textField($model,'email',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'email'); ?>
								</div>

								<div class="form-group">
								<?php echo $form->labelEx($model,'password'); ?>
								<?php echo $form->passwordField($model,'password',array('class' => 'form-control')); ?>
								<?php echo $form->error($model,'password'); ?>
								</div>
								<div class="form-group">
								<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Create') : Yii::t('admin','Save'),array('class' => 'btn btn-success')); ?>
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
