<?php

class BuynowController extends Controller
{

	public function actionIndex()
	{
		$this->render('index');
	}

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
	*/

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
		$allowedActions = array('adaptiveipnprocess', 'ipnprocess', 'canceled', 'success');
		$user = Yii::app()->user;
		if($user->isGuest && !in_array(Yii::app()->controller->action->id, $allowedActions)) {
			$this->redirect(array('/user/login'));
			return false;
		}

		return true;
	}
}