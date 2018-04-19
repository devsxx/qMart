<?php

class SitesettingsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/adminwithmenu';

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

	protected function beforeAction($action)
	{
		if (!parent::beforeAction($action)) {
			return false;
		}

		$user = Yii::app()->adminUser;
		if($user->isGuest) {
			$this->redirect(Yii::app()->adminUser->loginUrl);
			return false;
		}

		return true;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Sitesettings;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Sitesettings']))
		{
			$model->attributes=$_POST['Sitesettings'];
			if($model->save())
			$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionRestorapikey() {
		$id = 1;
		$model=$this->loadModel($id);

		if (isset($model->id)){
			$apiDetails = json_decode($model->api_settings, true);
			$defaultUsername = $apiDetails['apicredential']['default']['username'];
			$defaultPassword = $apiDetails['apicredential']['default']['password'];
			$apiDetails['apicredential']['current']['username'] = $defaultUsername;
			$apiDetails['apicredential']['current']['password'] = $defaultPassword;

			$model->api_settings = json_encode($apiDetails);
			if($model->save(false)) {
				Yii::app()->user->setFlash('success','API Credentials updated to default successfully.');
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			Yii::app()->user->setFlash('failed','Something went wrong, please try again later.');
			$this->redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	public function actionFootersettings() {
		$id = 1;
		$model=$this->loadModel($id);
		$makeDefault = 0;
		
		if (isset($model->id)){
			$footerDetails = json_decode($model->footer_settings, true);
			
			$model->facebookFooterLink = $footerDetails['footerDetails']['facebooklink'];
			$model->googleFooterLink = $footerDetails['footerDetails']['googlelink'];
			$model->twitterFooterLink = $footerDetails['footerDetails']['twitterlink'];
			$model->androidFooterLink = $footerDetails['footerDetails']['androidlink'];
			$model->iosFooterLink = $footerDetails['footerDetails']['ioslink'];
			$model->footerCopyRightsDetails = $footerDetails['footerDetails']['footerCopyRightsDetails'];
		}else{
			$model=new Sitesettings;
		}
		$this->performAjaxValidation($model);
		
		if(isset($_POST['Sitesettings']))
		{
			//echo "<pre>";print_r($_POST['Sitesettings']);die;
			$model->attributes = $_POST['Sitesettings'];
			
			$footerDetails['footerDetails']['facebooklink'] = $_POST['Sitesettings']['facebookFooterLink'];
			$footerDetails['footerDetails']['googlelink'] = $_POST['Sitesettings']['googleFooterLink'];
			$footerDetails['footerDetails']['twitterlink'] = $_POST['Sitesettings']['twitterFooterLink'];
			$footerDetails['footerDetails']['androidlink'] = $_POST['Sitesettings']['androidFooterLink'];
			$footerDetails['footerDetails']['ioslink'] = $_POST['Sitesettings']['iosFooterLink'];
			$footerDetails['footerDetails']['footerCopyRightsDetails'] = $_POST['Sitesettings']['footerCopyRightsDetails'];
		
			$model->footer_settings = json_encode($footerDetails);
			$model->tracking_code = $_POST['Sitesettings']['tracking_code'];
			
			if($model->save(false)) {
				Yii::app()->user->setFlash('success',Yii::t('admin','Footer Settings updated successfully.'));
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->render('footersettings', array('model'=>$model));
	}

	public function actionApidetails() {
		$id = 1;
		$model=$this->loadModel($id);
		$makeDefault = 0;

		if (isset($model->id)){
			$apiDetails = json_decode($model->api_settings, true);
			$model->apiUsername = $apiDetails['apicredential']['current']['username'];
			$model->apiPassword = $apiDetails['apicredential']['current']['password'];
			if(!isset($apiDetails['apicredential']['default']['username']) ||
			$apiDetails['apicredential']['default']['username'] == ""){
				$makeDefault = 1;
			}
		}else{
			$model=new Sitesettings;
		}
		$this->performAjaxValidation($model);

		if(isset($_POST['Sitesettings']))
		{
			//echo "<pre>";print_r($_POST['Sitesettings']);die;
			$model->attributes = $_POST['Sitesettings'];
			if($makeDefault == 1){
				$apiDetails['apicredential']['default']['username'] = $_POST['Sitesettings']['apiUsername'];
				$apiDetails['apicredential']['default']['password'] = $_POST['Sitesettings']['apiPassword'];
			}
			$apiDetails['apicredential']['current']['username'] = $_POST['Sitesettings']['apiUsername'];
			$apiDetails['apicredential']['current']['password'] = $_POST['Sitesettings']['apiPassword'];

			$model->api_settings = json_encode($apiDetails);
			if($model->save(false)) {
				Yii::app()->user->setFlash('success','API Credentials updated successfully.');
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}

		$this->render('apidetails', array('model'=>$model, 'makeDefault'=>$makeDefault));
	}

	/**
	 * Handles the social login settings in the
	 * admin panel (FB, twitter and google+)
	 * app id and secret key with enable and disable
	 * options.
	 *
	 */
	public function actionSocialLogin()
	{
		$id = 1;
		$model=$this->loadModel($id);
		//$siteSettingsModel = Sitesettings::model()->findAllByAttributes(array('id'=>1));
		if (isset($model->id)){
			//$id = $siteSettingsModel->id;
			//$model=$this->loadModel($id);
			$socialLoginSettings = json_decode($model->socialLoginDetails, true);
			if ($socialLoginSettings['facebook']['status'] == 'enable'){
				$model->facebookstatus = '1';
			}else{
				$model->facebookstatus = '0';
			}
			$model->facebookappid = $socialLoginSettings['facebook']['appid'];
			$model->facebooksecret = $socialLoginSettings['facebook']['secret'];
			if ($socialLoginSettings['twitter']['status'] == 'enable'){
				$model->twitterstatus = '1';
			}else{
				$model->twitterstatus = '0';
			}
			$model->twitterappid = $socialLoginSettings['twitter']['appid'];
			$model->twittersecret = $socialLoginSettings['twitter']['secret'];
			if ($socialLoginSettings['google']['status'] == 'enable'){
				$model->googlestatus = '1';
			}else{
				$model->googlestatus = '0';
			}
			$model->googleappid = $socialLoginSettings['google']['appid'];
			$model->googlesecret = $socialLoginSettings['google']['secret'];
		}else{
			$model=new Sitesettings;
		}
		$model->setScenario('sociallogin');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Sitesettings']))
		{
			$model->attributes=$_POST['Sitesettings'];
			$socialLoginSettings = array();
			if ($model->facebookstatus == '1'){
				$socialLoginSettings['facebook']['status'] = 'enable';
			}else{
				$socialLoginSettings['facebook']['status'] = 'disable';
			}
			$socialLoginSettings['facebook']['appid'] = $model->facebookappid;
			$socialLoginSettings['facebook']['secret'] = $model->facebooksecret;
			if ($model->twitterstatus == '1'){
				$socialLoginSettings['twitter']['status'] = 'enable';
			}else{
				$socialLoginSettings['twitter']['status'] = 'disable';
			}
			$socialLoginSettings['twitter']['appid'] = $model->twitterappid;
			$socialLoginSettings['twitter']['secret'] = $model->twittersecret;
			if ($model->googlestatus == '1'){
				$socialLoginSettings['google']['status'] = 'enable';
			}else{
				$socialLoginSettings['google']['status'] = 'disable';
			}
			$socialLoginSettings['google']['appid'] = $model->googleappid;
			$socialLoginSettings['google']['secret'] = $model->googlesecret;

			$model->socialLoginDetails = json_encode($socialLoginSettings);
			if($model->save()) {
				Yii::app()->user->setFlash('success',Yii::t('admin','Social settings updated successfully.'));
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}

		$this->render('sociallogin',array(
			'model'=>$model,'scenario'=>'sociallogin'
			));
	}

	public function actionPayment() {
		$id = 1;
		$model=$this->loadModel($id);
		$model->setScenario('payment');
		if (isset($model->id)){
			$model->attributes = json_decode($model->paypal_settings, true);
		}
		$this->performAjaxValidation($model);

		if(isset($_POST['Sitesettings']))
		{
			$model->attributes=$_POST['Sitesettings'];
			$model->paypal_settings = json_encode(
			array(
				'paypalType'=> $_POST['Sitesettings']['paypalType'],
				'paypalEmailId'=> $_POST['Sitesettings']['paypalEmailId'],
				'paypalApiUserId'=> $_POST['Sitesettings']['paypalApiUserId'],
				'paypalApiPassword'=> $_POST['Sitesettings']['paypalApiPassword'],
				'paypalApiSignature'=> $_POST['Sitesettings']['paypalApiSignature'],
				'paypalAppId'=> $_POST['Sitesettings']['paypalAppId'],
				'paypalCcStatus' => $_POST['Sitesettings']['paypalCcStatus'],
				'paypalCcClientId' => $_POST['Sitesettings']['paypalCcClientId'],
				'paypalCcSecret' => $_POST['Sitesettings']['paypalCcSecret'],
			));
			if($model->save()){
				
			}
			Yii::app()->user->setFlash('success',Yii::t('admin','Payment settings updated successfully.'));
		}
		$this->render('payment',compact('model','paymentSettings'));
	}

	public function actionSitePaymentModes() {
		$id = 1;
		$model=$this->loadModel($id);
		$model->setScenario('paymentmodes');
		if (isset($model->id) && !isset($_POST['Sitesettings'])){
			if(!empty($model->sitepaymentmodes)){
				$sitePaymentMode = json_decode($model->sitepaymentmodes, true);
				$model->exchangePaymentMode = $sitePaymentMode['exchangePaymentMode'];
				$model->buynowPaymentMode = $sitePaymentMode['buynowPaymentMode'];
				$model->cancelEnableStatus = $sitePaymentMode['cancelEnableStatus'];
				$model->sellerClimbEnableDays = $sitePaymentMode['sellerClimbEnableDays'];
				$model->scrowPaymentMode = $sitePaymentMode['scrowPaymentMode'];
			}
		}
		$this->performAjaxValidation($model);

		if(isset($_POST['Sitesettings']))
		{
			$model->attributes=$_POST['Sitesettings'];
			$model->sitepaymentmodes = json_encode(
			array(
				'exchangePaymentMode'=> $_POST['Sitesettings']['exchangePaymentMode'],
				'buynowPaymentMode'=> $_POST['Sitesettings']['buynowPaymentMode'],
				'cancelEnableStatus'=> $_POST['Sitesettings']['cancelEnableStatus'],
				'sellerClimbEnableDays'=> $_POST['Sitesettings']['sellerClimbEnableDays'],
				'scrowPaymentMode'=> $_POST['Sitesettings']['scrowPaymentMode'],
			));
			if($model->save()){
				if(!empty($model->sitepaymentmodes)){
					$sitePaymentMode = json_decode($model->sitepaymentmodes, true);
					$model->exchangePaymentMode = $sitePaymentMode['exchangePaymentMode'];
					$model->buynowPaymentMode = $sitePaymentMode['buynowPaymentMode'];
					$model->cancelEnableStatus = $sitePaymentMode['cancelEnableStatus'];
					$model->sellerClimbEnableDays = $sitePaymentMode['sellerClimbEnableDays'];
					$model->scrowPaymentMode = $sitePaymentMode['scrowPaymentMode'];
				}
				Yii::app()->user->setFlash('success',Yii::t('admin','Site Payment Modes updated successfully.'));
			}
		}
		$this->render('sitepaymentmodes',compact('model'));
	}

	public function actionBrainTreeSettings() {
		$id = 1;
		$model=$this->loadModel($id);
		$model->setScenario('braintreesettings');
		if (isset($model->id) && !isset($_POST['Sitesettings'])){
			if(!empty($model->braintree_settings)){
				$braintreeSetting = json_decode($model->braintree_settings, true);
				$model->brainTreeType = $braintreeSetting['brainTreeType'];
				$model->brainTreeMerchantId = $braintreeSetting['brainTreeMerchantId'];
				$model->brainTreePublicKey = $braintreeSetting['brainTreePublicKey'];
				$model->brainTreePrivateKey = $braintreeSetting['brainTreePrivateKey'];
			}
		}
		$this->performAjaxValidation($model);

		if(isset($_POST['Sitesettings'])){
			//echo "<pre>";print_r($_POST);die;
			$model->attributes=$_POST['Sitesettings'];
			$model->braintree_settings = json_encode(
			array(
				'brainTreeType'=> $_POST['Sitesettings']['brainTreeType'],
				'brainTreeMerchantId'=> $_POST['Sitesettings']['brainTreeMerchantId'],
				'brainTreePublicKey'=> $_POST['Sitesettings']['brainTreePublicKey'],
				'brainTreePrivateKey'=> $_POST['Sitesettings']['brainTreePrivateKey'],
			));
			if($model->save()){
				if(!empty($model->braintree_settings)){
					$braintreeSetting = json_decode($model->braintree_settings, true);
					$model->brainTreeType = $braintreeSetting['brainTreeType'];
					$model->brainTreeMerchantId = $braintreeSetting['brainTreeMerchantId'];
					$model->brainTreePublicKey = $braintreeSetting['brainTreePublicKey'];
					$model->brainTreePrivateKey = $braintreeSetting['brainTreePrivateKey'];
				}
				Yii::app()->user->setFlash('success',Yii::t('admin','Braintree Settings updated successfully.'));
			}
		}
		$this->render('braintreesettings',compact('model'));
	}
	
	public function actionSmtpSettings() {
		$id = 1;
		$model=$this->loadModel($id);
		$model->setScenario('smtp');
		$this->performAjaxValidation($model);

		if(isset($_POST['Sitesettings']))
		{
			$model->attributes=$_POST['Sitesettings'];
			$model->save();
			Yii::app()->user->setFlash('success',Yii::t('admin','SMTP settings updated successfully.'));
		}
		$this->render('smtp',compact('model'));
	}

	public function actionDefaultsettings() {
		$id = 1;
		$model=$this->loadModel($id);
		$model->setScenario('defaultsettings');
		$oldSite = $model->sitename;
		$oldLogo = $model->logo;
		$oldLogoDark = $model->logoDarkVersion;
		
		$oldUser = $model->default_userimage;
		if (isset($model->id)){
			if(!isset($_POST['Sitesettings'])){
				$metaData = json_decode($model->metaData, true);
				$model->metaTitle = $metaData['metaTitle'];
				$model->metaDescription = $metaData['metaDescription'];
				$model->metaKeywords = $metaData['metaKeywords'];
			}
			
			if(isset($_POST['Sitesettings']))
			{
				//echo "<pre>";print_r($_POST['Sitesettings']);die;
				$model->attributes=$_POST['Sitesettings'];
				$logoUpload = CUploadedFile::getInstance($model,'logo');
				
				$logoDarkUpload = CUploadedFile::getInstance($model,'logoDarkVersion');
				
				$userUpload = CUploadedFile::getInstance($model,'default_userimage');
				if(!is_null($logoUpload)) {

					$model->logo = rand(0000,9999).'_'.$logoUpload;
				} else {
					$model->logo = $oldLogo;
				}
				
				if(!is_null($logoDarkUpload)) {
					$model->logoDarkVersion = rand(0000,9999).'_'.$logoDarkUpload;
				} else {
					$model->logoDarkVersion = $oldLogoDark;
				}
				
				if(!is_null($userUpload)) {
					$model->default_userimage = rand(0000,9999).'_'.$userUpload;
				} else {
					$model->default_userimage = $oldUser;
				}
				//echo $model->default_userimage;die;
				if(is_null($model->sitename))
				$model->sitename = $oldSite;
				
				$metaData['metaTitle'] = $_POST['Sitesettings']['metaTitle'];
				$metaData['metaDescription'] = $_POST['Sitesettings']['metaDescription'];
				$metaData['metaKeywords'] = $_POST['Sitesettings']['metaKeywords'];
				$model->metaData = json_encode($metaData);
				$model->googleapikey = $_POST['Sitesettings']['googleapikey'];
				
				if($model->save(false)) {
					if(!is_null($logoUpload)){
						$logoUpload->saveAs('media/logo/'.str_replace(" ","-",$model->logo));
					}
					
					if(!is_null($logoDarkUpload)){
						$logoDarkUpload->saveAs('media/logo/'.str_replace(" ","-",$model->logoDarkVersion));
					}
					
					if(!is_null($userUpload)){
						$userUpload->saveAs('media/user/default/'.str_replace(" ","-",$model->default_userimage));
					}
					Yii::app()->user->setFlash('success',Yii::t('admin','Default settings updated successfully.'));
					$this->redirect($_SERVER['HTTP_REFERER']);
				}
			}
		} else {
			$model = new Sitesettings;
		}
		$model->setScenario('defaultsettings');
		if(isset($_POST['Sitesettings']))
		{
			$model->attributes=$_POST['Sitesettings'];
			$logoUpload = CUploadedFile::getInstance($model,'logo');
			
			$logoDarkUpload = CUploadedFile::getInstance($model,'logoDarkVersion');
			
			$userUpload = CUploadedFile::getInstance($model,'default_userimage');
			if(!is_null($logoUpload)) {
				$model->logo = rand(0000,9999).'_'.$logoUpload;
			} else {
				$model->logo = $oldLogo;
			}
			
			if(!is_null($logoDarkUpload)) {
				$model->logoDarkVersion = rand(0000,9999).'_'.$logoDarkUpload;
			} else {
				$model->logoDarkVersion = $oldLogoDark;
			}
			
			if(!is_null($userUpload)) {
				$model->default_userimage = rand(0000,9999).'_'.$userUpload;
			} else {
				$model->default_userimage = $oldUser;
			}
			if(is_null($model->sitename))
			$model->sitename = $oldSite;
			if($model->save(false)) {
				if(!is_null($logoUpload)){
					$logoUpload->saveAs('media/logo/'.$model->logo);
					Yii::import('application.extensions.image.Image');
					$image = new Image('media/logo/'.$model->logo);
					$image->resize(124, 100)->quality(100)->sharpen(20);
					$image->save();
				}
				
				if(!is_null($logoDarkUpload)){
					$logoDarkUpload->saveAs('media/logo/'.$model->logoDarkVersion);
					Yii::import('application.extensions.image.Image');
					$darkimage = new Image('media/logo/'.$model->logoDarkVersion);
					$darkimage->resize(124, 100)->quality(100)->sharpen(20);
					$darkimage->save();
				}
				
				if(!is_null($userUpload)){
					$userUpload->saveAs('media/user/default/'.$model->default_userimage);
				}
				Yii::app()->user->setFlash('success',Yii::t('admin','Default settings updated successfully.'));
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->render('defaultsettings',array(
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
		$this->performAjaxValidation($model);

		if(isset($_POST['Sitesettings']))
		{
			$model->attributes=$_POST['Sitesettings'];
			if($model->save())
			$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Sitesettings');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Sitesettings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Sitesettings::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Sitesettings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sitesettings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionShowtop() {
		$currencies = Currencies::model()->findAll();
		$model = Sitesettings::model()->findByPk(1);
		if(isset($_POST['Sitesettings'])) {
			$unique = $_POST['Sitesettings']['priority'];
			foreach($_POST['Sitesettings']['priority'] as $value):
			if (in_array($value,$unique)) {
				$val = Currencies::model()->findByPk($value);
				//Yii::app()->user->setFlash('warning','You have selected '. $val->currency_name .' twice.');
			}
			endforeach;
			$settings = json_encode($_POST['Sitesettings']['priority']);
			$model->currency_priority = $settings;
			$model->save(false);
			Yii::app()->user->setFlash('success',Yii::t('admin','Currency priority settings updated successfully.'));
		}

		if(!empty($model->currency_priority)) {
			$topFive = json_decode($model->currency_priority);
			if($topFive[0] == 'empty') { 
			$criteria = new CdbCriteria();
			$criteria->limit = 5;
			$curs = Currencies::model()->findAll($criteria);
			$count = count($curs);
			$topFive = array();
			foreach($curs as $cur):
			  $topFive[] = $cur->id;
			endforeach; 
			for($i=$count;$i < 5 ; $i++) {
				$topFive[] = 'empty';
			}
			}
		} else {
			$criteria = new CdbCriteria();
			$criteria->limit = 5;
			$curs = Currencies::model()->findAll($criteria);
			$count = count($curs);
			foreach($curs as $cur):
			  $topFive[] = $cur->id;
			endforeach; 
			for($i=$count;$i < 5 ; $i++) {
				$topFive[] = 'empty';
			}
		}
		$this->render('showtop',compact('currencies','topFive'));
	}

}
