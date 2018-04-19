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

					<?php if(Yii::app()->controller->action->id == 'sales') {?>
												<!--My sales and orders-->
						<div id="Sale-order" style="display:block;" class="profile-tab-content tab-pane col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">

							<div class="order-details"></div>

							<div class="order-content exchange-rows col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="order-content">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<ul class="recent-activities-tab nav nav-tabs">
									  <li><a href="<?php echo Yii::app()->createAbsoluteUrl('/orders'); ?>"><?php echo Yii::t('app','My orders'); ?></a></li>
									  <li class="active"><a href="<?php echo Yii::app()->createAbsoluteUrl('/sales'); ?>"><?php echo Yii::t('app','My sales'); ?></a></li>
									  
									</ul>
								</div>
								
								<!----------------------My order------------------->
								<div class="recent-activities-tab-content tab-content">
									<div id="my-orders" class="tab-pane fade in active">
										<div class="profile-listing-product-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
											<!--row 1-->
			<?php if(!empty($sales)) { ?>	
			<?php foreach($sales as $order){
			$productId = $order['orderitems'][0]['productId'];
			$check = Products::model()->findByPk($productId);
			
			if(!empty($check)) {
				$productImage = isset($order['orderitems'][0]->product->photos[0]->name) ? $order['orderitems'][0]->product->photos[0]->name : "";
			}

			if(!empty($check) && !empty($productImage)) {
				$productimageurl = Yii::app()->createAbsoluteUrl("/item/products/resized/100/".$productId."/".$productImage);
			}
			else
			{
				$productimageurl = Yii::app()->createAbsoluteUrl("/item/products/resized/100/".'default.jpeg');
			}

			$productName = $order['orderitems'][0]['itemName'];
			$productQuanity = $order['orderitems'][0]['itemQuantity'];
			$orderPrice = $order['orderitems'][0]['itemPrice'];
			$orderTotal = $order['totalCost'];
			$orderTotalShipping = (int)$order['totalShipping']; ?>						
								<div class="exchange-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="exchange-status-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<div class="exchange-status"> <?php echo Yii::t('app','Status :'); ?><span class="status-txt" id="status-accepted"><?php echo ucfirst($order->status);?></span></div>
										<?php
										if($order->status != "delivered" && $order->status != "shipped" && $order->status != "claimed" && $order->status != "cancelled") {
											?>
										<div class="view-exchange pull-right">

								<?php echo CHtml::ajaxLink(Yii::t('app','More info >'), array('/viewsales/'.Myclass::safe_b64encode($order->orderId.'-0')),
								array(
											'success' => 'js:function(response){ 
										        var output = response.trim();
												if (output) {
													document.body.scrollTop = document.documentElement.scrollTop = 0;
													$(".order-details").show();
										 			$(".order-details").html(output); 
										 			$(".order-content").hide();
												} 
											 }',
								)
								); ?>

										</div>
										<?php } ?>
									</div>
									<div class="exchange-content-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<div class="exchange-left-content col-xs-12 col-sm-12 col-md-5 col-lg-7 no-hor-padding">
											<div class="prof-pic-container col-xs-12 col-sm-5 col-md-5 col-lg-5 no-hor-padding">
												<a href="">
													<div class="exchange-prof-pic" id="exchange-pic-1" style="background-image:url(<?php echo $productimageurl;?>);">
													</div>
												</a>
												<a href=""><div class="exchange-prof-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<?php $userDetail = Myclass::getUserDetails($order->sellerId); ?>
													<span class="exchange-place"> <?php echo Yii::t('app','Seller :'); ?></span><?php echo $userDetail->name; ?></div>
												</a>
											</div>
											<div class="exchange-content col-xs-12 col-sm-7 col-md-7 col-lg-7 no-hor-padding">
												<a href=""><div class="xs-text-center exchange-name bold col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<?php echo $productName; ?></div>
												</a>
												<div class="xs-text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<?php echo $orderPrice.' '.$order->currency ; ?>
												</div>
												<div class="exchange-place col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Qty:'); ?>
													<span><?php echo $productQuanity; ?></span>
												</div>
											</div>
										</div>
										
										<div class="right-content col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding">
											<div class="xs-text-center xs-paddingtop-10"><span class="exchange-place"><?php echo Yii::t('app','Order on:'); ?></span>
												<?php echo date('dS M Y',$order->orderDate) ; ?>
											</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<div class="xs-width-100-a order-id-btn float-right">
														 <?php echo Yii::t('app','Txn Id:'); ?><?php echo $order['invoices'][0]['paymentTranxid'];?>
													</div>
												</div>
												<?php
												$paymentmodes = Myclass::getSitePaymentModes();
												if($order->status == "delivered" || $order->status == "shipped" || $order->status == "claimed" || $order->status == "cancelled") {
													?>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
										<?php echo CHtml::ajaxLink(Yii::t('app','Order details'), array('/viewsales/'.Myclass::safe_b64encode($order->orderId.'-0')),
											array(
														'success' => 'js:function(response){ 
													        var output = response.trim();
															if (output) {
																document.body.scrollTop = document.documentElement.scrollTop = 0;
																$(".order-details").show();
													 			$(".order-details").html(output); 
													 			$(".order-content").hide();
															} 
														 }',
											),array('class'=> 'xs-width-100-a order-btn float-right exc-success')
											); ?>
												</div>													
													<?php } ?>
												<?php
												if($order->status == "processing") {
													?>
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
														<a href="javascript:void(0);" id="exc-pending" class="xs-width-100-a order-btn float-right" onclick="edit_tracking(0,<?php echo $order->orderId;?>);" data-target="#shipping-seller-modal" data-toggle="modal"><?php echo Yii::t('app','Mark as shipped'); ?></a>														
													</div>	
												<?php } ?>
												<?php
												if($order->status == "pending") {
													?>												
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
														<a id="exc-accept" onclick="changeSalesStatus('processing','<?php echo $order->orderId; ?>')" class="xs-width-100-a order-btn float-right process<?php echo $order->orderId;?>" href="javascript:void(0);">
															<?php echo Yii::t('app','Mark process'); ?>
														</a>														
													</div>	
												<?php } ?>
										</div>
									</div>
									<div class="exchange-info col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<!--div class="exchange-initiate-date"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/order-placed.png'); ?>" alt="twitter"><span class="order-placed">Order palced!</span></div-->
										<div class="xs-text-center xs-paddingtop-10 xs-floatnone pull-right">
											<?php if ($order['discountSource'] != ""){ $orderTotal -= $order['discount']; } ?>
											<div class="Order-total"><?php echo Yii::t('app','Order total:'); ?>
												<span class="order-placed" id="status-accepted">
													<?php echo $orderTotal.' '.$order->currency; ?>
												</span>
											</div>
										</div>
									</div>
								</div>
								<?php }}
					echo '<div class="clear urgent-tab-right">';
					$this->widget('CLinkPager',array('pages' => $pages));
					echo '</div>';
								?>

											
										</div>
									</div>									
								</div>
									</div>									
								</div>
							</div>

											<?php } ?>
										</div>
									</div>									
								</div>
							</div>


