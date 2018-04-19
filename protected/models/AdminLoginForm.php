<?php

/**
 * AdminLoginForm class.
 * AdminLoginForm is the data structure for keeping
 * admin login form data. It is used by the 'login' action of 'AdminController'.
 */
class AdminLoginForm extends CFormModel
{
	public $username;
	public $password;

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
	              $this->_identity=new AdminUserIdentity($this->username,$this->password);   
	              $this->_identity->authenticate();
                      switch($this->_identity->errorCode)
                       {
                      case AdminUserIdentity::ERROR_USERNAME_INVALID:
                      $this->addError('password',Yii::t('admin','Email Id or Password is incorrect.')); 
                      break;
                      case AdminUserIdentity::ERROR_PASSWORD_INVALID:
                      $this->addError('password',Yii::t('admin','Email Id or Password is incorrect.'));
                      break;
                      default: 
                      return AdminUserIdentity::ERROR_NONE;
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
			$this->_identity=new AdminUserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===AdminUserIdentity::ERROR_NONE)
		{
			//$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			$duration=0;
			Yii::app()->adminUser->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
