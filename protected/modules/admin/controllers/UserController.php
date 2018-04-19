<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/adminwithmenu';//'//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array( // perform access control for CRUD operations
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users('create');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			$model->username = str_replace(" ",'',$_POST['Users']['username']);
			$password = $_POST['Users']['password'];
			$model->userstatus = 1;
			$model->activationStatus = 1;
			if($model->validate()) {
				$model->password = base64_encode($password);
				$model->save(false);
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
				$mail->setView('adminsignup');
				$mail->setData(array('name' => $model->name,'useremail' => $model->email,'password'=>$password,
							'siteSettings' => $siteSettings));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($model->email);
				$mail->setSubject($siteSettings->sitename.' Login Credentials');
				$mail->send();
				Yii::app()->user->setFlash('success',Yii::t('admin','User Created Successfully'));
				$this->redirect(array('admin'));
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
		$model->setScenario('update');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$model->password = base64_decode($model->password);
		if(isset($_POST['Users']))
		{
			$model->username = str_replace(" ",'',$_POST['Users']['username']);
			if($model->password != $_POST['Users']['password']){
				$password = $_POST['Users']['password'];
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
				$mail->setView('adminresetpassword');
				$mail->setData(array('name' => $model->name,'useremail' => $model->email,'password'=>$password,
						'siteSettings' => $siteSettings));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($model->email);
				$mail->setSubject($siteSettings->sitename.' User Security Update');
				$mail->send();
			}

			$model->attributes=$_POST['Users'];
			$model->password = base64_encode($_POST['Users']['password']);

			if($model->save()){
				Yii::app()->user->setFlash('success',Yii::t('admin','User Details Updated Successfully'));
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionProfile()
	{
		$id = Yii::app()->adminUser->id;

		$model=Admins::model()->findByPk($id);
		$password = base64_decode($model->password);
		$model->password = $password;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Admins']))
		{
			$model->attributes=$_POST['Admins'];
			$model->password = base64_encode($model->password);
			if($model->save()) {
				Yii::app()->user->setFlash('success',Yii::t('admin','Admin Profile Updated Successfully'));
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}

		$this->render('profile',array(
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
		$model = $this->loadModel($id);

		$criteria = new CDbCriteria;
		$criteria->condition = "user1 = $id OR user2 = $id";
		$chats = Chats::model()->findAll($criteria);

		foreach($chats as $chat):
			$messages = Messages::model()->findAllByAttributes(array("chatId" =>$chat->chatId));
			foreach($messages as $message):
				$message->delete();
			endforeach;
			$chat->delete();
		endforeach;

		$exCriteria = new CDbCriteria;
		$exCriteria->condition = "requestFrom = $id OR requestTo = $id";
		$exchanges = Exchanges::model()->findAll($exCriteria);
		foreach($exchanges as $exchange):
		$exModel = Exchanges::model()->findByPk($exchange->id);
		$exModel->delete();
		endforeach;

		$model->delete();

		$criteria = new CDbCriteria;
		$criteria->addCondition("userid = '$id'");
		$criteria->addCondition("notifyto = '$id'", 'OR');
		
		$logModel = Logs::model()->deleteAll($criteria);
		
		$followcriteria = new CDbCriteria;
		$followcriteria->addCondition("userId = '$id'");
		$followcriteria->addCondition("follow_userId = '$id'", 'OR');
		
		$logModel = Followers::model()->deleteAll($criteria);
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			Yii::app()->user->setFlash('success',Yii::t('admin','User deleted Successfully'));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else {
			echo "<ul class='flashes'><li><div class='flash-success'>".Yii::t('admin','User deleted Successfully')."</div></li></ul>";
		}
	}

	public function actionManage($status,$id) {
		$user = Users::model()->findByPk($id);
		if(!empty($user)) {
			if($status == 3) {
				//$user->activationStatus = 1;
				$user->save(false);
				$emailTo = $user->email;
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
				$mail->setData(array('access_url' => $verifyLink, 'name' => $user->name,
							'siteSettings' => $siteSettings));
				$mail->setFrom($siteSettings->smtpEmail, $siteSettings->sitename);
				$mail->setTo($emailTo);
				$mail->setSubject(Myclass::getSiteName().' Reverification Mail');
				$mail->send();
				echo "<ul class='flashes'><li><div class='flash-success'>".Yii::t('admin','User Reverfication mail has been sent Successfully')."</div></li></ul>";
			} elseif($status == 1) {
				// $user->activationStatus = 0;
				$user->userstatus = 1;
				$user->save(false);
				echo "<ul class='flashes'><li><div class='flash-success'>".Yii::t('admin','User has been Enabled Successfully')."</div></li></ul>";

			} else {
				// $user->activationStatus = 0;
				$exCriteria = new CDbCriteria;
				$exCriteria->condition = "requestFrom = $id OR requestTo = $id";
				$exCriteria->addCondition("status = 1");
				$exchanges = Exchanges::model()->findAll($exCriteria);	
				//print_r($exchanges);
				//$orderStatus[] = 'delivered';
				$orderStatus = array();
				$orderStatus[] = 'pending';
				$orderStatus[] = 'processing';
				$orderStatus[] = 'shipped';
				//$orderStatus[] = 'delivered';
				$orderStatus[] = 'track';
				$orderCriteria = new CDbCriteria;
				//$orderCriteria->addCondition('status NOT LIKE :status');
				//$orderCriteria->params[ ':status' ] = $orderStatus;
				$orderCriteria->addCondition("userId = $id ",'OR');
				$orderCriteria->addCondition("sellerId = $id",'OR');
				$orderCriteria->compare('status', $orderStatus, true);
				/*$orderCriteria->addCondition('status NOT LIKE '.$orderStatus );
				 $orderCriteria->params = array(
						':status' => "%$orderStatus%"); */
				$orders = Orders::model()->findAll($orderCriteria);
				//print_r($orders);
				if (empty($exchanges) && empty($orders)){
					$user->userstatus = 0;
					$user->save(false);
					//echo "<ul class='flashes'><li><div class='flash-success'>".Yii::t('admin','User has been disabled Successfully')."</div></li></ul>";
				}else{
					echo Yii::t('admin','User cannot be disabled ');
						
				}

			}
		}

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
		$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
