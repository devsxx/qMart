<?php

class SiteController extends Controller
{

	public function beforeAction($action)
	{
		if(isset(Yii::app()->request->cookies['userid']->value))
		{
			$cookie_userid = Yii::app()->request->cookies['userid']->value;
			$user = Myclass::getUserbyemail($cookie_userid);
			$userdata = Myclass::getUserDetails($user->userId);
								$model=new LoginForm;
					$model->username = $userdata->email;
					$model->password = base64_decode($userdata->password);
					$model->login();
			//Yii::app()->user->login ( $userdata );
		}
		return parent::beforeAction($action);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
				'resized' => array(
						'class'   => 'ext.resizer.ResizerAction',
						'options' => array(
		// Tmp dir to store cached resized images
								'cache_dir'   => Yii::getPathOfAlias('webroot') . '/assets/resized/',

		// Web root dir to search images from
								'base_dir'    => Yii::getPathOfAlias('webroot') . '/media/logo/',
		)
		),
		// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
		),
		// page action renders "static" pages stored under 'protected/views/site/pages'
		// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
		),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */



	public function actionIndex($search = null,$category= null, $subcategory=null)
	{
		$criteria = new CDbCriteria;
		$place = "";
		if(!isset(Yii::app()->session['latitude'])){
			if(!Yii::app()->user->isGuest) {
				$user = Yii::app()->user->id;
				$userModel = Users::model()->findByPk($user);
				$geoLocationDetails = "";
				
				if($userModel->geolocationDetails != ""){
					$geoLocationDetails = json_decode($userModel->geolocationDetails, true);
				}
			}
			
			if(isset($geoLocationDetails) && !empty($geoLocationDetails)){
				Yii::app()->session['latitude'] = $geoLocationDetails['latitude'];
				Yii::app()->session['longitude'] = $geoLocationDetails['longitude'];
				Yii::app()->session['place'] = $geoLocationDetails['place'];
				$lat = Yii::app()->session['latitude'];
				$lon = Yii::app()->session['longitude'];
				$place = $geoLocationDetails['place'];
			}
		}elseif(isset(Yii::app()->session['latitude'])){
			$lat = Yii::app()->session['latitude'];
			$lon = Yii::app()->session['longitude'];
			$place = Yii::app()->session['place'];
		}
		
		$remove = isset($_POST['remove']) ? $_POST['remove'] : "";
		
		if(isset($remove) && !empty($remove)){
			$this->removeLocation(1);
		}
		$location = 0;
		$locationReset = 0;
		$catrest = 0; //default;
		$loccheck = 0;
		
		$siteSettings = Sitesettings::model()->findByPk(1);
		$searchType = $siteSettings->searchType;
		$searchDistance = $siteSettings->searchDistance;
		$searchList = $siteSettings->searchList;
		$searchList = explode(",", $searchList);
		
		$kilometer = isset(Yii::app()->session['distance']) ? Yii::app()->session['distance'] : $searchList[0];
		Yii::app()->session['distance'] = $kilometer;
		//echo "{$siteSettings->searchList}<pre>";print_r($searchList);echo "kilometer: ".$kilometer; die;
		$displayInfo = $kilometer." km ";
		if($searchType == 'miles'){
			$displayInfo = $kilometer." mi ";
			$kilometer = $kilometer * 1.60934; // 1mile = 1.60934 km
		}
		
		do{
			$loccheck++;
			if($location == 1)
				$locationReset = 1;
			
			$criteria = new CDbCriteria;
			//echo $lat.$lon; die;
			if(!empty($search) || !empty($category) || !empty($subcategory) || isset( Yii::app()->session['latitude'])){
				if( !empty($lat) && !empty($lon) &&  $location == 0){
					$location = 1;
					
					$distance = $kilometer * 0.1 / 11;
						
					$LatN = $lat + $distance;
					$LatS = $lat - $distance;
					$LonE = $lon + $distance;
					$LonW = $lon - $distance;
					//echo "North:".$LatN." Southlat:".$LatS." West:".$LonW." Eastlon:".$LonE; 
					$criteria->addBetweenCondition('longitude', $LonW, $LonE);
					$criteria->addBetweenCondition('latitude', $LatS, $LatN);
					//$place  = $this->getPlacename($lat,$lon);
				
				}else{
					//$this->removeLocation();
				}
			}else{
				$location = 1;
				//$this->removeLocation();
			}
			
			if(!empty($search)) {
				//$criteria->addCondition("name LIKE '%$search%'");
			    $criteria->compare('name',$search,true);

			    $searchCriteria = clone $criteria;
			    $searchproducts = Products::model()->find($searchCriteria);
			    if(empty($searchproducts)){
			    	$catrest = 1;
			    	$location = 1;
			    }
			}
			
			if(!empty($category)) {
				$cat = Categories::model()->findByAttributes(array("slug"=>"$category","parentCategory"=>"0"));
				if(!empty($cat)){
					$categoryname = $cat->name;
					$criteria->addCondition("category = $cat->categoryId");
					$catproductCriteria = clone $criteria;
			    	$catproducts = Products::model()->find($catproductCriteria);
			    	if(empty($catproducts)){
			    		$catrest = 1; $location = 1;
			    	}
				}else{
					$catrest = 1;
					$location = 1;
				}
				
			}
			if(!empty($subcategory) && $catrest == 0) {
				$subcatCriteria = new CDbCriteria();
				$subcatCriteria->addCondition("slug = '$subcategory'");
				$subcatCriteria->addCondition("parentCategory != 0");
				$subcat = Categories::model()->find($subcatCriteria);
				//$subcat = Categories::model()->findByAttributes(array("slug"=>"'$subcategory'","parentCategory !="=>"0"));
				if(!empty($subcat)) {
					$subcatname = $subcat->name;
					$criteria->addCondition("subcategory = $subcat->categoryId");
					$subcatproductCriteria = clone $criteria;
					$subcatproducts = Products::model()->find($subcatproductCriteria);
					if(empty($subcatproducts)){
						$catrest = 1; $location = 1;
					}
				}else{
					$catrest = 1;
					$location = 1;
				}
			}
			
			if(empty($search) && empty($category)){
			//$adsCriteria = $criteria;
				$adsCriteria = clone $criteria;//$adsCriteria = new CDbCriteria;
				$adsCriteria->addCondition("promotionType = '1'");
				$adsCriteria->order = "rand()";
				$adsCriteria->limit = 8;
				$adsProducts = Products::model()->findAll($adsCriteria);

				$criteria->order = 'productId DESC';
				$criteria->addCondition("promotionType != '1'");
			}else{
				$adsProducts = array();
				$criteria->order = 'promotionType ASC';
			}
			$limit = 32 - count($adsProducts);
			$criteria->limit = $limit;
			$products = Products::model()->findAll($criteria);
			//echo "<pre>";print_r($products);
			
		}while(empty($products) && empty($adsProducts) && $loccheck <= 1);

		if(empty($products) && empty($adsProducts)){
				$normalCriteria = new CDbCriteria();
				$normalCriteria->limit = 32;
				$normalCriteria->order = 'productId DESC';
				$products = Products::model()->findAll($normalCriteria);
			}
		//echo count($products)." ".count($adsProducts);die;
		$loadMore = 0;
		if(!empty($category) && !empty($cat)) {
			$subcats = Categories::model()->findAll("parentCategory=$cat->categoryId");
		}
		
		$this->render('index',compact('adsProducts','products', 'catrest', 'locationReset','loadMore','pages','search','category', 'subcategory','subcat','subcats','limit','lat','lon','categoryname','subcatname','place','displayInfo'));
	}

	public function actionLoadresults($search = null,$category= null, $subcategory=null,$limit=null,$offset = null, 
			$lat = null, $lon = null, $adsOffset = null, $urgent = 0, $ads = 0 ,$catrest = 0)
	{
		$id = 1;
		$siteSettings = Sitesettings::model()->findByPk($id);
		$searchType = $siteSettings->searchType;
		$searchDistance = $siteSettings->searchDistance;
		$searchList = $siteSettings->searchList;
		$searchList = explode(",", $searchList);

		$kilometer = isset($_POST['distance']) ? $_POST['distance'] : Yii::app()->session['distance'];
		Yii::app()->session['distance'] = $kilometer;
		$displayInfo = $kilometer." km ";
		if($searchType == 'miles'){
			$displayInfo = $kilometer." mi ";
			$kilometer = $kilometer * 1.60934; // 1mile = 1.60934 km
		}
		$location = 0;
		$locationReset = 0;
		
		if (isset($_POST['search']) && $_POST['search'] != "")
			$search = $_POST['search'];
		if (isset($_POST['category']) && $_POST['category'] != "")
			$category = $_POST['category'];
		if (isset($_POST['subcategory']) && $_POST['subcategory'] != "")
			$subcategory = $_POST['subcategory'];
		if (isset($_POST['urgent']) && $_POST['urgent'] != "")
			$urgent = $_POST['urgent'];
		if (isset($_POST['ads']) && $_POST['ads'] != "")
			$ads = $_POST['ads'];
		if (isset($_POST['catrest']) && $_POST['catrest'] != "")
			$catrest = $_POST['catrest'];
		
				
		if(isset($_POST['lat']) && $_POST['lat'] != "" && isset($_POST['lon']) && $_POST['lon'] != ""){
			if(!Yii::app()->user->isGuest || !empty(Yii::app()->user->id)) {
				$user = Yii::app()->user->id;
				$userModel = Users::model()->findByPk($user);
				$geoLocationDetails = "";
		
				if($userModel->geolocationDetails != ""){
					$geoLocationDetails = json_decode($userModel->geolocationDetails, true);
				}
			}
				
			if(isset($geoLocationDetails)){
				if(empty($geoLocationDetails) || $geoLocationDetails['latitude'] != $_POST['lat']){
					$placeName = $this->getPlacename($_POST['lat'],$_POST['lon']);
					$geoLocationDetails['latitude'] = $_POST['lat'];
					$geoLocationDetails['longitude'] = $_POST['lon'];
					$geoLocationDetails['place'] = $placeName;
					
					$geoLocationDetail = json_encode($geoLocationDetails);
					$userModel->geolocationDetails = $geoLocationDetail;
					$userModel->save(false);
				}
			}
			Yii::app()->session['place'] = $this->getPlacename($_POST['lat'],$_POST['lon']);
		}
		
		$remove = isset($_POST['remove']) ? $_POST['remove'] : "";
		
		if(isset($remove) && !empty($remove)){
			$this->removeLocation(1);
		}
		
		do{	
			//$remove = isset($_POST['remove']) ? $_POST['remove'] : "";
			if($location == 1){
				$remove = 1;
				$locationReset = 1;
			}
			$location = 1;
			$criteria = new CDbCriteria;
			
			if(isset($_POST['lat']) && isset($remove) && empty($remove)){
				$lat = $_POST['lat'];
			}elseif(isset(Yii::app()->session['latitude']) && isset($remove) && empty($remove)){
				$lat = Yii::app()->session['latitude'];
			}else{
				$lat = "";
			}
				
			if(isset($_POST['lon']) && isset($remove) && empty($remove)){
				$lon = $_POST['lon'];
			}elseif(isset(Yii::app()->session['longitude']) && isset($remove) && empty($remove)){
				$lon = Yii::app()->session['longitude'];
			}else{
				$lon = "";
			}
			
			if(isset($remove) && !empty($remove)){
				 //$this->removeLocation();
			}
			
			if( !empty($lat) && !empty($lon) ){
				
					$distance = $kilometer * 0.1 / 11; // Range in degrees (0.1 degrees is close to 11km)
				
				$LatN = $lat + $distance;
				$LatS = $lat - $distance;
				$LonE = $lon + $distance;
				$LonW = $lon - $distance;
				$criteria->addBetweenCondition('longitude', $LonW, $LonE);
				$criteria->addBetweenCondition('latitude', $LatS, $LatN);
				if (!isset($_GET['loadData'])){
					echo $place  = $displayInfo." from ".Yii::app()->session['place'];
				}
					
			
			}
			/* if(isset($remove) && !empty($remove)){
				 $this->removeLocation();
			} */
			if(!empty($search)) {
				$criteria->addCondition("name LIKE '%$search%'");
			}
			if(!empty($category)) {
				$cat = Categories::model()->find("slug='$category'");
				if(!empty($cat))
					$criteria->addCondition("category = $cat->categoryId");

			}
			if(!empty($subcategory)) {
				$subcat = Categories::model()->find("slug='$subcategory'");
				if(!empty($subcat))
					$criteria->addCondition("subcategory = $subcat->categoryId");
			}
			//echo $category; die;
			if(empty($search) && empty($category)){
				$adsCriteria = clone $criteria;
				$adsCriteria->addCondition("promotionType = '1'");
				$adsCriteria->limit = 8;
				$adsCriteria->order = "rand()";
				if(isset($adsOffset)) { 
					$adsCriteria->offset = $adsOffset;
				}
				$adsCriteria->order = '`productId` DESC';
				$adsProducts = Products::model()->findAll($adsCriteria);
				
				$criteria->order = '`productId` DESC';
				$criteria->addCondition("promotionType != '1'");
			}else{
				$adsProducts = array();

				if($urgent == '1'){
					$checkurgent = clone $criteria;
					$checkurgent->addCondition("promotionType = '2'");
					$urgentproducts = Products::model()->count($checkurgent);
						if($urgentproducts != '0'){
							$criteria->addCondition("promotionType = '2'");
						}
				}

				if($ads == '1')
					$criteria->order = '`likes` DESC';
				else
					$criteria->order = 'promotionType ASC';
				
				
			}
			
		
			if(isset($limit)) {
				$limit -= count($adsProducts);
			}else{
				$limit = 32 - count($adsProducts);
			}
			$criteria->limit = $limit;
			if(isset($offset)) { 
				$criteria->offset = $offset;
			}
			
			$products = Products::model()->findAll($criteria);

			if(empty($products) && (empty($adsProducts)) || ($catrest == '1')){
				$locationReset = 1;
				break; //break for null results and no data on search and category
			}
			
			
		}while(empty($products) && empty($adsProducts) && !isset($_GET['loadData']));
		if(empty($products) && empty($adsProducts) && !isset($_GET['loadData'])){ //
			$normalCriteria = new CDbCriteria();
			if(isset($catrest)){
				if($urgent == '1')
					$normalCriteria->addCondition("promotionType = '2'");

				if($ads == '1')
					$normalCriteria->order = '`likes` DESC';
				else
					$normalCriteria->order = 'promotionType ASC';
			}else{
				$normalCriteria->order = 'productId DESC';
			}
			$normalCriteria->limit = 32;
			if(isset($offset)) {
				$normalCriteria->offset = $offset;
			}
			$products = Products::model()->findAll($normalCriteria);
		}

		if (!isset($_GET['loadData'])){
			echo '~'.$locationReset.'~';
		}
		if(!empty($category) && !empty($cat)) {
			$subcats = Categories::model()->findAll("parentCategory=$cat->categoryId");
		}
		//echo "<pre>";print_r($products);die;
		$this->renderPartial('loadresults',compact('adsProducts','catrest','products','locationReset','pages','search','category',
				'subcategory','subcats','limit','lat','lon','searchList','searchType','urgent','ads'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
			echo $error['message'];
			else
			$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	
	/**
	 * Store the lat lon in the session
	 */
	public function getPlacename($lat,$lon){
		
		$url  = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".
				$lat.",".$lon."&sensor=false";
				$json = @file_get_contents($url);
				$data = json_decode($json);
				$status = $data->status;
				$address = '';
				if($status == "OK"){
					$address = $data->results[0]->formatted_address;
					$result = explode(",",$address);
					$count = count($result);
					$country=$result[$count-1];
					$state=$result[$count-2];
					$city=$result[$count-3];
				}
				
		Yii::app()->session['cityName'] = $city.','.$country;
		Yii::app()->session['latitude'] = $lat;
		Yii::app()->session['longitude'] = $lon;
		Yii::app()->session->add('cityName',$city.','.$country);
		return  $city.','.$country;
				
	}
	
	public function removeLocation($removeFlag = 0){
		
		unset(Yii::app()->session['cityName']);
		unset(Yii::app()->session['latitude']);
		unset(Yii::app()->session['longitude']);
		unset(Yii::app()->session['place']);
		Yii::app()->session->remove('cityName');
		Yii::app()->session->remove('latitude');
		Yii::app()->session->remove('longitude');
		Yii::app()->session->remove('place');
		
		if($removeFlag == 1){
			if(!Yii::app()->user->isGuest || !empty(Yii::app()->user->id)) {
				$user = Yii::app()->user->id;
				$userModel = Users::model()->findByPk($user);
				$geoLocationDetails = "";
			
				if($userModel->geolocationDetails != ""){
					$geoLocationDetails = json_decode($userModel->geolocationDetails, true);
				}
			}
			
			if(isset($geoLocationDetails) && !empty($geoLocationDetails)){
				$userModel->geolocationDetails = "";
				$userModel->save(false);
			}
		}
		
		return ;
	}
	
	/**
	 * Method to handle the promotion validity
	 * It will automatically invoke the promotion transaction
	 * table and update the promotion status if needed.
	 * 
	 */
	public function actionPromotionCron(){
		$promotionCriteria = new CDbCriteria();
		$promotionCriteria->addCondition("promotionName NOT LIKE 'urgent'");
		$promotionCriteria->addCondition("status LIKE 'live'");
		$promotionModel = Promotiontransaction::model()->findAll($promotionCriteria);
		
		foreach ($promotionModel as $promotion){
			$promotionCreatedOn = $promotion->createdDate;
			$promotionEndsOn = strtotime('+'.$promotion->promotionTime.' day', $promotionCreatedOn);
			$currentDate = time();
			if($promotionEndsOn < $currentDate){
				$previousCriteria = new CDbCriteria();
				$previousCriteria->addCondition("productId = $promotion->productId");
				$previousCriteria->addCondition("status LIKE 'Expired'");
				$previousPromotion = Promotiontransaction::model()->find($previousCriteria);
				if(!empty($previousPromotion)){
					$previousPromotion->status = "Canceled";
					$previousPromotion->save(false);
				}
				
				$productModel = Products::model()->findByPk($promotion->productId);
				if(!empty($productModel)){
					$productModel->promotionType = 3;
					$productModel->save(false);
				}
				
				$promotion->status = "Expired";
				$promotion->save(false);

				$userid = $productModel->userId;
				$criteria = new CDbCriteria;
				$criteria->addCondition('user_id = "'.$userid.'"');
				$userdevicedet = Userdevices::model()->findAll($criteria);
				$userdata = Users::model()->findByPk($userid);
				$currentusername = $userdata->name;
				if(count($userdevicedet) > 0){
					foreach($userdevicedet as $userdevice){
						$deviceToken = $userdevice->deviceToken;
						$badge = $userdevice->badge;
						$badge +=1;
						$userdevice->badge = $badge;
						$userdevice->deviceToken = $deviceToken;
						$userdevice->save(false);
						if(isset($deviceToken)){
							$messages =  "Your promotion is expired for ".$productModel->name." by today. Kindly repromote for geting more sale for this products. 'Repromote'";
							Myclass::pushnot($deviceToken,$messages,$badge);
						}
					}
				}

				//echo $promotionCreatedOn." + ".$promotion->promotionTime." = ".$promotionEndsOn;
				//echo "</br>";
			}
		}
		
		//echo "<pre>";print_r($promotionModel);
		return;
	}
}
