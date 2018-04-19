<?php

class AdminController extends Controller
{
	public $layout = '//layouts/admin';

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	
	public function actionIndex()
	{
		if(isset(Yii::app()->adminUser->id))
			$this->redirect(array('/admin/dashboard'));
		
		$model=new AdminLoginForm;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='adminlogin-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		// collect user input data
		if(isset($_POST['AdminLoginForm']))
		{
			$model->attributes=$_POST['AdminLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(array('/admin/dashboard'));
		}
		// display the login form
		$this->render('index',array('model'=>$model));
	}
	
	public function actionDashboard(){
		if(!isset(Yii::app()->adminUser->id))
			$this->redirect(array('/admin'));
		
		$this->layout = '//layouts/adminwithmenu';
		
		$this->render('dashboard');
	}
	
	public function actionLogout(){
		
		Yii::app()->adminUser->logout(false); 
		$this->redirect(array('/admin'));
	}
}