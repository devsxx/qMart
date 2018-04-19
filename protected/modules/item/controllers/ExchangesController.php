<?php

class ExchangesController extends Controller
{
	const ACCEPT = 1;
	const DECLINE = 2;
	const CANCEL = 3;
	const SUCCESS = 4;
	const FAILED = 5;
	const SOLDOUT = 6;
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
			'postOnly + delete', // we only allow deletion via POST request
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

		$user = Yii::app()->user;
		if($user->isGuest) {
			$this->redirect(array('/user/login'));
			return false;
		}

		return true;
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{	$userId = Yii::app()->user->id;
		$model = Users::model()->findByPk($userId);
		$exchange = Exchanges::model()->find("slug='$id'");
		$mainProduct = Products::model()->findByPk($exchange->mainProductId);
		$exchangeProduct = Products::model()->findByPk($exchange->exchangeProductId);
		if($exchange->status == self::ACCEPT || $exchange->status == 0) {
			if($exchange->status != self::SUCCESS) {
				if($mainProduct->quantity == 0 || $exchangeProduct->quantity == 0) {
					$exchange->status = self::SOLDOUT;
					$exchange->save(false);
				}
			}
			$this->render('view',compact('model','exchange','mainProduct','exchangeProduct'));
		}else{
			$_SESSION['exchange_message'] = Yii::t('app','Exchange marked as Success or Failed');
			$this->redirect(array('index','type'=>'incoming'));
		}
	}

