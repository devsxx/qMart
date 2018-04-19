<?php

/**
 * This is the model class for table "hts_users".
 *
 * The followings are the available columns in table 'hts_users':
 * @property integer $userId
 * @property string $username
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $postalcode
 * @property string $geolocationDetails
 * @property string $userImage
 * @property integer $userstatus
 * @property integer $activationStatus
 * @property string $gender
 * @property string $facebookId
 * @property string $twitterId
 * @property string $googleId
 * @property string $notificationSettings
 * @property integer $defaultshipping
 * @property integer $createdDate
 * @property integer $lastLoginDate
 * @property integer $averageRating
 * @property string $recently_view_product
 * @property integer $mobile_verificationcode
 * @property integer $mobile_status
 * @property integer $unreadNotification
 *
 * The followings are the available model relations:
 * @property Comments[] $comments
 * @property Followers[] $followers
 * @property Followers[] $followers1
 * @property Orders[] $orders
 * @property Orders[] $orders1
 * @property Products[] $products
 */
class Users extends CActiveRecord
{
	public $confirm_password;
	public $existing_password;
	public $live;
	public $comment;
	public $message;
	public $offer;
	public $updates;
	public $fbemail;
	public $fbfirstName;
	public $fblastName;
	public $fbphone;
	public $fbprofileURL;
	public $facebookSession;
	// var for signup confirm password;
	/**
	* @return string the associated database table name
	*/
	public function tableName()
	{
		return 'hts_users';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('username, name, password, email', 'required','on' => 'create,update'),
		array('username, name, password, email', 'required','on' => 'register'),
		//array('username,name','match','pattern'=>'/^[\p{L}\p{N} .-]+$/u','message'=>'Special Characters not allowed'),
		array('username,name','matchPattern'),
		array('username, name, email', 'required','on' => 'profile'),
		array('username', 'unique','on' => 'register,create,update,profile'),
		array('email','unique','on' => 'register,create,update,profile'),
		array('name','length','min'=> 3,'on' => 'create,update,profile'),
		array('confirm_password,password','length','min'=> 6,'on' => 'changepassword'),
		array('password','length','min'=> 6,'on'=>'create,update'),
		//array('email', 'required','on' => 'forgetpassword'),
		array('email','checkEmail','on'=>'forgetpassword'),
		array('email', 'email'),
		array('confirm_password,password,existing_password', 'required','on' => 'changepassword'),
		array('existing_password', 'checkPassword','on' => 'changepassword'),
		array('password','existPassword','on' => 'changepassword'),
		array('confirm_password', 'required','on' => 'register'),
		array('confirm_password', 'compare', 'compareAttribute'=>'password','message' => Yii::t('app','Confirm password does not match.'),'on' => 'register,changepassword'),
		//array('userstatus, twitterId', 'numerical', 'integerOnly'=>true),
		array('username,name', 'length', 'max'=>30),
		array('password, country, city, state', 'length', 'max'=>50),
		array('email', 'length', 'max'=>150),
		array('postalcode', 'length', 'max'=>10),
		array('gender', 'length', 'max'=>6),
		//array('facebookId', 'length', 'max'=>20),
		array('notificationSettings,defaultshipping', 'safe'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('userId,username, name, email', 'safe', 'on'=>'search'),
		);
	}

	public function checkEmail($attribute) {
		$check = Users::model()->findByAttributes(array('email'=>$this->email));
		if(empty($check)) {
			$this->addError($this->attribute,Yii::t('app',"Email Not Found"));
		}
	}
	public function matchPattern($attribute) {
		if(preg_match('/[`~!@#$%^&*()_|+\-=?;:",.<>{}[]]/',$this->name)) {
			$this->addError($this->name,Yii::t('app',"Special Characters not allowed"));
		}
		if(preg_match('/[`~!@#$%^&*()_|+\-=?;:",.<>{}[]]/',$this->username)) {
			$this->addError($this->username,Yii::t('app',"Special Characters not allowed"));
		}
	}
	public function checkPassword($attribute) {
		if(!empty($this->password)) {
			$id = Yii::app()->user->id;
			$check = Users::model()->findByAttributes(array('password'=>base64_encode($this->existing_password),'userId'=>$id));
			if(empty($check)) {
				$this->addError('existing_password',Yii::t('app',"Existing Password is Incorrect"));
			}
		}
	}
	public function existPassword($attribute) {
		if(!empty($this->password)) {
			$id = Yii::app()->user->id;
			$check = Users::model()->findByAttributes(array('password'=>base64_encode($this->password),'userId'=>$id));
			if(!empty($check)) {
				$this->addError('password',Yii::t('app',"Your new password should be different from your current password."));
			}
		}
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'comments' => array(self::HAS_MANY, 'Comments', 'userId'),
			'followers' => array(self::HAS_MANY, 'Followers', 'userId'),
			'followers1' => array(self::HAS_MANY, 'Followers', 'follow_userId'),
			'orders' => array(self::HAS_MANY, 'Orders', 'userId'),
			'orders1' => array(self::HAS_MANY, 'Orders', 'sellerId'),
			'products' => array(self::HAS_MANY, 'Products', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userId' => Yii::t('admin','User'),
			'username' => Yii::t('admin','Username'),
			'name' => Yii::t('admin','Name'),
			'password' => Yii::t('admin','Password'),
			'email' => Yii::t('admin','Email'),
			'country' => Yii::t('admin','Country'),
			'city' => Yii::t('admin','City'),
			'state' => Yii::t('admin','State'),
			'postalcode' => Yii::t('admin','Postalcode'),
			'userImage' => Yii::t('admin','User Image'),
			'userstatus' => Yii::t('admin','Userstatus'),
			'gender' => Yii::t('admin','Gender'),
			'facebookId' => Yii::t('admin','Facebook'),
			'twitterId' => Yii::t('admin','Twitter'),
			'googleId' => Yii::t('admin','Google'),
			'notificationSettings' => Yii::t('admin','Notification Settings'),
		    'confirm_password' => Yii::t('app','Confirm Password'),
		    'existing_password' => Yii::t('app','Existing Password'),
			'fbdetails' => Yii::t('app','Facebook details'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		/* $criteria->compare('country',$this->country,true);
		 $criteria->compare('city',$this->city,true);
		 $criteria->compare('state',$this->state,true);
		 $criteria->compare('postalcode',$this->postalcode,true);
		 $criteria->compare('userImage',$this->userImage,true);
		 $criteria->compare('userstatus',$this->userstatus);
		 $criteria->compare('gender',$this->gender,true);
		 $criteria->compare('facebookId',$this->facebookId,true);
		 $criteria->compare('twitterId',$this->twitterId);
		 $criteria->compare('googleId',$this->googleId,true);
		 $criteria->compare('notificationSettings',$this->notificationSettings,true); */
		//$criteria->order = 'createdDate DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		'sort'=>array(
               'defaultOrder'=>'createdDate DESC',
		)

		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function beforeSave() {
		if($this->isNewRecord)
		$this->createdDate = time();
		return parent::beforeSave();
	}
	
	public function generateFbdtails(){
		$details = json_decode($this->fbdetails, true);
		$output = "";
		foreach ($details as $fbKey => $fbvalue){
			$output .= $fbKey.": ".$fbvalue."</br>";
		}
		return $output;
	}
}
