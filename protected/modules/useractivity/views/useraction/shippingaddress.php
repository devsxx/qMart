<script>
var offset = 15;
var limit = 15;
</script>
<?php 
	if(count($products) == 0)
		$empty_tap = " empty-tap ";
	else
		$empty_tap = "";
	if(empty($followerlist))
		$fempty_tap = " empty-tap ";
	else
		$fempty_tap = "";
?>		

<div class="container profile-page-dev">
		
			<div class="row">		
				<div class="qMart-breadcrumb add-product col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					 <ol class="breadcrumb">
						<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"><?php echo Yii::t('app','Home'); ?></a></li>
						<li><a href="#"><?php echo Yii::t('app','Profile'); ?></a></li>					 
					 </ol>			
				</div>	
			</div>
	<div class="row">
				<div class="profile-vertical-tab-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
				 <?php $this->renderPartial('application.modules.useractivity.views.useraction.profilemenu',array('user'=>$user, 
				 			'followerIds'=>$followerIds)); ?> 

					<div class="tab-content col-xs-12 col-sm-9 col-md-9 col-lg-9">

					<?php if(Yii::app()->controller->action->id == 'shippingaddress') { ?>
						

						<!--address book-->
						<div id="address-book" style="display:block;" class="profile-tab-content tab-pane col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="profile-tab-content-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<span><?php echo Yii::t('app','Address book'); ?></span>
								<a data-target="#address-modal" data-toggle="modal" href="#" class="profile-tab-heading-btn pull-right">								
									<div class="btn-follow btn-chat-with-seller col-xs-12 col-sm-12 col-md-3 col-lg-2 no-hor-padding">
										<div class="chat-with-seller-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','+Add address'); ?></div>
									</div>						
								</a>
							</div>
							<div class="edit-profile-form col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">									
							 <div class="edit-profile-addr-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">							
						<?php if(empty($address)) {
							echo '<div class="record-not-found">'.Yii::t('app','You haven’t added any shipping address yet.').'</div>';
						} else { ?>

							<?php foreach($address as $add){ ?>

									<div class="qMart-acc-addr-cont col-xs-12 col-sm-4 col-md-4" style="float:left;">
										<?php $userDefaultAddress = Myclass::getDefaultShippingAddress($add->userId);
											if($add->shippingaddressId == $userDefaultAddress) {
												?>
										<div class="qMart-acc-addr-cnt col-xs-12 col-sm-12 no-hor-padding" id="sample-hover-status">
											<div class="address-active" style="display:block;"></div>
											<?php
										}
										else
										{
										?>
										<div class="qMart-acc-addr-cnt col-xs-12 col-sm-12 no-hor-padding">
										<?php
										}
										?>
											
											<div class="qMart-acc-icon-cnt col-xs-12 col-sm-6 col-md-6 col-lg-5 no-hor-padding pull-right">
												<?php if ($defaultShipping != $add->shippingaddressId){ ?>
												<a href="javascript:void(0);"><img onclick="confirmModal('method', 'deleteShipping', '<?php echo $add->slug; ?>')" src="<?php echo Yii::app()->createAbsoluteUrl("/images/delete-icon.png");?>"></a>
												<?php } ?>
												<a data-target="#address-modal" data-toggle="modal" href="#" onclick="edit_shipping(<?php echo $add->shippingaddressId; ?>)"><img src="<?php echo Yii::app()->createAbsoluteUrl("/images/edit-icon.png");?>"></a>
											</div>
											<div class="qMart-acc-addr col-xs-12 col-sm-12 no-hor-padding">
												<div class="qMart-acc-addr-heading"><?php echo $add->nickname; ?></div>
												<div class="qMart-acc-addr-txt">	
												<span class="address-user-name"><?php echo $add->name; ?></span>
											<span class="qMart-acc-addr-line1">
											<?php echo $add->address1; ?>
											<?php if(!empty($add->address2)) echo ",".$add->address2; ?>
											</span>
											<span class="qMart-acc-addr-line2">
											<?php echo $add->city." - ".$add->zipcode; ?>
											</span>
											<span class="qMart-acc-addr-city">
											<?php echo $add->state; ?>
											</span>
											<span class="qMart-acc-addr-city">
											<?php echo $add->country; ?>
											</span>

												</div>
											</div>	
											<div class="qMart-acc-phone col-xs-12 col-sm-12 no-hor-padding">
												<?php echo $add->phone; ?>
											</div>
											<div class="qMart-acc-btn-cnt col-xs-12 col-sm-12 no-hor-padding">
												<div class="qMart-acc-select-cnt">
											<?php $userDefaultAddress = Myclass::getDefaultShippingAddress($add->userId);
											if($add->shippingaddressId == $userDefaultAddress) {
													echo '<a href="" class="qMart-acc-continue-btn qMart-acc-btn qMart-acc-select">Default</a>';
												}
												else
												{
													$defaulturl = Yii::app()->createAbsoluteUrl('useractivity/useraction/default',array('id'=>$add->shippingaddressId,'userid' => $add->userId));
													echo '<a href="'.$defaulturl.'" class="qMart-acc-continue-btn qMart-acc-btn qMart-acc-select">Set as default</a>';
													/*echo CHtml::link(Yii::t('app','Set as Default'),Yii::app()->createAbsoluteUrl(
															'useractivity/useraction/default',array('id'=>$add->shippingaddressId, 
															'userid' => $add->userId)),array('class' => 'qMart-acc-continue-btn qMart-acc-btn qMart-acc-select'));*/
												}
												?>
												</div>
											</div>	
										</div>
									</div>

					<?php
					}
					echo '<div class="clear urgent-tab-right">';
					$this->widget('CLinkPager',array('pages' => $pages));
					echo '</div>';
				}
					?>
					</div>
						</div>					
						</div>
						<!--address book-->	


					<?php }?>
						</div>
					</div>
				</div>
			</div>



