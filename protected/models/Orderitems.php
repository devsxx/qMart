<?php

/**
 * This is the model class for table "hts_orderitems".
 *
 * The followings are the available columns in table 'hts_orderitems':
 * @property integer $orderitemId
 * @property integer $orderId
 * @property integer $productId
 * @property string $itemName
 * @property string $itemPrice
 * @property string $itemSize
 * @property integer $itemQuantity
 * @property string $itemunitPrice
 * @property string $shippingPrice
 *
 * The followings are the available model relations:
 * @property Orders $order
 * @property Products $product
 */
class Orderitems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_orderitems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderId, productId', 'required'),
			array('orderId, productId, itemQuantity', 'numerical', 'integerOnly'=>true),
			array('itemName', 'length', 'max'=>150),
			array('itemPrice, itemunitPrice', 'length', 'max'=>18),
			array('itemSize', 'length', 'max'=>30),
			array('shippingPrice', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orderitemId, orderId, productId, itemName, itemPrice, itemSize, itemQuantity, itemunitPrice, shippingPrice', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Orders', 'orderId'),
			'product' => array(self::BELONGS_TO, 'Products', 'productId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'orderitemId' => 'Orderitem',
			'orderId' => 'Order',
			'productId' => 'Product',
			'itemName' => 'Item Name',
			'itemPrice' => 'Item Price',
			'itemSize' => 'Item Size',
			'itemQuantity' => 'Item Quantity',
			'itemunitPrice' => 'Itemunit Price',
			'shippingPrice' => 'Shipping Price',
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

		$criteria->compare('orderitemId',$this->orderitemId);
		$criteria->compare('orderId',$this->orderId);
		$criteria->compare('productId',$this->productId);
		$criteria->compare('itemName',$this->itemName,true);
		$criteria->compare('itemPrice',$this->itemPrice,true);
		$criteria->compare('itemSize',$this->itemSize,true);
		$criteria->compare('itemQuantity',$this->itemQuantity);
		$criteria->compare('itemunitPrice',$this->itemunitPrice,true);
		$criteria->compare('shippingPrice',$this->shippingPrice,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orderitems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
