<?php

/**
 * This is the model class for table "hts_carts".
 *
 * The followings are the available columns in table 'hts_carts':
 * @property integer $cartId
 * @property integer $userId
 * @property integer $merchantId
 * @property integer $productId
 * @property integer $quantity
 * @property integer $price
 * @property string $options
 * @property integer $createdDate
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Products $product
 */
class Carts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_carts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('cartId', 'required'),
			//array('userId, productId, quantity, price, createdDate', 'numerical', 'integerOnly'=>true),
			//array('options', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cartId, userId, productId, quantity, price, options, createdDate', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
			'product' => array(self::BELONGS_TO, 'Products', 'productId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cartId' => 'Cart',
			'userId' => 'User',
			'merchantId' => 'Merchant',
			'productId' => 'Product',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'options' => 'Options',
			'createdDate' => 'Created Date',
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

		$criteria->compare('cartId',$this->cartId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('merchantId',$this->merchantId);
		$criteria->compare('productId',$this->productId);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price);
		$criteria->compare('options',$this->options,true);
		$criteria->compare('createdDate',$this->createdDate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Carts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
