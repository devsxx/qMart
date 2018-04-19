<!-- The file upload form used as target for the file upload widget -->
<?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<?php /* ?>
<div class="stuff-upload col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
	<div class="stuff-img files" data-toggle="modal-gallery" data-target="#modal-gallery">							
		
	</div>	


	<span class="fileinput-button stuff-img-add-section">
            <i class="icon-plus icon-white"></i>
            <div class="stuff-img-add">
            	<?php echo $this->t('<img src="'.Yii::app()->createAbsoluteUrl('images/design/add_img.png').'" alt="add img">', $this->multiple); ?>
            </div>
			<?php
			$htmlOptions['accept'] = 'image/*';
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
            ?>
	</span>
	
	<?php if ($this->multiple) { ?>
	<button type="submit" class="btn btn-primary start start-container">
		<i class="icon-upload icon-white"></i>
		<span><?php echo $this->t('Start upload'); ?></span>
	</button>
	<!-- <div class="stuff-img-upload col-xs-5 col-sm-12 col-md-12 col-lg-12 no-hor-padding start-container">
		<button type="button" class="upload-btn start"><?php echo $this->t('Start upload'); ?></button>
	</div>
	<button type="reset" class="btn btn-warning cancel">
		<i class="icon-ban-circle icon-white"></i>
		<span><?php echo $this->t('Cancel upload'); ?></span>
	</button>
	<button type="button" class="btn btn-danger delete">
		<i class="icon-trash icon-white"></i>
		<span><?php echo $this->t(Yii::t('app','Delete')); ?></span>
	</button>
	<input type="checkbox" class="toggle"> -->
        <?php } ?>						
</div>

<div class="row fileupload-buttonbar">
	<div class="span7">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="fileinput-button stuff-img-add-section">
            <i class="icon-plus icon-white"></i>
            <div class="stuff-img-add">
            	<?php echo $this->t('<img src="'.Yii::app()->createAbsoluteUrl('images/design/add_img.png').'" alt="add img">', $this->multiple); ?>
            </div>
			<?php
			$htmlOptions['accept'] = 'image/*';
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
            ?>
		</span>
        <?php if ($this->multiple) { ?>
		<button type="submit" class="btn btn-primary start start-container">
			<i class="icon-upload icon-white"></i>
			<span><?php echo $this->t('Start upload'); ?></span>
		</button>
		<!-- <button type="reset" class="btn btn-warning cancel">
			<i class="icon-ban-circle icon-white"></i>
			<span><?php echo $this->t('Cancel upload'); ?></span>
		</button>
		<button type="button" class="btn btn-danger delete">
			<i class="icon-trash icon-white"></i>
			<span><?php echo $this->t(Yii::t('app','Delete')); ?></span>
		</button>
		<input type="checkbox" class="toggle"> -->
        <?php } ?>
	</div>
	<div class="span5" style="display: none;">
		<!-- The global progress bar -->
		<div class="progress progress-success progress-striped active fade">
			<div class="bar" style="width:0%;"></div>
		</div>
	</div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<!-- <br> -->
<!-- The table listing the files available for upload/download -->
<table class="table table-striped">
	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
</table>

<?php */ ?>	
<div class="row fileupload-buttonbar">
	<div class="span7">
	<div class="stuff-img files" data-toggle="modal-gallery" data-target="#modal-gallery">							
		
	</div>	
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="fileinput-button stuff-img-add-section">
            <i class="icon-plus icon-white"></i>
            <div class="stuff-img-add">
            	<?php echo $this->t('<img src="'.Yii::app()->createAbsoluteUrl('images/design/add_img.png').'" alt="add img">', $this->multiple); ?>
            </div>
			<?php
			$htmlOptions['accept'] = 'image/*';
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
            ?>
		</span>
        <?php if ($this->multiple) { ?>
        <div class="stuff-img-upload col-xs-5 col-sm-12 col-md-12 col-lg-12 no-hor-padding start-container">
		<button type="submit" class="btn upload-btn  start start-container">
			<i class="icon-upload icon-white"></i>
			<span><?php echo $this->t('Upload'); ?></span>
		</button>
		<!-- <button type="reset" class="btn btn-warning cancel">
			<i class="icon-ban-circle icon-white"></i>
			<span><?php echo $this->t('Cancel upload'); ?></span>
		</button>
		<button type="button" class="btn btn-danger delete">
			<i class="icon-trash icon-white"></i>
			<span><?php echo $this->t(Yii::t('app','Delete')); ?></span>
		</button>
		<input type="checkbox" class="toggle"> -->
		</div>
        <?php } ?>
	</div>
	<div class="span5" style="display: none;">
		<!-- The global progress bar -->
		<div class="progress progress-success progress-striped active fade">
			<div class="bar" style="width:0%;"></div>
		</div>
	</div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<!-- <br> -->

<?php if ($this->showForm) echo CHtml::endForm();?>
