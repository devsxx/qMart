<?php
class Myclass {
	public static function encrypt($string) {
		return substr(hash('sha256',$string),0,8);
	}
	public static function getLogo() {
		$id = 1;
		$setting = Sitesettings::model()->findByPk($id);
		return $setting->logo;
	}
	public static function getSitePaymentModes() {
		$id = 1;
		$setting = Sitesettings::model()->findByPk($id);
		$paymentModes = "";
		if(!empty($setting->sitepaymentmodes))
			$paymentModes = json_decode($setting->sitepaymentmodes, true);
		return $paymentModes;
	}
	public static function getLogoDarkVersion() {
		$id = 1;
		$setting = Sitesettings::model()->findByPk($id);
		return $setting->logoDarkVersion;
	}
	public static function getDefaultUser() {
		$id = 1;
		$setting = Sitesettings::model()->findByPk($id);
		return $setting->default_userimage;
	}
	public static function getFooterLinks() {
		$footerLinksModel = Helppages::model()->findAll();
		
		return $footerLinksModel;
	}
	public static function getTermsSlug() {
		$footerLinksModel = Helppages::model()->findByAttributes(array('id'=>1));
		
		return $footerLinksModel->slug;
	}
	public static function getcurrentUserdetail() {
		$userId = Yii::app()->user->id;
		$userdetail = Users::model()->find("userId = $userId");
		return $userdetail;
	}

