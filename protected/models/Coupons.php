<?php

/**
 * This is the model class for table "hts_coupons".
 *
 * The followings are the available columns in table 'hts_coupons':
 * @property integer $id
 * @property string $couponCode
 * @property integer $sellerId
 * @property integer $productId
 * @property integer $couponType
 * @property integer $couponValue
 * @property integer $maxAmount
 * @property string $startDate
 * @property string $endDate
 * @property integer $status
 * @property string $createdDate
 */
class Coupons extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_coupons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('id, couponCode, sellerId, productId, couponType, couponValue', 'required','on'=>'itemView'),
		array('couponCode, sellerId, couponType, couponValue, startDate, endDate, status', 'required','on' => 'sellerProfile'),
		array('couponValue','checkValue','on'=>'sellerProfile'),
		array('id, sellerId, productId, couponType, couponValue, maxAmount, status', 'numerical', 'integerOnly'=>true),
		array('couponCode', 'length', 'max'=>15),
		array('startDate,endDate','DateRequired','on' => 'sellerProfile'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, couponCode, sellerId, productId, couponType, couponValue, maxAmount, startDate, endDate, status, createdDate', 'safe', 'on'=>'search'),
		);
	}
	public function checkValue($attribute) {
		if($this->couponValue < 1 || $this->couponValue >= 100) {
			$this->addError('couponValue',Yii::t('app','Coupon Value should be between 1% to 99%.'));
		}
	}
	public function DateRequired($attribute)
	{
		if($this->startDate > $this->endDate){
			$this->addError('endDate', Yii::t('app','End Date should be some date after start date.'));
		}
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'couponCode' => 'Coupon Code',
			'sellerId' => 'Seller',
			'productId' => 'Product',
			'couponType' => 'Coupon Type',
			'couponValue' => Yii::t('app','Coupon Value In %'),
			'maxAmount' => Yii::t('app','Max Amount'),
			'startDate' =>Yii::t('app', 'Start Date'),
			'endDate' => Yii::t('app','End Date'),
			'status' => Yii::t('app','Status'),
			'createdDate' => Yii::t('app','Created Date'),
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
		$criteria->compare('couponCode',$this->couponCode,true);
		$criteria->compare('sellerId',$this->sellerId);
		$criteria->compare('productId',$this->productId);
		$criteria->compare('couponType',$this->couponType);
		$criteria->compare('couponValue',$this->couponValue);
		$criteria->compare('maxAmount',$this->maxAmount);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('endDate',$this->endDate,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('createdDate',$this->createdDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Coupons the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
