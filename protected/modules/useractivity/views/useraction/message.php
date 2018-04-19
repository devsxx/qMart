<div class="container-fluid no-hor-padding chatnotify-container" style="display: none;"></div>
<div class="container">

<!-- Message HTML Starts-->
	<!-- <div class="row">		
				<div class="qMart-breadcrumb add-product col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
					 <ol class="breadcrumb">
						<li><a href="#">Home</a></li>
						<li><a href="#">message</a></li>					 
					 </ol>			
				</div>
				
			</div>	 
			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<div class="full-horizontal-line col-xs-12 col-sm-12 col-md-12 col-lg-12 "></div>
				</div>

					
			</div>	-->
				
			<div class="row">				
					<div class="add-product-heading col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:25px">
						<h2 class="top-heading-text"><?php echo Yii::t('app','Messages'); ?></h2>
						<!-- <p class="top-heading-sub-text">Reference site about Lorem Ipsum, giving information on its origins</p> -->
					</div>
			</div>	
			
			<?php if(!empty($chattingUsers)){ ?>

			<div class="row">
				<div class="message-vertical-tab-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<ul class="message-vertical-tab-container nav nav-tabs col-xs-12 col-sm-3 col-md-3 col-lg-3 no-hor-padding">
					<?php foreach ($chattingUsers as $chattingUser){
							$active = "";
							$userDetails = $chatUser[$chattingUser];
							if(!empty($userDetails->userImage)) {
								$userImage = Yii::app()->createAbsoluteUrl('user/resized/75/'.
										$userDetails->userImage);
							} else {
								$userImage = Yii::app()->createAbsoluteUrl('user/resized/75/default/'.
										Myclass::getDefaultUser());
							}
							if ($currentChatUser == $userDetails->userId){
								$active = "active";
							}
							$userName = $userDetails->name;
							$latestMessage = $lastMessages[$chattingUser]['message'];
							$lastTime = Myclass::getElapsedTime($lastMessages[$chattingUser]['time'])." ".Yii::t('app',"ago");
							if ($lastMessages[$chattingUser]['messaggeMarker'] == '<div class="message-unread-count"></div>'){
								$unread = 1;
							}else{
								$unread = 0;
							} ?>
							<li class="<?php echo $active; ?>  chatlist-<?php echo $userDetails->username; ?> col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<a class="chat-link userNameLink" href="<?php echo Yii::app()->baseUrl."/message/".Myclass::safe_b64encode(
										$userDetails->userId.'-0'); ?>" data-userid="<?php echo Myclass::safe_b64encode($userDetails->userId.'-0'); ?>"
										data-userread = "<?php echo $unread; ?>">
									<div class="message-icon col-xs-4 col-sm-12 col-md-4 col-lg-4 no-hor-padding">
										<div class="message-prof-pic col-sm-offset-3 col-md-offset-0 col-lg-offset-0" 
											style="background-image:url('<?php echo $userImage; ?>');">
											<?php echo $lastMessages[$chattingUser]['messaggeMarker']; ?>
										</div>
									</div>
									<div class="message-details col-xs-8 col-sm-8 col-md-8 col-lg-8 no-hor-padding">
										<div class="message-prof-name"><?php echo $userName; ?></div>
										<div class="short-message"><?php echo $lastMessages[$chattingUser]['messaggeReplyMarker'].$latestMessage; ?></div>
										<div class="message-time"><?php echo $lastTime; ?></div>
									</div>
								</a>
							</li>
						<?php } ?>
						</ul>

					<div class="chat-message-container tab-content col-xs-12 col-sm-9 col-md-9 col-lg-9 no-hor-padding">
					
					  <div id="home" class="message-tab-content tab-pane fade in active col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="message-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="live-msg-container">
							<ol
								class="live-messages-ol-<?php echo $currentUserDetails->username; ?>-<?php echo $chatUser[$currentChatUser]->username; ?>">
								<?php
								$receiverId = $currentChatUser;
								if(!empty($messageChatId)) {
									$chatId = $messageChatId;
								}
								foreach ($messageModel as $message){
									$sender = $message->senderId;
									$gridAlign = "user-conv";
									$messageContainerAlign = "message-conversation-right-cnt";
									$gridArrowAlign = "arrow-right";
									$userImageAlign = "id='user'";
									$chatGirdImage = $currentUserImage;
									if ($sender != $currentUserDetails->userId){
										$gridAlign = "";
										$messageContainerAlign = "message-conversation-left-cnt";
										$gridArrowAlign = "arrow-left";
										$userImageAlign = "";
										$chatGirdImage = $currentChatUserImage;
										$receiverId = $sender;
									}
									$chatDate = $message->createdDate;
									$chatMessage = $message->message;
									$chatId = $message->chatId;
									?>
								<li>
									<div class="<?php echo $gridAlign; ?> message-conversation-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<div <?php echo $userImageAlign; ?> class="conversation-prof-pic no-hor-padding">
											<div class="message-prof-pic" style="background-image: url('<?php echo $chatGirdImage; ?>')"></div>
										</div>								
										<div class="<?php echo $messageContainerAlign; ?> col-xs-9 col-sm-9 col-md-9 col-lg-7 no-hor-padding">
											<div class="<?php echo $gridArrowAlign; ?>"></div>
											<div class="message-conversation col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
										<?php 
										if ($message->messageType == 'offer'){
											$chatSourceItem = Myclass::getProductDetails($message->sourceId);
											if(!empty($chatSourceItem)){
												if(isset($chatSourceItem->photos[0])){
													$productImage = Yii::app()->createAbsoluteUrl(
															'item/products/resized/80/'.$chatSourceItem->productId.
															'/'.$chatSourceItem->photos[0]->name);
												}else{
													$productImage = Yii::app()->createAbsoluteUrl('item/products/resized/80/default.jpeg');
												}
												$productTitle = $chatSourceItem->name;
												$chatMessage = json_decode($chatMessage, true);
												$offerCurrency = explode("-", $chatMessage['currency']);
												$productLink = Yii::app()->createAbsoluteUrl('item/products/view',array(
														'id' => Myclass::safe_b64encode($chatSourceItem->productId.'-'.rand(0,999)))).'/'.
														Myclass::productSlug($chatSourceItem->name);
												?>
												<div class="conversation-topic col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<?php echo Yii::t('app','Sent offer request on'); ?> <a href="<?php echo $productLink; ?>" target="_blank" class="message-conversation-item-name"><?php echo $productTitle; ?></a>
												</div>
												<div class="conversation-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<div class="conversation-product-pic-container col-xs-offset-3 col-sm-offset-0">
														<div class="conversation-product-pic" style="background-image: url('<?php echo $productImage; ?>')"></div>
													</div>
													<div class="conversation-bargain-container">
														<div class="conversation-rate-container">
															<div class="conversation-rate">
																<?php echo $offerCurrency[0].$chatMessage['price']?>
															</div>											
														</div>
														<div class="conversation-text"><?php echo $chatMessage['message']?></div>
													</div>
												</div>
												<?php }
										}else{
											if($message->messageType == 'normal' && $message->sourceId != 0){
												$chatSourceItem = Myclass::getProductDetails($message->sourceId);
												if(!empty($chatSourceItem)){
													if(isset($chatSourceItem->photos[0])){
														$productImage = Yii::app()->createAbsoluteUrl(
																'item/products/resized/80/'.$chatSourceItem->productId.
																'/'.$chatSourceItem->photos[0]->name);
													}else{
														$productImage = Yii::app()->createAbsoluteUrl('item/products/resized/80/default.jpeg');
													}										
													$productTitle = $chatSourceItem->name;
													$productLink = Yii::app()->createAbsoluteUrl('item/products/view',array(
															'id' => Myclass::safe_b64encode($chatSourceItem->productId.'-'.rand(0,999)))).'/'.
															Myclass::productSlug($chatSourceItem->name);
													?>
												<div class="conversation-topic col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<?php echo Yii::t('app','About'); ?> <a href="<?php echo $productLink; ?>" target="_blank" class="message-conversation-item-name"><?php echo $productTitle; ?></a>
												</div>
												<div class="conversation-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
													<div class="conversation-product-pic-container col-xs-offset-3 col-sm-offset-0">
														<div class="conversation-product-pic" style="background-image: url('<?php echo $productImage; ?>')"></div>
													</div>
													<div class="conversation-bargain-container">
														<div class="conversation-text"><?php echo $chatMessage; ?></div>
													</div>
												</div>
												<?php }
												}else{ ?>
													<div class="conversation-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
														<div class="conversation-bargain-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">											
															<div class="conversation-text"><?php echo $chatMessage; ?></div>
														</div>
													</div>
											<?php } ?>
										<?php } ?>
											</div>	
											<div class="conversation-date col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
												<?php echo date('M jS Y', $chatDate); ?>
											</div>
										</div>
									</div>	
								</li>
								<?php } ?>
							</ol>
							</div>
							<?php $disable = '';
								if ($chatUser[$receiverId]->userstatus == 0)
									$disable = "disabled = 'disabled'";
							?>
							<div class="message-type-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
								<div class="live-messages-typing typing-status col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php echo $chatUser[$receiverId]->username." ".Yii::t('app','Typing'); ?>...
								</div>
								<div class="chat-message-type col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<form class="form-inline" id="messageForm">
										<div class="form-group col-xs-12 col-sm-10 col-md-10 col-lg-11 no-hor-padding">
										  <textarea id="messageInput" class="comment-text-area form-control" rows="5" maxlength="500"
										  	placeholder="<?php echo Yii::t('app','Message'); ?>" onkeyup="limitMessage(500,event);" <?php echo $disable;?>></textarea>
										</div>
										<input id="sourcce" type="hidden" value="<?php if(!empty($chatId))echo $chatId; ?>" /> 
										<input id="sendingsource" type="hidden" value="<?php echo $currentUserDetails->userId; ?>" /> 
										<input id="appendinggsource" type="hidden" value="<?php echo $currentUserDetails->username; ?>" /> 
										<input id="receiveingsource" type="hidden" value="<?php if(!empty($chatUser[$receiverId]->username))echo $chatUser[$receiverId]->username; ?>" />
										<input id="sourccetype" type="hidden" value="normal" /> 
										<input id="chatsourcce" type="hidden" value="0" /> 
										<input id="sourceId" type="hidden" value="" /> 
										<div class="message-send col-xs-12 col-sm-2 col-md-2 col-lg-1 no-hor-padding">
											<a href="javascript:void(0);" <?php echo $disable;?> onclick="sendMessage();">
												<div class="send-btn"><span><?php echo Yii::t('app','Send'); ?></span><img src="<?php echo Yii::app()->createAbsoluteUrl('images/send-icon.png');?>" alt="send-icon"></div>
											</a>
										</div>
									</form>
								</div>	
							</div>												
					  </div>
					  
					</div>
				</div>
			</div>
			<?php }else{ ?>
		  		<div class="row">
		  			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding no-conversation-msg">
		  				<img alt="No Converstations Found" src="<?php echo Yii::app()->createAbsoluteUrl('images/no-conversation.jpg'); ?>">
		  				<div><?php echo Yii::t('app', 'No conversation yet')."."; ?></div>
		  			</div>
		  		</div>
		  	<?php } ?>
			<!------------------------------Modals---------------------------------->
			  
			<!----------------------------E O Modals---------------------------------->  
		
<!-- Message HTML Ends -->
</div>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script src="js/bootstrap.js"></script> -->
<?php if($ajaxChat == 0){ ?>
<script
	src="<?php echo Yii::app()->baseUrl ?>/js/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
<script
	src="<?php echo Yii::app()->baseUrl ?>/js/nodeClient.js"></script>
			<?php
}
			$user = Yii::app()->user;
			//echo "User: ".Yii::app()->user->id;
			//if ($user->isGuest != 1 && !isset(Yii::app()->session['firstLogin'])){ ?>
<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function() {
			$("#live-msg-container").scrollTop($("#live-msg-container")[0].scrollHeight);
			$('.live-messages ol').css({'opacity':'1'});
		}, 1000);
		<?php if($ajaxChat == 0){ ?>
		socket.emit( 'join', { joinid: '<?php echo $currentUserDetails->username ?>' } );
		<?php } ?>
	});
</script>
<?php 	//Yii::app()->session['firstLogin'] = 1;
		//} ?>
