<?php

/**
 * This is the model class for table "hts_trackingdetails".
 *
 * The followings are the available columns in table 'hts_trackingdetails':
 * @property integer $id
 * @property integer $orderid
 * @property string $status
 * @property integer $merchantid
 * @property string $buyername
 * @property string $buyeraddress
 * @property integer $shippingdate
 * @property string $couriername
 * @property string $courierservice
 * @property string $trackingid
 * @property string $notes
 */
class Trackingdetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_trackingdetails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shippingdate, couriername, trackingid,courierservice', 'required'),
			array('orderid, merchantid', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>150),
			array('buyername, couriername, courierservice, trackingid', 'length', 'max'=>250),
			array('notes', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, orderid, status, merchantid, buyername, buyeraddress, shippingdate, couriername, courierservice, trackingid, notes', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orderid' => 'Order Id',
			'status' => 'Status',
			'merchantid' => 'Merchantid',
			'buyername' => 'Buyer Name',
			'buyeraddress' => 'Buyer Address',
			'shippingdate' => 'Shipping Date',
			'couriername' => 'Courier Name',
			'courierservice' => 'Courier Service',
			'trackingid' => 'Tracking ID',
			'notes' => 'Notes',
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
		$criteria->compare('orderid',$this->orderid);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('merchantid',$this->merchantid);
		$criteria->compare('buyername',$this->buyername,true);
		$criteria->compare('buyeraddress',$this->buyeraddress,true);
		$criteria->compare('shippingdate',$this->shippingdate);
		$criteria->compare('couriername',$this->couriername,true);
		$criteria->compare('courierservice',$this->courierservice,true);
		$criteria->compare('trackingid',$this->trackingid,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Trackingdetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
