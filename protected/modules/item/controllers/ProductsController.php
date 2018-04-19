<?php

class ProductsController extends Controller
{
	const FIXED = 1;
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
		//'postOnly + delete', // we only allow deletion via POST request
		);
	}

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
		$allowedActions = array('view','resized','loadresults','myoffer',
			'promotionipnprocess','productproperty');

		$user = Yii::app()->user;
		if($user->isGuest && !in_array(Yii::app()->controller->action->id, $allowedActions)) {
			$this->redirect(array('/login'));
			return false;
		}
		if(Yii::app()->controller->action->id == 'update') {
			$userId = Yii::app()->user->id;
			$productId = Yii::app()->request->getParam('id');
			$dec = Myclass::safe_b64decode($productId);
			$spl = explode('-',$dec);
			$id = $spl[0];
		    $productRecord = Products::model()->findByPk($id);
		    if($productRecord->userId != $userId) {
		    	Yii::app()->user->setFlash('success',Yii::t('app',"You don't have access to edit this product."));
		    	$this->redirect('/');
		    	return false;
		    }
			
		}

		return true;
	}

	public function actions()
	{
		return array(
			'resized' => array(
				'class'   => 'ext.resizer.ResizerAction',
				'options' => array(
		// Tmp dir to store cached resized images
					'cache_dir'   => Yii::getPathOfAlias('webroot') . '/assets/resized/',

		// Web root dir to search images from
					'base_dir'    => Yii::getPathOfAlias('webroot') . '/media/item/',
		)
		),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionReportitem(){
		$id = Yii::app()->user->id;
		if (isset($_GET['itemid']) && isset($_GET['userid'])){
		$itemid = $_GET['itemid'];
		$userid = $_GET['userid'];
		$itemModel = $this->loadModel($itemid);
		if (!empty($itemModel->reports)){
			$reportFlag = json_decode($itemModel->reports,true);
			$reportFlag[] = $id;
			$itemModel->reports = json_encode($reportFlag);
			$itemModel->productId = $itemid;
		}else{
			$reportFlag[] = $id;
			$itemModel->reports = json_encode($reportFlag);
			$itemModel->productId = $itemid;
		}
		$itemModel->reportCount += 1; 
		$itemModel->save(false);
		echo true;
		}
	}
	public function actionUndoreportitem(){
		$id = Yii::app()->user->id;
		if (isset($_GET['itemid']) && isset($_GET['userid'])){
			$itemid = $_GET['itemid'];
			$userid = $_GET['userid'];
			$itemModel = $this->loadModel($itemid);
			if (!empty($itemModel->reports)){
				$reportFlag = json_decode($itemModel->reports,true);
				$newreportflag = array();
				foreach ($reportFlag as $flag){
					if ($flag != $id){
						$newreportflag[] = $flag;
					}
				}
				if (!empty($newreportflag)){
					$itemModel->reports = json_encode($newreportflag);
					$itemModel->productId = $itemid;
				}else{
					$itemModel->reports = '';
					$itemModel->productId = $itemid;
				}
			}
			$itemModel->reportCount -= 1;
			$itemModel->save(false);
			echo true;
		}
	}
	public function actionView($id)
	{
		$dec = Myclass::safe_b64decode($id);
		$spl = explode('-',$dec);
		$id = $spl[0];
		
		unset($_SESSION['deletefile'][$id]);

		$itemModel = $this->loadModel($id);
		$itemModel->views++;
		$itemModel->save(false);
		$this->fbtitle = $itemModel->name;
		$this->fbimg = $itemModel->name;
		$this->fbdescription = $itemModel->description;
		$fbtitle = $itemModel->name;
		$photoModel = $itemModel->photos;
		//$commentModel = $itemModel->comments;
		
		$categoryModel = $itemModel->category0;
		$subcategoryModel = $itemModel->subCategory0;
		$userId = $itemModel->userId;

		$condition = new CDbCriteria;
		$condition->addCondition('productId = "'.$id.'"');
		$condition->order = '`commentId` DESC';
		$commentModel = Comments::model()->findAll($condition);
		//echo "<pre>"; print_r($commentModel); die;
		$checkCondition = new CDbCriteria;
		$checkCondition->addCondition('userId = "'.$userId.'"');
		$totalItem = Products::model()->findAll($checkCondition);
		
		$followingCondition = new CDbCriteria;
		$followingCondition->addCondition('userId = "'.$userId.'"');
		$followings = Followers::model()->findAll($followingCondition);
	
		$followerCondition = new CDbCriteria;
		$followerCondition->addCondition('follow_userId = "'.$userId.'"');
		$followers = Followers::model()->findAll($followerCondition);

		$loguser = Yii::app()->user->id;
		$followCondition = new CDbCriteria;
		$followCondition->addCondition('userId = "'.$loguser.'"');
		$followCondition->addCondition('follow_userId = "'.$userId.'"');
		$checkFollow = Followers::model()->findAll($followCondition);
		//echo "<pre>"; print_r($checkFollow); die;

		$popularaddcondition = new CDbCriteria;
//		$popularaddcondition->addCondition('userId = "'.$userId.'"');
		$popularaddcondition->addCondition('promotionType = "1"');
		$popularaddcondition->addCondition("productId != '$id'");
		$popularaddcondition->order = 'RAND()';
		$popularadditems = Products::model()->findAll($popularaddcondition);
		$count_popularadditems = count($popularadditems);
		
		$popularcondition = new CDbCriteria;
//		$popularcondition->addCondition('userId = "'.$userId.'"');
		$popularcondition->addCondition('promotionType != "1"');
		$popularcondition->addCondition("productId != '$id'");
		$popularcondition->order = '`likes` DESC';
		$popularcondition->limit = '4';
		$popularitems = Products::model()->findAll($popularcondition);
		$recentlyprodcts = array();
		if($loguser) {
			$userCondition = new CDbCriteria;
			$userCondition->addCondition('userId = "'.$loguser.'"');
			$curruserdetails = Users::model()->find($userCondition);
			$loguserdetails = Users::model()->find($userCondition);
			if(empty($loguserdetails->recently_view_product)) {
				$prodctdata[] = $id;
				$prodctdetl = json_encode($prodctdata); 
				$loguserdetails->recently_view_product = $prodctdetl;
				$loguserdetails->save(false);
			} else {
				$product_exists = json_decode($loguserdetails->recently_view_product,true);
				if(!in_array($id,$product_exists)) {
					$new_product[] = $id;
					$real_products = array_merge($new_product,$product_exists);
					$prodctdata = array_slice($real_products,0,5);
					$prodctdetl = json_encode($prodctdata);
					$loguserdetails->recently_view_product = $prodctdetl;
					$loguserdetails->save(false);
				}
			}
			$prodctIds = json_decode($curruserdetails->recently_view_product,true);
			$product_ids = array_diff($prodctIds,[$id]);
			$recentlyCondition = new CDbCriteria;
			$recentlyprodcts = Products::model()->findAllByAttributes(array('productId'=>$product_ids),array('limit'=>'4'));
		}

		$userModel = $itemModel->user;
		//echo "<pre>"; print_r($recentlyprodcts); die;
		//echo RAND(1,2); echo "<pre>"; echo RAND(3,4); die;
		$fav = array();
		$ownItems = array();
		$user = "";
		if(!Yii::app()->user->isGuest) {
			$user = Yii::app()->user->id;
			$fav = Favorites::model()->find("userId = $user AND productId = $id");

			$criteria = new CDbCriteria;
			$criteria->addCondition("userId = $user");
			$criteria->addCondition("`quantity` > 0");
			$criteria->addCondition("`soldItem` = 0");
			$criteria->order = '`t`.`productId` DESC';
			$criteria->select = 't.productId,t.name,t.price,t.currency';
			$ownItems = Products::model()->with('photos')->findAll($criteria);
		}
		$sameUserCriteria = new CDbCriteria;
		$sameUserCriteria->addCondition("userId = $itemModel->userId");
		$sameUserCriteria->order = '`t`.`productId` DESC';
		$sameUserCriteria->select = 't.productId,t.name,t.price,t.currency,t.quantity,t.soldItem';
		$sameUserItems = Products::model()->with('photos')->findAll($sameUserCriteria);

		$offerModel = new MyOfferForm;
		
		$this->render('view',array(
				'model'=>$itemModel, 'photoModel'=>$photoModel, 'categoryModel'=>$categoryModel, 
				'subcategoryModel'=>$subcategoryModel, 'userModel'=>$userModel, 'ownItems' => $ownItems, 
				'commentModel'=>$commentModel, 'newcommentModel'=>new Comments(),'fav' => $fav,
				'offerModel' => $offerModel, 'sameUserItems' => $sameUserItems,'user' => $user,
				'itemCount' => count($totalItem), 'followingCount' => count($followings),
				'followerCount' => count($followers), 'checkFollow' => $checkFollow,
				'popularitems' => $popularitems, 'popularadditems' => $popularadditems,
				'count_popularadditems' => $count_popularadditems, 'recentlyprodcts' => $recentlyprodcts
		));
	}

	public function actionLoadresults($limit=null,$offset = null,$userId = null)
	{
		$criteria = new CDbCriteria;
		if(isset($userId)) {
			$user = $userId;
		} else {
			$user = Yii::app()->user->id;
		}
		if(isset($limit)) {
			$criteria->limit = $limit;
		}
		if(isset($offset)) {
			$criteria->offset = $offset;
		}
		$criteria->addCondition("userId = $user");

		$criteria->order = '`productId` DESC';
		$products = Products::model()->findAll($criteria);

		$this->renderPartial('loadresults',compact('products','limit'));
	}

	public function actionMyoffer() {
		$model = new MyOfferForm;

		if(isset($_POST)) {
			$offerRate = $_POST['offerRate'];
		 	$name = $_POST['name'];
			$email = $_POST['email'];
			$message = $_POST['message'];
			$phone = $_POST['phone'];
			$productId = $_POST['productId'];
			$sellerDetails = Myclass::getUserDetails($_POST['sellerId']);
			$sellerEmail = $sellerDetails->email;
			$sellerName = $sellerDetails->name;
			//$userModel = Myclass::getUserDetails($_POST['buyerId']);
			$siteSettings = Sitesettings::model()->find();
			$productModel = Products::model()->findByPk($productId);
			$productURL = Yii::app()->createAbsoluteUrl('item/products/view',array(
					'id' => Myclass::safe_b64encode($productModel->productId.'-'.rand(0,999)))).'/'.
					Myclass::productSlug($productModel->name);
			
			if(!Yii::app()->user->isGuest) {
				$senderId = Yii::app()->user->id;
				$receiverId = $_POST['sellerId'];
				$timeUpdate = time();
				$criteria = new CDbCriteria;
				$criteria->condition = "(user1 = '$senderId' AND user2 = '$receiverId') OR (user1 = '$receiverId' AND user2 = '$senderId')";
				
				$chatModel = Chats::model()->find($criteria);
				
				if (empty($chatModel)){
					$senderDetails = Myclass::getUserDetails($senderId);
					$newChat = new Chats();
					$newChat->user1 = $senderId;
					$newChat->user2 = $receiverId;
					$newChat->lastMessage = "Offer from".$senderDetails->name;
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
				
				$offerMessage['message'] = $message;
				$offerMessage['price'] = $offerRate;
				$offerMessage['currency'] = $productModel->currency;
				$offerMessage = json_encode($offerMessage);
				
				$messageModel = new Messages();
				$messageModel->message = $offerMessage;
				$messageModel->messageType = "offer";
				$messageModel->senderId = $senderId;
				$messageModel->sourceId = $productId;
				$messageModel->chatId = $chatModel->chatId;
				$messageModel->createdDate = $timeUpdate;
				$messageModel->save();
				
				$notifyMessage = 'Sent offer Request '.$productModel->currency.$offerRate.' on your product';
				Myclass::addLogs("myoffer", $senderId, $receiverId, 0, $productId, $notifyMessage);
			}
			
			$mail = new YiiMailer();
			if($siteSettings->smtpEnable == 1) {
				//$mail->IsSMTP();                         // Set mailer to use SMTP
				$mail->Mailer = 'smtp';                         // Set mailer to use SMTP
				$mail->Host = $siteSettings->smtpHost;  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = $siteSettings->smtpEmail;                            // SMTP username
				$mail->Password = $siteSettings->smtpPassword;                           // SMTP password
				$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
				$mail->Port = $siteSettings->smtpPort;
			}
			$mail->setView('myofferintimation');
			$mail->setData(array('name' => $name, 'email' => $email,'phone' => $phone, 
					'offerRate' => $offerRate, 'message'=> $message, 'sellerName' => $sellerName,
				'siteSettings' => $siteSettings,'currency' => $_POST['currency'], 'productURL'=>$productURL));
			$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
			$mail->setTo($sellerEmail);
			$mail->setSubject($siteSettings->sitename.' Offer Intimation Mail');
		 	$userid = $_POST['sellerId'];
			$criteria = new CDbCriteria;
			$criteria->addCondition('user_id = "'.$userid.'"');
			$userdevicedet = Userdevices::model()->findAll($criteria);
			$userdata = Users::model()->findByPk($senderId);
			$currentusername = $userdata->name;
			if(count($userdevicedet) > 0){
				foreach($userdevicedet as $userdevice){
					$deviceToken = $userdevice->deviceToken;
					$badge = $userdevice->badge;
					$badge +=1;
					$userdevice->badge = $badge;
					$userdevice->deviceToken = $deviceToken;
					$userdevice->save(false);
					if(isset($deviceToken)){
						$messages = $currentusername." has sent offer request ".$productModel->currency.$offerRate." on your product ".$productModel->name;
						Myclass::pushnot($deviceToken,$messages,$badge);
					}	
				}	
			}
			
			 if ($mail->send()) {
			 	return true;
			 } else {
			 	echo $mail->getError();die;
			 }

		}
	}

	public function actionSavecomment() {
		$model = new Comments();
		$userId = Yii::app()->user->id;
		$model->userId = $userId;
		$model->createdDate = time();
		$model->productId = $_POST['itemId'];
		$model->comment = $_POST['comment'];
		if ($model->save()){
			$userDetails = Myclass::getUserDetails($model->userId);
			if(!empty($userDetails->userImage)) {
				$userImage = $userDetails->userImage;
			} else {
				$userImage = 'default/'.Myclass::getDefaultUser();
			}
			$productModel = Products::model()->findByPk($_POST['itemId']);
			$productModel->commentCount = $productModel->commentCount + 1;
			$productModel->save();
			$notifyMessage = 'comment on your product';
			Myclass::addLogs("comment", $userId, $productModel->userId, $model->commentId, $productModel->productId, $notifyMessage);

			$userid = $productModel->userId;
			$userdata = Users::model()->findByPk($userId);
			$currentusername = $userdata->name;
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
						$messages =$currentusername.' commented on your product '.$productModel->name;
						Myclass::pushnot($deviceToken,$messages,$badge);
					}		
				}
			}			
			
			/* $logsModel = new Logs();
			$logsModel->type = "comment";
			$logsModel->userId = Yii::app()->user->id;
			$logsModel->notifyTo = $productModel->userId;
			$logsModel->notifyAbout = $productModel->productId;
			$logsModel->sourceId = $model->commentId;
			$logsModel->createdDate = time();
			$logsModel->save(false); */
			$count = strlen($userDetails->name);
			if($count > 20){
				$userName = substr($userDetails->name,0,20).'...';
			} else {
				$userName = $userDetails->name;
			}
			/*echo '<li>
					<div class="comment-box">
						<div class="comment-image">'.CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/'.$userImage),$userDetails->username).'</div>
						<div class="comment-user"><div class="comment-username"><a class="userNameLink" href="'.Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))).'">'.$userName.'
							</a></div>
							<div class="comment-time"><i class="fa fa-clock-o"></i> 0 '.Yii::t('app','seconds').' '.Yii::t('app','ago').'
							</div>
						</div>
						<div class="comment-message">'.$model->comment.'</div>
					</div>
				  </li>';*/

			echo '<div class="comment col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" id="cmt-1">';
			if(!empty($userDetails->userImage)) {
				$user_profile = Yii::app()->createAbsoluteUrl('user/resized/40x40/'.$userDetails->userImage);
			} else {
				$user_profile = Yii::app()->createAbsoluteUrl('user/resized/40x40/default/'.Myclass::getDefaultUser());
			}
						
			echo '<a href="'.Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))).'"><div class="comment-profile-default icon col-xs-2 col-sm-2 col-md-1 col-lg-1 no-hor-padding" style="background: rgba(0, 0, 0, 0) url('.$user_profile.') no-repeat scroll center center / cover; border-radius:20px; "></div></a>
			<div class="comment-content icon col-xs-10 col-sm-10 col-md-11 col-lg-11 no-hor-padding">
			<div class="comment-user-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"><a href="'.Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($userDetails->userId.'-'.rand(0,999)))).'">'.$userDetails->name.'</a></div>';
			echo '<div class="comment-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<p>'.$model->comment.'</p>
			<div class="comment-timing-detail col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			<p>0 '.Yii::t('app','seconds').' '.Yii::t('app','ago').'</p>
			</div>
			</div>									
			</div>
			</div>';

				  
			/* $userid = $productModel->userId;
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
				$messages = $userDetails->username." commented on the product - ".$productModel->name;
				Myclass::pushnot($deviceToken,$messages,$badge);
			}
			} 
			} */
		}else{
			//echo "false";
		}
	}

	public function actionLike($id) {
		$userId = Yii::app()->user->id;
		$model = new Favorites();
		$model->userId = $userId;
		$model->productId = $id;
		if($model->save()) {
			$product = Products::model()->findByPk($id);
			$product->likes++;
			$product->save(false);
			
			$notifyMessage = 'liked your product';
			Myclass::addLogs("like", $userId, $product->userId, $model->id, $id, $notifyMessage);

			$userid = $product->userId;
			$userdata = Users::model()->findByPk($userId);
			$currentusername = $userdata->name;
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
						$messages =$currentusername.' liked your product '.$product->name;
						Myclass::pushnot($deviceToken,$messages,$badge);
					}		
				}
			}			
			
			/* $logsModel = new Logs();
			$logsModel->type = "like";
			$logsModel->userId = Yii::app()->user->id;
			$logsModel->notifyTo = $product->userId;
			$logsModel->notifyAbout = $product->productId;
			$logsModel->sourceId = $model->id;
			$logsModel->createdDate = time();
			$logsModel->save(false); */
			
			/* $userid = $product->userId;
			$criteria = new CDbCriteria;
			$criteria->addCondition('user_id = "'.$userid.'"');
			$userdevicedet = Userdevices::model()->findAll($criteria);
			
			$userModel = Users::model()->findByPk($model->userId);
			if(count($userdevicedet) > 0){
			foreach($userdevicedet as $userdevice){
			$deviceToken = $userdevice->deviceToken;
			$badge = $userdevice->badge;
			$badge +=1;
			$userdevice->badge = $badge;
			$userdevice->deviceToken = $deviceToken;
			$userdevice->save(false);
			if(isset($deviceToken)){
				$messages = $userModel->username." liked on the product ".$product->name;
				Myclass::pushnot($deviceToken,$messages,$badge);
			}
		}
	} */
		
			//	Yii::app()->user->setFlash("success",'Item added to your favorites');
			//$this->redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function actionDislike($id) {
		$user = Yii::app()->user->id;
		$criteria = new CDbCriteria;
		$criteria->addCondition("userId = $user");
		$criteria->addCondition("productId = $id");
		$model = Favorites::model()->find($criteria);
		$favouriteId = $model->id;
		$model->delete();

		$product = Products::model()->findByPk($id);
		$product->likes--;
		$product->save(false);

		$logCriteria = new CDbCriteria();
		$logCriteria->addCondition("type LIKE 'like'");
		$logCriteria->addCondition("sourceId = $favouriteId");
		$logsModel = Logs::model()->find($logCriteria);
		$logsModel->delete();
		//Yii::app()->user->setFlash("success",'Item removed from your favorites');
		//$this->redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		Yii::import( "xupload.models.XUploadForm" );
		$photos = new XUploadForm;

		$model=new Products;

		$parentCategory = array();
		$parentCategory = Categories::model()->findAllByAttributes(array('parentCategory'=>0));
		if (!empty($parentCategory)){
			$parentCategory = CHtml::listData($parentCategory, 'categoryId', 'name');
		}
		$subCategory = array();

		$shippingTime['1 business day'] = '1 business day';
		$shippingTime['1-2 business day'] = '1-2 business day';
		$shippingTime['2-3 business day'] = '2-3 business day';
		$shippingTime['3-5 business day'] = '3-5 business day';
		$shippingTime['1-2 weeks'] = '1-2 weeks';
		$shippingTime['2-4 weeks'] = '2-4 weeks';
		$shippingTime['5-8 weeks'] = '5-8 weeks';

		$countryModel = array();
		$countryList = Country::model()->findAllByAttributes(array(),array(
									'condition' => 'countryId != :id',
									'params' => array('id'=>'0')));
		if (!empty($countryList)){
			//$countryModel = CHtml::listData($countryList, 'countryId', 'country');
			foreach ($countryList as $country){
				$countryKey = $country->countryId."-".$country->country;
				$countryModel[$countryKey] = $country->country;
			}
		}
		
		$promotionDetails = Promotions::model()->findAll();
		
		$siteSettings = Sitesettings::model()->find();
		$urgentPrice = $siteSettings->urgentPrice;
		$promotionCurrency = $siteSettings->promotionCurrency;

		$user = Yii::app()->user->id;
		$userModel = Users::model()->findByPk($user);
		$geoLocationDetails = "";
		
		if($userModel->geolocationDetails != ""){
			$geoLocationDetails = json_decode($userModel->geolocationDetails, true);
		}
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		if(isset($_POST['Products']))
		{
			$productData = $_POST['Products'];
			$model->attributes=$_POST['Products'];
			$model->name = htmlentities($model->name);
			$model->description = htmlentities($model->description);
			
			$model->userId = Yii::app()->user->id;
			$model->createdDate = time();
			$model->chatAndBuy = $_POST['Products']['chatAndBuy'];
			
			$model->exchangeToBuy = 0;
			if(isset($_POST['Products']['exchangeToBuy']))
				$model->exchangeToBuy = $_POST['Products']['exchangeToBuy'];
			
			$model->instantBuy = 0;
			if(isset($_POST['Products']['instantBuy'])){
				$model->instantBuy = $_POST['Products']['instantBuy'];
				
				$model->shippingcountry = Myclass::getCountryId($_POST['Products']['shippingcountry']);
				$model->shippingCost = $_POST['Products']['shippingCost'];
			}
			
			$model->myoffer = 0;
			if(isset($_POST['Products']['myoffer']))
				$model->myoffer = $_POST['Products']['myoffer'];
			$model->currency  = $_POST['Products']['currency'];
			$model->subCategory  = $_POST['Products']['subCategory'];
			$model->shippingTime = $_POST['Products']['shippingTime'];
			
			

			if (isset($productData['productOptions'])){
				$model->sizeOptions = json_encode($productData['productOptions']);
				$quantity = 0;
				$optionPrice = 0;
				foreach($productData['productOptions'] as $options){
					$quantity += $options['quantity'];
					$optionPrice = $optionPrice == 0 && !empty($options['price']) ? $options['price'] : $optionPrice;
				}
				$model->quantity = $quantity;
				$model->price = $optionPrice != 0 ? $optionPrice : $model->price;
			}
			$model->quantity = 1;
			/* // THIS is how you capture those uploaded images: remember that in your CMultiFile widget,
			 //you set 'name' => 'images'
			 $images = CUploadedFile::getInstancesByName('images');

			 // proceed if the images have been set
			 if (isset($images) && count($images) > 0) {

			 // go through each uploaded image
			 foreach ($images as $image => $pic) {
			 echo $pic->name.'<br />';
			 if ($pic->saveAs(Yii::getPathOfAlias('webroot').'/media/item/'.$pic->name)) {
			 // add it to the main model now
			 $img_add = new Picture();
			 $img_add->filename = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
			 $img_add->topic_id = $model->id; // this links your picture model to the main model (like your user, or profile model)

			 $img_add->save(); // DONE
			 }
			 //else
				// handle the errors here, if you want
				}
				} */

			if($model->save()){
				foreach ($productData['shipping'] as $key => $shipping){
					if($shipping != ""){
						$shippingModel = new Shipping();
						$shippingModel->productId = $model->productId;
						$shippingModel->countryId = $key;
						$shippingModel->shippingCost = $shipping;
						$shippingModel->createdDate = time();
						$shippingModel->save();
					}
				}
				
				$notifyMessage = 'Added the product';
				Myclass::addLogs("add", $model->userId, 0, $model->productId, $model->productId, $notifyMessage);
				$userdetail = Myclass::getcurrentUserdetail();


				$userid = $model->userId;
				$userdata = Users::model()->findByPk($userid);
				$currentusername = $userdata->name;
				$followCriteria = new CDbCriteria;
				$followCriteria->addCondition("follow_userId = $userid");
				$followers = Followers::model()->findAll($followCriteria);	
				foreach ($followers as $follower) {
					$followuserid = $follower->userId;
					$criteria = new CDbCriteria;
					$criteria->addCondition('user_id = "'.$followuserid.'"');
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
								$messages =$currentusername.' added a product '.$product->name;
								Myclass::pushnot($deviceToken,$messages,$badge);
							}		
						}
					}	
				}			
				
					
				if(isset($_POST['facebook_share'])) {
					/*$facebookdetails = Myclass::getsocialLoginDetails();
					
					$root_path = Yii::app()->basePath;
					require_once( $root_path . 'extensions/HybridAuth/hybridauth-2.2.2/hybridauth/Hybrid/Auth.php' );
					$hybridauth_config = array(
							"base_url" => Yii::app()->createAbsoluteUrl('extensions/HybridAuth/hybridauth-2.2.2/hybridauth/'), // set hybridauth path
								
							"providers" => array(
									"Facebook" => array(
											"enabled" => true,
											"keys" => array("id" => $facebookdetails['facebook']['appid'], "secret" => $facebookdetails['facebook']['secret']),
											"scope" => 'publish_actions',
											"display" => 'popup',
									)
							)
					);
					
					if(!empty($hybridauth_config)){
						$hybridauth = new Hybrid_Auth($hybridauth_config);
					}*/

					$photo_detail = Photos::model()->find("productId = $model->productId");
					
					$haComp = new HybridAuthIdentity();
					
					$haComp->hybridAuth->restoreSessionData($userdetail->facebook_session);
					$adapter = $haComp->hybridAuth->getAdapter( "Facebook" );
					$adapter->setUserStatus(
							array(
									"message" => $model->description, // status or message content
									"link"    => Yii::app()->createAbsoluteUrl('item/products/view',array('id'=>Myclass::safe_b64encode($model->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($model->name), // webpage link
									"picture" => Yii::app()->createAbsoluteUrl("/item/products/resized/155/".$model->productId."/".$photo_detail->name), // a picture link
							)
						);
				}
				
				if(isset($_POST['Products']['promotion']['type']) && $_POST['Products']['promotion']['type'] != ""){
					$promotionType = $_POST['Products']['promotion']['type'];
					Yii::app()->session['promotionType'] = $promotionType;
					if($promotionType == "adds"){
						Yii::app()->session['addspromotionType'] = $_POST['Products']['promotion']['addtype'];
					}
					Yii::app()->session['productId'] = $model->productId;
					$redirectUrl = Yii::app()->createAbsoluteUrl('promotionpayment');
					$this->redirect($redirectUrl);
					//$this->promotionPaymentProcess($promotionType);
				}else{
					$redirectUrl = Yii::app()->createAbsoluteUrl('item/products/view',array('id'=>Myclass::safe_b64encode($model->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($model->name);
					//$this->redirect($redirectUrl);
					echo $model->productId."-_-".$redirectUrl;die;
					
				}
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','Not Saved'));
			}

		}

		$currencies = Currencies::model()->findAll();
		$topFiveCur = Sitesettings::model()->findByPk(1)->currency_priority;
		$topFive = json_decode($topFiveCur);
		foreach($topFive as $top):
		$topCurs[] = Currencies::model()->findAllByAttributes(array("id" => $top));
		endforeach;

		Yii::app( )->user->setState( 'images', null );
		//echo "<pre> $urgentPrice $promotionCurrency";print_r($promotionDetails);die;
		$this->render('create',array(
				'model'=>$model, 'parentCategory'=>$parentCategory,'subCategory'=>$subCategory,
				'photos' => $photos, 'shippingTime' => $shippingTime, 'countryModel' => $countryModel, 
				'topCurs' => $topCurs,'currencies' => $currencies, 'promotionCurrency'=>$promotionCurrency,
				'urgentPrice'=>$urgentPrice, 'promotionDetails'=>$promotionDetails, 
				'geoLocationDetails' => $geoLocationDetails
		));
	}
	
	public function actionSuccess() {
		$this->render('success', array());
	}
	
	public function actionCanceled() {
		$this->render('canceled', array());
	}
	
	/**
	 * Function to handle the UI
	 * and ajax for calling the form
	 * generating URL for the paypal form
	 * 
	 */
	public function actionPromotionpayment(){
		$promotionType = $_POST['promotionType'];
		$productId = $_POST['productId'];
		Yii::app()->session['addspromotionType'] = $_POST['promotionId'];
		unset(Yii::app()->session['promotionType']);
		$this->render('promotionpayment', array('promotionType'=>$promotionType, 
				'productId'=>$productId));
	}

	/**
	 * Function to process the promotion payments
	 * after adding the product
	 * 
	 */
	public function actionPromotionpaymentprocess(){
		$userId = Yii::app()->user->id;
		$promotionType = $_POST['promotionType'];
		$siteSettings = Sitesettings::model()->find();
		
		$productPromotionStatus = Products::model()->findByPk($_POST['productId']);
		if(empty($productPromotionStatus) || $productPromotionStatus->promotionType != 3){
			echo 0;die;
		}elseif ($productPromotionStatus->soldItem == 1){
			echo 1;die;
		}
		
		$paypalSettings = json_decode($siteSettings->paypal_settings, true);
		$promotionCurrency = $siteSettings->promotionCurrency;
		$currencyDetails = explode('-', $promotionCurrency);
		$promotionCurrency = $currencyDetails[0];
		if ($promotionType == 'urgent'){
			$price = $siteSettings->urgentPrice;
			$customField = $promotionType."-_-".$promotionCurrency."-_-0-_-".$price."-_-".$userId;
			$customField = Myclass::cart_encrypt($customField, "pr0m0tion-det@ils");
		}else{
			$promotionId = $_POST['promotionId'];
			$promotionDetails = Promotions::model()->findByPk($promotionId);
			$customField = $promotionType."-_-".$promotionCurrency."-_-".$promotionDetails->days."-_-".$promotionDetails->price."-_-".$userId;
			$customField = Myclass::cart_encrypt($customField, "pr0m0tion-det@ils");
			$price = $promotionDetails->price;
		}

		$this->renderPartial('promotionpaymentprocessing', array('paypalSettings'=>$paypalSettings, 'price'=>$price, 
				'promotionCurrency'=>$promotionCurrency, 'customField'=>$customField));
	}
	
	/**
	 * Method to process the ipn from
	 * the paypal for the promotion payment
	 * process
	 * 
	 */
	public function actionPromotionipnprocess(){
		$postFields = 'cmd=_notify-validate';
		$siteSettings = Sitesettings::model()->find();
		
		$paypalSettings = json_decode($siteSettings->paypal_settings, true);
		
		if($paypalSettings['paypalType'] == 2){
			$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}elseif($paypalSettings['paypalType'] == 1){
			$url = 'https://www.paypal.com/cgi-bin/webscr';
		}
		
		foreach($_POST as $key => $value)
		{
			$postFields .= "&$key=".urlencode(stripslashes($value));
			$keyarray[urldecode($key)] = urldecode($value);
		}
		
		$ch = curl_init();
			
		curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postFields
		));
			
		$result = curl_exec($ch);
		curl_close($ch);
		
		if ($result == 'VERIFIED' && $keyarray['payment_status'] == 'Completed') {
			$keyarray['custom'] = Myclass::cart_decrypt($keyarray['custom'], "pr0m0tion-det@ils");
			$custom = explode('-_-', $keyarray['custom']);

			$itemId = $keyarray['item_number'];
			$productModel = Products::model()->findByPk($itemId);
		
			$currencyCode = $keyarray['mc_currency'];
			$createdDate = time();
			/* $forexrateModel = $this->Forexrates->find('first',
			 array('conditions'=>array('currency_code' => $currencyCode)));
			$forexRate = $forexrateModel['Forexrates']['price']; */

			//$customField = $promotionType."-_-".$promotionCurrency."-_-".$promotionDetails->days."-_-".$promotionDetails->price;
			
			$promotionTranxModel = new Promotiontransaction();
			$promotionTranxModel->promotionName = $custom[0];
			$promotionTranxModel->promotionPrice = $custom[3];
			$promotionTranxModel->promotionTime = $custom[2];
			$promotionTranxModel->userId = $custom[4];
			$promotionTranxModel->productId = $itemId;
			$promotionTranxModel->tranxId = $keyarray['txn_id'];
			$promotionTranxModel->createdDate = $createdDate;
		
			$promotionTranxModel->save(false);
			$promotionTranxId = $promotionTranxModel->id;
		
			if($custom[0] != "urgent"){
				$adsPromotionDetailsModel = new Adspromotiondetails();
				$adsPromotionDetailsModel->productId = $itemId;
				$adsPromotionDetailsModel->promotionTime = $custom[2];
				$adsPromotionDetailsModel->promotionTranxId = $promotionTranxId;
				$adsPromotionDetailsModel->createdDate = $createdDate;
				
				$adsPromotionDetailsModel->save(false);
			}
		
			if($custom[0] == "urgent"){
				$productModel->promotionType = 2;
			}else{
				$productModel->promotionType = 1;
			}
		
			$productModel->save(false);
		
		
			$siteSettings = Sitesettings::model()->find();
			$userModel = Myclass::getUserDetails($productModel->userId);
			$sellerEmail = $userModel->email;
			$sellerName = $userModel->name;
			$mail = new YiiMailer();
			if($siteSettings->smtpEnable == 1) {
				//$mail->IsSMTP();                         // Set mailer to use SMTP
				$mail->Mailer = 'smtp';                         // Set mailer to use SMTP
				$mail->Host = $siteSettings->smtpHost;  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = $siteSettings->smtpEmail;                            // SMTP username
				$mail->Password = $siteSettings->smtpPassword;                           // SMTP password
				$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
				$mail->Port = $siteSettings->smtpPort;
			}
			$mail->setView('promotionsuccessintimation');
			$mail->setData(array('siteSettings' => $siteSettings, 
					'userModel' => $userModel,'productModel'=>$productModel,'productName'=>$productModel->name, 'sellerName' => $sellerName, 
					));
			$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
			$mail->setTo($sellerEmail);
			$mail->setSubject($siteSettings->sitename.' Your product promoted');
			$mail->send();
				
			$userid = $productModel->userId;
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
						if($custom[0] == "urgent"){
							$messages =  "You have promoted your product ".$productModel->name." by ".$currencyCode.$custom[3];
						}else{
							$messages =  "You have promoted your product ".$productModel->name." by ".$currencyCode.$custom[3]." for ".$custom[2]." days";
						}
						Myclass::pushnot($deviceToken,$messages,$badge);
					}
				}
			}
				
			/*if ($mail->send()) {
				//Yii::app()->user->setFlash('login','Thank you for contacting us. We will respond to you as soon as possible.');
				//$this->redirect(array('user/login'));
				//echo "email sent";die;
			} else {
				//Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
				//echo $mail->getError();die;
			} */
			
		}
	}


	/**
	 * Method to get the subcategory
	 * for the parent category sent from
	 * the create item form
	 *
	 */
	public function actionGetsubcategory(){
		if(isset($_POST)) {
			$categoryId = $_POST['category'];
			$subCategoryModel = Categories::model()->findAllByAttributes(array('parentCategory'=>$categoryId));
			$subCategory = CHtml::listData($subCategoryModel, 'categoryId', 'name');

			echo "<option value=''>Select Subcategory</option>";
			foreach ($subCategory as $key => $category){
				echo "<option value='".$key."'>".$category."</option>";
			}
		}
	}
	
	/**
	 * Method to handle the property 
	 * updation on the add product page
	 * according to the selected category
	 * 
	 */
	public function actionProductproperty(){
		if(isset($_POST)) {
			$categoryId = $_POST['selectedCategory'];
			$categoryModel = Categories::model()->findByAttributes(array('categoryId'=>$categoryId));	
			$categoryProperty = json_decode($categoryModel->categoryProperty, true);
			//print_r($categoryProperty);
			$itemCondition = "";
			$itemConditionFlag = 0;
			$sitePaymentModes = Myclass::getSitePaymentModes();
			
			if(isset($_POST['productId']) && $_POST['productId'] != ""){
				$productModel = Myclass::getProductDetails($_POST['productId']);
				if(!empty($productModel) && $productModel->category == $_POST['selectedCategory']){
					$itemStatus = $productModel->productCondition;
					$exchangeToBuy = $productModel->exchangeToBuy;
					$myOffers = $productModel->myoffer;
					$instantBuy = $productModel->instantBuy;
				}
			}
			
			if ($categoryProperty['itemCondition'] == 'enable'){
				$itemCondition .= '<div class="Category-select-box-row col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					<div class="form-group col-xs-12 col-sm-12 col-md-5 col-lg-5 no-hor-padding">
					<label class="Category-select-box-heading">'.Yii::t('admin','Product Condition').'<span class="required">*</span></label>';
					if(isset($itemStatus)) {
						$selected = $itemStatus;
					} else {
						$selected = '';
					}
					
					$productConditions = Productconditions::model()->findAll();
					$itemCondition .= '<select id="Products_productCondition" class="form-control select-box-down-arrow" name="Products[productCondition]">';
					$itemCondition .= '<option value="">Select Product Condition</option>';
					foreach ($productConditions as $productCondition){
						$select = "";
						if($itemStatus == $productCondition->condition)
							$select = "selected";
						$itemCondition .= '<option value="'.$productCondition->condition.'" '.$select.'>'.$productCondition->condition.'</option>';
					}
					$itemCondition .= '</select>
						<div id="Products_productCondition_em_" class="errorMessage" style="display:none"></div>
					</div>
				</div>';
				$itemConditionFlag = 1;
			}else{
				$itemCondition .= '<input type="hidden" name="Products[productCondition]" value="" />';
			}
			if ($categoryProperty['exchangetoBuy'] == 'enable' && $sitePaymentModes['exchangePaymentMode'] == 1){
				$itemCondition .= '<div class="switch-box col-xs-6 col-sm-3 col-md-2 col-lg-2 no-hor-padding">					
									<label class="Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">Exchange to buy</label>
									<div class="switch col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
				if(isset($exchangeToBuy) && $exchangeToBuy == 1){
					$itemCondition .= '
									<input id="Products_exchangeToBuy" class="cmn-toggle cmn-toggle-round" checked="checked" type="checkbox" name="Products[exchangeToBuy]" value="1">
									<label for="Products_exchangeToBuy"></label>
									</div>
							</div>';
				}else{
					$itemCondition .= '
									<input id="Products_exchangeToBuy" class="cmn-toggle cmn-toggle-round" type="checkbox" name="Products[exchangeToBuy]" value="1">
									<label for="Products_exchangeToBuy"></label>
									</div>
							</div>';
				}
				$itemConditionFlag = 1;
			}else{
				$itemCondition .= '<input type="hidden" name="Products[exchangeToBuy]" value="0" />';
			}
			if ($categoryProperty['myOffer'] == 'enable'){
				$itemCondition .= '<div class="switch-box col-xs-6 col-sm-3 col-md-2 col-lg-2 no-hor-padding">
									<label class="Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">Fixed Price</label>
									<div class="switch col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
				if(isset($myOffers) && $myOffers == 1){
					$itemCondition .= '
									<input id="Products_myoffer" class="cmn-toggle cmn-toggle-round" checked="checked" type="checkbox" name="Products[myoffer]" value="1">
									<label for="Products_myoffer"></label>
									</div>
							</div>';
				}else{
					$itemCondition .= '
									<input id="Products_myoffer" class="cmn-toggle cmn-toggle-round" type="checkbox" name="Products[myoffer]" value="1">
									<label for="Products_myoffer"></label>
									</div>
							</div>';
				}
				$itemConditionFlag = 1;
			}else{
				$itemCondition .= '<input type="hidden" name="Products[myoffer]" value="2" />';
			}
			if ($categoryProperty['buyNow'] == 'enable' && $sitePaymentModes['buynowPaymentMode'] == 1){
				$itemCondition .= '<div class="switch-box col-xs-6 col-sm-3 col-md-2 col-lg-2 no-hor-padding">
									<label class="Category-input-box-heading  col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">Instant Buy</label>
									<div class="switch col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">';
				if(isset($instantBuy) && $instantBuy == 1){
					$itemCondition .= '
									<input id="Products_instantBuy" class="cmn-toggle cmn-toggle-round" checked="checked" type="checkbox" name="Products[instantBuy]" value="1">
									<label for="Products_instantBuy"></label>
									</div>
							</div>';
				}else{
					$itemCondition .= '
									<input id="Products_instantBuy" class="cmn-toggle cmn-toggle-round" type="checkbox" name="Products[instantBuy]" value="1">
									<label for="Products_instantBuy"></label>
									</div>
							</div>';
				}
				$itemConditionFlag = 1;
			}else if($sitePaymentModes['buynowPaymentMode'] == 1){
				$itemCondition .= '<input type="hidden" name="Products[instantBuy]" value="0" />';
			}
			
			$subCategoryModel = Categories::model()->findAllByAttributes(array('parentCategory'=>$categoryId));
			$subCategory = CHtml::listData($subCategoryModel, 'categoryId', 'name');
			
			$subCategoryOptions = "<option value=''>Select Subcategory</option>";
			foreach ($subCategory as $key => $category){
				$subCategoryOptions .= "<option value='".$key."'>".$category."</option>";
			}
			
			$propertyData[] = $itemConditionFlag;
			$propertyData[] = $itemCondition;
			$propertyData[] = $subCategoryOptions;
			$propertyDetails = json_encode($propertyData);
			echo $propertyDetails;
		}
	}

	/**
	 * function to handle the product listing
	 * or product view page actions
	 * @param integer $id the ID of the model to be displayed
	 *
	 */
	public function actionListing($id) {
		$itemModel = $this->loadModel($id);
		$photoModel = $itemModel->photos;
		//$commentModel = $itemModel->comments;
		$categoryModel = $itemModel->category0;
		$subcategoryModel = $itemModel->subCategory0;
		$userModel = $itemModel->user;
		echo "<pre>";print_r($photoModel);
		//echo "<br><br><pre>";print_r($commentModel);
		echo "<br><br><pre>";print_r($categoryModel);
		echo "<br><br><pre>";print_r($subcategoryModel);
		echo "<br><br><pre>";print_r($userModel);die;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$dec = Myclass::safe_b64decode($id);
		$spl = explode('-',$dec);
		$id = $spl[0];
		if(count($spl) <= 1){
			$this->redirect(array('/'));
		}
		Yii::import( "xupload.models.XUploadForm" );
		$photos = new XUploadForm;

		$model=$this->loadModel($id);
		$userId = Yii::app()->user->id;
		if($model->userId != $userId) {
			$this->redirect(array('/'));
		}
		$parentCategory = array();
		$parentCategory = Categories::model()->findAllByAttributes(array('parentCategory'=>0));
		if (!empty($parentCategory)){
			$parentCategory = CHtml::listData($parentCategory, 'categoryId', 'name');
		}
		$subCategory = Categories::model()->findAllByAttributes(array('parentCategory'=>$model->category));
		$subCategory = CHtml::listData($subCategory, 'categoryId', 'name');

		$shippingTime['1 business day'] = '1 business day';
		$shippingTime['1-2 business day'] = '1-2 business day';
		$shippingTime['2-3 business day'] = '2-3 business day';
		$shippingTime['3-5 business day'] = '3-5 business day';
		$shippingTime['1-2 weeks'] = '1-2 weeks';
		$shippingTime['2-4 weeks'] = '2-4 weeks';
		$shippingTime['5-8 weeks'] = '5-8 weeks';

		$countryModel = array();
		$countryList = Country::model()->findAllByAttributes(array(),array(
									'condition' => 'countryId != :id',
									'params' => array('id'=>'0')));
		if (!empty($countryList)){
			//$countryModel = CHtml::listData($countryList, 'countryId', 'country');
			foreach ($countryList as $country){
				$countryKey = $country->countryId."-".$country->country;
				$countryModel[$countryKey] = $country->country;
				$shippingCountry[$country->countryId] = $country->country;
			}
		}

		$options = array();
		if (!empty($model->sizeOptions)){
			$options = json_decode($model->sizeOptions, true);
		}

		$shippingModel = $model->shippings;
		$jsShippingDetails = '';
		$itemShipping = array();
		foreach ($shippingModel as $shippingDetail) {
			$itemShipping[$shippingDetail->countryId] = $shippingDetail->shippingCost;
			if(empty($jsShippingDetails)){
				$jsShippingDetails .= '"'.$shippingDetail->countryId.'"';
			}else{
				$jsShippingDetails .= ',"'.$shippingDetail->countryId.'"';
			}
		}

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Products']))
		{
			//echo "<pre>";print_r($_POST);die;
			$productData = $_POST['Products'];
			$model->attributes=$_POST['Products'];
			//echo "<pre>";print_r($model->attributes);die;
			$model->name = htmlentities($model->name);
			$model->description = htmlentities($model->description);

			$model->chatAndBuy = $_POST['Products']['chatAndBuy'];
			$model->exchangeToBuy = 0;
			if(isset($_POST['Products']['exchangeToBuy']))
				$model->exchangeToBuy = $_POST['Products']['exchangeToBuy'];
		
			$model->instantBuy = 0;
			if(isset($_POST['Products']['instantBuy'])){
				$model->instantBuy = $_POST['Products']['instantBuy'];
				
				$model->shippingcountry = Myclass::getCountryId($_POST['Products']['shippingcountry']);
				$model->shippingCost = $_POST['Products']['shippingCost'];
			}
			
			$model->myoffer = 0;
			if(isset($_POST['Products']['myoffer']))
				$model->myoffer = $_POST['Products']['myoffer'];
			$model->shippingTime = $_POST['Products']['shippingTime'];
			$model->currency = $_POST['Products']['currency'];
			$model->subCategory = $_POST['Products']['subCategory'];
			//echo "<pre>";print_r($model->attributes);die;
				
			if (isset($productData['productOptions'])){
				$model->sizeOptions = json_encode($productData['productOptions']);
				$quantity = 0;
				$optionPrice = 0;
				foreach($productData['productOptions'] as $options){
					$quantity += $options['quantity'];
					$optionPrice = $optionPrice == 0 && !empty($options['price']) ? $options['price'] : $optionPrice;
				}
				$model->quantity = $quantity;
				$model->price = $optionPrice != 0 ? $optionPrice : $model->price;
			} else {
				$model->sizeOptions = '';
			}

				
			Shipping::model()->deleteAllByAttributes(array('productId'=>$model->productId));
			if(isset($productData['shipping'])) {
				foreach ($productData['shipping'] as $key => $shipping){
					if($shipping != ""){
						$shippingModel = new Shipping();
						$shippingModel->productId = $model->productId;
						$shippingModel->countryId = $key;
						$shippingModel->shippingCost = $shipping;
						$shippingModel->createdDate = time();
						$shippingModel->save();
					}
				}
			}
			if($model->save()) {
				$redirectUrl = Yii::app()->createAbsoluteUrl('item/products/view',array('id'=>Myclass::safe_b64encode($model->productId.'-'.rand(0,999)))).'/'.Myclass::productSlug($model->name);
				$this->redirect($redirectUrl);
			}
		}else{
			unset($_SESSION['deletefile'][$id]);
		}
		$currencies = Currencies::model()->findAll();
		$topFiveCur = Sitesettings::model()->findByPk(1)->currency_priority;
		$topFive = json_decode($topFiveCur);
		foreach($topFive as $top):
		$topCurs[] = Currencies::model()->findAllByAttributes(array("id" => $top));
		endforeach;
		$model->name = html_entity_decode($model->name);
		$model->description = html_entity_decode($model->description);
		if(isset($_POST['Products']['instantBuy'])){
			$model->shippingcountry = Myclass::getCountryCode($model->shippingcountry);
		}
		else
		{
			$model->shippingcountry = "0";
		}
		$this->render('update',array(
				'model'=>$model, 'parentCategory'=>$parentCategory,'subCategory'=>$subCategory,
				'photos' => $photos,'options'=>$options, 'shippingTime' => $shippingTime, 
				'countryModel' => $countryModel, 'itemShipping' => $itemShipping, 
				'shippingCountry'=>$shippingCountry, 'jsShippingDetails' => $jsShippingDetails, 
				'topCurs' => $topCurs,'currencies' => $currencies
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$dec = Myclass::safe_b64decode($id);
		$spl = explode('-',$dec);
		$id = $spl[0];
		$this->loadModel($id)->delete();

		Adspromotiondetails::model()->deleteAllByAttributes(array('productId'=>$id));
		Promotiontransaction::model()->deleteAllByAttributes(array('productId'=>$id));
		
		Myclass::removeItemLogs($id);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			Yii::app()->user->setFlash("success",Yii::t('app','Product Deleted'));
			$this->redirect(Yii::app()->createAbsoluteUrl('/'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Products');
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Products('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Products']))
		$model->attributes=$_GET['Products'];

		$this->render('admin',array(
				'model'=>$model,
		));
	}

	public function actionAddtocart() {
		if(isset($_POST)){
			$itemId = $_POST['itemId'];
			$option = $_POST['selectedOption'];
			$userId = Yii::app()->user->id;

			$cartModel = Carts::model()->findByAttributes(array('userId'=>$userId,'productId'=>$itemId));
			if($cartModel === null){
				$itemModel = Products::model()->findByAttributes(array('productId'=>$itemId));
				$model = new Carts();
				$price = $itemModel->price;
				if ($option != ''){
					$itemOption = json_decode($itemModel->sizeOptions, true);
					$itemOptionDetails = $itemOption[$option];
					if ($itemOptionDetails['price'] != ''){
						$price = $itemOptionDetails['price'];
					}
				}
				$model->userId = $userId;
				$model->merchantId = $itemModel->userId;
				$model->productId = $itemId;
				$model->quantity = 1;
				$model->price = $price;
				$model->options = $option;
				$model->createdDate = time();

				$model->save();
			}
			echo Yii::app()->baseurl.'/item/products/cart';
		}
	}

	public function actionCart(){
		$userId = Yii::app()->user->id;

		if (isset($_POST['selectedQty'])){
			$currentMerchant = $_POST['merchantId'];
			$currentItemid = $_POST['itemId'];
			$selectedQty = $_POST['selectedQty'];
			$cartQtyModel = Carts::model()->findByAttributes(array('userId'=>$userId,
					'productId'=>$currentItemid));
			$cartQtyModel->quantity = $selectedQty;
			$cartQtyModel->save();
			$cartModel = Carts::model()->findAllByAttributes(array('userId'=>$userId,
					'merchantId'=>$currentMerchant, ));
		}else{
			$cartModel = Carts::model()->findAllByAttributes(array('userId'=>$userId));
		}
		$cartCount = count($cartModel);
		$merchantList = array();
		$merchantItemList = array();
		$shippingAddressesModel = array();
		$shippingAddress = '';
		if ($cartCount > 0){
			$merchantPointer = array();
			$merchantCount = 0;
			$shippingAddressesModel = Tempaddresses::model()->findAllByAttributes(array('userId'=>$userId));
			if (count($shippingAddressesModel) > 0){
				$shippingAddress .= "<b>{$shippingAddressesModel[0]->name}</b></br>";
				$shippingAddress .= "{$shippingAddressesModel[0]->address1}</br>";
				if (!empty($shippingAddressesModel[0]->address2)){
					$shippingAddress .= "{$shippingAddressesModel[0]->address2}</br>";
				}
				$shippingAddress .= "{$shippingAddressesModel[0]->city} - {$shippingAddressesModel[0]->zipcode}</br>";
				$shippingAddress .= "{$shippingAddressesModel[0]->state}</br>";
				$shippingAddress .= "{$shippingAddressesModel[0]->country}</br>";
				$shippingAddress .= "ph: {$shippingAddressesModel[0]->phone}</br>";
			}
			foreach ($cartModel as $cart){
				$merchantId = $cart->product->user->userId;
				if (!isset($merchantPointer[$merchantId])){
					$merchantList[$merchantCount]['merchantId'] = $merchantId;
					$merchantList[$merchantCount]['merchantName'] = $cart->product->user->name;
					$merchantPointer[$merchantId] = 0;
					$merchantCount++;
				}
				$pointerCount = $merchantPointer[$merchantId];
				$merchantItemList[$merchantId][$pointerCount]['itemId'] = $cart->product->productId;
				$merchantItemList[$merchantId][$pointerCount]['name'] = $cart->product->name;
				$merchantItemList[$merchantId][$pointerCount]['sellername'] = $cart->product->user->name;
				$merchantItemList[$merchantId][$pointerCount]['price'] = $cart->price;
				$merchantItemList[$merchantId][$pointerCount]['option'] = $cart->options;
				$merchantItemList[$merchantId][$pointerCount]['cartquantity'] = $cart->quantity;
				$merchantItemList[$merchantId][$pointerCount]['totalquantity'] = $cart->product->quantity;
				$merchantItemList[$merchantId][$pointerCount]['shippingTime'] = $cart->product->shippingTime;
				if ($cart->options != ''){
					$itemOption = json_decode($cart->product->sizeOptions, true);
					$itemQuantity = $itemOption[$cart->options]['quantity'];
					if (!empty($itemQuantity)){
						$merchantItemList[$merchantId][$pointerCount]['totalquantity'] = $itemQuantity;
					}
				}
				$merchantItemList[$merchantId][$pointerCount]['productimage'] = $cart->product->photos[0]->name;
				$merchantPointer[$merchantId] = $pointerCount + 1;
				//echo "<pre>";print_r($merchantList);
				//echo "<pre>";print_r($merchantItemList);
			}
		}
		//echo "<pre>";print_r($cartModel);die;
		if (isset($_POST['selectedQty'])){
			$this->renderPartial('updateqtycart',array(
					'merchantList'=>$merchantList, 'merchantItemList'=>$merchantItemList,
					'cartCount'=>$cartCount,'shippingAddressesModel'=>$shippingAddressesModel,
					'shippingAddress'=>$shippingAddress,
			));
		}else{
			$this->render('cart',array(
					'merchantList'=>$merchantList, 'merchantItemList'=>$merchantItemList,
					'cartCount'=>$cartCount,'shippingAddressesModel'=>$shippingAddressesModel,
					'shippingAddress'=>$shippingAddress,
			));
		}
	}

	public function actionUpload( ) {
		Yii::import( "xupload.models.XUploadForm" );
		//Here we define the paths where the files will be stored temporarily
		$path = realpath( Yii::app( )->getBasePath( )."/../media/item/tmp/" )."/";
		$publicPath = Yii::app( )->getBaseUrl( )."/media/item/tmp/";

		//This is for IE which doens't handle 'Content-type: application/json' correctly
		header( 'Vary: Accept' );
		if( isset( $_SERVER['HTTP_ACCEPT'] )
		&& (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
			header( 'Content-type: application/json' );
		} else {
			header( 'Content-type: text/plain' );
		}

		//Here we check if we are deleting and uploaded file
		if( isset( $_GET["_method"] ) ) {
			if( $_GET["_method"] == "delete" ) {
				if (isset($_GET['id']) && $_GET['id'] != ''){
					$photosModel = Photos::model()->findByAttributes(array('photoId' => $_GET['id']));
					/* Photos::model()->deleteAllByAttributes(array('photoId' => $_GET['id']));
					$path = realpath( Yii::app( )->getBasePath( )."/../media/item/".$photosModel->productId."/" )."/";
					$file = $path.$photosModel->name;
					if( is_file( $file ) ) {
						unlink( $file );
					} */
					$fileDetails['productId'] = $photosModel->productId;
					$fileDetails['photoId'] = $_GET['id'];
					$path = realpath( Yii::app( )->getBasePath( )."/../media/item/".$photosModel->productId."/" )."/";
					$file = $path.$photosModel->name;
					$fileDetails['photoPath'] = $file;
					$_SESSION['deletefile'][$photosModel->productId][] = $fileDetails;
					//echo "<pre>";print_r($_SESSION['deletefile']);
				}elseif( $_GET["file"][0] !== '.' ) {
					$file = $path.$_GET["file"];
					if( is_file( $file ) ) {
						unlink( $file );
					}
				}
				echo json_encode( true );
			}elseif ($_GET["_method"] == "list") {
				$intProductId = $_GET['id'];
				$objProductImages = Photos::model()->findAllByAttributes(array('productId' => $intProductId));
				if ($objProductImages !== null)
				{
					$arrProductImages = array();
					foreach ($objProductImages as $objProductImage)
					{
						$arrProductImages[] = array(
								"name" => $objProductImage->name,
								"id" => $objProductImage->photoId,
						//"type" => $objProductImage->mimeType,
						//"size" => $objProductImage->size,
								"url" => Yii::app( )->getBaseUrl( )."/media/item/".$intProductId."/".$objProductImage->name,//$objProductImage->path,
								"thumbnail_url" => Yii::app( )->getBaseUrl( )."/item/products/resized/100x100/".$intProductId."/".$objProductImage->name,//$objProductImage->thumb,
								"delete_url" => $this->createUrl("upload", array("_method" => "delete", "id" => $objProductImage->photoId)),
								"delete_type" => "GET",
						);//domain/test/resized/100x100/images/big.png
					}
					echo json_encode($arrProductImages);
				}
			}
		} else {
			$model = new XUploadForm;
			$model->file = CUploadedFile::getInstance( $model, 'file' );
			//We check that the file was successfully uploaded
			if( $model->file !== null ) {
				//Grab some data
				$model->mime_type = $model->file->getType( );
				$model->size = $model->file->getSize( );
				$model->name = $model->file->getName( );
				//(optional) Generate a random name for our file
				$filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
				$filename .= ".".$model->file->getExtensionName( );
				if( $model->validate( ) ) {
					//Move our file to our temporary dir
					$model->file->saveAs( $path.$filename );
					chmod( $path.$filename, 0777 );
					//here you can also generate the image versions you need
					//using something like PHPThumb


					//Now we need to save this path to the user's session
					if( Yii::app( )->user->hasState( 'images' ) ) {
						$userImages = Yii::app( )->user->getState( 'images' );
					} else {
						$userImages = array();
					}
					$userImages[] = array(
							"path" => $path.$filename,
					//the same file or a thumb version that you generated
							"thumb" => $path.$filename,
							"filename" => $filename,
							'size' => $model->size,
							'mime' => $model->mime_type,
							'name' => $model->name,
					);
					Yii::app( )->user->setState( 'images', $userImages );

					//Now we need to tell our widget that the upload was succesfull
					//We do so, using the json structure defined in
					// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
					echo json_encode( array( array(
							"name" => $model->name,
							"type" => $model->mime_type,
							"size" => $model->size,
							"url" => $publicPath.$filename,
							"thumbnail_url" => $publicPath."/$filename",
							"delete_url" => $this->createUrl( "upload", array(
									"_method" => "delete",
									"file" => $filename
					) ),
							"delete_type" => "POST"
							) ) );
				} else {
					//If the upload failed for some reason we log some data and let the widget know
					echo json_encode( array(
					array( "error" => $model->getErrors( 'file' ),
					) ) );
					Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
					CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction"
					);
				}
			} else {
				throw new CHttpException( 500, "Could not upload file" );
			}
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Products the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Products::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Products $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionRequestExchange() {
		$user_Id = Yii::app()->user->id;
		$exchange = new Exchanges();
		if(isset($_POST['mainProductId']) && isset($_POST['exchangeProductId'])  && isset($_POST['requestTo'])) {
			$exchange->mainProductId = $_POST['mainProductId'];
			$exchange->exchangeProductId = $_POST['exchangeProductId'];
			$exchange->requestFrom = Yii::app()->user->id;
			$exchange->requestTo = $_POST['requestTo'];
			$exchange->date = time();
			$exchange->slug = Myclass::getRandomString(8);
			$exchange->status = 0;
			$mainProductModel = Myclass::getProductDetails($_POST['mainProductId']);
			$exchangeProductModel = Myclass::getProductDetails($_POST['exchangeProductId']);
			if($mainProductModel->quantity < 1 || $mainProductModel->soldItem != 0){
				echo "sold";
			}elseif($exchangeProductModel->quantity < 1 || $exchangeProductModel->soldItem != 0){
				echo "exchangesold";
			}else{
				$check = Myclass::exchangeProductExist($exchange->mainProductId,$exchange->exchangeProductId,$exchange->requestFrom,$exchange->requestTo);
				if(!empty($check)) {
					if($check->blockExchange == 1) {
						echo 'blocked';
					} else {
						if($check->status != 0 && $check->status != 1) {
							$check->requestFrom = Yii::app()->user->id;
							$check->requestTo = $_POST['requestTo'];
							$check->status = 0;
							$check->date = time();
							$history = array();
							if(!empty($check->exchangeHistory)) {
								$history = json_decode($check->exchangeHistory,true);
							}
							$history[] = array('status' =>'created','date'=>$check->date,'user'=>$check->requestFrom);
							$check->exchangeHistory = json_encode($history);
							$check->save(false);
							
							$userid = $check->requestFrom;
							$senderid = $check->requestTo;
							
							$notifyTo = $userid;
							$notifyItem = $check->mainProductId;
							if($user_Id == $userid){
								$notifyTo = $senderid;
								$notifyItem = $check->exchangeProductId;
							}
							if($user_Id == $userid)
								$notifyTo = $senderid;
							$notifyMessage = 'Sent Exchange request to your product';
							Myclass::addLogs("exchange", $user_Id, $notifyTo, $check->id, $notifyItem, $notifyMessage);
														
							$pushsender = $senderid;
							$pushuser = $userid;
							if($user_Id == $userid){
									$pushuser = $senderid;
									$pushsender = $userid;
							}
							$sellerDetails = Myclass::getUserDetails($user_Id);
							$criteria = new CDbCriteria;
							$criteria->addCondition('user_id = "'.$notifyTo.'"');
							$userdevicedet = Userdevices::model()->findAll($criteria);
							$productRecord = Products::model()->findByPk($check->mainProductId);
							if(count($userdevicedet) > 0){
									foreach($userdevicedet as $userdevice){
										$deviceToken = $userdevice->deviceToken;
										$badge = $userdevice->badge;
										$badge +=1;
										$userdevice->badge = $badge;
										$userdevice->deviceToken = $deviceToken;
										$userdevice->save(false);
										if(isset($deviceToken)){
												$messages = $sellerDetails->username." has sent an exchange request on your product ".$productRecord->name;
												Myclass::pushnot($deviceToken,$messages,$badge);
										}
									}
							}

							$siteSettings = Sitesettings::model()->find();
							$mail = new YiiMailer();
							$sellerDetails = Myclass::getUserDetails($notifyTo);
							$c_username = $sellerDetails->name;
							$emailTo = $sellerDetails->email;
							$userDetails = Myclass::getUserDetails($user_Id);
							$r_username = $userDetails->name;
							if($siteSettings->smtpEnable == 1) {
								//$mail->IsSMTP();                         // Set mailer to use SMTP
								$mail->Mailer = 'smtp';                         // Set mailer to use SMTP
								$mail->Host = $siteSettings->smtpHost;  // Specify main and backup server
								$mail->SMTPAuth = true;                               // Enable SMTP authentication
								$mail->Username = $siteSettings->smtpEmail;                            // SMTP username
								$mail->Password = $siteSettings->smtpPassword;                           // SMTP password
								$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
								$mail->Port = $siteSettings->smtpPort;
							}
				
							$mail->setView('exchangecreated');
							$mail->setData(array('c_username' => $c_username, 'r_username' => $r_username,
									'siteSettings' => $siteSettings));
							$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
							$mail->setTo($emailTo);
							$mail->setSubject($r_username.' sent Exchange Request with your product');
							$mail->send();

							echo 'success';
						} else {
							echo 'sent';
						}
					}
				} else {
					if($exchange->validate()) {
						$history = array();
						if(!empty($exchange->exchangeHistory)) {
							$history = json_decode($exchange->exchangeHistory,true);
						}
						$history[] = array('status' =>'created','date'=>$exchange->date,'user'=>$exchange->requestFrom);
						$exchange->exchangeHistory = json_encode($history);
						$exchange->save(false);
						
						$userid = $exchange->requestFrom;
						$senderid = $exchange->requestTo;
							
						$notifyTo = $userid;
						$notifyItem = $exchange->mainProductId;
						if($user_Id == $userid){
							$notifyTo = $senderid;
							$notifyItem = $exchange->exchangeProductId;
						}
						if($user_Id == $userid)
							$notifyTo = $senderid;
						$notifyMessage = 'Sent Exchange request to your product';
						Myclass::addLogs("exchange", $user_Id, $notifyTo, $exchange->id, $notifyItem, $notifyMessage);
					
						$pushsender = $senderid;
						$pushuser = $userid;
						if($user_Id == $userid){
							$pushuser = $senderid;
							$pushsender = $userid;
						}
						$sellerDetails = Myclass::getUserDetails($user_Id);
						$criteria = new CDbCriteria;
						$criteria->addCondition('user_id = "'.$notifyTo.'"');
						$userdevicedet = Userdevices::model()->findAll($criteria);
						$productRecord = Products::model()->findByPk($exchange->mainProductId);
						if(count($userdevicedet) > 0){
							foreach($userdevicedet as $userdevice){
								$deviceToken = $userdevice->deviceToken;
								$badge = $userdevice->badge;
								$badge +=1;
								$userdevice->badge = $badge;
								$userdevice->deviceToken = $deviceToken;
								$userdevice->save(false);
								if(isset($deviceToken)){
									$messages = $sellerDetails->username." has sent an exchange request on your product ".$productRecord->name;
									Myclass::pushnot($deviceToken,$messages,$badge);
								}
							}
						}

							$siteSettings = Sitesettings::model()->find();
							$mail = new YiiMailer();
							$sellerDetails = Myclass::getUserDetails($notifyTo);
							$c_username = $sellerDetails->name;
							$emailTo = $sellerDetails->email;
							$userDetails = Myclass::getUserDetails($user_Id);
							$r_username = $userDetails->name;
							if($siteSettings->smtpEnable == 1) {
								//$mail->IsSMTP();                         // Set mailer to use SMTP
								$mail->Mailer = 'smtp';                         // Set mailer to use SMTP
								$mail->Host = $siteSettings->smtpHost;  // Specify main and backup server
								$mail->SMTPAuth = true;                               // Enable SMTP authentication
								$mail->Username = $siteSettings->smtpEmail;                            // SMTP username
								$mail->Password = $siteSettings->smtpPassword;                           // SMTP password
								$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
								$mail->Port = $siteSettings->smtpPort;
							}
				
							$mail->setView('exchangecreated');
							$mail->setData(array('c_username' => $c_username, 'r_username' => $r_username,
									'siteSettings' => $siteSettings));
							$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
							$mail->setTo($emailTo);
							$mail->setSubject($r_username.' sent Exchange Request with your product');
							$mail->send();						
						
						echo 'success';
					}
				}
			}
		}
	}

	public function actionGeneratecoupon() {
		$model = new Coupons;
		$model->setScenario('itemView');
		$model->sellerId = $_POST['userId'];
		$model->productName = Myclass::getProductDetails($_POST['productId'])->name;
		$model->productId = $_POST['productId'];
		$model->couponType = self::FIXED;
		$model->couponValue = $_POST['couponValue'];
		$model->status = 1;
		$model->currency = $_POST['currency'];
		$model->couponCode = Myclass::getRandomString(8);
		if($model->save(false)) {
			echo $model->couponCode;
		}
	}
	public function actionSoldItem() {
		if(isset($_POST)) {
			$id = $_POST['id'];
			$value = $_POST['value'];
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];

			if($value == 1) {
				$product = $this->loadModel($id);
				//echo "<pre>";print_r($product);
				if($product->promotionType != 3){
					$promotionCriteria = new CDbCriteria();
					$promotionCriteria->addCondition("productId = $id");
					$promotionCriteria->addCondition("status LIKE 'live'");
					$promotionModel = Promotiontransaction::model()->find($promotionCriteria);
					if(!empty($promotionModel)){
						if($promotionModel->promotionName != 'urgent'){
							$previousCriteria = new CDbCriteria();
							$previousCriteria->addCondition("productId = $id");
							$previousCriteria->addCondition("status LIKE 'Expired'");
							$previousPromotion = Promotiontransaction::model()->find($previousCriteria);
							if(!empty($previousPromotion)){
								$previousPromotion->status = "Canceled";
								$previousPromotion->save(false);
							}
						}
						$promotionModel->status = "Expired";
						$promotionModel->save(false);
					}
					$product->promotionType = 3;
				}
				
				$product->soldItem = 1;
				$product->save(false);
			} else {
				$product = $this->loadModel($id);
				$product->soldItem = 0;
				$product->quantity = 1;
				$product->save(false);
			}
		}
	}

	public function actioncheckChatId() {
		$user1 = $_POST['user1'];
		$user2 = $_POST['user2'];
		$criteria = new CDbCriteria;
		$criteria->condition = "(`user1` = '$user1' AND `user2` = '$user2' OR `user1` = '$user2' AND `user2` = '$user1')";
		$chatCheck = Chats::model()->find($criteria);
		if(!empty($chatCheck)) {
			echo Myclass::safe_b64encode($user1.'-0');
		}
	}
}
