<?php
/* @var $this ItemController */
/* @var $model Products */
/* @var $form CActiveForm */
?>

<div class="form">
	<p class="note">
	<?php echo Yii::t('admin' , 'Fields with'); ?>
		<span class="required"> * </span>
		<?php echo Yii::t('admin', 'are required.'); ?>
	</p>
	<?php if(!$model->isNewRecord) { ?>
	
	<div class="row">	
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4" style="width: auto; padding: 0px; float: right;">						
			<div class="edit-btn">	
			<?php if($model->soldItem == 1){ ?>				
				<a href="#" data-loading-text="Posting..." id="load" data-toggle="modal" 
					class="sold-btn sale-btn" onclick="soldItemAdmin('<?php echo Myclass::safe_b64encode($model->productId.'-0') ?>', '0')">
					<?php echo Yii::t('app','Back to sale'); ?>
				</a>
			<?php }else{ ?>
				<a href="#" data-loading-text="Posting..." id="load" data-toggle="modal" 
					class="sold-btn" onclick="soldItemAdmin('<?php echo Myclass::safe_b64encode($model->productId.'-0') ?>', '1')">
					<?php echo Yii::t('app','Mark as sold'); ?>
				</a>
			<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'products-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
'htmlOptions' => array('onsubmit'=> 'return validateProduct()'),

	)); ?>



	<?php // echo $form->errorSummary($model); ?>


	<?php
	/* $this->widget('CMultiFileUpload', array(
	 'name' => 'images',
	 'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
	 'duplicate' => 'Already a file with this name added!', // useful, i think
	 'denied' => 'Invalid file type', // useful, i think
	 'max'=>10, // max 10 files
		)); */ ?>
	<?php
	$this->widget( 'xupload.XUpload', array(
                'url' => Yii::app( )->createUrl( "/admin/item/upload"),
	//our XUploadForm
                'model' => $photos,
	//We set this for the widget to be able to target our own form
                'htmlOptions' => array('id'=>'products-form','class' => 'form-control'),
                'attribute' => 'file',
                'multiple' => true,
            	'showForm' => false,
				'options' => array(
					'maxFileSize' => 2097152, //2MB in bytes
					'acceptFileTypes' => "js:/(\.|\/)(jpe?g|png)$/i",
					'completed' => "js:function (e, data) {
						productImage++;
						$('#image_error').text('');
						console.log('Uploaded Image: '+productImage);
					}",
					'destroyed' => "js:function (e, data) {
						productImage--;
						if (productImage == 0)
						$('#image_error').text(Yii.t('admin','Upload atleast a single product image'));
						console.log('Uploaded Image: '+productImage);
					}",
					'added' => "js:function (e, data) {					
						addImage++;
						if(addImage == addImageError)
							$('.start-container').fadeOut('fast');
						else if(addImage > 0)
							$('.start-container').fadeIn();
						console.log('added Image: '+addImage);
						console.log('added Image Error: '+addImageError);
					}",
					'started' => "js:function (e, data) {
						addImage = 0;
						if(addImage <= 0)
						$('.start-container').fadeOut('fast');
						console.log('Started upload');
					}",
					'failed' => "js:function (e, data) {
						addImage = addImage > 0 ? --addImage : 0;
						if(addImage == addImageError)
							$('.start-container').fadeOut('fast');
						else if(addImage <= 0)
							$('.start-container').fadeOut('fast');
						console.log('Stopped upload: '+addImage);
					}",
	),
	//Note that we are using a custom view for our widget
	//Thats becase the default widget includes the 'form'
	//which we don't want here
	//'formView' => 'application.views.products._form',
	)
	);
	?>
	<div id="image_error" class="errorMessage" style="display: none;"></div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>70,'class'=>'form-control')); ?>
	<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'description'); ?>
	<?php echo $form->textArea($model,'description',array('class' => 'form-control','rows'=>'10')); ?>

	<?php echo $form->error($model,'description'); ?>
	</div>


	<div class="form-group">
	<?php echo $form->labelEx($model,'category'); ?>
	<?php //echo $form->textField($model,'category'); ?>
	<?php if (!empty($parentCategory)){
		echo $form->dropDownList($model,'category',$parentCategory,array(
						'prompt'=>Yii::t('admin','Select Category'),
						'ajax'=>array(
								'type'=>'POST',
								'url'=>CController::createUrl('item/getsubcategory'),
								'update'=>'.subcatid',
		                        'data'=>array('category'=>'js:this.value'),
		),
		 'class' => 'form-control',
		));
		//echo $form->dropDownList($model, 'category', $parentCategory, array('prompt'=>'Select Parent category'));
	}else{
		echo $form->dropDownList($model, 'category', array('prompt'=>'Select Parent category','class' => 'form-control'));
	}
	?>
	<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="form-group">
	<?php echo $form->labelEx($model,'subCategory'); ?>
	<?php //echo $form->textField($model,'subCategory'); ?>
	<?php if (!empty($subCategory)){
		echo $form->dropDownList($model, 'subCategory', $subCategory, array('prompt'=>Yii::t('admin','Select subcategory'),'class'=>'subcatid form-control'));
	}else{
		echo $form->dropDownList($model, 'subCategory', $subCategory, array('prompt'=>Yii::t('admin','Select subcategory'),'class'=>'subcatid form-control'));
	}
	?>
	<?php echo $form->error($model,'subCategory'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'price', array('style'=>'width: 100%;')); ?>
		<?php echo $form->textField($model,'price',array('class' => 'form-control','onkeypress'=>'return isNumber(event)',
					'style'=>'margin:0; height:34px; display: inline-block; float: left;width: 70%;','maxlength'=>"9")); ?>
		<div class="currency-select-box-row col-xs-12 col-sm-2 col-md-3 col-lg-2 no-hor-padding" style="display: inline-block;width: 30%;">	
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">		
			<?php $currencyList = Myclass::getCurrencyData();$hideCurrencyFlag = 0; ?>									 
			  <select class="form-control select-box-down-arrow" id="sel1" name="Products[currency]">		
			  <?php foreach ($currencyList as $currency){ 
			  	echo "<option value='$currency->currency_symbol-$currency->currency_shortcode'>$currency->currency_shortcode</option>";
			  }?>
			  </select>
			</div>
		</div>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="dynamicProperty col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>

	<div class="form-group">
	<?php echo $form->labelEx($model,Yii::t('admin','Where the item is located?')); ?>
		<input id="Products_location" class="form-control" type="text"
			placeholder="<?php echo Yii::t('admin','Tell where you sell the item'); ?>"
			name="Products[location]" onchange="return resetLatLong()"
			value="<?php echo $model->location; ?>"> <input id="latitude"
			type="hidden" name="Products[latitude]"
			value="<?php echo $model->latitude;?>"> <input id="longitude"
			type="hidden" name="Products[longitude]"
			value="<?php echo $model->longitude;?>">
		<p>
		<?php echo Yii::t('admin',"Note: Select Location Only from Dropdown.Please don't enter manually."); ?>
		</p>
		<div class="errorMessage" id="Products_location_em_"></div>
	</div>


	<div class="form-group">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin','Create') : Yii::t('admin','Save'),array('class' => 'btn btn-success btnUpdate')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
	<?php $id = Myclass::safe_b64encode($model->productId.'-0'); ?>
