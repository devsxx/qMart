<?php

/**
 * This is the model class for table "hts_sitesettings".
 *
 * The followings are the available columns in table 'hts_sitesettings':
 * @property integer $id
 * @property string $smtpEmail
 * @property string $smtpPassword
 * @property string $smtpPort
 * @property string $smtpHost
 * @property integer $smtpEnable
 * @property string $socialLoginDetails
 * @property string $logo
 * @property string $logoDarkVersion
 * @property string $sitename
 * @property string $metaData
 * @property string $default_userimage
 * @property string $currency_priority
 * @property string $category_priority
 * @property string $promotionCurrency
 * @property integer $urgentPrice
 * @property integer $searchDistance
 * @property string $searchType
 * @property string $searchList
 * @property string $sitepaymentmodes
 * @property integer $commission_status
 * @property string $paypal_settings
 * @property string $braintree_settings
 * @property string $api_settings
 * @property string $footer_settings
 * @property string $tracking_code
 * 
 */
class Sitesettings extends CActiveRecord
{
	public $facebookstatus;
	public $facebookappid;
	public $facebooksecret;
	public $twitterstatus;
	public $twitterappid;
	public $twittersecret;
	public $googlestatus;
	public $googleappid;
	public $googlesecret;
	public $defaultlogo;
	public $defaultuser;
	public $paypalType;
	public $paypalEmailId;
	public $paypalAppId;
	public $paypalApiUserId;
	public $paypalApiPassword;
	public $paypalApiSignature;
	public $paypalCcStatus;
	public $paypalCcClientId;
	public $paypalCcSecret;
	public $apiUsername;
	public $apiPassword;
	public $facebookFooterLink;
	public $googleFooterLink;
	public $twitterFooterLink;
	public $androidFooterLink;
	public $iosFooterLink;
	public $footerCopyRightsDetails;
	public $exchangePaymentMode;
	public $buynowPaymentMode;
	public $scrowPaymentMode;
	public $cancelEnableStatus;
	public $sellerClimbEnableDays;
	public $brainTreeType;
	public $brainTreeMerchantId;
	public $brainTreePublicKey;
	public $brainTreePrivateKey;
	public $metaTitle;
	public $metaDescription;
	public $metaKeywords;
	public $googleapikey;
	


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_sitesettings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('smtpEmail, smtpPassword, smtpEnable, smtpPort, smtpHost', 'required', 'on'=>'smtp'),
		array('cancelEnableStatus, sellerClimbEnableDays', 'buynowRequired', 'on'=>'paymentmodes'),
		array('brainTreeMerchantId, brainTreePublicKey, brainTreePrivateKey', 'required', 'on'=>'braintreesettings'),
		array('facebookstatus, facebookappid, facebooksecret', 'facebookRequired', 'on'=>'sociallogin'),
		array('twitterstatus, twitterappid, twittersecret', 'twitterRequired', 'on'=>'sociallogin'),
		array('googlestatus, googleappid, googlesecret', 'googleRequired', 'on'=>'sociallogin'),
		array('paypalType,paypalApiSignature,paypalAppId,paypalEmailId,paypalApiUserId,paypalApiPassword','required','on'=>'payment'),
		array('paypalCcStatus, paypalCcClientId, paypalCcSecret', 'paypalCcRequired', 'on'=>'payment'),
		array('sitename, metaTitle, metaDescription, metaKeywords,googleapikey','required','on'=>'defaultsettings'),
		array('logo,default_userimage','file','types' => 'jpg,jpeg,gif,bmp,png','allowEmpty' => true,'on' => 'defaultsettings'),
		array('logo,default_userimage','file','types' => 'jpg,jpeg,gif,bmp,png','allowEmpty' => false,'on' => 'defaultsettings'),
		array('smtpEmail','email'),
		array('sitename','length','max'=>30),
		array('smtpEmail, smtpHost', 'length', 'max'=>150),
		array('smtpPassword', 'length', 'max'=>50),
		array('smtpPort', 'length', 'max'=>10),
		array('logo, default_userimage', 'length', 'max'=>60),
		array('sitename', 'length', 'max'=>40),
		array('searchType', 'length', 'max'=>9),
		array('searchList', 'length', 'max'=>200),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, smtpEmail, smtpPassword', 'safe', 'on'=>'search'),
		array('urgentPrice', 'numerical'),
				
		);
	}
	
	/**
	 * Check the buynow configuration 
	 * details based on the buynow enable
	 * and disable
	 */
	public function buynowRequired($attribute){
		if($this->buynowPaymentMode == 1){
			if($this->cancelEnableStatus == ""){
				$this->addError('cancelEnableStatus', Yii::t('admin','Select a Status upto which the Cancel is available'));
			}
			if($this->sellerClimbEnableDays == ""){
				$this->addError('sellerClimbEnableDays', Yii::t('admin','Enter no. of days after when the Claim button should be enable for Seller'));
			}
		}
	}

	/**
	 * Check the client id and secret key
	 * fields if the user enabled the
	 * paypal credit card payment
	 * This is the 'paypalCcRequired' validator as declared in rules().
	 */
	public function paypalCcRequired($attribute)
	{
		if($this->paypalCcStatus == 1){
			if($this->paypalCcClientId == ''){
				$this->addError('paypalCcClientId', Yii::t('admin','Paypal App Client Id cannot be empty'));
			}/* else{
			$this->clearErrors('facebookappid');
			} */
			if($this->paypalCcSecret == ''){
				$this->addError('paypalCcSecret', Yii::t('admin','Paypal App Secret Key cannot be empty'));
			}
		}
	}

	/**
	 * Check the appid and secret key
	 * fields if the user enabled the
	 * appropriate social login
	 * This is the 'facebookRequired' validator as declared in rules().
	 */
	public function facebookRequired($attribute)
	{
		if($this->facebookstatus == 1){
			if($this->facebookappid == ''){
				$this->addError('facebookappid', Yii::t('admin','Facebook Appid cannot be empty'));
			}/* else{
			$this->clearErrors('facebookappid');
			} */
			if($this->facebooksecret == ''){
				$this->addError('facebooksecret', Yii::t('admin','Facebook Secret Key cannot be empty'));
			}
		}
	}

	/**
	 * Check the appid and secret key
	 * fields if the user enabled the
	 * appropriate social login
	 * This is the 'twitterRequired' validator as declared in rules().
	 */
	public function twitterRequired($attribute)
	{
		if($this->twitterstatus == 1){
			if($this->twitterappid == ''){
				$this->addError('twitterappid', Yii::t('admin','Twitter Appid cannot be empty'));
			}
			if($this->twittersecret == ''){
				$this->addError('twittersecret', Yii::t('admin','Twitter Secret Key cannot be empty'));
			}
		}
	}

	/**
	 * Check the appid and secret key
	 * fields if the user enabled the
	 * appropriate social login
	 * This is the 'googleRequired' validator as declared in rules().
	 */
	public function googleRequired($attribute)
	{
		if($this->googlestatus == 1){
			if($this->googleappid == ''){
				$this->addError('googleappid', Yii::t('admin','Google Appid cannot be empty'));
			}
			if($this->googlesecret == ''){
				$this->addError('googlesecret', Yii::t('admin','Google Secret Key cannot be empty'));
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sitename' => Yii::t('admin','Site Name'),
		    'logo' => Yii::t('admin','Logo'),
		    'default_userimage' => Yii::t('admin','Default User Image'),
			'smtpPassword' => Yii::t('admin','Smtp Password'),
			'socialLoginDetails' => Yii::t('admin','Social Login Details'),
			'facebookstatus' => Yii::t('admin','Enable').' '.Yii::t('admin','Facebook'),
			'twitterstatus' => Yii::t('admin','Enable').' '.Yii::t('admin','Twitter'),
			'googlestatus' => Yii::t('admin','Enable').' '.Yii::t('admin','Google'),
			'facebookappid' => Yii::t('admin','Facebook').' '.Yii::t('admin','App id'),
			'facebooksecret' => Yii::t('admin','Facebook').' '.Yii::t('admin','Secret Key'),
			'twitterappid' => Yii::t('admin','Twitter').' '.Yii::t('admin','App id'),
			'twittersecret' => Yii::t('admin','Twitter').' '.Yii::t('admin','Secret Key'),
			'googleappid' => Yii::t('admin','Google').' '.Yii::t('admin','App id'),
			'googlesecret' => Yii::t('admin','Google').' '.Yii::t('admin','Secret Key'),
	     	'smtpEnable' => Yii::t('admin','SMTP').' '.Yii::t('admin','Enable'),
		    'smtpEmail' =>  Yii::t('admin','SMTP').' '.Yii::t('admin','Email'),
		    'smtpPassword' =>  Yii::t('admin','SMTP').' '.Yii::t('admin','Password'),
		    'smtpPort' =>  Yii::t('admin','SMTP').' '.Yii::t('admin','Port'),
		    'smtpHost' =>  Yii::t('admin','SMTP').' '.Yii::t('admin','Host'),
		    'paypalType' => Yii::t('admin','Paypal Type'),
		    'paypalEmailId' => Yii::t('admin','Paypal Email ID'),
		    'paypalApiUserId' => Yii::t('admin','Paypal API').' '.Yii::t('admin','User ID'),
		    'paypalApiPassword' => Yii::t('admin','Paypal API').' '.Yii::t('admin','Password'),
		    'paypalApiSignature' => Yii::t('admin','Paypal API').' '.Yii::t('admin','Signature'),
		    'paypalAppId' => Yii::t('admin','Paypal App ID'),
			'paypalCcStatus' => Yii::t('admin','Paypal Credit Card Checkout'),
			'paypalCcClientId' => Yii::t('admin','Paypal App Client ID'),
			'paypalCcSecret' => Yii::t('admin','Paypal App Secret Key'),
			'apiUsername' => Yii::t('admin','API Username'),
			'apiPassword' => Yii::t('admin','API Password'),
			'facebookFooterLink' => Yii::t('admin','Footer Facebook Link'),
			'googleFooterLink' => Yii::t('admin','Footer Google plus Link'),
			'twitterFooterLink' => Yii::t('admin','Footer Twitter Link'),
			'androidFooterLink' => Yii::t('admin','Footer Android app Link'),
			'iosFooterLink' => Yii::t('admin','Footer IOS app Link'),
			'searchType' => Yii::t('admin','Search Type'),
			'searchList' => Yii::t('admin','Search List'),
			'searchDistance' => Yii::t('admin','Search Distance'),
			'cancelEnableStatus' => Yii::t('admin','Enable Cancel Upto Which Status ?'),
			'tracking_code' => Yii::t('admin','Analytics Code(Tracking Code)'),
				
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

		$criteria->compare('id',$this->id);
		$criteria->compare('smtpEmail',$this->smtpEmail,true);
		$criteria->compare('smtpPassword',$this->smtpPassword,true);
		$criteria->compare('socialLoginDetails',$this->socialLoginDetails,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sitesettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