</div>
<div class="paypal-form-container"></div>

	<!--Address details popup-->
	
	<div class="modal fade" id="address-modal" role="dialog"> 
		<div class="modal-dialog modal-dialog-width">
			<div class="login-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
					<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="login-header-text"><?php echo Yii::t('app','Address details'); ?></h2>
							<button data-dismiss="modal" class="close login-close" type="button">×</button>							
					</div>
						
						<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
					
							<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
								<div class="login-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">


	<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'tempaddresses-addshipping-form',
    'action'=>Yii::app()->createUrl('checkout/addshipping'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
 //   'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>false,
	),
	'htmlOptions' => array('onsubmit' => 'return validaddship()'),
	)); ?>
	<div class="login-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">

		<input type="hidden" id="shippingId" name="shippingId" value="0">

		<label class="Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Nickname'); ?><span class="required">*</span></label>
		<input type="text" maxlength="20" id="Tempaddresses_nickname" name="Tempaddresses[nickname]" onkeypress="return validateNumeric(this,event)" class="popup-input">
		<div style="display:none" id="Tempaddresses_nickname_em_" class="errorMessage"></div>

		<label class="Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Name'); ?><span class="required">*</span></label>
		<input type="text" maxlength="30" id="Tempaddresses_name" name="Tempaddresses[name]" onkeypress="return validateNumeric(this,event)" class="form-control">
		<div style="display:none" id="Tempaddresses_name_em_" class="errorMessage"></div>

		<label class="Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Country'); ?><span class="required">*</span></label>
		<select id="Tempaddresses_country" class="form-control" name="Tempaddresses[country]">
			<?php
			foreach ($countriesList as $key => $value) {
				echo '<option value="'.$key.'">'.$value.'</option>';
			}
			?>
		</select>
		<div style="display:none" id="Tempaddresses_country_em_" class="errorMessage"></div>

		<label class="Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Address 1'); ?><span class="required">*</span></label>
		<input type="text" maxlength="60" id="Tempaddresses_address1" name="Tempaddresses[address1]" class="form-control">
		<div style="display:none" id="Tempaddresses_address1_em_" class="errorMessage"></div>

		<label class="Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Address 2'); ?></label>
		<input type="text" maxlength="60" id="Tempaddresses_address2" name="Tempaddresses[address2]" class="form-control">
		<div style="display:none" id="Tempaddresses_address2_em_" class="errorMessage"></div>

		<label class="Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','City'); ?><span class="required">*</span></label>
		<input type="text" maxlength="40" id="Tempaddresses_city" name="Tempaddresses[city]" onkeypress="return validateNumeric(this,event)" class="form-control">
		<div style="display:none" id="Tempaddresses_city_em_" class="errorMessage"></div>

		<label class="Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','State'); ?><span class="required">*</span></label>
		<input type="text" maxlength="40" id="Tempaddresses_state" name="Tempaddresses[state]" onkeypress="return validateNumeric(this,event)" class="form-control">
		<div style="display:none" id="Tempaddresses_state_em_" class="errorMessage"></div>

		<label class="Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Zipcode'); ?><span class="required">*</span></label>
		<input type="text" maxlength="20" id="Tempaddresses_zipcode" name="Tempaddresses[zipcode]" onkeypress="return IsAlphaNumeric(event)" class="form-control">
		<div style="display:none" id="Tempaddresses_zipcode_em_" class="errorMessage"></div>

		<label class="Category-input-box-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Phone'); ?><span class="required">*</span></label>
		<input type="text" maxlength="20" id="Tempaddresses_phone" name="Tempaddresses[phone]" class="form-control">
		<div style="display:none" id="Tempaddresses_phone_em_" class="errorMessage"></div>

		<input type="submit" value="Save address" name="yt0" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding login-btn">
</div>
	<?php $this->endWidget(); ?>


									
								</div>
											
							</div>	
									
					
										
										
		
			</div>
		</div>
	</div>
		
<!--E O address details popup-->
	

<style type="text/css">
.footer {
    margin-top: 0px !important;
}


</style>