<script>
var shippingArray = new Array();
<?php if (isset($jsShippingDetails) && $jsShippingDetails != ''){ ?>
shippingArray = [<?php echo $jsShippingDetails; ?>];
<?php } ?>
<?php if (!$model->isNewRecord){ ?>
$(document).ready(function(){
	productId = "<?php echo $model->productId; ?>";
	$.getJSON('<?php echo $this->createUrl("upload", array("_method" => "list", "id" => $model->productId)); ?>', function (result) {
	    var objForm = $('#products-form');
	    if (result && result.length) {
	        objForm.fileupload('option', 'done').call(objForm, null, {result: result});
	        productImage = parseInt(result.length);
	        console.log("In product append: "+productImage);
	    }
	});
	var selectedCategory = $('#Products_category').val();
	console.log('Products_category on change call');
	$.ajax({
		url: yii.urls.base + '/products/productproperty/',
		type: "post",
		data: {'selectedCategory':selectedCategory, 'productId': productId},
		dataType: "html",
		success: function(responce){
			responce = responce.trim();
			var result = jQuery.parseJSON(responce);
			//console.log("Responce string: "+responce);
			if(result[1] == ""){
				$('.dynamicProperty').html("");
				$('.dynamic-section').hide();
			}else{
				$('.dynamicProperty').html(result[1]);
				$('.dynamic-section').show();
			}
		}
	});
});
<?php } ?>

$("#showMore").hide();
function changeCurDiv(cur,code) {
  $("#cur").html(cur+' <span class="caret"></span>');
  $("#showMore").hide();
  $("#currency").val(cur+'-'+code);
}
function showMore() {
	$("#showMore").show();
}
function soldItemAdmin(id, value) {
	/*var value = 0;
	if ($('#soldOut').is(':checked')) {
		value = 1;
	}*/
	$.ajax({
		type : 'POST',
		url  : '<?php echo Yii::app()->createAbsoluteUrl('/admin/item/soldItem'); ?>',
		data : {
			id : id,
			value : value
		},
		success : function(data) {
			var appendText = '';
			if(value == 0){
				appendText = '<a href="javascript: void(0);" data-loading-text="Posting..." id="load" data-toggle="modal" '
								+'class="sold-btn" onclick="soldItemAdmin(\''+id+'\', \'1\')">'
								+Yii.t('app','Mark as sold')+'</a>';
			}else{
				appendText = '<a href="javascript: void(0);" data-loading-text="Posting..." id="load" data-toggle="modal" '
								+'class="sold-btn sale-btn" onclick="soldItemAdmin(\''+id+'\', \'0\')">'
								+Yii.t('app','Back to sale')+'</a>';
			}
			$('.edit-btn').html(appendText);
			console.log('success');
		}
	});
}
function initialize() {
	autocomplete = new google.maps.places.Autocomplete((document
			.getElementById('Products_location')), {
		types : [ 'geocode' ]
	});
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		fillInAddress();
	});
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>