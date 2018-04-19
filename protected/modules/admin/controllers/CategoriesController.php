<?php

class CategoriesController extends Controller
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

	public function actions()
	{
		return array(
			'resized' => array(
				'class'   => 'ext.resizer.ResizerAction',
				'options' => array(
		// Tmp dir to store cached resized images
					'cache_dir'   => Yii::getPathOfAlias('webroot') . '/assets/resized/',

		// Web root dir to search images from
					'base_dir'    => Yii::getPathOfAlias('webroot') . '/media/category/',
		)
		),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		$model=$this->loadModel($id);
		$categoryProperty = json_decode($model->categoryProperty, true);
		 if ($categoryProperty['itemCondition'] == 'enable'){
			$model->itemCondition = 'Enable';
		}elseif ($categoryProperty['itemCondition'] == 'disable'){
			$model->itemCondition = 'Disable';
		}
		if ($categoryProperty['contactSeller'] == 'enable'){
			$model->contactSeller = 'Enable';
		}elseif ($categoryProperty['contactSeller'] == 'disable'){
			$model->contactSeller = 'Disable';
		}
		if ($categoryProperty['exchangetoBuy'] == 'enable'){
			$model->exchangetoBuy = 'Enable';
		}elseif ($categoryProperty['exchangetoBuy'] == 'disable'){
			$model->exchangetoBuy = 'Disable';
		}
		if ($categoryProperty['buyNow'] == 'enable'){
			$model->buyNow = 'Enable';
		}elseif ($categoryProperty['buyNow'] == 'disable'){
			$model->buyNow = 'Disable';
		}		
		if ($categoryProperty['myOffer'] == 'enable'){
			$model->myOffer = 'Enable';
		}elseif ($categoryProperty['myOffer'] == 'disable'){
			$model->myOffer = 'Disable';
		} 
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Categories('create');

		$parentCategory = array();
		$parentCategory = Categories::model()->findAllByAttributes(array('parentCategory'=>0));
		if (!empty($parentCategory)){
			$parentCategory = CHtml::listData($parentCategory, 'categoryId', 'name');
		}

		//echo "<pre>";print_r($parentCat);print_r($parentCategory);die;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Categories']))
		{
		$existcategory = Categories::model()->findAllByAttributes(array('name'=>$_POST['Categories']['name'],'parentCategory'=>$_POST['Categories']['parentCategory']));
if(count($existcategory)==0)
{	
			$model->attributes=$_POST['Categories'];
			if ($model->parentCategory == ''){
				$model->parentCategory = 0;
			}
			$catImage = CUploadedFile::getInstances($model,'image');
			if(!empty($catImage)) {
				$imageName = explode(".",$catImage[0]->name);
				$model->image = rand(000,9999).'-'.Myclass::productSlug($imageName[0]).'.'.$catImage[0]->extensionName;
			}
			
			$categoryProperty = array();
			if ($_POST['Categories']['itemCondition'] == 1){
				$categoryProperty['itemCondition'] = 'enable';
			}elseif ($_POST['Categories']['itemCondition'] == 0){
				$categoryProperty['itemCondition'] = 'disable';
			}
			if ($_POST['Categories']['exchangetoBuy'] == 1){
				$categoryProperty['exchangetoBuy'] = 'enable';
			}elseif ($_POST['Categories']['exchangetoBuy'] == 0){
				$categoryProperty['exchangetoBuy'] = 'disable';
			}
			if ($_POST['Categories']['buyNow'] == 1){
				$categoryProperty['buyNow'] = 'enable';
			}elseif ($_POST['Categories']['buyNow'] == 0){
				$categoryProperty['buyNow'] = 'disable';
			}			
			if ($_POST['Categories']['myOffer'] == '1'){
				$categoryProperty['myOffer'] = 'enable';
			}elseif ($_POST['Categories']['myOffer'] == 0){
				$categoryProperty['myOffer'] = 'disable';
			}
			if ($_POST['Categories']['contactSeller'] == '1'){
				$categoryProperty['contactSeller'] = 'enable';
			}elseif ($_POST['Categories']['contactSeller'] == 0){
				$categoryProperty['contactSeller'] = 'disable';
			}
			
			$model->categoryProperty = json_encode($categoryProperty);
			
			$model->createdDate = time();
			if($model->validate()) { 
				if(!empty($catImage)) {  
					$catImage[0]->saveAs('media/category/'. $model->image);
				}
				$model->save(false);
				Yii::app()->user->setFlash('success',Yii::t('admin','Category created successfully.'));
				$this->redirect(array('admin'));
			}
			
		}
else
{
				Yii::app()->user->setFlash('success',Yii::t('admin','Category already added to this parent category'));
				$this->redirect(array('admin'));	
}
}

		
		$this->render('create',array(
			'model'=>$model, 'parentCategory'=>$parentCategory
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
		$parentCategory = array();
		$parentCategory = Categories::model()->findAllByAttributes(array('parentCategory'=>0));
		if (!empty($parentCategory)){
			$parentCategory = CHtml::listData($parentCategory, 'categoryId', 'name');
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$oldImage = $model->image;
		$categoryProperty = json_decode($model->categoryProperty, true);
		
		if ($categoryProperty['itemCondition'] == 'enable'){
			$model->itemCondition = '1';
		}elseif ($categoryProperty['itemCondition'] == 'disable'){
			$model->itemCondition = '0';
		}
		if ($categoryProperty['contactSeller'] == 'enable'){
			$model->contactSeller = '1';
		}elseif ($categoryProperty['contactSeller'] == 'disable'){
			$model->contactSeller = '0';
		}
		if ($categoryProperty['exchangetoBuy'] == 'enable'){
			$model->exchangetoBuy = '1';
		}elseif ($categoryProperty['exchangetoBuy'] == 'disable'){
			$model->exchangetoBuy = '0';
		}
		if ($categoryProperty['buyNow'] == 'enable'){
			$model->buyNow = '1';
		}elseif ($categoryProperty['buyNow'] == 'disable'){
			$model->buyNow = '0';
		}		
		if ($categoryProperty['myOffer'] == 'enable'){
			$model->myOffer = '1';
		}elseif ($categoryProperty['myOffer'] == 'disable'){
			$model->myOffer = '0';
		}
		if(isset($_POST['Categories']))
		{
		$condition = new CDbCriteria;
		$condition->addCondition('categoryId != "'.$id.'"');	
		$condition->addCondition('name = "'.$_POST['Categories']['name'].'"');
		$condition->addCondition('parentCategory = "'.$_POST['Categories']['parentCategory'].'"');
		$existcategory = Categories::model()->findAll($condition);
		if(count($existcategory)==0)
		{
			$model->attributes=$_POST['Categories'];
			if(!isset($_POST['Categories']['parentCategory']) || $_POST['Categories']['parentCategory'] == ""){
				$model->parentCategory = 0;
			}
			$catImage = CUploadedFile::getInstances($model,'image');
              
			if(!empty($catImage)) { 
				$imageName = explode(".",$catImage[0]->name);
				$model->image = rand(000,9999).'-'.Myclass::productSlug($imageName[0]).'.'.$catImage[0]->extensionName;
			} else {
				$model->image = $oldImage;
			}
			
			$categoryProperty = array();
			if ($_POST['Categories']['itemCondition'] == 1){
				$categoryProperty['itemCondition'] = 'enable';
			}elseif ($_POST['Categories']['itemCondition'] == 0){
				$categoryProperty['itemCondition'] = 'disable';
			}
			if ($_POST['Categories']['exchangetoBuy'] == 1){
				$categoryProperty['exchangetoBuy'] = 'enable';
			}elseif ($_POST['Categories']['exchangetoBuy'] == 0){
				$categoryProperty['exchangetoBuy'] = 'disable';
			}
			if ($_POST['Categories']['buyNow'] == 1){
				$categoryProperty['buyNow'] = 'enable';
			}elseif ($_POST['Categories']['buyNow'] == 0){
				$categoryProperty['buyNow'] = 'disable';
			}			
			if ($_POST['Categories']['myOffer'] == '1'){
				$categoryProperty['myOffer'] = 'enable';
			}elseif ($_POST['Categories']['myOffer'] == 0){
				$categoryProperty['myOffer'] = 'disable';
			}
			if ($_POST['Categories']['contactSeller'] == '1'){
				$categoryProperty['contactSeller'] = 'enable';
			}elseif ($_POST['Categories']['contactSeller'] == 0){
				$categoryProperty['contactSeller'] = 'disable';
			}
				
			$model->categoryProperty = json_encode($categoryProperty);
			
			if($model->validate()) {  
				if(!empty($catImage)) {
					$catImage[0]->saveAs('media/category/'.$model->image);
				}
				$model->save(false);
				Yii::app()->user->setFlash('success',Yii::t('admin','Category updated successfully.'));
				$this->redirect(array('admin'));
			}
		}
else
{
				Yii::app()->user->setFlash('success',Yii::t('admin','Category already added to this parent category'));
				$this->redirect(array('admin'));
}
}

		$this->render('create',array(
			'model'=>$model, 'parentCategory'=>$parentCategory
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
		$criteria->condition = ("category = $id OR subCategory = $id");
		$products = Products::model()->findAll($criteria);
		if(empty($products)) {
			$siteSettings = Sitesettings::model()->find();
			$priorityCategories = $siteSettings->category_priority;
			if(!empty($priorityCategories)){
				$priorityCategories = json_decode($priorityCategories, true);
				if(in_array($id, $priorityCategories)){
					$restricedCategories = array();
					foreach($priorityCategories as $priorityKey => $priorityCategory){
						if($priorityCategory != $id)
							$restricedCategories[] = $priorityCategory;
					}
					$filteredCategories = "";
					if(!empty($restricedCategories))
						$filteredCategories = json_encode($restricedCategories);
					$siteSettings->category_priority = $filteredCategories;
					$siteSettings->save(false);
				}
			}
			$subcategories = Categories::model()->findAllByAttributes(array("parentCategory" => $id));
			foreach($subcategories as $subcategory):
			$subcategory->delete();
			endforeach;
			$model->delete();
			$val = 0;
		} else {
			$val = 1;
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else {
			if($val == 1) {
				echo "<ul class='flashes'><li><div class='flash-warning'>".Yii::t('admin','One or more products has been added to this category.You cannot delete this category.')."</div></li></ul>";
			} else {
				echo "<ul class='flashes'><li><div class='flash-success'>".Yii::t('admin','Category Deleted Successfully')."</div></li></ul>";
			}
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Categories');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Categories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Categories']))
		$model->attributes=$_GET['Categories'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Categories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Categories::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Categories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	function actionShowtopcategory() {
		$categories = Categories::model()->findAllByAttributes(array('parentCategory'=>0));
		$model = Sitesettings::model()->findByPk(1);
		if(isset($_POST['Sitesettings'])) {
			$unique = $_POST['Sitesettings']['priority'];
			foreach($_POST['Sitesettings']['priority'] as $value):
			if (in_array($value,$unique)) {
				$val = Categories::model()->findByPk($value);
				//Yii::app()->user->setFlash('warning','You have selected '. $val->currency_name .' twice.');
			}
			endforeach;
			$settings = json_encode($_POST['Sitesettings']['priority']);
			$model->category_priority = $settings;
			$model->save(false);
			Yii::app()->user->setFlash('success',Yii::t('admin','Category priority settings updated successfully.'));
		}
		
		if(!empty($model->category_priority)) {
			$topTen = json_decode($model->category_priority);
			if($topTen[0] == 'empty') {
				$criteria = new CdbCriteria();
				$criteria->addCondition('parentCategory = 0');
				$criteria->limit = 10;
				$curs = Categories::model()->findAll($criteria);
				$count = count($curs);
				$topTen = array();
				//foreach($curs as $cur):
				//$topTen[] = $cur->categoryId;
				//endforeach;
				for($i=0;$i < 10 ; $i++) {
					$topTen[] = 'empty';
				}
			}
		} else {
			$criteria = new CdbCriteria();
			$criteria->addCondition('parentCategory = 0');
			$criteria->limit = 10;
			$curs = Categories::model()->findAll($criteria);
			$count = count($curs);
			foreach($curs as $cur):
			$topTen[] = $cur->categoryId;
			endforeach;
			for($i=$count;$i < 10 ; $i++) {
				$topTen[] = 'empty';
			}
		}
		
		$this->render('showtopcategory',compact('categories','topTen'));
		}

	//}
}
