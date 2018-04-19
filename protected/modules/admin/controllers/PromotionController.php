<?php

class PromotionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
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
				
			$user = Yii::app()->adminUser;
			if($user->isGuest && Yii::app()->controller->action->id != 'index'&& Yii::app()->controller->action->id != 'resized') {
				$this->redirect(Yii::app()->adminUser->loginUrl);
				return false;
			}elseif(isset(Yii::app()->adminUser->id) && Yii::app()->controller->action->id == 'index'){
				$this->redirect(array('/admin/action/dashboard'));
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
		$model=new Promotions;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$id = 1;
		$siteSettings = Sitesettings::model()->findByPk($id);
		$promotionCurrency = $siteSettings->promotionCurrency;
		
		if(isset($_POST['Promotions']))
		{
			$model->attributes=$_POST['Promotions'];
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->setFlash('success',Yii::t('admin','Promotions created successfully.'));
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,'siteSettings'=>$promotionCurrency,
				
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

		if(isset($_POST['Promotions']))
		{
			$model->attributes=$_POST['Promotions'];
			if($model->save())
				Yii::app()->user->setFlash('success',Yii::t('admin','Promotions updated successfully.'));
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
		//Yii::app()->user->setFlash('success',Yii::t('admin','Payment settings updated successfully.'));
		//$this->redirect(array('admin'));
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		// if(!isset($_GET['ajax']))
		// 	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		
		if(!isset($_GET['ajax'])) {
			Yii::app()->user->setFlash('success',Yii::t('admin','Promotion deleted Successfully'));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else {
			echo "<ul class='flashes'><li><div class='flash-success'>".Yii::t('admin','Promotion deleted Successfully')."</div></li></ul>";
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Promotions');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Promotions('search');
		$model->unsetAttributes();  // clear any default values
		

		$siteSettingsModel = Sitesettings::model()->findByAttributes(array('id'=>1));
		$currencySymbols = explode("-", $siteSettingsModel->promotionCurrency);
		$currencySymbol = trim($currencySymbols[0]);
		
		if(isset($_GET['Promotions']))
			$model->attributes=$_GET['Promotions'];
		
		$this->render('admin',array(
			'model'=>$model, 'selectedcurrency'=>$currencySymbol,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Promotions the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Promotions::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Promotions $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='promotions-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionPromotioncurrencies(){
		$currency = $_GET['currency'];
		$str = explode("-",$currency);
		$currency = $str[2].'-'.$str[0];
		//print_r($str);
		//echo $currency;
		$siteSettingsModel = Sitesettings::model()->findByAttributes(array('id'=>1));
		/* if($currency == 0){
			$currency = $siteSettingsModel->promotionCurrency;
			
		} */
		//echo $currency;
		$siteSettingsModel->promotionCurrency = $currency;
		$siteSettingsModel->save(false);
		$siteSettingsModels = Sitesettings::model()->findByAttributes(array('id'=>1));
		echo  $siteSettingsModels->promotionCurrency;
		//$updatedcurrency = Currencies::model()->findByPk($currency);
		//echo $updatedcurrency->currency_name.' - '.$updatedcurrency->currency_shortcode.' - '.$updatedcurrency->currency_symbol;
		
	}
	public function actionUrgentpromotion() {
		$urgentprice = $_REQUEST['urgentprice'];
		
		$settings = Sitesettings::model()->findByAttributes(array('id'=>1));
		$promotionCurrency = $settings->promotionCurrency;
		$promotionCurrency = explode('-', $promotionCurrency);
		if(isset($_POST['urgentprice'])) {
			//echo "fskdjh";die;
			$settings->urgentPrice = $urgentprice;
			$settings->save(false);
			Yii::app()->user->setFlash('success',Yii::t('admin','Urgent promotion\'s Price updated successfully.'));
		}
		
		$this->render('urgentpromotion',compact('settings','urgentprice','promotionCurrency'));
	}
}
