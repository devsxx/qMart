<?php

/**
 * This is the model class for table "hts_promotiontransaction".
 *
 * The followings are the available columns in table 'hts_promotiontransaction':
 * @property integer $id
 * @property integer $productId
 * @property string $promotionName
 * @property integer $promotionPrice
 * @property integer $promotionTime
 * @property string $status
 * @property string $tranxId
 * @property integer $createdDate
 *
 * The followings are the available model relations:
 * @property Adspromotiondetails[] $adspromotiondetails
 * @property Products $product
 */
class Promotiontransaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_promotiontransaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('productId, promotionName, promotionPrice, promotionTime, status, tranxId, createdDate', 'required'),
			array('productId, promotionPrice, promotionTime, createdDate', 'numerical', 'integerOnly'=>true),
			array('promotionName, tranxId', 'length', 'max'=>250),
			array('status', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, productId, promotionName, promotionPrice, promotionTime, status, tranxId, createdDate', 'safe', 'on'=>'search'),
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
			'adspromotiondetails' => array(self::HAS_MANY, 'Adspromotiondetails', 'promotionTranxId'),
			'product' => array(self::BELONGS_TO, 'Products', 'productId'),
			//'productuser' => array(self::HAS_MANY, 'Products', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'productId' => 'Product',
			'promotionName' => 'Promotion Name',
			'promotionPrice' => 'Promotion Price',
			'promotionTime' => 'Promotion Time',
			'status' => 'Status',
			'tranxId' => 'Tranx',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('productId',$this->productId);
		$criteria->compare('promotionName',$this->promotionName,true);
		$criteria->compare('promotionPrice',$this->promotionPrice);
		$criteria->compare('promotionTime',$this->promotionTime);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('tranxId',$this->tranxId,true);
		$criteria->compare('createdDate',$this->createdDate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Promotiontransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