<div class="paypal-form-container"></div>


<style type="text/css">
.footer {
    margin-top: 0px !important;
}


</style>
<script type="text/javascript">
function hide_order_details()
{
			$(".order-details").hide();
 			$(".order-details").html(""); 
 			$(".order-content").show();
 		}
</script>

		<!--Shippping details for seller popup-->
	
	<div class="modal fade" id="shipping-seller-modal" role="dialog"> 
		<div class="modal-dialog modal-dialog-width">
			<div class="login-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
					<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="login-header-text"><?php echo Yii::t('app','Shipping details'); ?></h2>
							<button data-dismiss="modal" class="close login-close" type="button">×</button>							
					</div>
						
						<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
					
							<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
								<div class="login-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="login-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<?php 
								$url = Yii::app()->createAbsoluteUrl('tracking/'.Myclass::safe_b64encode($model->orderId.'-0'));
								$form=$this->beginWidget('CActiveForm', array(
                                'id'=>'trackingdetails-form',
                                'action' => $url,
								// Please note: When you enable ajax validation, make sure the corresponding
								// controller action is handling ajax validation correctly.
								// See class documentation of CActiveForm for details on this,
								// you need to use the performAjaxValidation()-method described there.
                                'enableAjaxValidation'=>true,
								'htmlOptions' => array('onsubmit' => 'return validatetracking()','class' => 'form-horizontal'),
								)); 
								?>
								<input type="hidden" id="Trackingdetails_orderid" name="Trackingdetails[orderid]" value="">
								<label class="Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Shipment Date'); ?><span class="required">*</span></label>
																<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                    'model'=>$tracking,
									'attribute' => 'shippingdate',

    								'options'=>array(
    									'minDate'=>'0',
       									 'showAnim'=>'fold',
										),
   								    'htmlOptions'=>array(
										 'class' => 'form-control',
									'value' => empty($tracking['shippingdate']) ? '' : date('m/d/Y',$tracking['shippingdate']),
										),
										));?>
										<div style="display:none" id="Trackingdetails_shippingdate_em_" class="errorMessage"></div>

										<label class="Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Shipment Method'); ?><span class="required">*</span></label>
										<input type="text" maxlength="250" id="Trackingdetails_couriername" name="Trackingdetails[couriername]" placeholder="Enter the courier" class="form-control">
										<div style="display:none" id="Trackingdetails_couriername_em_" class="errorMessage"></div>
										<input id="Trackingdetails_courierservice" class="form-control" type="text" maxlength="250" name="Trackingdetails[courierservice]" placeholder="Shipping Service">
										<div id="Trackingdetails_courierservice_em_" class="errorMessage" style="display:none"></div>										

										<label class="Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Tracking ID'); ?><span class="required">*</span></label>
										<input id="Trackingdetails_trackingid" class="form-control" type="text" maxlength="250" name="Trackingdetails[trackingid]">
										<div id="Trackingdetails_trackingid_em_" class="errorMessage" style="display:none"></div>

										<label class="Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><?php echo Yii::t('app','Additional Notes'); ?></label>
										<textarea id="Trackingdetails_notes" class="form-control" name="Trackingdetails[notes]" rows="10" cols="15" style=""></textarea>
										<div id="Trackingdetails_notes_em_" class="errorMessage" style="display:none"></div>										

										<input type="submit" value="Mark as shipped" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding login-btn">
								<?php $this->endWidget(); ?>
									</label>

									</div>
								</div>											
							</div>	
			</div>
		</div>
	</div>
		
<!--E O Shippping details for seller popup-->	