<?php

/**
 * This is the model class for table "hts_products".
 *
 * The followings are the available columns in table 'hts_products':
 * @property integer $productId
 * @property integer $userId
 * @property string $name
 * @property string $description
 * @property integer $category
 * @property integer $subCategory
 * @property integer $price
 * @property string $currency
 * @property integer $quantity
 * @property string $sizeOptions
 * @property string $productCondition
 * @property integer $createdDate
 * @property integer $likeCount
 * @property integer $commentCount
 * @property integer $chatAndBuy
 * @property integer $exchangeToBuy
 * @property integer $instantBuy
 * @property integer $myoffer
 * @property string $paypalid
 * @property string $shippingTime
 * @property string $shippingcountry
 * @property string $shippingCost
 * @property integer $soldItem
 * @property string $location
 * @property double $latitude
 * @property double $longitude
 * @property integer $likes
 * @property integer $views
 * @property string $reports
 * @property integer $reportCount
 * @property string $promotionType
 *
 * The followings are the available model relations:
 * @property Adspromotiondetails[] $adspromotiondetails
 * @property Carts[] $carts
 * @property Comments[] $comments
 * @property Orderitems[] $orderitems
 * @property Categories $category0
 * @property Categories $subCategory0
 * @property Users $user
 * @property Promotiontransaction[] $promotiontransactions
 * @property Shipping[] $shippings
 */
