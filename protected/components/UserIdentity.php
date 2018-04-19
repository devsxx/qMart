<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	// Need to store the user's ID:
	private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users = Users::model()->findByAttributes(array('email'=>$this->username));


		/* $users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		); */
		if ($users===null) { // No user found!
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}elseif ($users->password !== base64_encode($this->password)) { // Invalid password!
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
			//In the first conditional, if $user has no value, then no records were found, so the email address was incorrect. In the second conditional, the stored password is compared against the SHA1() version of the submitted password. This assumes the record’s password was stored in a SHA1()-encrypted format. If neither of these conditionals are true, then everything is okay:
		}else{
			$this->errorCode=self::ERROR_NONE;
			$this->_id = $users->userId;
			$users->lastLoginDate = time();
			$users->save(false);
		}
		
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function setId($id)
	{
		$this->errorCode=self::ERROR_NONE;
		$this->_id = $id;
	}
}
