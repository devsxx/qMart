<?php

class UseractionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	protected function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
			return false;
		}
		$allowedActions = array('help');
		$user = Yii::app()->user;
		if($user->isGuest && !in_array(Yii::app()->controller->action->id, $allowedActions)) {
			$this->redirect(array('/user/login'));
			return false;
		}

		return true;
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionDelete($id)
	{
		$address = Tempaddresses::model()->findByAttributes(array('slug'=>$id));
		$userDefaultShipping = Myclass::getDefaultShippingAddress($address->userId);
		if($userDefaultShipping == $address->shippingaddressId) {
			$criteria = new CDbCriteria;
			$criteria->addCondition("userId = '$address->userId'");
			$criteria->addCondition("shippingaddressId != '$address->shippingaddressId'");
			$criteria->order = 'shippingaddressId DESC';
			$addressChange  = Tempaddresses::model()->find($criteria);
			
			//echo "<pre>";print_r($addressChange);die;
			$user = Users::model()->findByPk($address->userId);
			if(!empty($addressChange)){
				$user->defaultshipping = $addressChange->shippingaddressId;
			}else{
				$user->defaultshipping = 0;
			}
			$user->save(false);
		}
		$address->delete();
		//if(!isset($_GET['ajax']))
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('shippingaddress'));
	}

	public function actionAddshipping($id=null) {
		if ($id === null){
			echo $id = $_POST['shippingId'];
		}
		if ($id === null || $id == 0){
			$model = new Tempaddresses();
			$model->setScenario('create');
			$model->slug = Myclass::getRandomString(8);
		}else{
			$model = Tempaddresses::model()->findByAttributes(array('slug'=>$id));
			$model->country = $model->countryCode.'-'.$model->country;
			$model->setScenario('update');
		}
		$criteria = new CDbCriteria;
		$criteria->addCondition("countryId != 0");
		$countryModel = Country::model()->findAll($criteria);

		foreach ($countryModel as $country){
			$combineCode = $country->countryId.'-'.$country->country;
			$countriesList[$combineCode] = $country->country;
		}

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Tempaddresses']))
		{
			$addressData = $_POST['Tempaddresses'];
			$model->attributes=$_POST['Tempaddresses'];
			$model->userId = Yii::app()->user->id;

			if (isset($addressData['country'])){
				$countryDetails = explode('-', $addressData['country']);
				$model->countryCode = $countryDetails[0];
				$model->country = $countryDetails[1];
			}

			if($model->save()){
				$default = Users::model()->findByPk(Yii::app()->user->id);
				if($default->defaultshipping == 0){
					$default->defaultshipping = $model->shippingaddressId;
					$default->save(false);
				}
				//	$this->redirect(array('view','id'=>$model->productId));
				$this->redirect(array('shippingaddress'));
			}else{
				Yii::app()->user->setFlash('success',"Unable to save please try again");
			}
			
		}
		$this->redirect(array('shippingaddress'));
		//$this->render('addshipping', array('model'=>$model, 'countriesList'=>$countriesList));
	}

	/**
	 * Performs the AJAX validation.
	 * @param Products $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tempaddresses-addshipping-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

	}

	public function actionShippingaddress() {
			$user = Yii::app()->user;
			if($user->isGuest) {
				$this->redirect(array('/user/login'));
				return false;
			}
			$id = Yii::app()->user->id;

		$user = Users::model()->findByPk($id);
		
		$userid = Yii::app()->user->id;
		if(!empty($userid)){
		$followCriteria = new CDbCriteria;
		$followCriteria->addCondition("userId = $userid");
		$follower = Followers::model()->findAll($followCriteria);
		//echo "<pre>";print_r($follower);die;
		$followerIds = array();
		if(!empty($follower)) {		            
			foreach($follower as $follower):
			$followerIds[] = $follower->follow_userId;
			endforeach;
		}          
		}  			

		$criteria = new CDbCriteria;
		$criteria->addCondition("countryId != 0");
		$countryModel = Country::model()->findAll($criteria);

		foreach ($countryModel as $country){
			$combineCode = $country->countryId.'-'.$country->country;
			$countriesList[$combineCode] = $country->country;
		}

		if(isset($_POST['Tempaddresses']))
		{
			if(isset($_POST['shippingId']))
			{
				$address = Tempaddresses::model()->findByAttributes(array('shippingaddressId'=>$addressId));
			}
			else
			{
				$address = new Tempaddresses();
			}
			$address->nickname = $_POST['Tempaddresses']['nickname'];
			$address->name = $_POST['Tempaddresses']['name'];
			$countryDetails = explode('-', $_POST['Tempaddresses']['country']);
			$address->countryCode = $countryDetails[0];
			$address->country = $countryDetails[1];
			$address->address1 = $_POST['Tempaddresses']['address1'];
			if(isset($_POST['Tempaddresses']['address2']))
				$address->address2 = $_POST['Tempaddresses']['address2'];
			$address->city = $_POST['Tempaddresses']['city'];
			$address->state = $_POST['Tempaddresses']['state'];
			$address->zipcode = $_POST['Tempaddresses']['zipcode'];
			$address->phone = $_POST['Tempaddresses']['phone'];echo "sdf";
			if($addressse->save(false))
				echo "sucess";
			else
				echo "error";
		}
		if(!empty($id)) {
			$defaultShipping = Myclass::getDefaultShippingAddress($id);
			$criteria = new CDbCriteria;
			$criteria->addCondition("userId = '$id'");
			$count = Tempaddresses::model()->count($criteria);
			$pages = new CPagination($count);
			$pages->setPageSize(15);
			$pages->applyLimit($criteria);
			$criteria->order = 'shippingaddressId DESC';
			$address  = Tempaddresses::model()->findAll($criteria);
			$this->render('shippingaddress',compact('address','pages','defaultShipping','user','follower','followerIds','countriesList'));
		}
	}

	public function actionDefault($id,$userid)
	{
		$default = Users::model()->findByPk($userid);
		$default->defaultshipping = $id;
		$default->save(false);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}

	public function actionCancelorder($id)
	{
		$orderdata = Orders::model()->findByPk($id);
		$orderdata->status = "cancelled";
		$orderdata->trackPayment = "pending";
		$orderdata->save(false);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}

	public function actionMessage($id = ""){
		$userId = Yii::app()->user->id;
		$userDetails = Myclass::getUserDetails(Yii::app()->user->id);


		if(!empty($id)) {
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];
			$chatCriteria = new CDbCriteria;
			$chatCriteria->condition = "user1 = '$userId' AND user2 = '$id' OR user1 = '$id' AND user2 = '$userId'";
			$chat = Chats::model()->find($chatCriteria);
			if(empty($chat)) {
				$newChat = new Chats();
				$newChat->user1 = $userId;
				$newChat->user2 = $id;
				$newChat->lastContacted = time();
				$newChat->save(false);
				$messageChatId = $newChat->chatId;
			} else {
				$messageChatId = $chat->chatId;
			}
		}
		$criteria = new CDbCriteria;
		$criteria->condition = "user1 = '$userId' OR user2 = '$userId' order by lastContacted DESC";
		$chatedUsers = Chats::model()->findAll($criteria);

		$firstChat = "";
		$currentChatUser = $id;
		$firstLastReadCheck = 0;
		$chattingUsers = array();
		if (count($chatedUsers) > 0){
			$lastMessages = array();
			foreach ($chatedUsers as $chatedUser){
				$chatUserkkey = 0;
				$firstLastReadCheck = 0;
				if ($chatedUser->user1 != $userId){
					$chattingUsers[] = $chatedUser->user1;
					$lastMessages[$chatedUser->user1]['message'] = $chatedUser->lastMessage;
					$lastMessages[$chatedUser->user1]['time'] = $chatedUser->lastContacted;
					//$currentChatUser = $currentChatUser == '' ? $chatedUser->user1 : $currentChatUser;
					if ($currentChatUser == ""){
						$currentChatUser = $chatedUser->user1;
						$firstChat = $chatedUser->chatId;
						$firstLastReadCheck = 1;
					}elseif ($currentChatUser == $chatedUser->user1){
						$firstChat = $chatedUser->chatId;
						$firstLastReadCheck = 1;
					}
					$chatUserkkey = $chatedUser->user1;
				}elseif($chatedUser->user2 != $userId){
					$chattingUsers[] = $chatedUser->user2;
					$lastMessages[$chatedUser->user2]['message'] = $chatedUser->lastMessage;
					$lastMessages[$chatedUser->user2]['time'] = $chatedUser->lastContacted;
					//$currentChatUser = $currentChatUser == '' ? $chatedUser->user2 : $currentChatUser;
					if ($currentChatUser == ""){
						$currentChatUser = $chatedUser->user2;
						$firstChat = $chatedUser->chatId;
						$firstLastReadCheck = 1;
					}elseif ($currentChatUser == $chatedUser->user2){
						$firstChat = $chatedUser->chatId;
						$firstLastReadCheck = 1;
					}
					$chatUserkkey = $chatedUser->user2;
				}
				if($chatedUser->lastToRead == $userId && $firstLastReadCheck != 1){
					$lastMessages[$chatUserkkey]['messaggeMarker'] = '<div class="message-unread-count"></div>';//"<i class='fa fa-circle green-dot'></i>";
					$lastMessages[$chatUserkkey]['messaggeReplyMarker'] = "";
				}elseif($chatedUser->lastToRead != 0 && $firstLastReadCheck != 1){
					$lastMessages[$chatUserkkey]['messaggeReplyMarker'] = '<img alt="send-icon" src="'.Yii::app()->createAbsoluteUrl('images/reply.png').'">';//"<i class='fa fa-mail-reply'></i>";
					$lastMessages[$chatUserkkey]['messaggeMarker'] = "";
				}else{
					$lastMessages[$chatUserkkey]['messaggeMarker'] = "";
					$lastMessages[$chatUserkkey]['messaggeReplyMarker'] = "";
				}
				//$firstChat = $firstChat == '' ? $chatedUser->chatId : $firstChat;
			}
			$firstChatModel = Chats::model()->findByPk($firstChat);
			if($firstChatModel->lastToRead != 0 && $firstChatModel->lastToRead == $userId){
				$firstChatModel->lastToRead = 0;
				$firstChatModel->save(false);
			}

			$chatUserModel = Users::model()->findAllByAttributes(array('userId'=>$chattingUsers));
			foreach ($chatUserModel as $chatModel){
				$chatUser[$chatModel->userId] = $chatModel;
			}

			$criteria = new CDbCriteria;
			$criteria->condition = "chatId = '$firstChat' AND messageType NOT LIKE 'exchange'";
			$messageModel = Messages::model()->findAll($criteria);
			
			//$messageModel = Messages::model()->findAllByAttributes(array('chatId'=>$firstChat,
			//		'messageType NOTLIKE'=>'exchange'));
			$messageChatId = $firstChat;
			$currentChatUserImage = $chatUser[$currentChatUser]->userImage;
			if(!empty($currentChatUserImage)) {
				//$currentChatUserImage = CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/'.$currentChatUserImage),$chatUser[$currentChatUser]->username);
				$currentChatUserImage = Yii::app()->createAbsoluteUrl('user/resized/75/'.$currentChatUserImage);
			} else {
				//$currentChatUserImage = CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/default/'.Myclass::getDefaultUser()),$chatUser[$currentChatUser]->username);
				$currentChatUserImage = Yii::app()->createAbsoluteUrl('user/resized/75/default/'.Myclass::getDefaultUser());
			}
			if(!empty($userDetails->userImage)) {
				//$currentUserImage = CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/'.$userDetails->userImage),$userDetails->username);
				$currentUserImage = Yii::app()->createAbsoluteUrl('user/resized/75/'.$userDetails->userImage);
			} else {
				//$currentUserImage = CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/default/'.Myclass::getDefaultUser()),$userDetails->username);
				$currentUserImage = Yii::app()->createAbsoluteUrl('user/resized/75/default/'.Myclass::getDefaultUser());
			}
			//echo "<pre>";print_r($chattingUsers);print_r($messageModel);die;
			if(Yii::app()->request->isAjaxRequest) {
				$this->renderPartial('message',array('currentUserDetails'=>$userDetails, 'chattingUsers'=>$chattingUsers,
						'chatUser'=>$chatUser, 'messageModel'=>$messageModel, 'lastMessages'=>$lastMessages,
						'currentChatUser'=>$currentChatUser, 'currentChatUserImage'=>$currentChatUserImage,
						'currentUserImage'=>$currentUserImage,'messageChatId' => $messageChatId, 'ajaxChat' => 1));
			}else{
				$this->render('message',array('currentUserDetails'=>$userDetails, 'chattingUsers'=>$chattingUsers,
					'chatUser'=>$chatUser, 'messageModel'=>$messageModel, 'lastMessages'=>$lastMessages,
					'currentChatUser'=>$currentChatUser, 'currentChatUserImage'=>$currentChatUserImage, 
					'currentUserImage'=>$currentUserImage,'messageChatId' => $messageChatId, 'ajaxChat' => 0));
			}
		}else{
			$this->render('message',array('currentUserDetails'=>$userDetails,
					'chattingUsers'=>$chattingUsers));
		}
	}
	
	public function actionUpdatechat(){
		if(isset($_POST)){
			if($_POST['type'] == 'getcount'){
				$userName = $_POST['userName'];
				$userDetails = Users::model()->findByAttributes(array('username'=>$userName));
				if(!empty($userDetails)){
					$userId = $userDetails->userId;
					$messageCount = Myclass::getMessageCount($userId);
					echo $messageCount;
				}else{
					echo 0;
				}
			}elseif($_POST['type'] == 'markread'){
				$senderDetails = Users::model()->findByAttributes(array('username'=>$_POST['sender']));
				$receiverDetails = Users::model()->findByAttributes(array('username'=>$_POST['receiver']));
				if(!empty($senderDetails) && !empty($receiverDetails)){
					$senderId = $senderDetails->userId;
					$receiverId = $receiverDetails->userId;
					
					$criteria = new CDbCriteria;
					$criteria->condition = "(user1 = '$senderId' AND user2 = '$receiverId') OR (user1 = '$receiverId' AND user2 = '$senderId')";
					
					$chatModel = Chats::model()->find($criteria);
					
					if (!empty($chatModel)){
						$chatModel->lastToRead = 0;
						$chatModel->save();
					}
				}
				echo 0;
			}
		}
	}

	public function actionPostmessage(){
		if (isset($_POST)){
			$message = $_POST['message'];
			$senderId = $_POST['senderId'];
			$messageType = $_POST['messageType'];
			$sourceId = isset($_POST['sourceId']) && $_POST['sourceId'] != "" ? $_POST['sourceId'] : 0;
			$chatId = $_POST['chatId'];
			$timeUpdate = time();
			
			$p = new CHtmlPurifier();
			$message = $p->purify($message);
			
			if ($message != ""){
			
				$messageModel = new Messages();
				$messageModel->message = $message;
				$messageModel->messageType = $messageType;
				$messageModel->senderId = $senderId;
				$messageModel->sourceId = $sourceId;
				$messageModel->chatId = $chatId;
				$messageModel->createdDate = $timeUpdate;
				$messageModel->save();
	
				if($sourceId == 0){
					$chatModel = Chats::model()->findByPk($chatId);
	
					$chatModel->lastContacted = $timeUpdate;
					if ($chatModel->user1 == $senderId){
						$chatModel->lastToRead = $chatModel->user2;
					}else{
						$chatModel->lastToRead = $chatModel->user1;
					}
					$chatModel->lastMessage = $message;
					$chatModel->save();
				}
	
				$userImage = Myclass::getUserDetails($senderId);
				$outputData = array();
				if(!empty($userImage->userImage)) {
					//$userImage = CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/'.$userImage->userImage),$userImage->username);
					$outputData['userName'] = $userImage->username;
					$outputData['userImage'] = Yii::app()->createAbsoluteUrl('user/resized/75/'.$userImage->userImage);
				} else {
					//$userImage = CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/default/'.Myclass::getDefaultUser()),$userImage->username);
					$outputData['userName'] = $userImage->username;
					$outputData['userImage'] = Yii::app()->createAbsoluteUrl('user/resized/75/default/'.Myclass::getDefaultUser());
				}
				$outputData['chatURL'] = Yii::app()->baseUrl."/message/".Myclass::safe_b64encode($userImage->userId.'-0');
				$outputData['chatTime'] = date('M jS Y', $timeUpdate);
				$outputData['message'] = $message;
				/* echo '<div class="chat-grid-userimage">'.$userImage.'</div><div class="chat-grid-details">
				 <p class="chat-grid-msgs">'.$message.'</p><p class="chat-grid-time">'.date('M jS Y', $timeUpdate).'</p>
				 </div>'; */
				
				$userid = $chatModel->lastToRead;
				$criteria = new CDbCriteria;
				$criteria->addCondition('user_id = "'.$userid.'"');
				$userdevicedet = Userdevices::model()->findAll($criteria);
			
				if(count($userdevicedet) > 0){
					foreach($userdevicedet as $userdevice){
					$deviceToken = $userdevice->deviceToken;
					$badge = $userdevice->badge;
					$badge +=1;
					$userdevice->badge = $badge;
					$userdevice->deviceToken = $deviceToken;
					$userdevice->save(false);
					if(isset($deviceToken)){
						$messages = $userImage->name." : ".$message;
						Myclass::pushnot($deviceToken,$messages,$badge,"message");
					}
					}
				}
				
				echo json_encode($outputData);
				
			}else{
				echo "";
			}
		}
	}

	public function actionInitiatechat() {
		if (isset($_POST)){
			$message = $_POST['message'];
			$senderId = $_POST['sender'];
			$receiverId = $_POST['receiver'];
			$messageType = $_POST['messageType'];
			$sourceId = $_POST['sourceId'];
			$timeUpdate = time();

			$criteria = new CDbCriteria;
			$criteria->condition = "(user1 = '$senderId' AND user2 = '$receiverId') OR (user1 = '$receiverId' AND user2 = '$senderId')";

			$chatModel = Chats::model()->find($criteria);

			if (empty($chatModel)){
				$newChat = new Chats();
				$newChat->user1 = $senderId;
				$newChat->user2 = $receiverId;
				$newChat->lastMessage = $message;
				$newChat->lastToRead = $receiverId;
				$newChat->lastContacted = $timeUpdate;

				$newChat->save();

				

				$criteria = new CDbCriteria;
				$criteria->condition = "(user1 = '$senderId' AND user2 = '$receiverId') OR (user1 = '$receiverId' AND user2 = '$senderId')";
					
				$chatModel = Chats::model()->find($criteria);
			}
			$chatModel->lastContacted = $timeUpdate;
			if ($chatModel->user1 == $senderId){
				$chatModel->lastToRead = $chatModel->user2;
			}else{
				$chatModel->lastToRead = $chatModel->user1;
			}
			$chatModel->lastMessage = $message;
			$chatModel->save();

			$messageModel = new Messages();
			$messageModel->message = $message;
			$messageModel->messageType = $messageType;
			$messageModel->senderId = $senderId;
			$messageModel->sourceId = $sourceId;
			$messageModel->chatId = $chatModel->chatId;
			$messageModel->createdDate = $timeUpdate;
			$messageModel->save();


			$notifyMessage = 'Contacted you on your product';
			Myclass::addLogs("myoffer", $senderId, $receiverId, $sourceId, $sourceId, $notifyMessage);

			$userid = $receiverId;
			$sellerDetails = Myclass::getUserDetails($senderId);
			$criteria = new CDbCriteria;
			$criteria->addCondition('user_id = "'.$userid.'"');
			$userdevicedet = Userdevices::model()->findAll($criteria);
		
		
		if(count($userdevicedet) > 0){
			foreach($userdevicedet as $userdevice){
			$deviceToken = $userdevice->deviceToken;
			$badge = $userdevice->badge;
			$badge +=1;
			$userdevice->badge = $badge;
			$userdevice->deviceToken = $deviceToken;
			$userdevice->save(false);
			if(isset($deviceToken)){
				$messages = $sellerDetails->name." : ".$message;
				Myclass::pushnot($deviceToken,$messages,$badge,"message");
			}
			}
		}	

			echo "success";
		}else{
			echo "failed";
		}
	}
	public function actionOrders() {
		$userId = Yii::app()->user->id;
		$criteria = new CDbCriteria;
		$criteria->addCondition("userId = $userId");
		$criteria->order = "orderDate DESC";
		$count = Orders::model()->count($criteria);
		$pages = new CPagination($count);
		$pages->setPageSize(10);
		$pages->applyLimit($criteria);
		$orders = Orders::model()->with('orderitems','invoices')->findAll($criteria);

		$user = Yii::app()->user;
		if($user->isGuest) {
			$this->redirect(array('/user/login'));
			return false;
		}
		$id = Yii::app()->user->id;

		$user = Users::model()->findByPk($id);
		
		$userid = Yii::app()->user->id;
		if(!empty($userid)){
		$followCriteria = new CDbCriteria;
		$followCriteria->addCondition("userId = $userid");
		$follower = Followers::model()->findAll($followCriteria);
		//echo "<pre>";print_r($follower);die;
		$followerIds = array();
		if(!empty($follower)) {		            
			foreach($follower as $follower):
			$followerIds[] = $follower->follow_userId;
			endforeach;
		}          
		}  			

		$criteria = new CDbCriteria;
		$criteria->addCondition("countryId != 0");
		$countryModel = Country::model()->findAll($criteria);

		foreach ($countryModel as $country){
			$combineCode = $country->countryId.'-'.$country->country;
			$countriesList[$combineCode] = $country->country;
		}

		if(Yii::app()->request->isAjaxRequest) {
			$pages = new CPagination($count);
			$pages->setPageSize(10);
			$pages->applyLimit($criteria);
			$this->renderPartial('orders',array(
			'orders'=>$orders,'pages' => $pages,
			'user' => $user,'follower' => $follower,
			'followerIds' => $followerIds, 'countriesList' => $countriesList
			));
		} else {
			$this->render('orders',array(
			'orders'=>$orders,'pages' => $pages,
			'user' => $user,'follower' => $follower,
			'followerIds' => $followerIds, 'countriesList' => $countriesList
			));
		}
	}

	public function actionSales() {
		$userId = Yii::app()->user->id;
		$criteria = new CDbCriteria;
		$criteria->addCondition("sellerId = $userId");
		$criteria->order = "orderDate DESC";
		$count = Orders::model()->count($criteria);
		$pages = new CPagination($count);
		$pages->setPageSize(10);
		$pages->applyLimit($criteria);
		$sales = Orders::model()->with('orderitems','user')->findAll($criteria);
		$tracking = new Trackingdetails;

		$user = Yii::app()->user;
		if($user->isGuest) {
			$this->redirect(array('/user/login'));
			return false;
		}
		$id = Yii::app()->user->id;

		$user = Users::model()->findByPk($id);
		
		$userid = Yii::app()->user->id;
		if(!empty($userid)){
		$followCriteria = new CDbCriteria;
		$followCriteria->addCondition("userId = $userid");
		$follower = Followers::model()->findAll($followCriteria);
		//echo "<pre>";print_r($follower);die;
		$followerIds = array();
		if(!empty($follower)) {		            
			foreach($follower as $follower):
			$followerIds[] = $follower->follow_userId;
			endforeach;
		}          
		}  			

		$criteria = new CDbCriteria;
		$criteria->addCondition("countryId != 0");
		$countryModel = Country::model()->findAll($criteria);

		foreach ($countryModel as $country){
			$combineCode = $country->countryId.'-'.$country->country;
			$countriesList[$combineCode] = $country->country;
		}

		if(Yii::app()->request->isAjaxRequest) {
			$pages = new CPagination($count);
			$pages->setPageSize(10);
			$pages->applyLimit($criteria);
			$this->renderPartial('sales',array(
			'sales'=>$sales,'pages' => $pages,'tracking' => $tracking,'user' => $user,'follower' => $follower,'followerIds'=> $followerIds,
			'countriesList' => $countriesList
			));
		} else {
			$this->render('sales',array(
			'sales'=>$sales,'pages' => $pages,'tracking' => $tracking,'user' => $user,'follower' => $follower,'followerIds'=> $followerIds,
			'countriesList' => $countriesList
			));
		}
	}

	public function actionChangestatus() {
		if(isset($_POST['orderId'])) {
			$order = Orders::model()->findByPk($_POST['orderId']);
			
			if($order->status == 'shipped' && $_POST['status']  == 'processing') {
				Yii::app()->user->setFlash('warning',Yii::t('app','Product has already been Shipped.'));
				$this->redirect(array('sales'));
			}
			
			if(!empty($order)) {
				if(isset($_POST['status'])) {
					$order->status = $_POST['status'];
					if($_POST['status'] == 'delivered'){
						$order->statusDate = time();
						$order->reviewFlag = 1;	
					}
					$order->save(false);
					
						$userid = $order->userId;
						$criteria = new CDbCriteria;
						$criteria->addCondition('user_id = "'.$userid.'"');
						$userdevicedet = Userdevices::model()->findAll($criteria);
						if(count($userdevicedet) > 0){
							foreach($userdevicedet as $userdevice){
						$deviceToken = $userdevice->deviceToken;
						$badge = $userdevice->badge;
						$badge +=1;
						$userdevice->badge = $badge;
						$userdevice->deviceToken = $deviceToken;
						$userdevice->save(false);
						if(isset($deviceToken)){
							$messages ='Your orderid: '.$_POST['orderId'].' has been marked as '.$_POST['status'];
							Myclass::pushnot($deviceToken,$messages,$badge);
						}		
						}
						}
					
				}
			}
		}
	}

	public function actionClaimorder()
	{
		$orderid = $_POST['orderid'];
		$order = Orders::model()->findByPk($orderid);
		$order->status = "claimed";
		$order->save(false);
	}

	public function actionVieworders($id)
	{
		$dec = Myclass::safe_b64decode($id);
		$spl = explode('-',$dec);
		$id = $spl[0];
		if(count($spl) <= 1){
			$this->redirect(array('orders'));
		}
		$model = Orders::model()->with('user','orderitems')->findByPk($id);
		$trackingDetails = Trackingdetails::model()->findByAttributes(array("orderid" => $id));
		$shipping = Shippingaddresses::model()->findByPk($model->shippingAddress);
		$this->renderPartial('vieworders',array(
			'model'=>$model,'shipping' => $shipping,'trackingDetails' => $trackingDetails
		));
	}

	public function actionViewsales($id)
	{
		$this->layout = "ajax";
		$dec = Myclass::safe_b64decode($id);
		$spl = explode('-',$dec);
		$id = $spl[0];
		if(count($spl) <= 1){
			$this->redirect(array('orders'));
		}
		$model = Orders::model()->with('user','orderitems')->findByPk($id);
		$trackingDetails = Trackingdetails::model()->findByAttributes(array("orderid" => $id));
		$tracking = new Trackingdetails;
		$shipping = Shippingaddresses::model()->findByPk($model->shippingAddress);
		$this->renderPartial('viewsales',array(
			'model'=>$model,'shipping' => $shipping,'trackingDetails' => $trackingDetails,'tracking' => $tracking
		), false, true);
	}	

	public function actionShippingconfirm($id) {
		$dec = Myclass::safe_b64decode($id);
		$spl = explode('-',$dec);
		$id = $spl[0];
		if(count($spl) <= 1){
			$this->redirect(array('sales'));
		}
		$model = Orders::model()->with('user','orderitems')->findByPk($id);
		
		if($model->status == 'delivered') {
			Yii::app()->user->setFlash('warning',Yii::t('app','Product has already been delivered.'));
			$this->redirect(array('sales'));
		}
		
		$shipping = Shippingaddresses::model()->findByPk($model->shippingAddress);
		$seller = Myclass::getUserDetails($model->sellerId);
		$siteSettings = Sitesettings::model()->find();
		$userModel = $model['user'];
		$sellerId = $model->sellerId;
		if(isset($_POST['subject']) && isset($_POST['message'])) {
			$subject = $_POST['subject'];
			$message = $_POST['message'];
			$model->status = 'shipped';
			if($model->save(false)) {
				$mail = new YiiMailer();
				if($siteSettings->smtpEnable == 1) {
					//$mail->IsSMTP();                         // Set mailer to use SMTP
					$mail->Mailer = 'smtp';                         // Set mailer to use SMTP
					$mail->Host = $siteSettings->smtpHost; //'smtp.gmail.com';  // Specify main and backup server
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = $siteSettings->smtpEmail;                            // SMTP username
					$mail->Password = $siteSettings->smtpPassword;                           // SMTP password
					$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
					$mail->Port =$siteSettings->smtpPort; // 465;
				}
					
				$mail->setView('shippingintimation');
				$mail->setData(array('subject' => $subject,'siteSettings' => $siteSettings, 'message' => $message,'tempShippingModel' => $shipping,'userModel' => $userModel,'orderId' => $model->orderId,'sellerName' => $seller->name,'sellerId' => $sellerId));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($model['user']['email']);
				$mail->setSubject(Myclass::getSiteName().' Shipping Confirmation Mail');
					
						$userid = $userModel->userId;
						$criteria = new CDbCriteria;
						$criteria->addCondition('user_id = "'.$userid.'"');
						$userdevicedet = Userdevices::model()->findAll($criteria);
						if(count($userdevicedet) > 0){
						foreach($userdevicedet as $userdevice){
						$deviceToken = $userdevice->deviceToken;
						$badge = $userdevice->badge;
						$badge +=1;
						$userdevice->badge = $badge;
						$userdevice->deviceToken = $deviceToken;
						$userdevice->save(false);
						if(isset($deviceToken)){
							$messages = 'Your orderid: '.$id.' has been marked as Shipped';
							Myclass::pushnot($deviceToken,$messages,$badge);
						}	
						}
						}		
				
				if ($mail->send()) {
					$this->redirect(array('sales'));
				} else {
					echo $mail->getError();die;
				}
			}
		}
		$this->render('shippingconfirm',array(
			'model'=>$model,'shipping' => $shipping
		));
	}

	public function actionGetInvoiceData() {
		if(isset($_POST['invoiceId'])) {
			$invoiceData = Orders::model()->with('orderitems','user','invoices')->findByPk($_POST['invoiceId']);
			$shipping = Shippingaddresses::model()->findByPk($invoiceData->shippingAddress);
			$this->renderPartial('viewinvoice',compact('invoiceData','shipping'),false,true);
		}
	}

	public function actionEdit_tracking_details()
	{
		$id = $_POST['orderid'];
		$tracking = Trackingdetails::model()->findByAttributes(array("orderid" => $id));
		$trackingdetail['orderid'] = $tracking->orderid;
		$trackingdetail['shippingdate'] = date('m/d/Y',$tracking->shippingdate);
		$trackingdetail['couriername'] = $tracking->couriername;
		$trackingdetail['courierservice'] = $tracking->courierservice;
		$trackingdetail['trackingid'] = $tracking->trackingid;
		$trackingdetail['notes'] = $tracking->notes;
		print_r(json_encode($trackingdetail));
	}

	public function actionTracking($id) {

		$dec = Myclass::safe_b64decode($id);
		$spl = explode('-',$dec);
		$id = $spl[0];
		if(count($spl) <= 1){
			$this->redirect(array('sales'));
		}
		if($id == "")
		{
			$id = $_POST['Trackingdetails']['orderid'];
		}
		$model = Orders::model()->with('orderitems','user')->findByPk($id);
		if($model->status == 'delivered') {
			Yii::app()->user->setFlash('warning',Yii::t('app','Product has already been delivered.'));
			$this->redirect(array('sales'));
		}

		$seller = Myclass::getUserDetails($model->sellerId);
		$siteSettings = Sitesettings::model()->find();
		$userModel = $model['user'];
		$shipping = Shippingaddresses::model()->findByPk($model->shippingAddress);

		$check = Trackingdetails::model()->findAllByAttributes(array("orderid" => $id));

		if(empty($check)) {
			$tracking = new Trackingdetails;
		} else {
			$tracking = Trackingdetails::model()->findByAttributes(array("orderid" => $id));
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='trackingdetails-form')
		{
			echo CActiveForm::validate($tracking);
			Yii::app()->end();
		}

		if(isset($_POST['Trackingdetails']))
		{
			$tracking->attributes = $_POST['Trackingdetails'];
			$tracking->buyeraddress = $_POST['Trackingdetails']['buyeraddress'];
			$date = new DateTime($_POST['Trackingdetails']['shippingdate']);
			$tracking->shippingdate = $date->getTimeStamp();
			if($model->status != 'delivered') {
				if($tracking->validate()) {
					$tracking->save(false);
					$model->status = 'shipped';
					$siteSettings = Sitesettings::model()->find();
					if($model->save(false)) {
						$mail = new YiiMailer();
						if($siteSettings->smtpEnable == 1) {
							//$mail->IsSMTP();                         // Set mailer to use SMTP
							$mail->Mailer = 'smtp';                         // Set mailer to use SMTP
							$mail->Host = $siteSettings->smtpHost;'smtp.gmail.com';  // Specify main and backup server
							$mail->SMTPAuth = true;                               // Enable SMTP authentication
							$mail->Username = $siteSettings->smtpEmail;                            // SMTP username
							$mail->Password = $siteSettings->smtpPassword;                           // SMTP password
							$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
							$mail->Port = $siteSettings->smtpPort; //465;
						}

						$mail->setView('trackdetailsmail');
						$mail->setData(array('siteSettings' => $siteSettings, 
								'tempShippingModel' => $shipping,'userModel' => $userModel, 
								'sellerName' => $seller->name,'tracking'=>$tracking,'model'=>$model));
						$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
						$mail->setTo($model['user']['email']);
						$mail->setSubject(Myclass::getSiteName().' Tracking Details Mail');
						
						$userid = $userModel->userId;
						$criteria = new CDbCriteria;
						$criteria->addCondition('user_id = "'.$userid.'"');
						$userdevicedet = Userdevices::model()->findAll($criteria);
						if(count($userdevicedet) > 0){
						foreach($userdevicedet as $userdevice){
						$deviceToken = $userdevice->deviceToken;
						$badge = $userdevice->badge;
						$badge +=1;
						$userdevice->badge = $badge;
						$userdevice->deviceToken = $deviceToken;
						$userdevice->save(false);
						if(isset($deviceToken)){
							$messages = 'Your orderid: '.$id.' has been updated with Tracking details';
							Myclass::pushnot($deviceToken,$messages,$badge);
						}	
						}
					}
									
						
						if ($mail->send()) {
							$this->redirect(array('sales'));
						} else {
							echo $mail->getError();die;
						}
					}
				}
				$this->redirect($_SERVER['HTTP_REFERER']);
			} else {
				Yii::app()->user->setFlash('warning',Yii::t('app','Product has already been delivered.'));
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}
		//$this->render('tracking',compact('model','shipping','tracking'));
	}

	public function actionCoupons($type) {
		$id = Yii::app()->user->id;
		$criteria = new CDbCriteria;
		$criteria->addCondition("sellerId = $id");
		if($type == 'item') {
			$criteria->addCondition("productId != 0");
		}
		if($type == 'general') {
			$criteria->addCondition("productId = 0");
		}
		
		$itemCriteria = new CDbCriteria;
		$itemCriteria->addCondition("userId = $id");
		$itemCriteria->addCondition("quantity > 0");
		$itemCount = Products::model()->count($itemCriteria);

		$count = Coupons::model()->count($criteria);
		$pages = new CPagination($count);
		$pages->setPageSize(10);
		$pages->applyLimit($criteria);
		$criteria->order = 'id DESC';
		$coupons = Coupons::model()->findAll($criteria);
		$model = new Coupons;

		if($type != 'item'){
			if($type!= 'general') {
				$this->redirect(array('coupons','type' => 'item'));
			}
		}
		$this->render('coupons',compact('coupons','pages','model','type','itemCount'));
	}
	public function actionAddcoupon() {
		$model = new Coupons();
		$model->setScenario('sellerProfile');
		if(isset($_POST['ajax']) && $_POST['ajax']==='coupon-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['Coupons'])){
			$model->attributes = $_POST['Coupons'];
			$model->status = 1;
			$model->couponCode = Myclass::getRandomString(8);
			if($model->save()) {
				Yii::app()->user->setFlash('success',"Coupon Code : ".$model->couponCode);
				$this->redirect(array('coupons','type' => 'general'));
			}
		}
		$this->renderPartial('addcoupon',compact('model'),false,true);
	}
	public function actionDisableCoupon($id) {
		$findCoupon = Coupons::model()->findByPk($id);
		$findCoupon->status = 0;
		$findCoupon->save(false);
		$this->redirect($_SERVER['HTTP_REFERER']);

	}
	
	public function actionHelp($details){
		if (!empty($details)){
			$helppageModel = Helppages::model()->findByAttributes(array('slug'=>$details));
			if (!empty($helppageModel)){
				$allhelppageModel = Helppages::model()->findAll();
				$this->render('help',compact('helppageModel','allhelppageModel'));
			}else{
				Yii::app()->user->setFlash('error',"Unable to Process our request");
				$this->redirect(array('/'));
			}
		}else{
			Yii::app()->user->setFlash('error',"Unable to Process our request");
			$this->redirect(array('/'));
		}
	}
	
	public function actionNotification(){
		$userId = Yii::app()->user->id;
		$model = Users::model()->findByPk($userId);
		$userCreatedDate = $model->createdDate;
		
		if($model->unreadNotification != 0){
			$model->unreadNotification = 0;
			$model->save(false);
		}
		
		$followersModel = Followers::model()->findAllByAttributes(array('userId'=>$userId));
		$followers = array();
		
		foreach ($followersModel as $follower){
			$followers[] = $follower->follow_userId;
		}
		
		$criteria = new CDbCriteria;
		$criteria->addInCondition('userid', $followers);
		$criteria->addCondition("type LIKE 'Add'", 'AND');
		$criteria->addCondition("notifyto = $userId", 'OR');
		$criteria->addCondition("type LIKE 'Admin'", 'OR');
		$criteria->addCondition("createddate >= $userCreatedDate", 'AND');
		$criteria->order = "id DESC";
		$criteria->limit = 32;
		
		$logModel = Logs::model()->findAll($criteria);
		
		/* $logModel = Logs::model()->findAllBySql("SELECT * FROM hts_logs L
				LEFT OUTER JOIN hts_followers F ON (F.userId='$userId' AND F.follow_userId=L.userid) WHERE (L.notifyto = '$userId')
				");
//				WHERE L.notifyto != '0'"); */
		
		//echo "<pre>";print_r($logModel);die;
		$this->render('notification',array('logModel'=>$logModel, 'model'=>$model));
	}
	
	public function actionNotificationloadmore(){
		$userId = Yii::app()->user->id;
		$model = Users::model()->findByPk($userId);
		$userCreatedDate = $model->createdDate;
		
		$followersModel = Followers::model()->findAllByAttributes(array('userId'=>$userId));
		$followers = array();
		
		foreach ($followersModel as $follower){
			$followers[] = $follower->follow_userId;
		}
		
		$criteria = new CDbCriteria;
		$criteria->addInCondition('userid', $followers);
		$criteria->addCondition("type LIKE 'Add'", 'AND');
		$criteria->addCondition("notifyto = $userId", 'OR');
		$criteria->addCondition("type LIKE 'Admin'", 'OR');
		$criteria->addCondition("createddate >= $userCreatedDate", 'AND');
		$criteria->order = "id DESC";
		$criteria->limit = $_GET['notifyLimit'];
		$criteria->offset = $_GET['notifyOffset'];
		
		$logModel = Logs::model()->findAll($criteria);
		
		if(!empty($logModel)){
			$this->renderPartial('notificationloadmore',array('logModel'=>$logModel));
		}else{
			echo 0;
		}
	}
}