	public function actionHistoryview() {
		if(isset($_POST['exchangeId']))
		$slug = $_POST['exchangeId'];
		else
		$slug = Yii::app()->request->getParam('exchangeId');

		$exchange = Exchanges::model()->find("slug='$slug'");

		$history = json_decode($exchange->exchangeHistory,true);
		$count = count($history);
		$pages = new CPagination($count);
		$pages->setPageSize(10);
		$dataProvider=new CArrayDataProvider($history,array('sort'=> array(
          'defaultOrder'=>'date DESC',
		)));
		$dataProvider->setPagination($pages);
		$this->renderPartial('historyview',compact('history','pages','slug','dataProvider',false,true));


	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Exchanges;
		$user_Id = Yii::app()->user->id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Exchanges']))
		{
			$model->attributes=$_POST['Exchanges'];
			if($model->save()){
				$userid = $_POST['Exchanges']['requestFrom'];
				$senderid = $_POST['Exchanges']['requestTo'];
				
				$notifyTo = $userid;
				$notifyItem = $model->mainProductId;
				if($user_Id == $userid){
					$notifyTo = $senderid;
					$notifyItem = $model->exchangeProductId;
				}
				$notifyMessage = 'Sent Exchange request to your product';
				Myclass::addLogs("exchange", $user_Id, $notifyTo, $model->id, $notifyItem, $notifyMessage);
				
				$pushsender = $user_Id;
				$pushuser = $notifyTo;
				$sellerDetails = Myclass::getUserDetails($notifyTo);

				$c_username = $sellerDetails->name;
				$emailTo = $sellerDetails->email;
				$userDetails = Myclass::getUserDetails($user_Id);
				$r_username = $userDetails->name;
				$criteria = new CDbCriteria;
				$criteria->addCondition('user_id = "'.$pushuser.'"');
				$userdevicedet = Userdevices::model()->findAll($criteria);
				$productRecord = Products::model()->findByPk($model->mainProductId);
				if(count($userdevicedet) > 0){
					foreach($userdevicedet as $userdevice){
						$deviceToken = $userdevice->deviceToken;
						$badge = $userdevice->badge;
						$badge +=1;
						$userdevice->badge = $badge;
						$userdevice->deviceToken = $deviceToken;
						$userdevice->save(false);
						if(isset($deviceToken)){
							$messages = $r_username." has sent an exchange request on your product ".$productRecord->name;
							Myclass::pushnot($deviceToken,$messages,$badge);
						}
					}
				}

				$siteSettings = Sitesettings::model()->find();
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
				
				$mail->setView('exchangecreated');
				$mail->setData(array('c_username' => $c_username, 'r_username' => $r_username,
						'siteSettings' => $siteSettings));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($emailTo);
				$mail->setSubject($r_username.' sent Exchange Request with your product');
				$mail->send();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Exchanges']))
		{
			$model->attributes=$_POST['Exchanges'];
			if($model->save())
			$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($type)
	{	
		$userId = Yii::app()->user->id;
		$model = Users::model()->findByPk($userId);
		if (isset($_SESSION['exchange_message'])){
			Yii::app()->user->setFlash('error', $_SESSION['exchange_message']);
			unset($_SESSION['exchange_message']);
		}
		
		if($type == 'incoming') {
			$incriteria = new CDbCriteria;
			$incriteria->addCondition("requestTo = $userId");
			$incriteria->addCondition("status = 0 OR status = 1",'AND');
			$incriteria->order = 'date DESC';
			$count = Exchanges::model()->count($incriteria);
			$pages = new CPagination($count);
			$pages->setPageSize(10);
			$pages->applyLimit($incriteria);
			$exchanges = Exchanges::model()->findAll($incriteria);
			$this->render('index',compact('model','exchanges','pages','type','userId'));
		}

		if($type == 'outgoing') {
			$outcriteria = new CDbCriteria;
			$outcriteria->addCondition("requestFrom = $userId");
			$outcriteria->addCondition("status = 0 OR status = 1",'AND');
			$outcriteria->order = 'date DESC';
			$count = Exchanges::model()->count($outcriteria);
			$pages = new CPagination($count);
			$pages->setPageSize(10);
			$pages->applyLimit($outcriteria);
			$exchanges = Exchanges::model()->findAll($outcriteria);
			$this->render('index',compact('model','exchanges','pages','type','userId'));
		}
		if($type == 'success') {
			$scriteria = new CDbCriteria;
			$scriteria->addCondition("requestTo = $userId");
			$scriteria->addCondition("requestFrom = $userId",'OR');
			$scriteria->addCondition("status = ".self::SUCCESS,'AND');
			$scriteria->order = 'date DESC';
			$count = Exchanges::model()->count($scriteria);
			$pages = new CPagination($count);
			$pages->setPageSize(10);
			$pages->applyLimit($scriteria);
			$exchanges = Exchanges::model()->findAll($scriteria);
			$this->render('index',compact('model','exchanges','pages','type','userId'));
		}
		if($type == 'failed') {
			$fcriteria = new CDbCriteria;
			$decline = self::DECLINE;
			$cancel = self::CANCEL;
			$failed = self::FAILED;
			$soldout = self::SOLDOUT;
			$fcriteria->condition = "(`requestTo` = $userId OR `requestFrom` = $userId) AND (`status` = $decline OR `status` = $failed OR `status` = $cancel OR `status` = $soldout)";
			$fcriteria->order = 'date DESC';
			$count = Exchanges::model()->count($fcriteria);
			$pages = new CPagination($count);
			$pages->setPageSize(10);
			$pages->applyLimit($fcriteria);
			$exchanges = Exchanges::model()->findAll($fcriteria);
			$this->render('index',compact('model','exchanges','pages','type','userId'));
		}
		if($type != 'incoming'){ if($type!= 'outgoing') { if($type != 'success') { if($type != 'failed') {
			$this->redirect(array('index','type' => 'incoming'));
		} }}}
	}
	public function actionAccept($id) {
		
		$user_Id = Yii::app()->user->id;
		$status = $this->loadModel($id);
		if($status->status == 0){
			$status->status = self::ACCEPT;
			$status->save(false);
			if (!isset($_POST['ajax'])){
				$this->redirect(array('index','type'=>'incoming'));
			}else{
				echo 1;
			}
			
			$accriteria = new CDbCriteria;
			$accriteria->addCondition("id = $id");
			$exchanges = Exchanges::model()->find($accriteria);
			if(isset($exchanges)){
				$userid = $exchanges->requestFrom;
				$senderid = $exchanges->requestTo;

				$notifyTo = $userid;
				$notifyItem = $exchanges->mainProductId;
				if($user_Id == $userid){
					$notifyTo = $senderid;
					$notifyItem = $exchanges->exchangeProductId;
				}
				
				$notifyMessage = 'Accepted your Exchange request on';
				Myclass::addLogs("exchange", $user_Id, $notifyTo, $id, $notifyItem, $notifyMessage);
				
				$pushsender = $user_Id;
				$pushuser = $notifyTo;
				/*if($user_Id == $userid){
					$pushuser = $senderid;
					$pushsender = $userid;
				}*/
				$sellerDetails = Myclass::getUserDetails($notifyTo);
				$c_username = $sellerDetails->name;
				$emailTo = $sellerDetails->email;
				$userDetails = Myclass::getUserDetails($user_Id);
				$r_username = $userDetails->name;
				$criteria = new CDbCriteria;
				$criteria->addCondition('user_id = "'.$pushuser.'"');
				$userdevicedet = Userdevices::model()->findAll($criteria);
				$productRecord = Products::model()->findByPk($exchanges->exchangeProductId);
				if(count($userdevicedet) > 0){
					foreach($userdevicedet as $userdevice){
					$deviceToken = $userdevice->deviceToken;
					$badge = $userdevice->badge;
					$badge +=1;
					$userdevice->badge = $badge;
					$userdevice->deviceToken = $deviceToken;
					$userdevice->save(false);
					if(isset($deviceToken)){
						$messages = $r_username." has accepted your exchange request on ".$productRecord->name;
						Myclass::pushnot($deviceToken,$messages,$badge);
					}	
					}
				}
			
			}
				$siteSettings = Sitesettings::model()->find();
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
				
				$mail->setView('exchangeaccept');
				$mail->setData(array('c_username' => $c_username, 'r_username' => $r_username,
						'siteSettings' => $siteSettings));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($emailTo);
				$mail->setSubject($r_username.' Exchange Request with your product was Accepted');
				$mail->send();

		}else{
			if ($status->status == 1){
				$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Accept');
				$redirectType = 'incoming';
				$ajaxOutput = 1;
			}else if ($status->status == 2 || $status->status == 3){
				$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Canceled or Declined');
				$redirectType = 'failed';
				$ajaxOutput = 0;
			}
				
			if(!isset($_POST['ajax'])){
				$this->redirect(array('index','type'=>$redirectType));
			}else{
				echo $ajaxOutput;
			}
			/* $_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Canceled');
			if(!isset($_POST['ajax'])){
				$this->redirect(array('index','type'=>'failed'));
			}else{
				echo 0;
			} */
		}
	}
	public function actionDecline($id) {
		$user_Id = Yii::app()->user->id;
		$status = $this->loadModel($id);
		if($status->status == 0){
			$status->status = self::DECLINE;
			$user = Yii::app()->user->id;
			$history = array();
			if(!empty($status->exchangeHistory)) {
				$history = json_decode($status->exchangeHistory,true);
			}
			$history[] = array('status' =>'declined','date'=>time(),'user'=>$user);
			$status->exchangeHistory = json_encode($history);
			$status->save(false);
			if (!isset($_POST['ajax'])){
				$this->redirect(array('index','type'=>'failed'));
			}else{
				echo 1;
			}

			$decriteria = new CDbCriteria;
			$decriteria->addCondition("id = $id");
			$exchanges = Exchanges::model()->find($decriteria);
			if(isset($exchanges)){
				$userid = $exchanges->requestFrom;
				$senderid = $exchanges->requestTo;

				$notifyTo = $userid;
				$notifyItem = $exchanges->mainProductId;
				if($user_Id == $userid){
					$notifyTo = $senderid;
					$notifyItem = $exchanges->exchangeProductId;
				}
				
				$notifyMessage = 'Declined your Exchange request on';
				Myclass::addLogs("exchange", $user_Id, $notifyTo, $id, $notifyItem, $notifyMessage);
				
				$pushsender = $user_Id;
				$pushuser = $notifyTo;
				/*if($user_Id == $userid){
					$pushuser = $senderid;
					$pushsender = $userid;
				}*/
				$sellerDetails = Myclass::getUserDetails($notifyTo);
				$c_username = $sellerDetails->name;
				$emailTo = $sellerDetails->email;
				$userDetails = Myclass::getUserDetails($user_Id);
				$r_username = $userDetails->name;
				$criteria = new CDbCriteria;
				$criteria->addCondition('user_id = "'.$pushuser.'"');
				$userdevicedet = Userdevices::model()->findAll($criteria);
				$productRecord = Products::model()->findByPk($exchanges->exchangeProductId);
				if(count($userdevicedet) > 0){
					foreach($userdevicedet as $userdevice){
					$deviceToken = $userdevice->deviceToken;
					$badge = $userdevice->badge;
					$badge +=1;
					$userdevice->badge = $badge;
					$userdevice->deviceToken = $deviceToken;
					$userdevice->save(false);
					if(isset($deviceToken)){
						$messages = $r_username." has declined your exchange request on ".$productRecord->name;
						Myclass::pushnot($deviceToken,$messages,$badge);
					}
					}	
				}
			}

				$siteSettings = Sitesettings::model()->find();
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
				
				$mail->setView('exchangedecline');
				$mail->setData(array('c_username' => $c_username, 'r_username' => $r_username,
						'siteSettings' => $siteSettings));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($emailTo);
				$mail->setSubject($r_username.' Exchange Request with your product was Declined');
				$mail->send();
			
		}else{
			if ($status->status == 1){
				$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Accept');
				$redirectType = 'incoming';
				$ajaxOutput = 0;
			}else if ($status->status == 2 || $status->status == 3){
				$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Canceled or Declined');
				$redirectType = 'failed';
				$ajaxOutput = 1;
			}
			
			if(!isset($_POST['ajax'])){
				$this->redirect(array('index','type'=>$redirectType));
			}else{
				echo $ajaxOutput;
			}
			/* $_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Canceled');
			if(!isset($_POST['ajax'])){
				$this->redirect(array('index','type'=>'failed'));
			}else{
				echo 0;
			} */
		}

	}
	public function actionCancel($id) {
		$user_Id = Yii::app()->user->id;
		$status = $this->loadModel($id);
		if($status->status == 0){
			$status->status = self::CANCEL;
			$user = Yii::app()->user->id;
			$history = array();
			if(!empty($status->exchangeHistory)) {
				$history = json_decode($status->exchangeHistory,true);
			}
			$history[] = array('status' =>'cancelled','date'=>time(),'user'=>$user);
			$status->exchangeHistory = json_encode($history);
			$status->save(false);
			if (!isset($_POST['ajax'])){
				$this->redirect(array('index','type'=>'failed'));
			}else{
				echo 1;
			}
	
			$cacriteria = new CDbCriteria;
			$cacriteria->addCondition("id = $id");
			$exchanges = Exchanges::model()->find($cacriteria);
			if(isset($exchanges)){
			$userid = $exchanges->requestFrom;
			$senderid = $exchanges->requestTo;

			$notifyTo = $userid;
			$notifyItem = $exchanges->mainProductId;
			if($user_Id == $userid){
				$notifyTo = $senderid;
				$notifyItem = $exchanges->exchangeProductId;
			}
			$notifyMessage = 'Cancelled your Exchange request on';
			Myclass::addLogs("exchange", $user_Id, $notifyTo, $id, $notifyItem, $notifyMessage);
			
			$pushsender = $user_Id;
			$pushuser = $notifyTo;
			/*if($user_Id == $userid){
				$pushuser = $senderid;
				$pushsender = $userid;
			}*/
			$sellerDetails = Myclass::getUserDetails($notifyTo);
			$c_username = $sellerDetails->name;
			$emailTo = $sellerDetails->email;
			$userDetails = Myclass::getUserDetails($user_Id);
			$r_username = $userDetails->name;
			$criteria = new CDbCriteria;
			$criteria->addCondition('user_id = "'.$pushuser.'"');
			$userdevicedet = Userdevices::model()->findAll($criteria);
			$productRecord = Products::model()->findByPk($exchanges->mainProductId);
			if(count($userdevicedet) > 0){
				foreach($userdevicedet as $userdevice){
				$deviceToken = $userdevice->deviceToken;
				$badge = $userdevice->badge;
				$badge +=1;
				$userdevice->badge = $badge;
				$userdevice->deviceToken = $deviceToken;
				$userdevice->save(false);
				if(isset($deviceToken)){
					$messages = $r_username." has cancelled the exchange request on your product ".$productRecord->name;
					Myclass::pushnot($deviceToken,$messages,$badge);
				}		
			}
			}
		}
			

				$siteSettings = Sitesettings::model()->find();
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
				
				$mail->setView('exchangecancel');
				$mail->setData(array('c_username' => $c_username, 'r_username' => $r_username,
						'siteSettings' => $siteSettings));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($emailTo);
				$mail->setSubject($r_username.' cancelled Exchange Request with your product');
				$mail->send();

		}else{
			if ($status->status == 1){
				$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Accept');
				$redirectType = 'outgoing';
				$ajaxOutput = 0;
			}else if ($status->status == 2 || $status->status == 3 || $status->status == 5){
				$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Declined or Cancled');
				$redirectType = 'failed';
				$ajaxOutput = 1;
			}else if ($status->status == 4){
				$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Success');
				$redirectType = 'success';
				$ajaxOutput = 2;
			}
			
			if(!isset($_POST['ajax'])){
				$this->redirect(array('index','type'=>$redirectType));
			}else{
				echo $ajaxOutput;
			}
		}

	}
	public function actionCancelExchange($id) {
		$status = $this->loadModel($id);
		$status->blockExchange = '1';
		$status->save(false);
	}
	public function actionAllowExchange($id) {
		$status = $this->loadModel($id);
		$status->blockExchange = '0';
		$status->save(false);
	}
	public function actionSuccess($id) {
		$user_Id = Yii::app()->user->id;
		$status = $this->loadModel($id);
		if($status->status == 1){
			$status->status = self::SUCCESS;
			$user = Yii::app()->user->id;
			$history = array();
			if(!empty($status->exchangeHistory)) {
				$history = json_decode($status->exchangeHistory,true);
			}
			$history[] = array('status' =>'success','date'=>time(),'user'=>$user);
			$status->reviewFlagSender = 1;
			$status->reviewFlagReceiver = 1;
			$status->exchangeHistory = json_encode($history);
			$status->save(false);
	
			$mainProduct = Products::model()->findByPK($status->mainProductId);
			
			$mainProduct->soldItem = 1;
			if($mainProduct->promotionType != 3){
				$promotionCriteria = new CDbCriteria();
				$promotionCriteria->addCondition("productId = $mainProduct->productId");
				$promotionCriteria->addCondition("status LIKE 'live'");
				$promotionModel = Promotiontransaction::model()->find($promotionCriteria);
			
				if(!empty($promotionModel)){
					if($promotionModel->promotionName != 'urgent'){
						$previousCriteria = new CDbCriteria();
						$previousCriteria->addCondition("productId = $promotionModel->productId");
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
			}
			$mainProduct->promotionType = 3;
			
			$mainProduct->quantity--;
			$mainProduct->save(false);
	
			$exProduct = Products::model()->findByPK($status->exchangeProductId);
			$exProduct->soldItem = 1;
			
			if($exProduct->promotionType != 3){
				$promotionCriteria = new CDbCriteria();
				$promotionCriteria->addCondition("productId = $exProduct->productId");
				$promotionCriteria->addCondition("status LIKE 'live'");
				$promotionModel = Promotiontransaction::model()->find($promotionCriteria);
					
				if(!empty($promotionModel)){
					if($promotionModel->promotionName != 'urgent'){
						$previousCriteria = new CDbCriteria();
						$previousCriteria->addCondition("productId = $promotionModel->productId");
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
			}
			$exProduct->promotionType = 3;
					
			$exProduct->quantity--;
			$exProduct->save(false);
			
			$sucriteria = new CDbCriteria;
			$sucriteria->addCondition("id = $id");
			$exchanges = Exchanges::model()->find($sucriteria);
			if(isset($exchanges)){
			$userid = $exchanges->requestFrom;
			$senderid = $exchanges->requestTo;

			$notifyTo = $userid;
			$notifyItem = $exchanges->mainProductId;
			if($user_Id == $userid){
				$notifyTo = $senderid;
				$notifyItem = $exchanges->exchangeProductId;
			}
			$notifyMessage = 'Successed your Exchange request on';
			Myclass::addLogs("exchange", $user_Id, $notifyTo, $id, $notifyItem, $notifyMessage);
			
			$pushsender = $user_Id;
			$pushuser = $notifyTo;
			/*if($user_Id == $userid){
				$pushuser = $senderid;
				$pushsender = $userid;
			}*/
			$sellerDetails = Myclass::getUserDetails($notifyTo);
			$c_username = $sellerDetails->name;
			$emailTo = $sellerDetails->email;
			$userDetails = Myclass::getUserDetails($user_Id);
			$r_username = $userDetails->name;

			$criteria = new CDbCriteria;
			$criteria->addCondition('user_id = "'.$pushuser.'"');
			$userdevicedet = Userdevices::model()->findAll($criteria);
			if($notifyTo==$exchanges->requestFrom)
				$productRecord = Products::model()->findByPk($exchanges->exchangeProductId);
			else if($notifyTo==$exchanges->requestTo)
				$productRecord = Products::model()->findByPk($exchanges->mainProductId);
			if(count($userdevicedet) > 0){
				foreach($userdevicedet as $userdevice){
				$deviceToken = $userdevice->deviceToken;
				$badge = $userdevice->badge;
				$badge +=1;
				$userdevice->badge = $badge;
				$userdevice->deviceToken = $deviceToken;
				$userdevice->save(false);
				if(isset($deviceToken)){
					$messages = $r_username." has marked successful with your exchange request on ".$productRecord->name;
					Myclass::pushnot($deviceToken,$messages,$badge);
				}	
				}
			}
			}

				$siteSettings = Sitesettings::model()->find();
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
				
				$mail->setView('exchangesuccess');
				$mail->setData(array('c_username' => $c_username, 'r_username' => $r_username,
						'siteSettings' => $siteSettings));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($emailTo);
				$mail->setSubject($r_username.' Exchange Request with your product was Successed');
				$mail->send();
			
			$this->redirect(array('index','type'=>'success'));
		}else{
			if ($status->status == 4){
				$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Success');
				$redirectType = 'incoming';
				$ajaxOutput = 0;
			}else if ($status->status == 5){
				$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Failed');
				$redirectType = 'failed';
				$ajaxOutput = 1;
			}
				
			if(!isset($_POST['ajax'])){
				$this->redirect(array('index','type'=>$redirectType));
			}else{
				echo $ajaxOutput;
			}
			/* $_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Failed');
			$this->redirect(array('index','type'=>'failed')); */
		}
	}
	public function actionFailed($id) {
		$user_Id = Yii::app()->user->id;
		$status = $this->loadModel($id);
		if($status->status == 1){
			$status->status = self::FAILED;
			$user = Yii::app()->user->id;
			$history = array();
			if(!empty($status->exchangeHistory)) {
				$history = json_decode($status->exchangeHistory,true);
			}
			$history[] = array('status' =>'failed','date'=>time(),'user'=>$user);
			$status->exchangeHistory = json_encode($history);
	
			$status->save(false);
			
			$facriteria = new CDbCriteria;
			$facriteria->addCondition("id = $id");
			$exchanges = Exchanges::model()->find($facriteria);
			if(isset($exchanges)){
			$userid = $exchanges->requestTo;
			$senderid = $exchanges->requestFrom;

			$notifyTo = $userid;
			$notifyItem = $exchanges->mainProductId;
			if($user_Id == $userid){
				$notifyTo = $senderid;
				$notifyItem = $exchanges->exchangeProductId;
			}
			$notifyMessage = 'Failed your Exchange request on';
			Myclass::addLogs("exchange", $user_Id, $notifyTo, $id, $notifyItem, $notifyMessage);
			
			$pushsender = $user_Id;
			$pushuser = $notifyTo;
			/*if($user_Id == $userid){
				$pushuser = $senderid;
				$pushsender = $userid;
			}*/
			$sellerDetails = Myclass::getUserDetails($notifyTo);
			$c_username = $sellerDetails->name;
			$emailTo = $sellerDetails->email;
			$userDetails = Myclass::getUserDetails($user_Id);
			$r_username = $userDetails->name;
			$criteria = new CDbCriteria;
			$criteria->addCondition('user_id = "'.$pushuser.'"');
			$userdevicedet = Userdevices::model()->findAll($criteria);
			if($notifyTo==$exchanges->requestFrom)
				$productRecord = Products::model()->findByPk($exchanges->exchangeProductId);
			else if($notifyTo==$exchanges->requestTo)
				$productRecord = Products::model()->findByPk($exchanges->mainProductId);
			if(count($userdevicedet) > 0){
				foreach($userdevicedet as $userdevice){
				$deviceToken = $userdevice->deviceToken;
				$badge = $userdevice->badge;
				$badge +=1;
				$userdevice->badge = $badge;
				$userdevice->deviceToken = $deviceToken;
				$userdevice->save(false);
				if(isset($deviceToken)){
					$messages = $r_username." has marked as failed with your exchange request on ".$productRecord->name;
					Myclass::pushnot($deviceToken,$messages,$badge);
				}	
			}
		}
		}
			$siteSettings = Sitesettings::model()->find();
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
			
			$mail->setView('exchangefailed');
			$mail->setData(array('c_username' => $c_username, 'r_username' => $r_username,
					'siteSettings' => $siteSettings));
			$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
			$mail->setTo($emailTo);
			$mail->setSubject($r_username.' Exchange Request with your product was Failed');
			$mail->send();
			$this->redirect(array('index','type' => 'failed'));
		}else{
			$_SESSION['exchange_message'] = Yii::t('app','Exchange already marked as Success');
			$this->redirect(array('index','type'=>'success'));
		}

	}
	public function actionSold($id) {
		$user_Id = Yii::app()->user->id;
		$status = $this->loadModel($id);
		$status->status = self::SOLDOUT;
		$user = Yii::app()->user->id;
		$history = array();
		if(!empty($status->exchangeHistory)) {
			$history = json_decode($status->exchangeHistory,true);
		}
		$history[] = array('status' =>'failed','date'=>time(),'user'=>$user);
		$status->exchangeHistory = json_encode($history);
		$status->save(false);

			$socriteria = new CDbCriteria;
			$socriteria->addCondition("id = $id");
			$exchanges = Exchanges::model()->find($socriteria);
			if(isset($exchanges)){
			$userid = $exchanges->requestFrom;
			$senderid = $exchanges->requestTo;

			$notifyTo = $userid;
			$notifyItem = $exchanges->mainProductId;
			if($user_Id == $userid){
				$notifyTo = $senderid;
				$notifyItem = $exchanges->exchangeProductId;
			}
			$notifyMessage = 'Failed your Exchange request on';
			Myclass::addLogs("exchange", $user_Id, $notifyTo, $id, $notifyItem, $notifyMessage);
			
			$pushsender = $senderid;
			$pushuser = $userid;
			if($user_Id == $userid){
				$pushuser = $senderid;
				$pushsender = $userid;
			}
			$sellerDetails = Myclass::getUserDetails($pushsender);
			$criteria = new CDbCriteria;
			$criteria->addCondition('user_id = "'.$pushuser.'"');
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
					$messages = "Exchange Request sold out from ".$sellerDetails->username;
					Myclass::pushnot($deviceToken,$messages,$badge);
				}	
				}
			}
			}
		
		$this->redirect(array('index','type' => 'failed'));
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Exchanges('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Exchanges']))
		$model->attributes=$_GET['Exchanges'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Exchanges the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Exchanges::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Exchanges $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='exchanges-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionMessage($id = "",$sourceId = null,$from = null,$to = null) {
		if($from == Yii::app()->user->id) {
			$userId = $from;
		} else {
			$userId = $to;
		}

		$userDetails = Myclass::getUserDetails(Yii::app()->user->id);

		$criteria = new CDbCriteria;
		$criteria->condition = "user1 = '$from' AND user2 = '$to' OR user1 = '$to' AND user2 = '$from'";
		/* $criteria->addCondition("user1 = $from");
		$criteria->addCondition("user2 = $from",'OR');
		$criteria->addCondition("user1 = $to");
		$criteria->addCondition("user2 = $to",'OR');
		$criteria->order = 'lastContacted DESC'; */
		//	$criteria->condition = "user1 = '$userId' OR user2 = '$userId' order by lastContacted DESC";

		$chatedUser = Chats::model()->find($criteria);
		$firstChat = "";

		if (empty($chatedUser)){
			$chat = new Chats;
			$chat->user1 = $from;
			$chat->user2 = $to;
			$chat->lastContacted = time();
			$chat->save(false);
			$chatId = $chat->chatId;
			
			$chatedUser = Chats::model()->find($criteria);
		}
		$chattingUsers = array();
		if ($chatedUser->user1 != $userId){
			$chattingUsers = $chatedUser->user1;

		}elseif($chatedUser->user2 != $userId){
			$chattingUsers = $chatedUser->user2;

		}
		//$firstChat = $firstChat == '' ? $chatedUser->chatId : $firstChat;
		$chatUser = Users::model()->findByAttributes(array('userId'=>$chattingUsers));
		//var_dump($chatUserModel); exit;
		$chatId = $chatedUser->chatId;
		$messageModel = Messages::model()->findAllByAttributes(array('chatId'=>$chatedUser->chatId,
				'messageType'=>'exchange','sourceId' => $sourceId));

		$currentChatUserImage = $chatUser->userImage;
		if(!empty($currentChatUserImage)) {
			$currentChatUserImage = Yii::app()->createAbsoluteUrl('user/resized/80/'.$currentChatUserImage);
		} else {
			$currentChatUserImage = Yii::app()->createAbsoluteUrl('user/resized/80/default/'.Myclass::getDefaultUser());
		}
		if(!empty($userDetails->userImage)) {
			$currentUserImage = Yii::app()->createAbsoluteUrl('user/resized/80/'.$userDetails->userImage);
		} else {
			$currentUserImage = Yii::app()->createAbsoluteUrl('user/resized/80/default/'.Myclass::getDefaultUser());
		}

		// echo "<pre>";print_r($chattingUsers);print_r($messageModel);die;
		$this->renderPartial('message',array('currentUserDetails'=>$userDetails, 'chattingUsers'=>$chattingUsers,
				 'messageModel'=>$messageModel,'sourceId' => $sourceId, 'currentChatUserImage'=>$currentChatUserImage, 
				'currentUserImage'=>$currentUserImage,'chatUser' => $chatUser,'chatId' =>$chatId));
	}

	public function actionPostmessage(){
		if (isset($_POST)){
			$message = $_POST['message'];
			$senderId = $_POST['senderId'];
			$messageType = $_POST['messageType'];
			$sourceId = isset($_POST['sourceId']) ? $_POST['sourceId'] : 0;
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
	
				$chatModel = Chats::model()->findByPk($chatId);
	
				$chatModel->lastContacted = $timeUpdate;
				if ($chatModel->user1 == $senderId){
					$chatModel->lastToRead = $chatModel->user2;
				}else{
					$chatModel->lastToRead = $chatModel->user1;
				}
				$chatModel->lastMessage = $message;
				$chatModel->save();
						
				$userImage = Myclass::getUserDetails($senderId);

				
				/*$userid = $chatModel->user2;
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
					$messages = "You have message from ".$userImage->username." - ".$message;
					Myclass::pushnot($deviceToken,$messages,$badge);
				}	
				}
			}*/

				if(!empty($userImage)) {
					$userImage = CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/'.$userImage->userImage),$userImage->username);
				} else {
					$userImage = CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/40x40/default/'.Myclass::getDefaultUser()),$userImage->username);
				}
				echo '<div class="chat-grid-userimage">'.$userImage.'</div><div class="chat-grid-details">
						<p class="chat-grid-msgs">'.$message.'</p><p class="chat-grid-time">'.date('M jS Y', $timeUpdate).'</p>
						</div>';
			}else{
				echo "";
			}
		}
	}
	
	
	public function actionSavereview(){
		
		if (isset($_POST)){
			$senderId = $_POST['sender'];
			$receiverId = $_POST['receiver'];
			$rating = $_POST['rating'];
			$message = $_POST['message'];
			$reviewType = $_POST['reviewType'];
			$sourceId = isset($_POST['exchangeId']) ? $_POST['exchangeId'] : 0;
			$timeUpdate = time();
				
			$p = new CHtmlPurifier();
			$message = $p->purify($message);
			
			if ($message != ""){
		
				$messageModel = new Reviews();
				$messageModel->senderId = $senderId;
				$messageModel->receiverId = $receiverId;
				$messageModel->rating = $rating;
				$messageModel->review = $message;
				$messageModel->sourceId = $sourceId;
				$messageModel->reviewType = $reviewType;
				$messageModel->createdDate = $timeUpdate;
				$messageModel->save(false);
								
				if ($reviewType == 'exchange'){
					$exchangeModel = Exchanges::model()-> findByPk($sourceId);
					if( $exchangeModel->requestFrom == Yii::app()->user->id)
						$exchangeModel->reviewFlagSender = 0;
					if ($exchangeModel->requestTo == Yii::app()->user->id)
						$exchangeModel->reviewFlagReceiver = 0;
					$exchangeModel->save(false);
					
				}elseif ($reviewType == 'order'){
					$reviewModel = Orders::model()->findByPk($sourceId);
					$reviewModel->reviewFlag = 0;
					$reviewModel->save(false);
					
				}
				
				
				$reviewCriteia = new CDbCriteria;
				$reviewCriteia->addCondition('receiverId = "'.$receiverId.'"');
				$review = Reviews::model()->findAll($reviewCriteia);
				$ratings = '';
				$count = count($review);
				foreach ($review as $reviews):
				$ratings += $reviews->rating;
				endforeach;
				
				$ratings = floor($ratings / $count);
				$userDetail = Users::model()->findByPk($receiverId);
				$userDetail->averageRating = $ratings;
				$userDetail->save(false);
				
				echo "success";
			}
		}else{
				echo "error";
		}
	}

	public function actionEditsaveReview(){
		
		if (isset($_POST)){
			$reviewId = $_POST['reviewId'];
			$reviews = $_POST['reviews'];
			$ratings = $_POST['ratings'];
			
			$p = new CHtmlPurifier();
			$reviews = $p->purify($reviews);
			
			$reviewModel = Reviews::model()->findByPk($reviewId);
			$receiverId = $reviewModel->receiverId;
			$reviewModel->review = $reviews;
			$reviewModel->rating = $ratings;
			$reviewModel->save(false);
			
			$reviewCriteia = new CDbCriteria;
			$reviewCriteia->addCondition('receiverId = "'.$receiverId.'"');
			$review = Reviews::model()->findAll($reviewCriteia);
			$ratings = '';
			$count = count($review);
			foreach ($review as $reviews):
			$ratings += $reviews->rating;
			endforeach;
			
			$ratings = floor($ratings / $count);
			$userDetail = Users::model()->findByPk($receiverId);
			$userDetail->averageRating = $ratings;
			$userDetail->save(false);
			echo "success";
		}else{
			echo "error";
		}
	}
}
