<?php
/* @var $this ProductsController */
/* @var $model Products */
/* @var $form CActiveForm */
$trans = new JsTrans('admin',Yii::app()->language);
?>

<div class="form product-form-container">
	<div id="page-container" class="product-new-update">
	
		<div class="container">
		
			<div class="row">		
				<div class="qMart-breadcrumb add-product col-xs-12 col-sm-12 col-md-12 col-lg-12">
					 <ol class="breadcrumb">
						<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"><?php echo Yii::t('app','Home'); ?></a></li>
						<li><a href="#"><?php echo Yii::t('app','Sell your stuff'); ?></a></li>					 
					 </ol>			
				</div>
				
			</div>	
		<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'products-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange' => false,
			),
	    'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
			)); ?>
		
			<div class="row">
				<div class="full-horizontal-line col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>	
			</div>	
			
			<?php if(!$model->isNewRecord) { ?>
				<div class="row">				
					<div class="add-product-heading col-xs-12 col-sm-12 col-md-12 col-lg-8">
						<h2 class="top-heading-text"><?php echo Yii::t('app','Post your list free'); ?></h2>
						<p class="top-heading-sub-text">
							<?php echo Yii::t('app','Provide more information about your item and upload good quality photos'); ?>
						</p>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">						
						<div class="edit-btn">	
						<?php if($model->soldItem == 1){ ?>				
							<a href="#" data-loading-text="Posting..." id="load" data-toggle="modal" 
								class="sold-btn sale-btn" onclick="soldItems('<?php echo Myclass::safe_b64encode($model->productId.'-0') ?>', '0')">
								<?php echo Yii::t('app','Back to sale'); ?>
							</a>
						<?php }else if($model->soldItem != 1 && $model->quantity != 0){ ?>
							<a href="#" data-loading-text="Posting..." id="load" data-toggle="modal" 
								class="sold-btn" onclick="soldItems('<?php echo Myclass::safe_b64encode($model->productId.'-0') ?>', '1')">
								<?php echo Yii::t('app','Mark as sold'); ?>
							</a>
						<?php } ?>
							<a data-target="#" data-toggle="modal" href="#" class="delete-btn" 
								onclick="confirmModal('method', 'deleteItem', '<?php echo Myclass::safe_b64encode($model->productId.'-0') ?>')">
									<?php echo Yii::t('app','Delete Sale'); ?>
							</a>
						</div>
					</div>
				</div>
			<?php }else{ ?>
			<div class="row">				
					<div class="add-product-heading col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h2 class="top-heading-text"><?php echo Yii::t('app','Post your list free'); ?></h2>
						<p class="top-heading-sub-text">
							<?php echo Yii::t('app','Provide more information about your item and upload good quality photos'); ?>
						</p>
					</div>
			</div>	
			<?php } ?>
			
				
			<div class="row">
				<div class="add-product col-xs-12 col-sm-12 col-md-12 col-lg-12">					
							<div class="add-photos col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="add-photos-heading">
									<span><?php echo Yii::t('app','Add photos of your stuff'); ?></span>
								</div>
								
								<?php $form=$this->beginWidget('CActiveForm', array(
								'id'=>'products-image-form',
									// Please note: When you enable ajax validation, make sure the corresponding
									// controller action is handling ajax validation correctly.
									// There is a call to performAjaxValidation() commented in generated controller code.
									// See class documentation of CActiveForm for details on this.
								'enableAjaxValidation'=>true,
								'clientOptions'=>array(
									'validateOnSubmit'=>true,
									'validateOnChange' => false,
									),
							    'htmlOptions' => array('enctype' => 'multipart/form-data','onsubmit'=>'return validateProduct()'), // ADD THIS
									)); ?>
									<div class="form-group group-form-container">
									<?php
									$this->widget( 'xupload.XUpload', array(
							                'url' => Yii::app( )->createUrl( "/item/products/upload"),
									//our XUploadForm
							                'model' => $photos,
									//We set this for the widget to be able to target our own form
							                'htmlOptions' => array('id'=>'products-form'),
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
							
							</div>						
					</div>
						
						
					<div class="add-stuff-Category-section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
						
							<div class="add-stuff-Category-heading">
								<span><?php echo Yii::t('app','What is your listing based on'); ?>?</span>
							</div>
						
					
						
							<div class="Category-select-box-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
								<div class="form-group col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding">
									<?php echo $form->labelEx($model,'category',array('class'=>'Category-select-box-heading')); ?>
									<?php //echo $form->textField($model,'category'); ?>
									<?php if (!empty($parentCategory)){
										/* echo $form->dropDownList($model,'category',$parentCategory,array(
													'prompt'=>Yii::t('admin','Select Category'),
										            'class' => 'form-control select-box-down-arrow',
													'ajax'=>array(
															'type'=>'POST',
															'url'=>CController::createUrl('products/getsubcategory'),
															'update'=>'.subcatid',
									                        'data'=>array('category'=>'js:this.value'),
													),
												)); */
										echo $form->dropDownList($model, 'category', $parentCategory, array('prompt'=>Yii::t('admin','Select Category'), 'class' => 'form-control select-box-down-arrow'));
									}else{
										echo $form->dropDownList($model, 'category', array('prompt'=>Yii::t('admin','Select Parent category'), 'class' => 'form-control select-box-down-arrow'));
									}
									?>
									<?php echo $form->error($model,'category'); ?>
								</div>	
							</div>
							<div class="Category-select-box-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="form-group col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding">
									<?php echo $form->labelEx($model,'subCategory',array('class'=>'Category-select-box-heading')); ?>
									<?php //echo $form->textField($model,'subCategory'); ?>
									<?php if (!empty($subCategory)){
										echo $form->dropDownList($model, 'subCategory', $subCategory, array('prompt'=>Yii::t('admin','Select subcategory'),'class'=>'subcatid form-control select-box-down-arrow'));
									}else{
										echo $form->dropDownList($model, 'subCategory', $subCategory, array('prompt'=>Yii::t('admin','Select subcategory'),'class'=>'subcatid form-control select-box-down-arrow'));
									}
									?>
									<?php echo $form->error($model,'subCategory'); ?>
								</div>	
							</div>
							<div class="Category-input-box-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">		
								<?php echo $form->labelEx($model,'name',array('class'=>'Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding')); ?>
								<?php echo $form->textField($model,'name',array('class' => 'col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding', 
										'placeholder' => "Stuff title")); ?>
								<?php echo $form->error($model,'name'); ?>							
							</div>
							
							<div class="Category-input-box-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<?php echo $form->labelEx($model,'description', array('class' => 'Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding')); ?>
								<?php echo $form->textArea($model,'description',array('class' => 'Category-textarea col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding','rows'=>'4')); ?>
					
								<?php echo $form->error($model,'description'); ?>									
							</div>
							</br>
							<div class="Category-price-box-row col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding">		
								<div class="Category-input-box-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">		
									<?php echo $form->labelEx($model,'price', array('class'=>'Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding')); ?>
									<?php echo $form->textField($model,'price',array('class' => 'col-xs-12 col-sm-10 col-md-9 col-lg-10 no-hor-padding', 'placeholder'=>'Stuff price', 'maxlength'=>"9")); ?>
									<div class="currency-select-box-row col-xs-12 col-sm-2 col-md-3 col-lg-2 no-hor-padding">	
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
							</div>	
							
					</div>					
						<div class="add-stuff-Category-section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding dynamic-section" style="display: none;">						
							<div class="add-stuff-Category-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<span><?php echo Yii::t('app','What is your expectation and other details'); ?>?</span>
							</div>							
																
							<div class="dynamicProperty"></div>
							
						</div>
						<?php 
						$sitesetting = Myclass::getSitesettings();
						$paymentmode = json_decode($sitesetting->sitepaymentmodes,true);
						if($paymentmode['buynowPaymentMode'] == 1)
						{
							if(!$model->isNewRecord){
								$instantBuyDetails = "";
								if($model->instantBuy == 1){
									$instantBuyDetails = "style='display:block;'";
								}
							}else{
								$userId = Yii::app()->user->id;
								$model->paypalid = Myclass::getLastProductPaypalId($userId);
							}
						?>
						<div class="add-stuff-Category-section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding instant-buy-details" <?php echo $instantBuyDetails; ?>>						
							<div class="add-stuff-Category-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<span><?php echo Yii::t('app','Instant buy details'); ?></span>
							</div>	
							
								<div class="Category-input-box-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">									
									<?php echo $form->labelEx($model,'paypalid', array('class'=>'Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding')); ?>
									<?php echo $form->textField($model,'paypalid',array('class' => 'col-xs-12 col-sm-10 col-md-9 col-lg-10 no-hor-padding', 'placeholder'=> Yii::t('app','Paypal Id'))); ?>
									<span class="label-note col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Note: This will be your default payment processing account'); ?>.</span>									
									<?php echo $form->error($model,'paypalid'); ?>	
								</div>
								<?php
								if($paymentmode['buynowPaymentMode'] == 1) {
								?>
								<div class="Category-input-box-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">									
									<?php echo $form->labelEx($model,'shippingCost', array('class'=>'Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding')); ?>
									<?php echo $form->textField($model,'shippingCost',array('class' => 'col-xs-12 col-sm-10 col-md-9 col-lg-10 no-hor-padding', 'placeholder'=> Yii::t('app','Shipping Cost'))); ?>
									<?php echo $form->error($model,'shippingCost'); ?>
								</div>		
								<?php } ?>						
						</div>
						<?php } ?>
						
						<div class="add-stuff-Category-section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">						
							<div class="add-stuff-Category-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<span><?php echo Yii::t('admin','Where the item is located?'); ?></span>
							</div>							
										
							<?php 
								if($model->isNewRecord){
									$model->location = $geoLocationDetails['place'];
									$model->latitude = $geoLocationDetails['latitude'];
									$model->longitude = $geoLocationDetails['longitude'];
								}
							?>
																
							<div class="Category-input-box-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding location-container">									
								<label class="Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Listing’s location'); ?><span class="required">*</span></label>
								<input id="Products_location" type="text" name="Products[location]" value="<?php echo $model->location; ?>"
								placeholder="<?php echo Yii::t('admin','Tell where you sell the item'); ?>"  onchange="return resetLatLong()"
								class="col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding">	
								<input id="latitude" type="hidden" name="Products[latitude]" value="<?php echo $model->latitude; ?>"> 
								<input id="longitude" type="hidden" name="Products[longitude]" value="<?php echo $model->longitude; ?>">
								<?php
								if($paymentmode['buynowPaymentMode'] == 1) {
								?>
								<input id="shippingcountry" type="hidden" name="Products[shippingcountry]" value="<?php echo $model->shippingcountry; ?>">
								<?php } ?>
								</br>
								<span class="label-note col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo Yii::t('admin',"Note: Select the item location from the dropdown. Avoid entering the location manually."); ?>
								</span>
								<div class="errorMessage col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="Products_location_em_"></div>									  
							</div>
							<?php $logUserdetail = Myclass::getcurrentUserdetail(); 
							//if(!empty($logUserdetail->facebookId)) {
							/*
							?>
							<div class="switch-box col-xs-6 col-sm-3 col-md-2 col-lg-2 no-hor-padding" style="width:50%; margin-top:20px;">						
								<div class="add-stuff-Category-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<span><?php echo Yii::t('app','Share this item to facebook?'); ?></span>
								</div>	
								<div class="switch-1 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								  <input id="facebook_share" class="cmn-toggle-1 cmn-toggle-round-1" name="facebook_share" type="checkbox" checked="checked" value="1">
								  <label for="facebook_share"></label>
								</div>
							</div>
							<?php// }  */ ?>
						</div>
						<?php if($model->isNewRecord){ 
							echo "<input type='hidden' value='0' class='product-update-flag' />";
						}else{
							echo "<input type='hidden' value='1' class='product-update-flag' />";
						}?>
						
						<div class="stuff-post col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<?php echo CHtml::submitButton($model->isNewRecord ?Yii::t('app','SHARE YOUR '.strtoupper(Myclass::getSiteName())) : Yii::t('admin','Update'), 
									array('class'=>'post-btn btnUpdate btn','onclick'=>'return validateProduct()')); ?>
					
							<?php if(!$model->isNewRecord){ 
									$cancelURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : Yii::app()->createAbsoluteUrl('/');
									/* echo CHtml::link(Yii::t('admin','Cancel'),
							isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : Yii::app()->createAbsoluteUrl('/'),
							array('class'=>'btn btn-lg btn-warning delete-product-btn',
											'onclick'=> 'return confirm("'.Yii::t('admin','Your changes will not be saved, Continue ?').'")'));  */
									echo '<span class="delete-btn margin-10"
											onclick=\'confirmModal("link", "'.$cancelURL.'", "fullLink")\'>'.Yii::t('admin','Cancel').'</span>';
							} ?>
						</div>
						<!-- 
							<a class="post-btn" href="#" data-toggle="modal" data-target="#post-your-list">Post your list</a>
						</div>  -->
						<input type="hidden" name="Products[promotion][type]" value="" id="promotion-type">
						<input type="hidden" name="Products[promotion][addtype]" value="" id="promotion-addtype">
				</div>		
						
			</div>
				
		</div>
	
		<?php $this->endWidget(); ?>
	
		<div class="paypal-form-container"></div>
	
	<!--Add popup modal-->
	
		<div class="modal fade" id="post-your-list" role="dialog" data-backdrop="static" data-keyboard="false"> 
			<div class="modal-dialog post-list-modal-width">
				<div class="post-list-modal-content login-modal-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
						<div class="post-list-header login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="modal-header-text"><i class="modal-header-tick-icon"></i><p class="login-header-text"><?php echo Yii::t('app','Your stuff successfully posted!'); ?></p></div>
								<!-- <button data-dismiss="modal" class="close login-close" type="button" id="white">×</button> -->
						</div>
							
						<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
					
						<div class="post-list-cnt login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
							<div class="login-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="login-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="post-list-modal-heading"><?php echo Yii::t('app','Highlight your listing?'); ?></div>
								<div class="post-list-content"><?php echo Yii::t('app','qMart allows you to highlight your listing with two different options to reach 
								more number of buyers. You can choose the appropriate option for your listings. Urgent listings gets more leads 
								from buyers and featured listings shows at various places of the website to reach more buyers.'); ?></div>
								</div>
								<div class="post-list-tab-cnt">
									<ul class="post-list-modal-tab nav nav-tabs">
									  <li class="active"><a data-toggle="tab" href="#urgent"><?php echo Yii::t('app','Urgent'); ?></a></li>
									  <li><a data-toggle="tab" href="#promote"><?php echo Yii::t('app','Promote'); ?></a></li>
									</ul>
								</div>	
							</div>	
						</div>	
						<div class="post-list-tab-content  tab-content">
						  <div id="urgent" class="tab-pane fade in active">
							<p> <?php echo Yii::t('app','F'); ?><?php $promoteCurrency = explode("-", $promotionCurrency);echo $promoteCurrency[1].$urgentPrice; ?>.</p>
							<div class="urgent-tab-left col-xs-12 col-sm-8 col-md-8 col-lg-8 no-hor-padding">
								<ul><div class="urgent-tab-heading">Urgent tag Features:<?php echo Yii::t('app','To make your ads instantly viewable you can go for Urgent ads, which gets highlighted at the top just for'); ?></div>
									<li><i class="modal-header-tick-icon"></i><span class="urgent-tab-left-list"><?php echo Yii::t('app','Viewable by all users on desktop and mobile'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="urgent-tab-left-list"><?php echo Yii::t('app','Displayed at the top of the page in search results'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="urgent-tab-left-list"><?php echo Yii::t('app','Displayed at the top of the page in search results'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="urgent-tab-left-list"><?php echo Yii::t('app','Higher visibility on the  website'); ?></span></li>
									<li class="stuff-post">
										<a class="btn post-btn" href="javascript:void(0);" onclick="promotionUpdate('urgent');"><?php echo Yii::t('app','Highlight now'); ?></a>
										<a class="delete-btn promotion-cancel" href="javascript:void(0);"><?php echo Yii::t('app','Cancel'); ?></a>
										<div class="urgent-promote-error delete-btn"></div>
									</li>
								</ul>	
							</div>
							<div class="urgent-tab-right col-xs-12 col-sm-4 col-md-4 col-lg-4 no-hor-padding">
								<div class="urgent-right-circle-icon"></div>
							</div>
						  </div>
						  <div id="promote" class="tab-pane fade">
							<p><?php echo Yii::t('app','Promote your listings to reach more users than normal listings. The promoted listings will be shown at various places to attract the buyers easily.'); ?></p>
							<div class="tab-radio-button-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<?php foreach ($promotionDetails as $promotion){ ?>
								<div class="tab-radio-button col-xs-6 col-sm-6 col-md-3 col-lg-3 no-hor-padding">
									<div class="tab-radio-content">
										<label><input type="radio" name="optradio" onclick="updatePromotion('<?php echo $promotion->id; ?>')"></label>
										<div class="radio-tab-period"><?php echo $promotion->name; ?></div>
										<div class="radio-tab-price col-xs-offset-3 col-sm-offset-5 col-md-offset-4 col-lg-offset-4">
											<?php echo $promoteCurrency[1].$promotion->price; ?>
										</div>
										<div class="radio-tab-days"><?php echo $promotion->days; ?> <?php echo Yii::t('app','days'); ?></div>
									</div>	
								</div>
							<?php } ?>
							</div>
							<div class="promote-tab-left col-xs-12 col-sm-8 col-md-8 col-lg-8 no-hor-padding">
								<ul><div class="promote-tab-heading"><?php echo Yii::t('app','promote tag Features:'); ?></div>
									<li><i class="modal-header-tick-icon"></i><span class="promote-tab-left-list"><?php echo Yii::t('app','Viewable by all users on desktop and mobile'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="promote-tab-left-list"><?php echo Yii::t('app','Displayed at the top of the page in search results'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="promote-tab-left-list"><?php echo Yii::t('app','Displayed at the top of the page in search results'); ?></span></li>
									<li><i class="modal-header-tick-icon"></i><span class="promote-tab-left-list"><?php echo Yii::t('app','Higher visibility on the  website'); ?></span></li>
									<li class="stuff-post">
										<a class="post-btn btn" href="javascript:void(0);" onclick="promotionUpdate('adds');"><?php echo Yii::t('app','Promote now'); ?></a>
										<a class="delete-btn promotion-cancel" href="javascript:void(0);"><?php echo Yii::t('app','Cancel'); ?></a>
										<div class="adds-promote-error delete-btn"></div>
									</li>
								</ul>	
							</div>
							<div class="promote-tab-right col-xs-12 col-sm-4 col-md-4 col-lg-4 no-hor-padding">
								<div class="promote-right-circle-icon"></div>
							</div>
						  </div>
						</div>
				</div>
			</div>
			<input type="hidden" class="promotion-product-id" value="">
		</div>
		
	</div>
		
		<?php /* if ($model->isNewRecord || $model->promotion == 0){ ?>
		<div class="group-form-container">
			<div class='upload-image-head'>
			<?php echo $form->labelEx($model,Yii::t('admin','Promote Your Product'),array(
					'class'=>'required')); ?>
			</div>
			<div class="form-group">
				<input type="radio" name="Products[promotion][type]" value="urgent" id="urgent"> Urgent
				<input type="radio" name="Products[promotion][type]" value="adds" id="adds"> Adds
				<div class="errorMessage" id="Promotion_em_"></div>
			</div>
			<div class="form-group adds-promotion">
				<?php foreach ($promotionDetails as $promotion){ ?>
					<input type="radio" name="Products[promotion][addtype]" 
						value="<?php echo $promotion->id; ?>" > <?php echo $promotion->name; ?>
				<?php } ?>
			</div>
		</div>
		<?php } */ ?>

	<!-- form -->
		<?php $this->endWidget(); ?>
</div>

<?php $id = Myclass::safe_b64encode($model->productId.'-0');?>
<script>
var shippingArray = new Array();
var productId = "";
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
	        productImage = result.length - 1;
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

$('#products-form').on('keyup keypress', function(e) {
	descriptioncls = $("#Products_description").hasClass("desccls");

	  var keyCode = e.keyCode || e.which;
	  //console.log("Keypress "+keyCode);
	  if (keyCode === 13 && descriptioncls == false) { 
	    e.preventDefault();
	    return false;
	  }
});

$('#products-form').blur(function(){
	$("#Products_description").removeClass("desccls");
});

$("#Products_description").on("keyup",function (e){
	$("#Products_description").addClass("desccls");
});

$("#showMore").hide();
function changeCurDiv(cur,code) {
  $("#cur").html(cur+' <span class="caret"></span>');
  $("#showMore").hide();
  $("#currency").val(cur+'-'+code);
}
function showMore() {
	$("#showMore").show();
}
$('textarea.ckeditor').each(function () {
	   var $textarea = $(this);
	   $textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
	});

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

<style>
.added-options div input[type=text]:hover {
	cursor: default;
}

input[readonly] {
	background-color: #CCCCCC;
}
</style>