	public static function getUserbyemail($email) {
		$userdetail = Users::model()->find("email = '$email'");
		return $userdetail;
	}	
	public static function getMetaData(){
		$siteSettings = Sitesettings::model()->findByPk(1);
		
		$metaData = json_decode($siteSettings->metaData, true);
		if(!empty($metaData)){
			$metaContent['title'] = $metaData['metaTitle'];
			$metaContent['description'] = $metaData['metaDescription'];
			$metaContent['metaKeywords'] = $metaData['metaKeywords'];
		}
		$metaContent['sitename'] = $siteSettings->sitename;
		
		return $metaContent;
	}
	public static function getFooterSettings() {
		$id = 1;
		$setting = Sitesettings::model()->findByPk($id);
		$details = array();
		if(!empty($setting->footer_settings)){
			$footerSettings = json_decode($setting->footer_settings, true);
			$footerSettings = $footerSettings['footerDetails'];
			$details['socialLinks'] = array();$details['appLinks'] = array();
			if(!empty($footerSettings['facebooklink'])){
				$details['socialLinks']['facebook'] = $footerSettings['facebooklink'];
			}
			if(!empty($footerSettings['googlelink'])){
				$details['socialLinks']['google'] = $footerSettings['googlelink'];
			}
			if(!empty($footerSettings['twitterlink'])){
				$details['socialLinks']['twitter'] = $footerSettings['twitterlink'];
			}
			if(!empty($footerSettings['androidlink'])){
				$details['appLinks']['android'] = $footerSettings['androidlink'];
			}
			if(!empty($footerSettings['ioslink'])){
				$details['appLinks']['ios'] = $footerSettings['ioslink'];
			}
			$details['footerCopyRightsDetails'] = $footerSettings['footerCopyRightsDetails'];
		}
		$details['analytics'] = $setting->tracking_code;
		return $details;
	}
	public static function getProductImage($id) {
		//echo $id;
		if($id != null)
			$images = Photos::model()->find("productId = $id");
		if(!empty($images))
			return $images->name;
	}
	public static function getCountryId($countryCode){
		$countryModel = Country::model()->findByAttributes(array('code'=>$countryCode));
		
		return $countryModel->countryId;
	}
	public static function getCountryCode($countryId){
		$countryModel = Country::model()->findByAttributes(array('countryId'=>$countryId));
		
		return $countryModel->code;
	}
	public static function getProductDetails($id) {
		$product = Products::model()->findByPk($id);
		if(!empty($product))
		return $product;
	}
	public static function getProductURL($productModel){
		$productURL = Yii::app()->createAbsoluteUrl('item/products/view',array('id' => $this->safe_b64encode(
				$productModel->productId.'-'.rand(0,999)))).'/'.$this->productSlug($productModel->name);
		
		return $productURL;
	}
	public static function getUserProductDetails($id,$limit) {
		$UserProductcriteria = new CDbCriteria;
		$UserProductcriteria->addCondition("userId = '$id'");
		$UserProductcriteria->limit = $limit;
		$product = Products::model()->findAll($UserProductcriteria);
		if(!empty($product))
			return $product;
	}
	public static function getUserDetails($id) {
		$user = Users::model()->findByPk($id);
		if(!empty($user))
		return $user;
	}
	public static function getCategory() {
		$category = Categories::model()->findAll("parentCategory=0");
		return $category;
	}
	public static function getCategoryName($categorySlug) {
		$category = Categories::model()->findByAttributes(array('slug'=>$categorySlug));
		if(!empty($category))
			return $category->name;
		else
			return "";
	}
	public static function getCategoryId($categorySlug) {
		$category = Categories::model()->findByAttributes(array('slug'=>$categorySlug));
		if(!empty($category))
			return $category->categoryId;
			else
				return "";
	}
	public static function slug($str) {
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		return $str;
	}
	public static function trimSpace($str) {
		$str = str_replace(' ', '-',$str);
		return $str;
	}
	public static function productSlug($str) {
		$old = $str;
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '', $str);
		$str = preg_replace('/-+/', "", $str);
		$str = substr($str, 0, 10);
		if(!empty($str))
		return $str;
		else return trim($old);
	}
	public static function getMessageCount($id){
		$chatModel = Chats::model()->findAllByAttributes(array('lastToRead'=>$id));
		return count($chatModel);
	}
	public static function getNotificationCount($id){
		$userModel = Users::model()->findByPk($id);
		return $userModel->unreadNotification;
	}

	public static function getElapsedTime($timestamp) {
		$time = time() - $timestamp;

		$tokens = array (
		31536000 => 'year',
		2592000 => 'month',
		604800 => 'week',
		86400 => 'day',
		3600 => 'hour',
		60 => 'minute',
		1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			if($numberOfUnits>1) {
				$text = $text.'s';
			}
			$text = Yii::t('app',$text);
			return $numberOfUnits.' '.$text;
		}
	}
	public static function cart_encrypt($text, $salt)
	{
		//return trim(Myclass::safe_b64encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
		return trim(Myclass::safe_b64encode($text));
	}

	public static function cart_decrypt($text, $salt)
	{
		//return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, Myclass::safe_b64decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
		return trim(Myclass::safe_b64decode($text));
	}

	public static function safe_b64encode($string) {

		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}

	public static function safe_b64decode($string) {
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	public static function getCatName($id) {
		$category = Categories::model()->findByPk($id);
		if(!empty($category))
		return $category->name;
		else
		return Yii::t('app','NIL');
	}
	public static function getCatDetails($id) {
		$category = Categories::model()->findByPk($id);
		if(!empty($category))
			return $category;
	}
	public static function getDefaultShippingAddress($userId){

		$userAddress = Users::model()->findByPk($userId);
		if(!empty($userAddress))
		return $userAddress->defaultshipping;

	}
	public static function getRandomString($length) {
		$charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$charshuffle = str_shuffle($charset);
		return substr($charshuffle,0,$length);

		return $randomString;
	}

	public static function checkSoldOut($id) {
		$productCriteria = new CDbCriteria;
		$productCriteria->addCondition("productId = '$id'");
		$productCriteria->addCondition("quantity != '0'");
		$products = Products::model()->find($productCriteria);
		return $products;
	}

	public static function getImagefromURL($imageUrl, $type = 'user'){
		if ($type == "item"){
			$user_image_path = "media/items/";
		}else{
			$user_image_path = "media/user/";
		}

		$newname = time().".jpg";
		$finalPath = $user_image_path;
		/* while ($out == 0) {
			$i = file_get_contents($imageurl);
			if ($i != false){
			$out = 1;
			}
			} */

		$raw = file_get_contents($imageUrl);
		if ($raw == false){
			$ch = curl_init ($imageUrl);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			$raw=curl_exec($ch);
			curl_close ($ch);
		}


		/* if(file_exists($saveto)){
			unlink($saveto);
			}
			$fp = fopen($saveto,'x');
			fwrite($fp, $raw);
			fclose($fp); */

		$fori = fopen($finalPath.$newname,'wb');
		fwrite($fori,$raw);
		fclose($fori);
		chmod($finalPath.$newname, 0666);

		return $newname;
	}
	public static function getShippingCost($pid,$cid) {
		$criteria = new CDbCriteria;
		$criteria->addCondition("productId = $pid");
		$criteria->addCondition("countryId = $cid");
		$shippingCost = Shipping::model()->find($criteria);
		if(!empty($shippingCost))
		return $shippingCost->shippingCost;
		else {
			return '0';
		}
	}
	
	public static function getLastProductPaypalId($userId){
		$condition = new CDbCriteria;
		$condition->addCondition('userId = "'.$userId.'"');
		$condition->addCondition('paypalid != ""');
		$condition->order = '`productId` DESC';
		$productModel = Products::model()->find($condition);
		
		if(!empty($productModel)){
			return $productModel->paypalid;
		}else{
			return "";
		}
	}

	public static function getCurrency($str) {
		$str = explode("-",$str);
		return $str[0];
	}
	
	public static function getCurrencyData(){
		$currencyList = Currencies::model()->findAll();
		return $currencyList;
	}
	
	public static function getNewUsers() {
		$criteria = new CDbCriteria;
		$date = date("d-m-Y",time());
		$criteria->condition = "from_unixtime(`createdDate`, '%d-%m-%Y') = '$date'";
		return Users::model()->count($criteria);
	}

	public static function getNewItems() {
		$criteria = new CDbCriteria;
		$date = date("d-m-Y",time());
		$criteria->condition = "from_unixtime(`createdDate`, '%d-%m-%Y') = '$date'";
		return Products::model()->count($criteria);
	}
	public static function getTotalOrders() {
		return Orders::model()->count();
	}
	public static function getTotalPromotions() {
		return Promotiontransaction::model()->count();
	}
	public static function getTotalExchanges() {
		return Exchanges::model()->count();
	}
	public static function getTotalUsers() {
		return Users::model()->count();
	}
	public static function getTotalItems() {
		return Products::model()->count();
	}
	public static function getChatBuyCount() {
		$criteria = new CDbCriteria;
		$criteria->distinct = true;
		$criteria->select = 'chatId';
		$criteria->addCondition("messageType = 'normal'");
		$criteria->addCondition("sourceId != 0");
		$messages = Messages::model()->findAll($criteria);
		return count($messages);
	}
	public static function getExchangeBuyCount() {
		$criteria = new CDbCriteria;
		$date = date("d-m-Y",time());
		$criteria->condition = "from_unixtime(`date`, '%d-%m-%Y') = '$date'";
		$criteria->addCondition("status = 4");
		return Exchanges::model()->count($criteria);
	}
	public static function getInstantBuyCount() {
		$criteria = new CDbCriteria;
		$date = date("d-m-Y",time());
		$criteria->condition = "from_unixtime(`invoiceDate`, '%d-%m-%Y') = '$date'";
		return Invoices::model()->count($criteria);
	}
	public static function getExchangeBuyLog($date) {
		$criteria = new CDbCriteria;
		$criteria->condition = "from_unixtime(`date`, '%d-%m-%Y') = '$date'";
		$criteria->addCondition("status = 4");
		return Exchanges::model()->count($criteria);
	}
	public static function getPromotionsAddsCount() {
		$criteria = new CDbCriteria;
		$date = date("d-m-Y",time());
		$criteria->condition = "from_unixtime(`createdDate`, '%d-%m-%Y') = '$date'";
		$criteria->addCondition("promotionName = 'adds'");
		return Promotiontransaction::model()->count($criteria);
	}
	public static function getPromotionsUrgentCount() {
		$criteria = new CDbCriteria;
		$date = date("d-m-Y",time());
		$criteria->condition = "from_unixtime(`createdDate`, '%d-%m-%Y') = '$date'";
		$criteria->addCondition("promotionName = 'urgent'");
		return Promotiontransaction::model()->count($criteria);
	}
	public static function getPromotionsAdds($date) {
		$criteria = new CDbCriteria;
		$criteria->condition = "from_unixtime(`createdDate`, '%d-%m-%Y') = '$date'";
		$criteria->addCondition("promotionName = 'adds'");
		return Promotiontransaction::model()->count($criteria);
	}
	public static function getPromotionsUrgent($date) {
		$criteria = new CDbCriteria;
		$criteria->condition = "from_unixtime(`createdDate`, '%d-%m-%Y') = '$date'";
		$criteria->addCondition("promotionName = 'urgent'");
		return Promotiontransaction::model()->count($criteria);
	}
	public static function getInstantBuyLog($date) {
		$criteria = new CDbCriteria;
		$criteria->condition = "from_unixtime(`invoiceDate`, '%d-%m-%Y') = '$date'";
		return Invoices::model()->count($criteria);
	}
	public static function getRegisteredUsers($date = null) {
		$criteria = new CDbCriteria;
		if(empty($date)) {
			$date = date("d-m-Y",time());
		}
		$criteria->condition = "from_unixtime(`createdDate`, '%d-%m-%Y') = '$date'";
		return Users::model()->count($criteria);
	}
	public static function getLoggedUsers($date = null) {
		$criteria = new CDbCriteria;
		if(empty($date)) {
			$date = date("d-m-Y",time());
		}
		$criteria->condition = "from_unixtime(`lastLoginDate`, '%d-%m-%Y') = '$date'";
		return Users::model()->count($criteria);
	}
	public static function getItemsAdded($date) {
		$criteria = new CDbCriteria;
		$criteria->condition = "from_unixtime(`createdDate`, '%d-%m-%Y') = '$date'";
		return Products::model()->count($criteria);
	}
	public static function getUserId($username) {
		$user = Users::model()->findByAttributes(array('username'=>$username));
		if(!empty($user))
		{
		 return $user->userId;
		}
	}
	public static function exchangeProductExist($mid,$exid,$fromUser,$toUser) {
		$criteria = new CDbCriteria;
		$criteria->condition = "(`mainProductId` = '$mid' AND `exchangeProductId` = '$exid' OR `mainProductId` = '$exid' AND `exchangeProductId` = '$mid') AND (`requestFrom` = '$fromUser' AND `requestTo` = '$toUser' OR `requestFrom` = '$toUser' AND `requestTo` = '$fromUser')";
		$exCheck = Exchanges::model()->find($criteria);
		if(!empty($exCheck)) {
			return $exCheck;
		}
	}
	public static function getCurrencyList($cur = null) {
		$currency =  array('$-Australian Dollar' => 'AUD', 'R$-Brazilian Rea' => 'BRL', 'C$-Canadian Dollar' => 'CAD', 'Kč-Czech Koruna' => 'CZK', 'kr.-Danish Krone' => 'DKK', '€-Euro' => 'EUR', 'HK$-Hong Kong Dollar' => 'HKD', 'Ft-Hungarian Forint' => 'HUF', '₪-Israeli New Sheqel' => 'ILS', '¥-Japanese Yen' => 'JPY', 'RM-Malaysian Ringgit' => 'MYR', 'Mex$-Mexican Peso' => 'MXN', 'kr-Norwegian Krone' => 'NOK', '$-New Zealand Dollar' => 'NZD', '₱-Philippine Peso' => 'PHP', 'zł-Polish Zloty' => 'PLN', '£-Pound Sterling' => 'GBP', 'руб-Russian Ruble' => 'RUB', 'S$-Singapore Dollar' => 'SGD', 'kr-Swedish Krona' => 'SEK', 'CHF-Swiss Franc' => 'CHF', 'NT$-Taiwan New Dolla' => 'TWD', '฿-Thai Baht' => 'THB', '₺-Turkish Lira' => 'TRY', '$-U.S. Dollar' => 'USD' );
		if(!empty($cur)) {
			return $currency[$cur];
		} else {
			return $currency;
		}
	}
	public static function checkWhetherProductSold($productId) {
		$product = Products::model()->findByPk($productId);
		if(($product->soldItem == 1) || ($product->quantity == 0)) {
			return $product;
		} else {
			return 0;
		}
	}
	public static function checkChatExists($user1,$user2) {
		$criteria = new CDbCriteria;
		$criteria->condition = "(`user1` = '$user1' AND `user2` = '$user2' OR `user1` = '$user2' AND `user2` = '$user1')";
		$chatCheck = Chats::model()->find($criteria);
		if(!empty($chatCheck)) {
			return $chatCheck->chatId;
		}
	}
	public static function getSiteName() {
		$siteSetting = Sitesettings::model()->find();
		return $siteSetting->sitename;
	}
	
	/**
	 * To add the logs to the database
	 * 
	 * @param string $type
	 * @param integer $userid
	 * @param integer $notifyto
	 * @param integer $sourceid
	 * @param integer $itemid
	 * @param string $notifymessage
	 * @param integer $notificationId
	 * @param string $message
	 */
	
	public static function addLogs($type, $userid, $notifyto = 0, $sourceid = 0, $itemid = 0, 
			$notifymessage = null, $notificationId = 0, $message = null){
		if(Yii::app()->user->id != $notifyto || $userid == 0){
			$logsModel = new Logs();
			$logsModel->type = $type;
			$logsModel->userid = $userid;
			$logsModel->notifyto = $notifyto;
			$logsModel->sourceid = $sourceid;
			$logsModel->itemid = $itemid;
			$logsModel->notifymessage = $notifymessage;
			$logsModel->notification_id = $notificationId;
			$logsModel->message = $message;
			$logsModel->createddate = time();
			$logsModel->save(false);
			
			if($notifyto != 0){
				$userModel = Users::model()->findByPk($notifyto);
				if(!empty($userModel)){
					$userModel->unreadNotification += 1;
					$userModel->save(false);
				}
			}
			else if($notifyto == 0)
			{
				Users::model()->updateCounters(array("unreadNotification"=>"1"));
			}
		}
	}
	
	/**
	 * To removed the logs based on 
	 * the Product Id
	 * 
	 * @param string $itemId
	 */
	public static function removeItemLogs($itemId){
		$logCriteria = new CDbCriteria();
		$logCriteria->addCondition("itemid = $itemId");
		
		Logs::model()->deleteAll($logCriteria);
		
		return true;
	}
	
	public static function pushnot($deviceToken = NULL, $message = NULL, $badge = NULL,$notifytype="notification"){
		$criteria = new CDbCriteria;
		$criteria->addCondition('deviceToken = "'.$deviceToken.'"');
		$userdevicedatas = Userdevices::model()->find($criteria);
		if($userdevicedatas->type == 0){
			include_once('certificate/PushNotification.php');
				if($userdevicedatas->mode == 1){
							$certifcUrl =  'certificate/qMartDevelopment.pem';
							$push = new PushNotification("sandbox",$certifcUrl);
				}else{
							$certifcUrl =  'certificate/qMartProduction.pem';
							$push = new PushNotification("production",$certifcUrl);
				}
				$push->setDeviceToken($deviceToken);
				$push->setPassPhrase("");
				$push->setBadge($badge);
				$push->setNotifytype($notifytype);
				$push->setMessageBody($message);
				$push->sendNotification();
		}else{
				Myclass::send_push_notification($deviceToken, $message,$notifytype);
		}
	}

	public static function send_push_notification($registatoin_ids, $message,$notifytype){
	
			$url = 'https://android.googleapis.com/gcm/send';
			$registatoin_ids = array($registatoin_ids);
			$message = array("price" => $message,'type'=>$notifytype);
			$fields = array(
					'registration_ids' => $registatoin_ids,
					'data' => $message,
			);
		
			$headers = array(
					'Authorization: key=AIzaSyAyjswyCakvUXjGVzP95mSUGTKm0yFy31A',
					'Content-Type: application/json'
			);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);
			if ($result === FALSE) {
				
			}
			$errormsg = curl_error($ch);
			curl_close($ch);
			
	}	
	public static function getCategoryPriority() {
		$id = 1;
		$setting = Sitesettings::model()->findByPk($id);
		$details = array();
		if(!empty($setting->category_priority)){
			$categorypriority = json_decode($setting->category_priority, true);
			/*$categorypriority1 = $categorypriority['categorypriority'];
			$details['socialLinks'] = array();$details['appLinks'] = array();
			if(!empty($categorypriority['facebooklink'])){
				$details['socialLinks']['facebook'] = $categorypriority['facebooklink'];
			}
			if(!empty($categorypriority['googlelink'])){
				$details['socialLinks']['google'] = $categorypriority['googlelink'];
			}
			if(!empty($categorypriority['twitterlink'])){
				$details['socialLinks']['twitter'] = $categorypriority['twitterlink'];
			}
			if(!empty($categorypriority['androidlink'])){
				$details['appLinks']['android'] = $categorypriority['androidlink'];
			}
			if(!empty($categorypriority['ioslink'])){
				$details['appLinks']['ios'] = $footerSettings['ioslink'];
			}*/
		}
		return $categorypriority;
	}
	public static function getSubCategory($id) {
		
		
		$subCategory = Categories::model()->findAllByAttributes(array('parentCategory'=>$id));
		$subCategory = CHtml::listData($subCategory, 'categoryId', 'name');
		return $subCategory;
	}
	
	public static function getCatImage($id) {
		$category = Categories::model()->findByPk($id);
		if(!empty($category))
			return $category->image;
		else
			return Yii::t('app','NIL');
	}
	
	public static function getsocialLoginDetails() {
	
		$id = 1;
		$siteSettingsModel = Sitesettings::model()->findByAttributes(array('id'=>1));
		$socialLogin = json_decode($siteSettingsModel->socialLoginDetails, true);
		return $socialLogin;
	}

	public static function getSitesettings()
	{
		$id = 1;
		$siteSettingsModel = Sitesettings::model()->findByAttributes(array('id'=>1));
		return $siteSettingsModel;		
	}
	
	
}
