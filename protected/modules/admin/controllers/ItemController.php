<?php

class ItemController extends Controller
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
		if($user->isGuest) {
			$this->redirect(Yii::app()->adminUser->loginUrl);
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
								'base_dir'    => Yii::getPathOfAlias('webroot') . '/media/item/',
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
		$this->redirect(array('admin'));
		Yii::import( "xupload.models.XUploadForm" );
		$photos = new XUploadForm;

		$model=new Products;

		$parentCategory = array();
		$parentCategory = Categories::model()->findAllByAttributes(array('parentCategory'=>0));
		if (!empty($parentCategory)){
			$parentCategory = CHtml::listData($parentCategory, 'categoryId', 'name');
		}
		$subCategory = array();


		$shippingTime['1 business day'] = '1 business day';
		$shippingTime['1-2 business day'] = '1-2 business day';
		$shippingTime['2-3 business day'] = '2-3 business day';
		$shippingTime['3-5 business day'] = '3-5 business day';
		$shippingTime['1-2 weeks'] = '1-2 weeks';
		$shippingTime['2-4 weeks'] = '2-4 weeks';
		$shippingTime['5-8 weeks'] = '5-8 weeks';

		$countryModel = array();
		$countryList = Country::model()->findAllByAttributes(array(),array(
				'condition' => 'countryId != :id',
				'params' => array('id'=>'0')));
		if (!empty($countryList)){
			//$countryModel = CHtml::listData($countryList, 'countryId', 'country');
			foreach ($countryList as $country){
				$countryKey = $country->countryId."-".$country->country;
				$countryModel[$countryKey] = $country->country;
			}
		}
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Products']))
		{
			//echo "<pre>";print_r($_POST);die;
			$productData = $_POST['Products'];
			$model->attributes=$_POST['Products'];
			$model->userId = Yii::app()->user->id;
			$model->createdDate = time();
			$model->chatAndBuy = $_POST['Products']['chatAndBuy'];
			$model->exchangeToBuy = $_POST['Products']['exchangeToBuy'];
			$model->instantBuy = $_POST['Products']['instantBuy'];
			$model->currency  = $_POST['Products']['currency'];
			$model->shippingTime = $_POST['Products']['shippingTime'];
			$model->subCategory = $_POST['Products']['subCategory'];


			if (isset($productData['productOptions'])){
				$model->sizeOptions = json_encode($productData['productOptions']);
				$quantity = 0;
				$optionPrice = 0;
				foreach($productData['productOptions'] as $options){
					$quantity += $options['quantity'];
					$optionPrice = $optionPrice == 0 && !empty($options['price']) ? $options['price'] : $optionPrice;
				}
				$model->quantity = $quantity;
				$model->price = $optionPrice != 0 ? $optionPrice : $model->price;
			}
			/* // THIS is how you capture those uploaded images: remember that in your CMultiFile widget,
			 //you set 'name' => 'images'
			 $images = CUploadedFile::getInstancesByName('images');

			 // proceed if the images have been set
			 if (isset($images) && count($images) > 0) {

			 // go through each uploaded image
			 foreach ($images as $image => $pic) {
			 echo $pic->name.'<br />';
			 if ($pic->saveAs(Yii::getPathOfAlias('webroot').'/media/item/'.$pic->name)) {
			 // add it to the main model now
			 $img_add = new Picture();
			 $img_add->filename = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
			 $img_add->topic_id = $model->id; // this links your picture model to the main model (like your user, or profile model)

			 $img_add->save(); // DONE
			 }
			 //else
				// handle the errors here, if you want
				}
				} */

			if($model->save()){
				foreach ($productData['shipping'] as $key => $shipping){
					if($shipping != ""){
						$shippingModel = new Shipping();
						$shippingModel->productId = $model->productId;
						$shippingModel->countryId = $key;
						$shippingModel->shippingCost = $shipping;
						$shippingModel->createdDate = time();
						$shippingModel->save();
					}
				}
				Yii::app()->user->setFlash('success',Yii::t('admin','Item created successfully.'));
				$this->redirect(array('admin'));
			}else{
				Yii::app()->user->setFlash('error','Not Saved');
			}
		}
		$currencies = Currencies::model()->findAll();
		$topFiveCur = Sitesettings::model()->findByPk(1)->currency_priority;
		$topFive = json_decode($topFiveCur);
		foreach($topFive as $top):
		$topCurs[] = Currencies::model()->findAllByAttributes(array("id" => $top));
		endforeach;

		Yii::app( )->user->setState( 'images', null );
		$this->render('create',array(
				'model'=>$model, 'parentCategory'=>$parentCategory,'subCategory'=>$subCategory,
				'photos' => $photos, 'shippingTime' => $shippingTime, 'countryModel' => $countryModel, 
				'topCurs' => $topCurs,'currencies' => $currencies));
	}

	/**
	 * Method to get the subcategory
	 * for the parent category sent from
	 * the create item form
	 *
	 */
	public function actionGetsubcategory(){
		if(isset($_POST)) {
			$categoryId = $_POST['category'];
			$subCategoryModel = Categories::model()->findAllByAttributes(array('parentCategory'=>$categoryId));
			$subCategory = CHtml::listData($subCategoryModel, 'categoryId', 'name');

			echo "<option value=''>".Yii::t('admin','Select subcategory')."</option>";
			foreach ($subCategory as $key => $category){
				echo "<option value='".$key."'>".$category."</option>";
			}
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		Yii::import( "xupload.models.XUploadForm" );
		$photos = new XUploadForm;

		$model=$this->loadModel($id);

		$parentCategory = array();
		$parentCategory = Categories::model()->findAllByAttributes(array('parentCategory'=>0));
		if (!empty($parentCategory)){
			$parentCategory = CHtml::listData($parentCategory, 'categoryId', 'name');
		}
		$subCategory = Categories::model()->findAllByAttributes(array('parentCategory'=>$model->category));
		$subCategory = CHtml::listData($subCategory, 'categoryId', 'name');

		$shippingTime['1 business day'] = '1 business day';
		$shippingTime['1-2 business day'] = '1-2 business day';
		$shippingTime['2-3 business day'] = '2-3 business day';
		$shippingTime['3-5 business day'] = '3-5 business day';
		$shippingTime['1-2 weeks'] = '1-2 weeks';
		$shippingTime['2-4 weeks'] = '2-4 weeks';
		$shippingTime['5-8 weeks'] = '5-8 weeks';

		$countryModel = array();
		$countryList = Country::model()->findAllByAttributes(array(),array(
				'condition' => 'countryId != :id',
				'params' => array('id'=>'0')));
		if (!empty($countryList)){
			//$countryModel = CHtml::listData($countryList, 'countryId', 'country');
			foreach ($countryList as $country){
				$countryKey = $country->countryId."-".$country->country;
				$countryModel[$countryKey] = $country->country;
				$shippingCountry[$country->countryId] = $country->country;
			}
		}

		$shippingModel = $model->shippings;
		$jsShippingDetails = '';
		$itemShipping = array();
		foreach ($shippingModel as $shippingDetail){
			$itemShipping[$shippingDetail->countryId] = $shippingDetail->shippingCost;
			if(empty($jsShippingDetails)){
				$jsShippingDetails .= '"'.$shippingDetail->countryId.'"';
			}else{
				$jsShippingDetails .= ',"'.$shippingDetail->countryId.'"';
			}
		}

		$options = array();
		if (!empty($model->sizeOptions)){
			$options = json_decode($model->sizeOptions, true);
		}
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Products']))
		{
			//echo "<pre>";print_r($_POST);die;
			$productData = $_POST['Products'];
			$model->attributes=$_POST['Products'];
			$model->name = htmlentities($model->name);
			$model->description = htmlentities($model->description);

			$model->chatAndBuy = $_POST['Products']['chatAndBuy'];
			$model->exchangeToBuy = 0;
			if(isset($_POST['Products']['exchangeToBuy']))
				$model->exchangeToBuy = $_POST['Products']['exchangeToBuy'];
			$model->instantBuy = $_POST['Products']['instantBuy'];
					
			$model->myoffer = 0;
			if(isset($_POST['Products']['myoffer']))
				$model->myoffer = $_POST['Products']['myoffer'];
			
			$model->shippingTime = $_POST['Products']['shippingTime'];
			$model->currency  = $_POST['Products']['currency'];
			$model->subCategory = $_POST['Products']['subCategory'];


			// echo "<pre>";print_r($productData['productOptions']);die;
			if (isset($productData['productOptions'])){
				$model->sizeOptions = json_encode($productData['productOptions']);
				$quantity = 0;
				$optionPrice = 0;
				foreach($productData['productOptions'] as $options){
					$quantity += $options['quantity'];
					$optionPrice = $optionPrice == 0 && !empty($options['price']) ? $options['price'] : $optionPrice;
				}
				$model->quantity = $quantity;
				$model->price = $optionPrice != 0 ? $optionPrice : $model->price;
			} else {
				$model->sizeOptions = '';
			}
			Shipping::model()->deleteAllByAttributes(array('productId'=>$model->productId));
			if(isset($productData['shipping'])) {
				foreach ($productData['shipping'] as $key => $shipping){
					if($shipping != ""){
						$shippingModel = new Shipping();
						$shippingModel->productId = $model->productId;
						$shippingModel->countryId = $key;
						$shippingModel->shippingCost = $shipping;
						$shippingModel->createdDate = time();
						$shippingModel->save();
					}
				}
			}
			if($model->save(false)) {
				Yii::app()->user->setFlash('success',Yii::t('admin','Item updated successfully.'));
				$this->redirect(array('admin'));
			}
		}
		$currencies = Currencies::model()->findAll();
		$topFiveCur = Sitesettings::model()->findByPk(1)->currency_priority;
		$topFive = json_decode($topFiveCur);
		foreach($topFive as $top):
		$topCurs[] = Currencies::model()->findAllByAttributes(array("id" => $top));
		endforeach;
		$model->name = html_entity_decode($model->name);
		$model->description = html_entity_decode($model->description);
		$this->render('update',array(
					'model'=>$model, 'parentCategory'=>$parentCategory,'subCategory'=>$subCategory,
				'photos' => $photos,'options'=>$options, 'shippingTime' => $shippingTime, 
				'countryModel' => $countryModel, 'itemShipping' => $itemShipping, 
				'shippingCountry'=>$shippingCountry, 'jsShippingDetails' => $jsShippingDetails, 
				'topCurs' => $topCurs,'currencies' => $currencies
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

		Adspromotiondetails::model()->deleteAllByAttributes(array('productId'=>$id));
		Promotiontransaction::model()->deleteAllByAttributes(array('productId'=>$id));		
		
		Myclass::removeItemLogs($id);
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			Yii::app()->user->setFlash('success',Yii::t('admin','Item deleted Successfully.'));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else {
			echo "<ul class='flashes'><li><div class='flash-success'>".Yii::t('admin','Item deleted Successfully.')."</div></li></ul>";
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Products');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		//$this->layout='//layouts/adminwithmenu';

		$model=new Products('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Products']))
		$model->attributes=$_GET['Products'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionUpload( ) {
		Yii::import( "xupload.models.XUploadForm" );
		//Here we define the paths where the files will be stored temporarily
		$path = realpath( Yii::app( )->getBasePath( )."/../media/item/tmp/" )."/";
		$publicPath = Yii::app( )->getBaseUrl( )."/media/item/tmp/";

		//This is for IE which doens't handle 'Content-type: application/json' correctly
		header( 'Vary: Accept' );
		if( isset( $_SERVER['HTTP_ACCEPT'] )
		&& (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
			header( 'Content-type: application/json' );
		} else {
			header( 'Content-type: text/plain' );
		}

		//Here we check if we are deleting and uploaded file
		if( isset( $_GET["_method"] ) ) {
			if( $_GET["_method"] == "delete" ) {
				if (isset($_GET['id']) && $_GET['id'] != ''){
					$photosModel = Photos::model()->findByAttributes(array('photoId' => $_GET['id']));
					/* Photos::model()->deleteAllByAttributes(array('photoId' => $_GET['id']));
					 $path = realpath( Yii::app( )->getBasePath( )."/../media/item/".$photosModel->productId."/" )."/";
					$file = $path.$photosModel->name;
					if( is_file( $file ) ) {
					unlink( $file );
					} */
					$fileDetails['productId'] = $photosModel->productId;
					$fileDetails['photoId'] = $_GET['id'];
					$path = realpath( Yii::app( )->getBasePath( )."/../media/item/".$photosModel->productId."/" )."/";
					$file = $path.$photosModel->name;
					$fileDetails['photoPath'] = $file;
					$_SESSION['deletefile'][$photosModel->productId][] = $fileDetails;
				}elseif( $_GET["file"][0] !== '.' ) {
					$file = $path.$_GET["file"];
					if( is_file( $file ) ) {
						unlink( $file );
					}
				}
				echo json_encode( true );
			}elseif ($_GET["_method"] == "list") {
				$intProductId = $_GET['id'];
				$objProductImages = Photos::model()->findAllByAttributes(array('productId' => $intProductId));
				if ($objProductImages !== null)
				{
					$arrProductImages = array();
					foreach ($objProductImages as $objProductImage)
					{
						$arrProductImages[] = array(
								"name" => $objProductImage->name,
								"id" => $objProductImage->photoId,
						//"type" => $objProductImage->mimeType,
						//"size" => $objProductImage->size,
								"url" => Yii::app( )->getBaseUrl( )."/media/item/".$intProductId."/".$objProductImage->name,//$objProductImage->path,
								"thumbnail_url" => Yii::app( )->getBaseUrl( )."/item/products/resized/100x100/".$intProductId."/".$objProductImage->name,//$objProductImage->thumb,
								"delete_url" => $this->createUrl("upload", array("_method" => "delete", "id" => $objProductImage->photoId)),
								"delete_type" => "GET",
						);//domain/test/resized/100x100/images/big.png
					}
					echo json_encode($arrProductImages);
				}
			}
		} else {
			$model = new XUploadForm;
			$model->file = CUploadedFile::getInstance( $model, 'file' );
			//We check that the file was successfully uploaded
			if( $model->file !== null ) {
				//Grab some data
				$model->mime_type = $model->file->getType( );
				$model->size = $model->file->getSize( );
				$model->name = $model->file->getName( );
				//(optional) Generate a random name for our file
				$filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
				$filename .= ".".$model->file->getExtensionName( );
				if( $model->validate( ) ) {
					//Move our file to our temporary dir
					$model->file->saveAs( $path.$filename );
					chmod( $path.$filename, 0777 );
					//here you can also generate the image versions you need
					//using something like PHPThumb


					//Now we need to save this path to the user's session
					if( Yii::app( )->user->hasState( 'images' ) ) {
						$userImages = Yii::app( )->user->getState( 'images' );
					} else {
						$userImages = array();
					}
					$userImages[] = array(
							"path" => $path.$filename,
					//the same file or a thumb version that you generated
							"thumb" => $path.$filename,
							"filename" => $filename,
							'size' => $model->size,
							'mime' => $model->mime_type,
							'name' => $model->name,
					);
					Yii::app( )->user->setState( 'images', $userImages );

					//Now we need to tell our widget that the upload was succesfull
					//We do so, using the json structure defined in
					// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
					echo json_encode( array( array(
							"name" => $model->name,
							"type" => $model->mime_type,
							"size" => $model->size,
							"url" => $publicPath.$filename,
							"thumbnail_url" => $publicPath."/$filename",
							"delete_url" => $this->createUrl( "upload", array(
									"_method" => "delete",
									"file" => $filename
					) ),
							"delete_type" => "POST"
							) ) );
				} else {
					//If the upload failed for some reason we log some data and let the widget know
					echo json_encode( array(
					array( "error" => $model->getErrors( 'file' ),
					) ) );
					Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
					CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction"
					);
				}
			} else {
				throw new CHttpException( 500, Yii::t('admin',"Could not upload file"));
			}
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Products the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Products::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Products $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionSoldItem() {
		if(isset($_POST)) {
			$id = $_POST['id'];
			$value = $_POST['value'];
			$dec = Myclass::safe_b64decode($id);
			$spl = explode('-',$dec);
			$id = $spl[0];

			if($value == 1) {
				$product = $this->loadModel($id);
				$product->soldItem = 1;
				$product->save(false);
			} else {
				$product = $this->loadModel($id);
				$product->soldItem = 0;
				$product->save(false);
			}
		}
	}

}
