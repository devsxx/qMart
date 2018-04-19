<?php
class HybridAuthIdentity extends CUserIdentity
{ 
	const VERSION = '2.2.2';

	/**
	 *
	 * @var Hybrid_Auth
	 */
	public $hybridAuth;
	private $_identity;

	/**
	 *
	 * @var Hybrid_Provider_Adapter
	 */
	public $adapter;

	/**
	 *
	 * @var Hybrid_User_Profile
	 */
	public $userProfile;
	
	public $allowedProviders = array('google', 'facebook', 'twitter', 'instagram',);

	protected $config;
	function __construct()
	{
		$sitesetting = Sitesettings::model()->find();
		$socialLoginSettings = json_decode($sitesetting->socialLoginDetails, true);
		if ($socialLoginSettings['facebook']['status'] == 'enable'){
			$facebookappid = $socialLoginSettings['facebook']['appid'];
			$facebooksecret = $socialLoginSettings['facebook']['secret'];
		} else {
			$facebookappid = '';
			$facebooksecret = '';
		}
		if ($socialLoginSettings['twitter']['status'] == 'enable'){
			$twitterappid = $socialLoginSettings['twitter']['appid'];
			$twittersecret = $socialLoginSettings['twitter']['secret'];
		} else {
			$twitterappid = '';
			$twittersecret = '';
		}
		if ($socialLoginSettings['google']['status'] == 'enable'){
			$googleappid = $socialLoginSettings['google']['appid'];
			$googlesecret = $socialLoginSettings['google']['secret'];
		} else {
			$googleappid = '';
			$googlesecret = '';
		}

		$path = Yii::getPathOfAlias('ext.HybridAuth');
		require_once $path . '/hybridauth-' . self::VERSION . '/hybridauth/Hybrid/Auth.php';  //path to the Auth php file within HybridAuth folder

		$this->config = array(
				"base_url" =>  Yii::app()->createAbsoluteUrl("/user/socialLogininit"),
				"providers" => array(
						"Google" => array(
								"enabled" => true,
								"keys" => array(
										"id" => $googleappid,
										"secret" => $googlesecret,
		),
								"scope" => "https://www.googleapis.com/auth/userinfo.profile " . "https://www.googleapis.com/auth/userinfo.email",
								"access_type" => "offline",
		),
		"Twitter" => array ( 
                    "enabled" => true,
                    "keys"    => array ( "key" => $twitterappid, "secret" => $twittersecret) 
		),
						"Facebook" => array (
								"enabled" => true,
								"keys" => array (
											"id" => $facebookappid,
										"secret" => $facebooksecret,
		),
								"scope" => "email,user_birthday,
									public_profile, user_friends, publish_actions",
		//"display" => "popup",
								"redirect_uri" => Yii::app()->createAbsoluteUrl("/user/socialLogininit?hauth.done=Facebook"),
		),
						"Live" => array (
								"enabled" => true,
								"keys" => array (
										"id" => "windows client id",
										"secret" => "Windows Live secret",
		),
								"scope" => "email"
								),
						"Yahoo" => array(
								"enabled" => true,
								"keys" => array (
										"key" => "yahoo client id",
										"secret" => "yahoo secret",
								),
								),
						"LinkedIn" => array(
								"enabled" => true,
								"keys" => array (
										"key" => "linkedin client id",
										"secret" => "linkedin secret",
								),
								),
								),

				"debug_mode" => false,

								// to enable logging, set 'debug_mode' to true, then provide here a path of a writable file
				"debug_file" => "",
								);

								$this->hybridAuth = new Hybrid_Auth($this->config);
	}

