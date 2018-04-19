<?php
class UserController extends Controller
{

	/**
	 * Declares class-based actions.
	 */

	protected function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
			return false;
		}
		if(Yii::app()->user->isGuest) {
			$allowedActions = array('login', 'forgotpassword','signup','socialLogin','socialLogininit','check_mailstatus', 'sitemap', 
									'verify', 'resetpassword', 'verify_mail', 'resized','socialsignup','profiles','liked','review','follower','following');
		} else {
			$allowedActions = array('login', 'forgotpassword','signup','socialLogin','verify_mail', 'sitemap', 
									'verify', 'resetpassword', 'resized','socialsignup','check_mailstatus');
		}
		//echo Yii::app()->_COOKIE('username');
//echo $_COOKIE['username'];
		
		//echo $_COOKIE['username'];
		//echo Yii::app()->_COOKIE['usernames'];
		/*if(isset(Yii::app()->request->cookies['userid']->value))
		{
			$cookie_userid = Yii::app()->request->cookies['userid']->value;
			$user = Myclass::getUserbyemail($cookie_userid);
			$userdata = Myclass::getUserDetails($user->userId);
								$model=new LoginForm;
					$model->username = $userdata->email;
					$model->password = base64_decode($userdata->password);
					$model->login();
			//Yii::app()->user->login ( $userdata );
		}*/

		$user = Yii::app()->user;
		if($user->isGuest && !in_array(Yii::app()->controller->action->id, $allowedActions)) {
			$this->redirect(array('login'));
			return false;
		}
		if(!empty(Yii::app()->user->id) && Yii::app()->controller->action->id != 'resized' &&
		in_array(Yii::app()->controller->action->id, $allowedActions)) {
			$this->redirect('/');
			return false;
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
								'base_dir'    => Yii::getPathOfAlias('webroot') . '/media/user/',
		)
		),
		// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
		),
		// page action renders "static" pages stored under 'protected/views/site/pages'
		// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
		),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
	// return the filter configuration for this controller, e.g.:
	return array(
	'inlineFilterName',
	array(
	'class'=>'path.to.FilterClass',
	'propertyName'=>'propertyValue',
	),
	);
	}

	public function actions()
	{
	// return external action classes, e.g.:
	return array(
	'action1'=>'path.to.ActionClass',
	'action2'=>array(
	'class'=>'path.to.AnotherActionClass',
	'propertyName'=>'propertyValue',
	),
	);
	}
	*/

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				Yii::app()->user->setFlash('success',Yii::t('app','You have successfully logged in.'));
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		$siteSettingsModel = Sitesettings::model()->findByAttributes(array('id'=>1));
		$siteSettingsModel = json_decode($siteSettingsModel->socialLoginDetails, true);
		// display the login form
		$this->render('login',array('model'=>$model, 'socialLogin'=>$siteSettingsModel));
	}

	/**
	 * Action to provide the social login
	 * option.
	 *
	 * @throws CHttpException
	 */
	public function actionsocialLogin($type = NULL)
	{
		if (!isset($_GET['provider']) && $type == NULL){
			$this->redirect(array('/user/login'));
			return;
		}

		try{
			if(isset($_GET['provider'])){
				$type = $_GET['provider'];
			}
			$_SESSION['provider'] = $type;
			//Yii::import('ext.components.HybridAuthIdentity');
			$haComp = new HybridAuthIdentity();

			if (!$haComp->validateProviderName($type))
			throw new CHttpException ('500', 'Invalid Action. Please try again.');
			//echo "<pre>";print_r($haComp->validateProviderName($_GET['provider']));die;
			$haComp->adapter = $haComp->hybridAuth->authenticate($type);

			$haComp->userProfile = $haComp->adapter->getUserProfile();
			//echo '<pre>'; var_dump($haComp->userProfile); exit;

			if($haComp->adapter->id == 'Twitter') {
				$userStatus = $haComp->twitLogin();
			} else {
				$userStatus = $haComp->login();
			}
			if($userStatus === true) {
				Yii::app()->user->setFlash('success',Yii::t('app','You have successfully logged in.'));
				$this->redirect(Yii::app()->homeUrl);
			}elseif ($userStatus == "disabled"){
				Yii::app()->user->setFlash('success',Yii::t('app','Your account has been disabled by the Administrator.'));
				$haComp->hybridAuth->logoutAllProviders();
				$this->redirect(Yii::app()->homeUrl);
			}elseif ($userStatus == "no-email"){
				Yii::app()->user->setFlash('success',Yii::t('app','Unable to retrive your email, Please check with your social login provider'));
				$haComp->hybridAuth->logoutAllProviders();
				$this->redirect(Yii::app()->homeUrl);
			}else {
				$this->actionSocialsignup($userStatus);
			}

		}
		catch (Exception $e)
		{
			//process error message as required or as mentioned in the HybridAuth 'Simple Sign-in script' documentation
			$this->redirect(array('login'));
			return;
		}
	}
	public function actionSocialsignup($socialModel = null) {
		if($socialModel != null){
			$this->render('socialsignup',array('model'=>$socialModel));
			return;
		}
		$model=new Users('register');
		// uncomment the following code to enable ajax-based validation

		if(isset($_POST['ajax']) && $_POST['ajax']==='users-signup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Users']))
		{

			$model->attributes=$_POST['Users'];
			if(isset($_POST['Users']['twitterId'])) {
				$model->twitterId = $_POST['Users']['twitterId'];
			}
			if(isset($_POST['Users']['facebookId'])) {
				$model->facebookId = $_POST['Users']['facebookId'];
				$model->facebook_session = $_POST['Users']['facebookSession'];
				$fbdetails['email'] =  $_POST['Users']['fbemail'];
				$fbdetails['firstName'] =  $_POST['Users']['fbfirstName'];
				$fbdetails['lastName'] =  $_POST['Users']['fblastName'];
				$fbdetails['email'] =  $_POST['Users']['fbemail'];
				$fbdetails['phone'] =  $_POST['Users']['fbphone'];
				$fbdetails['profileURL'] =  $_POST['Users']['fbprofileURL'];
				$model->fbdetails = json_encode($fbdetails);
			}
			if(isset($_POST['Users']['googleId'])) {
				$model->googleId = $_POST['Users']['googleId'];
			}
			if(isset($_POST['Users']['userImage'])) {
				$imageURL = $_POST['Users']['userImage'];
			} else {
				$imageURL = '';
			}
			if($model->validate())
			{
				$model->username = str_replace(" ",'',$_POST['Users']['username']);
				if(!empty($imageURL)) {
					$userImg = file_get_contents($imageURL);
					$image = explode('?',$imageURL);
					$original_name = basename($image[0]);
					$original_extension = substr($original_name, strrpos($original_name, '.'));

					if(!is_null($userImg)) {
						$imageName = rand(0000,9999).'_'.Myclass::getRandomString(8).$original_extension;
					}
					if (!empty($imageName)) {
						file_put_contents('media/user/'.$imageName, $userImg);
					}
					$model->userImage = $imageName;
				}
				$model->password = base64_encode($_POST['Users']['password']);
				$model->userstatus = 1;
				$model->activationStatus = 1;
				$model->save(false);
				$usermodel = new LoginForm();
				$usermodel->username = $model->email;
				$usermodel->password = $_POST['Users']['password'];

				if($usermodel->validate() && $usermodel->login()) {
					Yii::app()->user->setFlash('success',Yii::t('app','You have successfully logged in.'));
					$this->redirect(Yii::app()->user->returnUrl);
				}
			}
		}
		$this->render('socialsignup',array('model'=>$model,'imageURL' => $imageURL));
	}

	public function actionSocialLogininit()
	{ 
		//Yii::import('ext.components.HybridAuthIdentity');
		$path = Yii::getPathOfAlias('ext.HybridAuth');
		require_once $path . '/hybridauth-' . HybridAuthIdentity::VERSION . '/hybridauth/index.php';

	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		$haComp = new HybridAuthIdentity();
		$haComp->logout();
		unset(Yii::app()->session['firstLogin']);
		unset(Yii::app()->session['cityName']);
		unset(Yii::app()->session['latitude']);
		unset(Yii::app()->session['longitude']);
		unset(Yii::app()->session['place']);
		unset(Yii::app()->request->cookies['userid']);
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionSitemap(){
		Yii::app()->sitemap->generateSitemap();
	}

	public function actionProfile() {
		$id = Yii::app()->user->id;
		$model->nowid = $id;
		$model = Users::model()->findByPk($id);
		$model->setScenario('profile');
		
		$oldUserImage = $model->userImage;
		$notifications = json_decode($model->notificationSettings,true);
		$model->live = $notifications['live'];
		$model->comment = $notifications['comment'];
		$model->message = $notifications['message'];
		$model->offer = $notifications['offer'];
		$model->updates = $notifications['updates'];
		/*if(!is_null($_FILES['XUploadForm']['name']['file'])) {
			$userCondition = new CDbCriteria;
			$userCondition->addCondition('userId = "'.$id.'"');
			$loguserdetails = Users::model()->find($userCondition);	
			$user_img = $_FILES['XUploadForm']['name']['file'];
			$userImge = rand(0000,9999).'_'.Myclass::productSlug($user_img);
			$loguserdetails->userImage = $userImge;
			$loguserdetails->save(false);
			$userImg->saveAs('media/user/'.$userImge);
		}*/
		if(isset($_POST['Users'])) { 
			$model->attributes = $_POST['Users'];
			if(!empty($_POST['Users']['username'])) {
				$model->username = str_replace(" ",'',$_POST['Users']['username']);
			}
			$userImg = CUploadedFile::getInstance($model,'userImage');
			$ext = pathinfo($userImg, PATHINFO_EXTENSION); 
			$allowedExtensions = array("jpg","jpeg","png","JPG","JPEG","PNG"); 
			if(!is_null($userImg)) {
				if(!in_array($ext, $allowedExtensions)){
				Yii::app()->user->setFlash('success',Yii::t('app','Invalid Image'));
				$this->redirect($_SERVER['HTTP_REFERER']);
				}
				$model->userImage = rand(0000,9999).'_'.Myclass::productSlug($userImg);

			} else {
				$model->userImage = $oldUserImage;
			}
			$model->notificationSettings = json_encode(
			array(
			'live' =>  $_POST['Users']['live'],
			'comment' => $_POST['Users']['comment'],
			'message' => $_POST['Users']['message'],
			'offer' => $_POST['Users']['offer'],
			'updates' => $_POST['Users']['updates']
			)
			);
			if($model->save(false)) {
				if(!is_null($userImg)) {
					$userImg->saveAs('media/user/'.$model->userImage);
				}
				Yii::app()->user->setFlash('success',Yii::t('app','User Profile updated successfully'));
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->render('profile',compact('model'));
	}
	
	public function actionGetSocialAccess()
	{ 
		if (!isset($_GET['provider']))
		{
			$this->redirect(array('/user/login'));
			return;
		}
		
		$facebookdetails = Myclass::getsocialLoginDetails();

		$userId = Yii::app()->user->id;
		$userCondition = new CDbCriteria;
		$userCondition->addCondition('userId = "'.$userId.'"');
		$userdetails = Users::model()->find($userCondition);
		
	/*	$root_path = Yii::app()->basePath;
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
		);*/
		try
		{	
			//Yii::import('ext.components.HybridAuthIdentity');
		/*	if(!empty($hybridauth_config)){
				$hybridauth = new Hybrid_Auth($hybridauth_config);
			}*/
			
			$haComp = new HybridAuthIdentity();
			
			$hybridauth_session_data = $haComp->hybridAuth->getSessionData();
			//echo $hybridauth_session_data; die;

			if (!$haComp->validateProviderName($_GET['provider']))
			throw new CHttpException ('500', 'Invalid Action. Please try again.');
			
			//echo "<pre>";print_r($haComp->validateProviderName($_GET['provider'])); die;
			$haComp->adapter = $haComp->hybridAuth->authenticate($_GET['provider']);
			//echo "<pre>";print_r($haComp->adapter); die;
			$haComp->userProfile = $haComp->adapter->getUserProfile();
			//echo '<pre>'; var_dump($haComp->userProfile);  echo 'hi';
			$facebookId =  $haComp->userProfile->identifier; 
			$fbdetails['email'] =  $haComp->userProfile->email; 
			$fbdetails['firstName'] =  $haComp->userProfile->firstName; 
			$fbdetails['lastName'] =  $haComp->userProfile->lastName;
			$fbdetails['email'] =  $haComp->userProfile->email; 
			$fbdetails['phone'] =  $haComp->userProfile->phone;
			$fbdetails['profileURL'] =  $haComp->userProfile->profileURL; 
			$fb_detail = json_encode($fbdetails);
			
			if($haComp->userProfile->email != '' || $haComp->userProfile->phone != '') {
				
				$userdetails->facebookId = $facebookId;
				$userdetails->fbdetails = $fb_detail;
				$userdetails->facebook_session = $hybridauth_session_data;
				$userdetails->save(false);
				echo "<script type='text/javascript'>
						window.opener.$('.facebook-verification').show();
						window.opener.$('#fb_verify').hide();
						window.opener.$('.fb-verification').attr('id','verified');
						window.opener.$('.fb-verification').attr('title','Facebook account Verified!');
						window.opener.$('.fb-verification').attr('data-original-title','Facebook account Verified!');
						window.close();
						</script>";
			}else{
				echo "<script type='text/javascript'>
						window.opener.$('.facebook-verification-failure').show();
						window.close();
						</script>";
			}

		}
		catch (Exception $e)
		{
			//process error message as required or as mentioned in the HybridAuth 'Simple Sign-in script' documentation
			$this->redirect(array('login'));
			return;
		}
		
	}
	public function actionSignup($socialModel = null)
	{
		if($socialModel != null){
			$this->render('signup',array('model'=>$socialModel));
			return;
		}

		$model=new Users('register');

		// uncomment the following code to enable ajax-based validation

		if(isset($_POST['ajax']) && $_POST['ajax']==='users-signup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}


		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			$model->name = strip_tags($_POST['Users']['name']);
			$model->username = str_replace(" ",'',$_POST['Users']['username']);
			if($model->validate())
			{
				$model->password = base64_encode($_POST['Users']['password']);
				$emailTo = $model->email;
				$model->userstatus = 1;
				$model->activationStatus = 0;
				if ($model->save(false)) {
					$verifyLink = Yii::app()->createAbsoluteUrl('/verify/'.base64_encode($emailTo));
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

					$mail->setView('signup');
					$mail->setData(array('access_url' => $verifyLink, 'name' => $model->name,
							'siteSettings' => $siteSettings));
					$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
					$mail->setTo($emailTo);
					$mail->setSubject($siteSettings->sitename.' Signup Verification Mail');
					if ($mail->send()) {
						Yii::app()->user->setFlash('login',Yii::t('app','Please verify your account by the mail sent to your email.'));
						$this->redirect(array('login'));
						//echo "email sent";die;
					} else {
						//Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
						echo $mail->getError();die;
					}

					$this->redirect(array('login'));
				}
				// form inputs are valid, do something here
				return;
			}
		}
		$siteSettingsModel = Sitesettings::model()->findByAttributes(array('id'=>1));
		$siteSettingsModel = json_decode($siteSettingsModel->socialLoginDetails, true);
		$this->render('signup',array('model'=>$model, 'socialLogin'=>$siteSettingsModel));
	}
	
	public function actionCheck_mailstatus() {
		$email = $_POST['email'];
		
		$userCondition = new CDbCriteria;
		$userCondition->addCondition('email = "'.$email.'"');
		$userdetails = Users::model()->find($userCondition);
		if(empty($userdetails)){
			echo '0'; die;
		} else {
			if($userdetails->activationStatus == '0') {
				echo '1-'.$userdetails->userId; die;
			} else {
				echo '2'; die;
			}
		}
	}
	
	public function actionVerify_mail(){
		$userId = $_GET['id'];
		
		$userCondition = new CDbCriteria;
		$userCondition->addCondition('userId = "'.$userId.'"');
		$userdetails = Users::model()->find($userCondition);
		
		$emailTo = $userdetails->email;
		$verifyLink = Yii::app()->createAbsoluteUrl('/verify/'.base64_encode($emailTo));
		$siteSettings = Sitesettings::model()->find();
		$mail = new YiiMailer();
		
		$mail->Mailer = 'smtp';                         // Set mailer to use SMTP
		$mail->Host = $siteSettings->smtpHost;  // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $siteSettings->smtpEmail;                            // SMTP username
		$mail->Password = $siteSettings->smtpPassword;                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
		$mail->Port = $siteSettings->smtpPort;
		
		$mail->setView('signup');
		$mail->setData(array('access_url' => $verifyLink, 'name' => $userdetails->name,
				'siteSettings' => $siteSettings));
		$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
		$mail->setTo($emailTo);
		$mail->setSubject(Myclass::getSiteName().' Reverification Mail');
		if ($mail->send()) {
		
			Yii::app()->user->setFlash('login',Yii::t('app','Please verify your account by the mail sent to your email.'));
			$this->redirect(array('login'));
		}else{
			Yii::app()->user->setFlash('login',Yii::t('app','Sorry, unable to send mail'));
			$this->redirect(Yii::app()->createAbsoluteUrl('login'));
                }
		
	}

	public function actionForgotpassword() {
		$model=new Users('forgetpassword');
		if(isset($_POST['Users'])) {
			if(isset($_POST['ajax']) && $_POST['ajax']==='forgetpassword-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
			$email = $_POST['Users']['email'];
			$criteria = new CDbCriteria;
			$criteria->addCondition("email='$email'");
			$criteria->addCondition("userstatus != 2");
			$check = Users::model()->find($criteria);
			if(!empty($check)) {
				//$userModel = Users::model()->findByPk($check->userId);
				$resetPasswordCheck = Resetpassword::model()->findByAttributes(array(
										'userId'=>$check->userId));
				if($check->userstatus == 1 && $check->activationStatus == 1) {
					/* $password = Myclass::getRandomString(8);
					$userModel->password = base64_encode($password); */
					if (empty($resetPasswordCheck)){
						$createdDate = time();
						$randomValue = rand(10000, 100000);
						$resetPasswordData = base64_encode($check->userId."-".$createdDate."-".$randomValue);
						$resetPasswordModel = new Resetpassword();
						$resetPasswordModel->userId = $check->userId;
						$resetPasswordModel->resetData = $resetPasswordData;
						$resetPasswordModel->createdDate = $createdDate;
						
						$resetPasswordModel->save();
					}else{
						$resetPasswordData = $resetPasswordCheck->resetData;
					}
	
					if(!empty($resetPasswordData)) {
						$resetPasswordLink = Yii::app()->createAbsoluteUrl('/resetpassword?resetLink='.$resetPasswordData);
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
						$mail->setView('forgetpassword');
						$mail->setData(array('name' => $check->name,
											'siteSettings' => $siteSettings,
											'uniquecode_pass'=> $resetPasswordLink));
						$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
						$mail->setTo($check->email);
						$mail->setSubject($siteSettings->sitename.' Reset Password Mail');
						if ($mail->send()) {
							Yii::app()->user->setFlash('success',Yii::t('app','Reset password link has been mailed to you.'));
							$this->redirect(array('login'));
							//$this->redirect(Yii::app()->createAbsoluteUrl('forgotpassword'));
							//echo "email sent";die;
						} else {
							//Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
							echo $mail->getError();die;
						}
					}
				}elseif($check->userstatus == 0 && $check->activationStatus == 0) {
					Yii::app()->user->setFlash('error',Yii::t('app','Your account has been disabled by the Administrator.'));
				}else {
					Yii::app()->user->setFlash('error',Yii::t('app','User not verified yet, activate the account from the email.'));
				}
			} else {
				$signupUrl = Yii::app()->createAbsoluteUrl('signup');
				Yii::app()->user->setFlash('error',Yii::t('app','Email Not Found'));
				$this->redirect($signupUrl);
			}
		}
		$this->render('forgetpassword', array('model'=>$model));
	}
	
	public function actionResetpassword(){
		$loginUrl = Yii::app()->createAbsoluteUrl('login');
		$homeUrl = Yii::app()->createAbsoluteUrl('/');
		if(isset($_GET['resetLink']) && !isset($_POST['Resetpassword'])) {
			$resetData = base64_decode($_GET['resetLink']);
			$resetData = explode('-', $resetData);
			$userId = $resetData[0];
			$resetPasswordModel = Resetpassword::model()->findByAttributes(array('userId'=>$userId));
			if(!empty($resetPasswordModel)){
				$this->render('resetpassword', array('model'=>$resetPasswordModel));
			}else{
				Yii::app()->user->setFlash("success",Yii::t('app','Access denied...!'));
				$this->redirect($loginUrl);
			}
		}elseif(isset($_POST['Resetpassword'])) {
			$userId = $_POST['Resetpassword']['user'];
			$password = base64_encode($_POST['Resetpassword']['resetpassword']);
			
			$userModel = Users::model()->findByPk($userId);
			$userModel->password = $password;
			if($userModel->save(false)){
				Resetpassword::model()->deleteAllByAttributes(array('userId'=>$userId));
				Yii::app()->user->setFlash("success",Yii::t('app','Password Reset Successfull'));
				$this->redirect($loginUrl);
			}else{
				Yii::app()->user->setFlash("success",Yii::t('app','Something went wrong, please try again'));
				$this->redirect($homeUrl);
			}
		}else{
			Yii::app()->user->setFlash("success",Yii::t('app','Access denied...!'));
			$this->redirect($loginUrl);
		}
	}

	public function actionVerify($details){
		//http://localhost:9002/qMart/verify/ZGVtbzdAaGFwcHlzYWxlLmNvbQ==
		if($details != ""){
			$email = base64_decode($details);
			$userModel = Users::model()->findByAttributes(array('email'=>$email));
			$loginUrl = Yii::app()->createAbsoluteUrl('login');
			$homeUrl = Yii::app()->createAbsoluteUrl('/');
			if(!empty($userModel)) {
				if($userModel->activationStatus == 1) {
					$userId = Yii::app()->user->id;
					if(!empty($userId)) {
						if(Yii::app()->user->id == $userModel->userId) {
							Yii::app()->user->setFlash("success",Yii::t('app','Account already verified.'));
							$this->redirect($homeUrl);
						} else {
							Yii::app()->user->setFlash("success",Yii::t('app','Account Mismatch.Please try later.'));
							$this->redirect($homeUrl);
						}
					} else {
						Yii::app()->user->setFlash("success",Yii::t('app','Account already verified, Please Login'));
						$this->redirect($loginUrl);
					}
				} else {
					$userModel->activationStatus = 1;
					$userModel->save();
					$model=new LoginForm;
					$model->username = $userModel->email;
					$model->password = base64_decode($userModel->password);
					if($model->validate() && $model->login()) {
						Yii::app()->user->setFlash("success",Yii::t('app','Your account has been verified.'));
						$this->redirect($homeUrl);
					}
				}
			}else{
				Yii::app()->user->setFlash("success",Yii::t('app','Access denied...!'));
				$this->redirect($loginUrl);
			}
		}else{
			Yii::app()->user->setFlash("success",Yii::t('app','Access denied...!'));
			$this->redirect($loginUrl);
		}
	}
	public function actionMobile_verificationCode() {
		$mobile = $_POST['mobile'];
		$id = Yii::app()->user->id;
		$pass= rand(100000, 999999);
		
		$userCondition = new CDbCriteria;
		$userCondition->addCondition('userId = "'.$id.'"');
		$loguserdetails = Users::model()->find($userCondition);
		$loguserdetails->mobile_verificationcode = $pass;
		//$loguserdetails->phone = $mobile;
		$loguserdetails->save(false);
		echo $pass; die;
	}
	public function actionMobile_verificationStatus() {
		$otp_code = $_POST['otp_code'];
		$mobile = $_POST['mobile'];
		$id = Yii::app()->user->id;
		$userCondition = new CDbCriteria;
		$userCondition->addCondition('userId = "'.$id.'"');
		$loguserdetails = Users::model()->find($userCondition);
		if($loguserdetails->mobile_verificationcode == $otp_code) {
			$loguserdetails->mobile_status = '1';
			$loguserdetails->phone = $mobile;
			$loguserdetails->save(false);
			echo '1'; die;
		} else {
			echo '0'; die;
		}		
	}
	public function actionNotifications()
	{
		$id = Yii::app()->user->id;
		$check = Notifications::model()->find("user_id = $id");
		if(empty($check)) {
			$model = new Notifications();
		} else {
			$model = Notifications::model()->find("user_id = $id");
		}
		// uncomment the following code to enable ajax-based validation
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='notifications-notifications-form')
		{
		echo CActiveForm::validate($model);
		Yii::app()->end();
		}
		*/

		if(isset($_POST['Notifications']))
		{
			$model->attributes=$_POST['Notifications'];
			$model->user_id = Yii::app()->user->id;
			if($model->validate())
			{
				$model->save(false);
				Yii::app()->user->setFlash('success','Email Notification Settings Updated Successfully');
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->render('notifications',array('model'=>$model));
	}

	public function actionProfiles($limit = null,$offset = null,$id=null) {
		if(!empty($id)) {
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];
		} else {
			$user = Yii::app()->user;
			if($user->isGuest) {
				$this->redirect(array('/user/login'));
				return false;
			}
			$id = Yii::app()->user->id;
		}
		
		$promotionDetails = Promotions::model()->findAll();
		
		$siteSettings = Sitesettings::model()->find();
		$urgentPrice = $siteSettings->urgentPrice;
		$promotionCurrency = $siteSettings->promotionCurrency;
		
		$reviewCriteia = new CDbCriteria;
		$reviewCriteia->addCondition('receiverId = "'.$id.'"');
		$review = Reviews::model()->findAll($reviewCriteia);
		$count = count($review);
				
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
		$criteria->addCondition("userId = $id");
		$criteria->order = 'productId desc';
		$limit = 15;
		$criteria->limit = $limit;
		if(isset($offset)) {
			$criteria->offset = $offset;
		}
		//$action = 'profiles';
		$products = Products::model()->findAll($criteria);
		if(Yii::app()->controller->action->id == 'review') {
			$this->renderPartial('review',compact('reviews'));
		}else if(Yii::app()->request->isAjaxRequest) {
			$this->renderPartial('loadresults',compact('products','limit','offset','count','follower','followerIds'));
		} else {
			$this->render('profiles',compact('user','products','limit','offset','count','follower','followerIds',
					'promotionCurrency', 'urgentPrice', 'promotionDetails'));

		}
		
	}

	public function actionPromotions($limit = null,$offset = null,$id=null) {
		if(!empty($id)) {
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];
		} else {
			$user = Yii::app()->user;
			if($user->isGuest) {
				$this->redirect(array('/user/login'));
				return false;
			}
			$id = Yii::app()->user->id;
		}
		
		//$id = Yii::app()->user->id;
		$model->nowid = $id;
		$model = Users::model()->findByPk($id);
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("userId = $id");
		$criteria->addCondition("promotionType = '2'");
		$criteria->order = 'productId desc';
		$limit = 8;
		$criteria->limit = $limit;
		if(isset($offset)) {
			$criteria->offset = $offset;
		}
		$products = Products::model()->findAll($criteria);
		//echo "<pre>"; print_r($products); die;
		if(Yii::app()->request->isAjaxRequest) { 
			$this->renderPartial('loadpromotions',compact('products','limit','offset','model'));
		} else {
			$this->render('promotions',compact('products','limit','offset','model'));

		}

	}

	public function actionAdvertisePromotions($limit = null,$offset = null,$id=null) {
		if(!empty($id)) {
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];
		} else {
			$user = Yii::app()->user;
			if($user->isGuest) {
				$this->redirect(array('/user/login'));
				return false;
			}
			$id = Yii::app()->user->id;
		}
		
		//$id = Yii::app()->user->id;
		$model->nowid = $id;
		$model = Users::model()->findByPk($id);

		$promotionDetails = Promotions::model()->findAll();
		
		$siteSettings = Sitesettings::model()->find();
		$urgentPrice = $siteSettings->urgentPrice;
		$promotionCurrency = $siteSettings->promotionCurrency;
		
		//$advertise = 1;

		$criteria = new CDbCriteria;
		$criteria->addCondition("t.userId = $id");
	//	$criteria->addCondition("product.promotionType = '1'");
		$criteria->addCondition("promotionName = 'adds'");
		$criteria->addCondition("status = 'Live'");
		$criteria->group = 't.productId';
		$criteria->order = 'id desc';
		$limit = 8;
		$criteria->limit = $limit;
		if(isset($offset)) {
			$criteria->offset = $offset;
		}
		$products = Promotiontransaction::model()->with('product')->findAll($criteria);
		//$products = Promotiontransaction::model()->with('productuser')->findByPk($id);
		//echo "<pre>"; print_r($products); die;
		if(Yii::app()->request->isAjaxRequest) { 
			$this->renderPartial('loadpromotions',compact('products','limit','offset','model'));
		} else {
			$this->render('advertisePromotions',compact('products','limit','offset','model',
					'promotionCurrency', 'urgentPrice', 'promotionDetails'));

		}

	}
	
	public function actionExpiredPromotions($limit = null,$offset = null,$id=null) {
		if(!empty($id)) {
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];
		} else {
			$user = Yii::app()->user;
			if($user->isGuest) {
				$this->redirect(array('/user/login'));
				return false;
			}
			$id = Yii::app()->user->id;
		}
	
		//$id = Yii::app()->user->id;
		$model->nowid = $id;
		$model = Users::model()->findByPk($id);
	
		$promotionDetails = Promotions::model()->findAll();
	
		$siteSettings = Sitesettings::model()->find();
		$urgentPrice = $siteSettings->urgentPrice;
		$promotionCurrency = $siteSettings->promotionCurrency;
	
		//$advertise = 1;
	
		$criteria = new CDbCriteria;
		$criteria->addCondition("t.userId = $id");
		//	$criteria->addCondition("product.promotionType = '1'");
		$criteria->addCondition("status = 'Expired'");
		$criteria->group = 't.productId';
		$criteria->order = 'id desc';
		$limit = 8;
		$criteria->limit = $limit;
		if(isset($offset)) {
			$criteria->offset = $offset;
		}
		$products = Promotiontransaction::model()->with('product')->findAll($criteria);
		//$products = Promotiontransaction::model()->with('productuser')->findByPk($id);
		//echo "<pre>"; print_r($products); die;
		if(Yii::app()->request->isAjaxRequest) {
			$this->renderPartial('loadpromotions',compact('products','limit','offset','model'));
		} else {
			$this->render('expiredPromotions',compact('products','limit','offset','model',
					'promotionCurrency', 'urgentPrice', 'promotionDetails'));
	
		}
	
	}

	public function actionPromotiondetails() {
		$productId = $_POST['id'];

		$criteria = new CDbCriteria;
		$criteria->addCondition("productId = $productId");
		$promot_detail = Promotiontransaction::model()->find($criteria);

		$condition = new CDbCriteria;
		$condition->addCondition("productId = $productId");
		$product_detail = Products::model()->find($condition);

		$this->renderPartial('promotiondetails',compact('promot_detail','product_detail'));
	}

	public function actionLiked($limit = null,$offset = null,$id=null) {
		if(!empty($id)) {
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];
		} else {
			$user = Yii::app()->user;
			if($user->isGuest) {
				$this->redirect(array('/user/login'));
				return false;
			}
			$id = Yii::app()->user->id;
		}
		//echo $id;die;
		$user = Users::model()->findByPk($id);
		$favCriteria = new CDbCriteria;
		$favCriteria->addCondition("userId = $id");
		$favorites = Favorites::model()->findAll($favCriteria);

		$criteria = new CDbCriteria;
		$productIds = array();
		if(!empty($favorites)) {
			foreach($favorites as $favorite):
			$productIds[] = $favorite->productId;
			endforeach;
		}
		
		$userid = Yii::app()->user->id;
		if(!empty($userid)){
		$followCriteria = new CDbCriteria;
		$followCriteria->addCondition("userId = $userid");
		$follower = Followers::model()->findAll($followCriteria);
		$followerIds = array();
		if(!empty($follower)) {
			foreach($follower as $follower):
			$followerIds[] = $follower->follow_userId;
			endforeach;
		}
		}
		
		$reviewCriteia = new CDbCriteria;
		$reviewCriteia->addCondition('receiverId = "'.$id.'"');
		$review = Reviews::model()->findAll($reviewCriteia);
		$count = count($review);
		
		
		$criteria->addInCondition("productId",$productIds);
		$criteria->order = 'productId desc';
		$limit = 15;
		$criteria->limit = $limit;
		if(isset($offset)) {
			$criteria->offset = $offset;
		}
		$forlikes = '1';
		//$action = 'liked';
		$products = Products::model()->findAll($criteria);
		if(Yii::app()->request->isAjaxRequest) {
			$this->renderPartial('loadliked',compact('products','limit','offset','count','follower','followerIds'));
		} else {
			$this->render('profiles',compact('user','products','productIds','limit','offset','count','follower','followerIds'));
		}
		
	}
	public function actionReview($limit = null,$offset = null,$id=null) {
		//echo $id;
		if(!empty($id)) {
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];
			
		} else {
			$user = Yii::app()->user;
			if($user->isGuest) {
				$this->redirect(array('/user/login'));
				return false;
			}
			$id = Yii::app()->user->id;
		}
		//echo $id;die;
		$user = Users::model()->findByPk($id);
		$userid = Yii::app()->user->id;
		
		$reviewCriteia = new CDbCriteria;
		$reviewCriteia->addCondition('receiverId = "'.$id.'"');
		$review = Reviews::model()->findAll($reviewCriteia);
		$count = count($review);
		
		
		$userid = Yii::app()->user->id;
		if(!empty($userid)){
		$followCriteria = new CDbCriteria;
		$followCriteria->addCondition("userId = $userid");
		$follower = Followers::model()->findAll($followCriteria);
		$followerIds = array();
		if(!empty($follower)) {
			foreach($follower as $follower):
			$followerIds[] = $follower->follow_userId;
			endforeach;
		}
		}
		
		$revcriteria = new CDbCriteria;
		$revcriteria->addCondition("receiverId = $id");
		$revcriteria->order = 'reviewId desc';
		$limit = 8;
		$revcriteria->limit = $limit;
		if(isset($offset)) {
			$revcriteria->offset = $offset;
		}
		
		$reviews = Reviews::model()->findAll($revcriteria);
			
		$favCriteria = new CDbCriteria;
		$favCriteria->addCondition("userId = $id");
		$favorites = Favorites::model()->findAll($favCriteria);

		$criteria = new CDbCriteria;
		$productIds = array();
		if(!empty($favorites)) {
			foreach($favorites as $favorite):
			$productIds[] = $favorite->productId;
			endforeach;
		}
		$criteria->addInCondition("productId",$productIds);
		$criteria->order = 'productId desc';
		$limit = 8;
		$criteria->limit = $limit;
		if(isset($offset)) {
			$criteria->offset = $offset;
		}
		
		$products = Products::model()->findAll($criteria);
		if(Yii::app()->request->isAjaxRequest) {
			$this->renderPartial('review',compact('products','limit','offset','count','follower','followerIds'));
		} else {
			$this->render('profiles',compact('user','products','limit','offset','reviews','count','follower','followerIds'));
		}
		
		
	}
	public function actionFollower($limit = 15,$offset = 0,$id=null) {
		//echo $id;
		if(!empty($id)) {
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];
				
		} else {
			$user = Yii::app()->user;
			if($user->isGuest) {
				$this->redirect(array('/user/login'));
				return false;
			}
			$id = Yii::app()->user->id;
		}
		//echo $id;die;
		$user = Users::model()->findByPk($id);
		$userid = Yii::app()->user->id;
	
		if(!empty($userid)){
			$followCriteria = new CDbCriteria;
			$followCriteria->addCondition("userId = $userid");
			$followCriteria->offset = $offset;
			$followCriteria->limit = $limit;
			$follower = Followers::model()->findAll($followCriteria);
			$followerIds = array();
			if(!empty($follower)) {
				foreach($follower as $follower):
				$followerIds[] = $follower->follow_userId;
				endforeach;
			}
		}
		
		$reviewCriteia = new CDbCriteria;
		$reviewCriteia->addCondition('receiverId = "'.$id.'"');
		$review = Reviews::model()->findAll($reviewCriteia);
		$count = count($review);
		
		$followerCriteria = new CDbCriteria;
		$followerCriteria->addCondition("follow_userId = $id");
		$followerCriteria->offset = $offset;
		$followerCriteria->limit = $limit;
		$followerlist = Followers::model()->findAll($followerCriteria);
		$followerlistIds = array();
		
		if(Yii::app()->request->isAjaxRequest) {
			$this->renderPartial('follower',compact('user','products','limit','offset','count','follower','followerIds','followerlist','followerproducts'));
		} else {
			$this->render('profiles',compact('user','products','limit','offset','reviews','count','follower','followerIds','followerlist','followerproducts'));
		}
	
	
	}
	
	public function actionFollowing($limit = 15,$offset = 0,$id=null) {
		//echo $id;
		if(!empty($id)) {
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];
	
		} else {
			$user = Yii::app()->user;
			if($user->isGuest) {
				$this->redirect(array('/user/login'));
				return false;
			}
			$id = Yii::app()->user->id;
		}
		//echo $id;die;
		$user = Users::model()->findByPk($id);
		$userid = Yii::app()->user->id;
		
		if(isset($_GET['limit'])){
			$limit = $_GET['limit'];
		}
		
		if(isset($_GET['offset'])){
			$offset = $_GET['offset'];
		}
	
		if(!empty($userid)){
			$followCriteria = new CDbCriteria;
			$followCriteria->addCondition("userId = $userid");
			$followCriteria->offset = $offset;
			$followCriteria->limit = $limit;
			$follower = Followers::model()->findAll($followCriteria);
			$followerIds = array();
			if(!empty($follower)) {
				foreach($follower as $follower):
				$followerIds[] = $follower->follow_userId;
				endforeach;
			}
		}
		
		$reviewCriteia = new CDbCriteria;
		$reviewCriteia->addCondition('receiverId = "'.$id.'"');
		$review = Reviews::model()->findAll($reviewCriteia);
		$count = count($review);
		
		
		$followerCriteria = new CDbCriteria;
		$followerCriteria->addCondition("userId = $id");
		$followerCriteria->offset = $offset;
		$followerCriteria->limit = $limit;
		$followerlist = Followers::model()->findAll($followerCriteria);
		$followerlistIds = array();
	
		if(Yii::app()->request->isAjaxRequest) {
			$this->renderPartial('following',compact('limit','offset','count','follower','followerIds','followerlist','followerproducts'));
		} else {
			$this->render('profiles',compact('user','limit','offset','reviews','count','follower','followerIds','followerlist','followerproducts'));
		}
	
	
	}
	public function actionChangepassword() {
		$id = Yii::app()->user->id;
		$model = Users::model()->findByPk($id);
		$model->setScenario('changepassword');
		$model->password = "";
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-change-password-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['Users'])) {
			$model->attributes = $_POST['Users'];
			if($model->validate()) {
				$model->password = base64_encode($model->password);
				$model->save(false);
				Yii::app()->user->setFlash('success',Yii::t('app','Password has been changed successfully'));
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->render('changepassword',compact('model'));
	}

	public function actionGetshipping()
	{
		$addressId = $_POST['id'];
		$address = Tempaddresses::model()->findByAttributes(array('shippingaddressId'=>$addressId));
		//print_r($address);
		$addresses['nickname'] = $address->nickname;
		$addresses['name'] = $address->name;
		$addresses['address1'] = $address->address1;
		$addresses['address2'] = $address->address2;
		$addresses['city'] = $address->city;
		$addresses['state'] = $address->state;
		$addresses['country'] = $address->country;
		$addresses['zipcode'] = $address->zipcode;
		$addresses['phone'] = $address->phone;
		$addresses['countryCode'] = $address->countryCode;
		$addresses['country'] = $address->country;
		$addresses['slug'] = $address->slug;
		print_r(json_encode($addresses));
	}
	
	public function actionGetfollow() {
		$id = Yii::app()->user->id;
		$userdetails = Users::model()->findByPk($id);
		$fusername = $userdetails->name;
		$follow_user = $_POST['fuserid'];
		$followerdetail = Users::model()->findByPk($follow_user);
		$curentusername = $followerdetail->name;
		$emailTo = $followerdetail->email; 
		//http://qMartscript.com/beta/user/follower/
		//echo $_POST['userid'];die;
		if(!empty($follow_user)){
			$getfollowmodel = Followers::model()->findByAttributes(array('userId'=>$id,'follow_userId'=>$follow_user));
			if(empty($getfollowmodel)){
				$model = new Followers();
				$model->userId = $id;
				$model->follow_userId = $follow_user;
				$model->followedOn = date ("Y-m-d H:i:s");
				$model->save();

				$notifyMessage = 'Started Following you';
				Myclass::addLogs("follow", $id, $follow_user, $model->id, 0, $notifyMessage);

				$userid = $follow_user;
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
							$messages =$fusername.' started following you';
							Myclass::pushnot($deviceToken,$messages,$badge);
						}		
					}
				}				

				$siteSettings = Sitesettings::model()->find();
				

				if($siteSettings->smtpEnable == 1) {
				$mail = new YiiMailer();
				//$mail->IsSMTP();    
				                     // Set mailer to use SMTP
				$mail->Mailer = 'smtp';                         // Set mailer to use SMTP
				$mail->Host = $siteSettings->smtpHost;  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = $siteSettings->smtpEmail;                            // SMTP username
				$mail->Password = $siteSettings->smtpPassword;                           // SMTP password
				$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
				$mail->Port = $siteSettings->smtpPort;
				

				$mail->setView('getfollow');
				$mail->setData(array('followername' => $fusername, 'username' => $curentusername,
						'siteSettings' => $siteSettings));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($emailTo);
				$mail->setSubject($fusername.' Now following you');
				$mail->send();
				}

			}else{
				echo "";
			}
		}else{
			echo "";
		}
		
		//Yii::app()->end();
	}
	public function actionDeletefollow() {
		
			$id = Yii::app()->user->id;
			$follow_user = $_POST['userid'];
			//echo $_POST['userid'];die;
			if(!empty($follow_user)){
				$getfollowmodel = Followers::model()->findByAttributes(array('userId'=>$id,'follow_userId'=>$follow_user));
				if(!empty($getfollowmodel)){
					$followId = $getfollowmodel->id;
					Followers::model()->deleteAllByAttributes(array('userId'=>$id,'follow_userId'=>$follow_user));
					
					$logCriteria = new CDbCriteria();
					$logCriteria->addCondition("type LIKE 'follow'");
					$logCriteria->addCondition("sourceId = $followId");
					$logsModel = Logs::model()->find($logCriteria);
					$logsModel->delete();
				}else{
					echo "";
				}
			}else{
				echo "";
			}
				
			//Yii::app()->end();
		}
}
