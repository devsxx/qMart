<div class="message-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="live-msg-container">
	<ol
		class="live-messages-ol-<?php echo $currentUserDetails->username; ?>-<?php echo $chatUser->username; ?>-<?php echo $sourceId; ?>">
		<?php if(!empty($messageModel)) { 
		 foreach ($messageModel as $message){
			
		 	$sender = $message->senderId;
		 	$gridAlign = "user-conv";
		 	$messageContainerAlign = "message-conversation-right-cnt";
		 	$messageContainer = "message-conversation";
		 	$gridArrowAlign = "arrow-right";
		 	$userImageAlign = "id='user'";
		 	$chatGirdImage = $currentUserImage;
		 	if ($sender != $currentUserDetails->userId){
		 		$gridAlign = "";
		 		$messageContainerAlign = "message-conversation-left-cnt";
		 		$messageContainer = "exchange-message-conversation";
		 		$gridArrowAlign = "exchange-arrow-left";
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
					<div class="<?php echo $messageContainer; ?> col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<div class="conversation-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<div class="conversation-bargain-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">											
								<div class="conversation-text"><?php echo $chatMessage; ?></div>
							</div>
						</div>
					</div>	
					<div class="conversation-date col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
						<?php echo date('M jS Y', $chatDate); ?>
					</div>
				</div>
			</div>	
		</li>
		
		<?php }
		}  ?>
	</ol>
</div>
<?php $disable = '';
			if($chatUser->userstatus == 0)
				$disable = "disabled = 'disabled'";
			?>			
<div class="message-type-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	<div class="live-messages-typing typing-status col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<?php echo $chatUser->username." ".Yii::t('app','Typing'); ?>...
	</div>
	<div class="chat-message-type col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<form class="form-inline" id="messageForm">
			<div class="form-group col-xs-12 col-sm-10 col-md-10 col-lg-11 no-hor-padding">
			  <textarea id="messageInput" class="exchange-comment-area comment-text-area form-control" rows="5" 
			  	placeholder="<?php echo Yii::t('app','Message'); ?>" onkeyup="limitMessage(500,event);" <?php echo $disable;?>></textarea>
			</div>
			<input id="sourcce" type="hidden" value="<?php echo $chatId; ?>" /> 
			<input id="sendingsource" type="hidden" value="<?php echo $currentUserDetails->userId; ?>" /> 
			<input id="appendinggsource" type="hidden" value="<?php echo $currentUserDetails->username; ?>" /> 
			<input id="receiveingsource" type="hidden" value="<?php echo $chatUser->username; ?>" />
			<input id="sourccetype" type="hidden" value="exchange" /> 
			<input id="chatsourcce" type="hidden" value="0" /> 
			<input id="sourceId" type="hidden" value="<?php echo $sourceId; ?>" /> 
			<div class="message-send col-xs-12 col-sm-2 col-md-2 col-lg-1 no-hor-padding">
				<a href="javascript:void(0);" <?php echo $disable;?> onclick="sendMessage();">
					<div class="send-btn">
						<span><?php echo Yii::t('app','Send'); ?></span>
						<img src="<?php echo Yii::app()->createAbsoluteUrl('images/send-icon.png');?>" alt="send-icon"></div>
				</a>
			</div>
		</form>
	</div>	
</div>	
	<!-- <h1>Integration test NodeJS + PHP</h1>
	<p>
		This is a simple application, showing integration between nodeJS and PHP.
	</p>
	
	<form class="form-inline" id="messageForm">
		<input id="nameInput" type="text" class="input-medium" placeholder="Name" />
		<input id="messageInput" type="text" class="input-xxlarge" placeHolder="Message" />
	
		<input type="submit" value="Send" />
	</form>
	
	<div>
		<ul id="messages">
			<?php 
				/*$query = $pdo->prepare( 'SELECT * FROM message ORDER BY id DESC' );
				$query->execute();
				
				$messages = $query->fetchAll( PDO::FETCH_OBJ );
				foreach( $messages as $message ):
			?>
				<li> <strong><?php echo $message->author; ?></strong> : <?php echo $message->message; ?> </li>
			<?php endforeach; */ ?>
		</ul>
	</div> -->
	<!-- End #messages -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script src="js/bootstrap.js"></script> -->
<script
	src="<?php echo Yii::app()->baseUrl ?>/js/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
<script
	src="<?php echo Yii::app()->baseUrl ?>/js/nodeClient.js"></script>
			<?php
			$user = Yii::app()->user;
			//echo "User: ".Yii::app()->user->id;
			//if ($user->isGuest != 1 && !isset(Yii::app()->session['firstLogin'])){ ?>
<script type="text/javascript">
	$(document).ready(function(){
		socket.emit( 'exchangejoin', { joinid: '<?php echo $currentUserDetails->username; ?>' } );
	});

	var objDiv = document.getElementById("live-msg-container");
	objDiv.scrollTop = objDiv.scrollHeight;
	$('.live-messages ol').css({'opacity':'1'});
</script>
			<?php 	//Yii::app()->session['firstLogin'] = 1;
			//} ?>