	/**
	 *
	 * @param string $provider
	 * @return bool
	 */
	public function validateProviderName($provider)
	{
		if (!is_string($provider))
		return false;
		if (!in_array($provider, $this->allowedProviders))
		return false;

		return true;
	}
	public function twitLogin() {
		$this->username = $this->userProfile->firstName.' '.$this->userProfile->lastName;  //CUserIdentity
		$verify = $this->verifyTwitUser();
		if($verify === true){
			$id = $this->twitAuthenticate();
			if($this->_identity===null)
			{
				$this->_identity=new UserIdentity($this->username,null);
				$this->_identity->setId($id);
			}
			if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
			{
				$duration=0;//$this->rememberMe ? 3600*24*30 : 0; // 30 days
				Yii::app()->user->login($this->_identity,$duration);
				//echo "hi <pre>";print_r(Yii::app()->user);print_r($_SESSION);die;
				return true;
			}
			else
			return false;
		}else{
			return $verify;
		}
	}
	public function verifyTwitUser() {
		//$users = Users::model()->findByAttributes(array('name'=>$this->username));
		$users = Users::model()->findByAttributes(array('twitterId'=>$this->userProfile->identifier));
		if($users === null){
			$userModel=new Users('register');
			$userModel->name = $this->userProfile->firstName." ".$this->userProfile->lastName;
			$userModel->username = $this->userProfile->displayName;
			$userModel->twitterId = $this->userProfile->identifier;

			//$image = explode('?',$this->userProfile->photoURL);
			//$userModel->userImage = $image[0].':large';
			$userModel->userImage = str_replace("_normal","",$this->userProfile->photoURL);
			//$userModel->userImage = $this->userProfile->photoURL;
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			return $userModel;
		}else{
			return TRUE;
		}
	}
	public function twitAuthenticate()
	{
		$users = Users::model()->findByAttributes(array('name'=>$this->username));
		if ($users===null) { // No user found!
			$userModel=new Users('register');
			$userModel->name = $this->userProfile->firstName;
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			return $userModel;
		}else{
			$this->errorCode=self::ERROR_NONE;
			$id = $users->userId;
		}
		return $id;
	}
	public function login()
	{
		if(empty($this->userProfile->email)){
			return "no-email";
		}else{
			$this->username = $this->userProfile->email;  //CUserIdentity
			$verify = $this->verifyUser();
			if($verify === true){
				$id = $this->authenticate();
				if($this->_identity===null)
				{
					$this->_identity=new UserIdentity($this->username,null);
					$this->_identity->setId($id);
				}
				if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
				{
					$duration=0;//$this->rememberMe ? 3600*24*30 : 0; // 30 days
					Yii::app()->user->login($this->_identity,$duration);
					//echo "hi <pre>";print_r(Yii::app()->user);print_r($_SESSION);die;
					return true;
				}
				else
				return false;
			}else{
				return $verify;
			}
		}
	}

	public function verifyUser(){
		$criteria = new CDbCriteria;
		$criteria->addCondition("email LIKE '{$this->username}'");

		//$userConditions['email'] = $this->username;
		if($_SESSION['provider'] == 'facebook')
			$criteria->addCondition("facebookId = {$this->userProfile->identifier}", 'OR');
		elseif($_GET['provider'] == 'twitter')
			$criteria->addCondition("twitterId = {$this->userProfile->identifier}", 'OR');
		elseif($_GET['provider'] == 'google')
			$criteria->addCondition("googleId = {$this->userProfile->identifier}", 'OR');
		$users = Users::model()->find($criteria);

		if($users === null){
			$userModel=new Users('register');
			$userModel->email = $this->username;
			$userModel->name = $this->userProfile->firstName." ".$this->userProfile->lastName;
			$username = explode("@", $this->username);
			$userModel->username = $username[0];
			$image = explode('?',$this->userProfile->photoURL);
			if($_SESSION['provider'] == 'facebook'){
				$userModel->facebookId = $this->userProfile->identifier;
				$userModel->facebookSession = $this->hybridAuth->getSessionData();
				$userModel->fbemail = $this->userProfile->email;
				$userModel->fbfirstName = $this->userProfile->firstName;
				$userModel->fblastName = $this->userProfile->lastName;
				$userModel->fbphone = $this->userProfile->phone;
				$userModel->fbprofileURL = $this->userProfile->profileURL;
				$userModel->userImage = $image[0].'?type=large';
			}elseif($_GET['provider'] == 'twitter'){
				$userModel->twitterId = $this->userProfile->identifier;
				$userModel->userImage = $image[0].':large';
			}elseif($_GET['provider'] == 'google'){
				$userModel->googleId = $this->userProfile->identifier;
				$userModel->userImage = $image[0].'?type=large';
			}

			//$userModel->name =
			/* if ($userModel->save(false)){
			$id = $userModel->userId;
			} */
			//$this->render('signup',array('model'=>$userModel));
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			return $userModel;
		}elseif($users->userstatus != 1){
			return "disabled";
		}elseif($users->userstatus == 1 && $users->activationStatus == 0){
			$users->activationStatus = 1;
			$users->save(false);
			return TRUE;
		}else{
			return TRUE;
		}
	}


	public function authenticate()
	{
		$users = Users::model()->findByAttributes(array('email'=>$this->username));

		if ($users===null) { // No user found!
			$userModel=new Users('register');
			$userModel->email = $this->username;
			$userModel->name = $this->userProfile->firstName." ".$this->userProfile->lastName;
			$username = explode("@", $this->username);
			$userModel->username = $username[0];
			//$userModel->name =
			/* if ($userModel->save(false)){
			 $id = $userModel->userId;
			 } */
			//$this->render('signup',array('model'=>$userModel));
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			return $userModel;
		}else{
			$this->errorCode=self::ERROR_NONE;
			$id = $users->userId;
		}

		return $id;
	}

	public function logout() {
		$this->hybridAuth->logoutAllProviders();
	}
}