class Products extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('price, name, category,location, description', 'required'),
		array('price, shippingCost', 'numerical', 'integerOnly'=>true),
		array('description', 'filter', 'filter'=>'strip_tags'),
		array('latitude,longitude','numerical'),
		array('name', 'length', 'max'=>70),
		array('paypalid', 'length', 'max'=>150),
		array('instantBuy,paypalid,shippingCost','paypalRequired'),
		array('price','invalidPrice'),
		//array('quantity','invalidQuantity'),
		array('paypalid','email'),
		array('productCondition', 'length', 'max'=>100),
		array('description, sizeOptions', 'safe'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('productId, userId, currency,name, description,location,latitude,longitude, category,
				subCategory, price, quantity, sizeOptions, productCondition, createdDate, likeCount, 
				commentCount, chatAndBuy, exchangeToBuy, instantBuy, paypalid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'adspromotiondetails' => array(self::HAS_MANY, 'Adspromotiondetails', 'productId'),
			'carts' => array(self::HAS_MANY, 'Carts', 'productId'),
			'comments' => array(self::HAS_MANY, 'Comments', 'productId'),
			'photos' => array(self::HAS_MANY, 'Photos', 'productId'),
			'orderitems' => array(self::HAS_MANY, 'Orderitems', 'productId'),
			'category0' => array(self::BELONGS_TO, 'Categories', 'category'),
			'subCategory0' => array(self::BELONGS_TO, 'Categories', 'subCategory'),
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
			'promotiontransactions' => array(self::HAS_MANY, 'Promotiontransaction', 'productId'),
			'shippings' => array(self::HAS_MANY, 'Shipping', 'productId'),
		    'favorites' => array(self::HAS_MANY, 'Favorites', 'productId'),
		);
	}
	public function paypalRequired($attribute) {
		if($this->instantBuy == 1) {
			if($this->paypalid == '') {
				$this->addError('paypalid',Yii::t('admin','PayPal ID cannot be Empty'));
			}
			if($this->shippingCost == ''){
				$this->addError('shippingTime',Yii::t('admin','Shipping Cost cannot be empty'));
			}
		}
	}

	public function invalidPrice($attribute) {
		if($this->price == 0) {
			$this->addError('price',Yii::t('admin','Price should be greater than zero'));
		}
	}

	public function invalidQuantity($attribute) {
		if($this->quantity == 0) {
			$this->addError('quantity',Yii::t('admin','Quantity should be greater than zero'));
		}
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'productId' => Yii::t('admin','Product ID'),
			'userId' => Yii::t('admin','User ID'),
			'name' => Yii::t('admin','Name'),
			'description' => Yii::t('admin','Description'),
			'category' => Yii::t('admin','Category'),
			'subCategory' => Yii::t('admin','Sub Category'),
			'price' => Yii::t('admin','Price'),
			'quantity' => Yii::t('admin','Quantity'),
			'sizeOptions' => Yii::t('admin','Size Options'),
			'productCondition' => Yii::t('admin','Product Condition'),
			'createdDate' => Yii::t('admin','Created Date'),
			'likeCount' => Yii::t('admin','Like Count'),
			'commentCount' => Yii::t('admin','Comment Count'),
			'chatAndBuy' => Yii::t('admin','Chat And Buy'),
			'exchangeToBuy' => Yii::t('admin','Exchange To Buy'),
			'instantBuy' => Yii::t('admin','Instant Buy'),
			'myoffer' => Yii::t('admin','Myoffer'),
			'paypalid' => Yii::t('admin','Paypal ID'),
			'likes' => Yii::t('admin','Likes'),
			'views' => Yii::t('admin','Views'),
			'shippingTime' => Yii::t('admin','Shipping Time'),
			'shippingPrice' => Yii::t('admin','Shipping Price'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('productId',$this->productId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('name',$this->name,true);
		/* $criteria->compare('description',$this->description,true);
		 $criteria->compare('category',$this->category);
		 $criteria->compare('subCategory',$this->subCategory); */
		$criteria->compare('price',$this->price);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('sizeOptions',$this->sizeOptions,true);
		$criteria->compare('productCondition',$this->productCondition,true);
		$criteria->compare("from_unixtime(`createdDate`, '%d-%m-%Y')",$this->createdDate,true);
		//if(!empty($this->createdDate))
		//$criteria->condition = "from_unixtime(`createdDate`, '%d-%m-%Y') = '$this->createdDate'";
		//else
		//$criteria->compare('createdDate',$this->createdDate);
		/* $criteria->compare('likeCount',$this->likeCount);
		$criteria->compare('commentCount',$this->commentCount); */
		$criteria->compare('chatAndBuy',$this->chatAndBuy);
		$criteria->compare('exchangeToBuy',$this->exchangeToBuy);
		$criteria->compare('instantBuy',$this->instantBuy);
		$criteria->compare('paypalid',$this->paypalid,true);
		// $criteria->order = 'productId DESC';
		return new CActiveDataProvider($this, array(
		'criteria'=>$criteria,
		'pagination'=>array(
              'pageSize'=>10,
		),
		'sort'=>array(
               'defaultOrder'=>'productId DESC',
		)

		));
	}
	function getModDate()
	{
		if ($this->createdDate===null)
		return;
		return date("d-m-Y",$this->createdDate);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Products the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function afterSave( ) {
		$this->addImages( );
		parent::afterSave( );
	}
	public function beforeValidate() {
		if($this->instantBuy == 1) {

		}
		return parent::beforeValidate();
	}
	public function addImages( ) {
		//If we have pending images
		if( Yii::app( )->user->hasState( 'images' ) ) {
			$userImages = Yii::app( )->user->getState( 'images' );
			//Resolve the final path for our images
			$path = Yii::app( )->getBasePath( )."/../media/item/{$this->productId}/";
			//Create the folder and give permissions if it doesnt exists
			if( !is_dir( $path ) ) {
				mkdir( $path );
				chmod( $path, 0777 );
			}

			//Now lets create the corresponding models and move the files
			foreach( $userImages as $image ) {
				if( is_file( $image["path"] ) ) {
					if( rename( $image["path"], $path.$image["filename"] ) ) {
						chmod( $path.$image["filename"], 0777 );
						$img = new Photos( );
						//$img->size = $image["size"];
						//$img->mime = $image["mime"];
						$img->name = $image["filename"];
						//$img->source = "/media/item/{$this->productId}/".$image["filename"];
						$img->productId = $this->productId;
						$img->createdDate = time();
						if( !$img->save( ) ) {
							//Its always good to log something
							Yii::log( "Could not save Image:\n".CVarDumper::dumpAsString(
							$img->getErrors( ) ), CLogger::LEVEL_ERROR );
							//this exception will rollback the transaction
							throw new Exception( 'Could not save Image');
						}
					}
				} else {
					//You can also throw an execption here to rollback the transaction
					Yii::log( $image["path"]." is not a file", CLogger::LEVEL_WARNING );
				}
			}
			//Clear the user's session
			Yii::app( )->user->setState( 'images', null );
		}
		if (isset($_SESSION['deletefile'][$this->productId])){
			//echo "<pre>"; print_r($_SESSION['deletefile'][$this->productId]);die;
			foreach($_SESSION['deletefile'][$this->productId] as $fileKey => $fileData){
				$photosModel = Photos::model()->findByAttributes(array('photoId' => $fileData['photoId']));
				Photos::model()->deleteAllByAttributes(array('photoId' => $fileData['photoId']));
				$path = realpath( Yii::app( )->getBasePath( )."/../media/item/".$photosModel->productId."/" )."/";
				$file = $path.$photosModel->name;
				if( is_file( $file ) ) {
					unlink( $file );
				}
			}
			unset($_SESSION['deletefile'][$this->productId]);
		}
	}
}
