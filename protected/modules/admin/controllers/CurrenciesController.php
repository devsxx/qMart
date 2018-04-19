<?php
class CurrenciesController extends Controller
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','showtop'),
				'users'=>array('*'),
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
		),
		array('deny',  // deny all users
				'users'=>array('*'),
		),
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
		$model=new Currencies;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Currencies']))
		{
			$model->attributes=$_POST['Currencies'];
			if($model->save()) {
				Yii::app()->user->setFlash('success',Yii::t('admin','Currency created successfully.'));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$selected = Myclass::getCurrency($model->currency_shortcode);

		if(isset($_POST['Currencies']))
		{
			$model->attributes=$_POST['Currencies'];
			//$model->currency_image = $_POST['Currencies']['currency_image'];
			//var_dump($_POST['Currencies']['currency_image']); exit;
			if($model->validate()) {
				$model->save(false);
				Yii::app()->user->setFlash('success',Yii::t('admin','Currency updated successfully.'));
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,'selected'=>$selected,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = Currencies::model()->count();
		if($model > 1) {
			$siteModel = Sitesettings::model()->findByPk(1);
			$siteCur = json_decode($siteModel->currency_priority,true);
			if(in_array($id,$siteCur)) {
				$key = array_search($id,$siteCur);
				if($key!==false){
					$array = array_splice($siteCur,$key,1);
				}
			}
			$array_length = count($siteCur);
			for($i = $array_length; $i<5; $i++) {
				$siteCur[$i] = "empty";
			}
			$siteModel->currency_priority = json_encode($siteCur);
			$siteModel->save(false);

			$this->loadModel($id)->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			else
			echo "<ul class='flashes'><li><div class='flash-success'>".Yii::t('admin','Currency deleted successfully.')."</div></li></ul>";		
		} else {
			echo "<ul class='flashes'><li><div class='flash-success'>".Yii::t('admin','Currency table should have atleast one record.')."</div></li></ul>";
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Currencies');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Currencies('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Currencies']))
		$model->attributes=$_GET['Currencies'];
		
		$totalCurrency = Currencies::model()->count();
		
		$deleteStatus = $totalCurrency > 1 ? true : false;

		$this->render('admin',array(
			'model'=>$model, 'deleteStatus' => $deleteStatus
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Currencies the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Currencies::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Currencies $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='currencies-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionShowtop() {
		$currencies = Currencies::model()->findAll();
		if(isset($_POST['Currencies'])) {
			$val = json_encode($_POST['Currencies']['priority']);

		}
		$this->render('showtop',compact('currencies'));
	}
}
