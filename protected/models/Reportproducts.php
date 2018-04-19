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
 * @property string $paypalid
 * @property string $shippingTime
 * @property string $location
 * @property double $latitude
 * @property double $longitude
 * @property integer $likes
 * @property integer $views
 * @property integer $soldItem
 * @property string $reports
 * @property integer $reportCount
 *
 * The followings are the available model relations:
 * @property Carts[] $carts
 * @property Comments[] $comments
 * @property Orderitems[] $orderitems
 * @property Categories $category0
 * @property Categories $subCategory0
 * @property Users $user
 * @property Shipping[] $shippings
 */
class Reportproducts extends CActiveRecord
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
			array('userId, currency, chatAndBuy, exchangeToBuy, instantBuy, paypalid, shippingTime, location, latitude, longitude, likes, views, soldItem, reports', 'required'),
			array('userId, category, subCategory, price, quantity, createdDate, likeCount, commentCount, chatAndBuy, exchangeToBuy, instantBuy, likes, views, soldItem', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude', 'numerical'),
			array('name, paypalid', 'length', 'max'=>150),
			array('currency', 'length', 'max'=>10),
			array('productCondition', 'length', 'max'=>13),
			array('shippingTime', 'length', 'max'=>60),
			array('location', 'length', 'max'=>255),
			array('reports', 'length', 'max'=>50),
			array('description, sizeOptions', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('productId, userId, name, description, category, subCategory, price, currency, quantity, sizeOptions, productCondition, createdDate, likeCount, commentCount, chatAndBuy, exchangeToBuy, instantBuy, paypalid, shippingTime, location, latitude, longitude, likes, views, soldItem, reports', 'safe', 'on'=>'search'),
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
			'carts' => array(self::HAS_MANY, 'Carts', 'productId'),
			'comments' => array(self::HAS_MANY, 'Comments', 'productId'),
			'orderitems' => array(self::HAS_MANY, 'Orderitems', 'productId'),
			'category0' => array(self::BELONGS_TO, 'Categories', 'category'),
			'subCategory0' => array(self::BELONGS_TO, 'Categories', 'subCategory'),
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
			'shippings' => array(self::HAS_MANY, 'Shipping', 'productId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'productId' => 'Product',
			'userId' => 'User',
			'name' => 'Name',
			'description' => 'Description',
			'category' => 'Category',
			'subCategory' => 'Sub Category',
			'price' => 'Price',
			'currency' => 'Currency',
			'quantity' => 'Quantity',
			'sizeOptions' => 'Size Options',
			'productCondition' => 'Product Condition',
			'createdDate' => 'Created Date',
			'likeCount' => 'Like Count',
			'commentCount' => 'Comment Count',
			'chatAndBuy' => 'Chat And Buy',
			'exchangeToBuy' => 'Exchange To Buy',
			'instantBuy' => 'Instant Buy',
			'paypalid' => 'Paypalid',
			'shippingTime' => 'Shipping Time',
			'location' => 'Location',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'likes' => 'Likes',
			'views' => 'Views',
			'soldItem' => 'Sold Item',
			'reports' => 'Reports',
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
		/* $criteria->compare('currency',$this->currency,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('sizeOptions',$this->sizeOptions,true);
		$criteria->compare('productCondition',$this->productCondition,true); 
		$criteria->compare('createdDate',$this->createdDate);*/
		$criteria->compare("from_unixtime(`createdDate`, '%d-%m-%Y')",$this->createdDate,true);
		/* $criteria->compare('likeCount',$this->likeCount);
		$criteria->compare('commentCount',$this->commentCount);
		$criteria->compare('chatAndBuy',$this->chatAndBuy);
		$criteria->compare('exchangeToBuy',$this->exchangeToBuy);
		$criteria->compare('instantBuy',$this->instantBuy);
		$criteria->compare('paypalid',$this->paypalid,true);
		$criteria->compare('shippingTime',$this->shippingTime,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('likes',$this->likes);
		$criteria->compare('views',$this->views);
		$criteria->compare('soldItem',$this->soldItem); */
		$criteria->compare('reports',$this->reports,true);
		

		$criteria->addCondition('reports != :reports');
		$criteria->params[ ':reports' ] = '';

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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reportproducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	function getModDate()
	{
		if ($this->createdDate===null)
			return;
			return date("d-m-Y",$this->createdDate);
	}
}
