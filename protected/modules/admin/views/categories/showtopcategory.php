<?php
/* @var $this CategoriesController */
/* @var $model Category */
/* @var $form CActiveForm */
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Set Top').' '.Yii::t('admin','Category'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<?php
	/* $flashMessages = Yii::app()->user->getFlashes();
	if ($flashMessages) {
		echo '<ul class="flashes">';
		foreach($flashMessages as $key => $message) {
			echo '<div class="flash-' . $key . '">' . $message . "<div class='alert-close pull-right'>X</div></div>";
		}
		echo '</ul>';
	} */
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Add').' '.Yii::t('admin','Priority'); ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">

							<div class="wide form">

							<?php $form=$this->beginWidget('CActiveForm', array(
							'enableAjaxValidation' => true,
                            'htmlOptions'=> array('onsubmit' => 'return showTopCat()'),

							)); ?>
							<?php 
							
							$count =0;
							foreach ($topTen as $topTens){
								if($topTens != 'empty'){
									$count += 1;
								}
							}
							?>
							

								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority1" onchange="changeCategory(1,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[0]) echo "selected"; ?> ">
										<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority1Error"></div>
								</div>
							<?php 
							if($count < 1){
								$disabled = "disabled='disable'";
							}else{
								$disabled = "";
							}?>
								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority2" <?php echo $disabled;?> onchange="changeCategory(2,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[1]) echo "selected"; ?>>
											<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority2Error"></div>
								</div>
								
							<?php 
							if($count < 2){
								$disabled = "disabled='disable'";
							}else{
								$disabled = "";
							}?>
								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority3" <?php echo $disabled;?> onchange="changeCategory(3,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[2]) echo "selected"; ?>>
											<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority3Error"></div>
								</div>
								
							<?php 
							if($count < 3){
								$disabled = "disabled='disable'";
							}else{
								$disabled = "";
							}?>
								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority4" <?php echo $disabled;?> onchange="changeCategory(4,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[3]) echo "selected"; ?>>
											<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority4Error"></div>
								</div>
								
							<?php 
							if($count < 4){
								$disabled = "disabled='disable'";
							}else{
								$disabled = "";
							}?>
								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority5" <?php echo $disabled;?> onchange="changeCategory(5,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[4]) echo "selected"; ?>>
											<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority5Error"></div>
								</div>
								
							<?php 
							if($count < 5){
								$disabled = "disabled='disable'";
							}else{
								$disabled = "";
							}?>
								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority6" <?php echo $disabled;?> onchange="changeCategory(6,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[5]) echo "selected"; ?> ">
										<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority6Error"></div>
								</div>
								
							<?php 
							if($count < 6){
								$disabled = "disabled='disable'";
							}else{
								$disabled = "";
							}?>
								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority7" <?php echo $disabled;?> onchange="changeCategory(7,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[6]) echo "selected"; ?> ">
										<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority7Error"></div>
								</div>
								
							<?php 
							if($count < 7){
								$disabled = "disabled='disable'";
							}else{
								$disabled = "";
							}?>
								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority8" <?php echo $disabled;?> onchange="changeCategory(8,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[7]) echo "selected"; ?> ">
										<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority8Error"></div>
								</div>
								
							<?php 
							if($count < 8){
								$disabled = "disabled='disable'";
							}else{
								$disabled = "";
							}?>
								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority9" <?php echo $disabled;?> onchange="changeCategory(9,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[8]) echo "selected"; ?> ">
										<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority9Error"></div>
								</div>
								
							<?php 
							if($count < 9){
								$disabled = "disabled='disable'";
							}else{
								$disabled = "";
							}?>
								<div class="form-group">
									<select name="Sitesettings[priority][]" class="btn" id="catpriority10" <?php echo $disabled;?> onchange="changeCategory(10,this);">
										<option value="empty"><?php echo Yii::t('admin','Select Category'); ?></option>
										<?php foreach($categories as $category): ?>
										<option value="<?php echo $category->categoryId; ?>"
										<?php if($category->categoryId == $topTen[9]) echo "selected"; ?> ">
										<?php echo $category->name; ?>
										</option>
										<?php endforeach; ?>
									</select>
									<div class="errorMessage" id="priority10Error"></div>
								</div>
								<div class="btn-block">
								<?php echo CHtml::submitButton(Yii::t('admin','Set').' '.Yii::t('admin','Priority'),array('class' => 'btn btn-success')); ?>
								</div>
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

	<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
<script>

	
</script>
