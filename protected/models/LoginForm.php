<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			array('username', 'email'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>Yii::t('app','Remember me next time'),
			'username'=>Yii::t('admin','Email'),
			'password'=>Yii::t('admin','Password'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			 $this->_identity->authenticate();
                      switch($this->_identity->errorCode)
                       {
                      case UserIdentity::ERROR_USERNAME_INVALID:
                      $this->addError('password',Yii::t('admin','Email Id or Password is incorrect.')); 
                      break;
                      case UserIdentity::ERROR_PASSWORD_INVALID:
                      $this->addError('password',Yii::t('admin','Email Id or Password is incorrect.'));
                      break;
                      default: 
                      return UserIdentity::ERROR_NONE;
                      break;
                      }		
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$userStatus = Myclass::getUserDetails($this->_identity->id);
			if ($userStatus->userstatus == 1 && $userStatus->activationStatus == 1){//print_r($_POST['sport']);die;
			if(isset($_POST['sport']))
			{
					setcookie ("username", $this->username, time()+3600*24*4);
					setcookie ("password", $this->password, time()+3600*24*4);
					$cookie = new CHttpCookie('userid', $this->username);
					$cookie->expire = time()+60*60*24*180; 
					Yii::app()->request->cookies['userid'] = $cookie;	
			}

				$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
				Yii::app()->user->login($this->_identity,$duration);
				return true;
			}elseif($userStatus->userstatus == 0 && $userStatus->activationStatus == 1) {
				$this->addError('username',Yii::t('app','Your account has been disabled by the Administrator.'));
				return false;
			}else {
				$this->addError('username',Yii::t('app','User not verified yet, activate the account from the email.'));
				return false;
			}
		}
		else
			return false;
	}
}
