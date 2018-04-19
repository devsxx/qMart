<?php

/**
 * This is the model class for table "hts_invoices".
 *
 * The followings are the available columns in table 'hts_invoices':
 * @property integer $invoiceId
 * @property integer $orderId
 * @property string $invoiceNo
 * @property integer $invoiceDate
 * @property string $invoiceStatus
 * @property string $paymentMethod
 * @property string $paymentTranxid
 *
 * The followings are the available model relations:
 * @property Orders $order
 */
class Invoices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('orderId', 'required'),
		array('orderId, invoiceDate', 'numerical', 'integerOnly'=>true),
		array('invoiceNo, invoiceStatus', 'length', 'max'=>20),
		array('paymentMethod', 'length', 'max'=>100),
		array('paymentTranxid', 'safe'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('invoiceId, orderId, invoiceNo, invoiceDate, invoiceStatus, paymentMethod, paymentTranxid', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoiceId' => Yii::t('admin','Invoice'),
			'orderId' => Yii::t('admin','Order ID'),
			'invoiceNo' => Yii::t('admin','Invoice ID'),
			'invoiceDate' => Yii::t('admin','Invoice Date'),
			'invoiceStatus' => Yii::t('admin','Invoice Status'),
			'paymentMethod' => Yii::t('admin','Payment Method'),
			'paymentTranxid' => Yii::t('admin','Payment Tranxid'),
		);
	}
	function getCreatedDate()
	{
		if ($this->invoiceDate===null)
		return;

		return date("d-m-Y",$this->invoiceDate);
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

		$criteria->compare('invoiceId',$this->invoiceId);
		$criteria->compare('orderId',$this->orderId);
		$criteria->compare('invoiceNo',$this->invoiceNo,true);
		$criteria->compare("from_unixtime(`invoiceDate`, '%d-%m-%Y')",$this->invoiceDate,true);
		if(!empty($this->invoiceDate)) {
		//	$criteria->condition = "from_unixtime(`invoiceDate`, '%d-%m-%Y') = '$this->invoiceDate'";
		}
		$criteria->compare('invoiceStatus',$this->invoiceStatus,true);
		$criteria->compare('paymentMethod',$this->paymentMethod,true);
		$criteria->compare('paymentTranxid',$this->paymentTranxid,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		'sort'=>array(
               'defaultOrder'=>'invoiceId DESC',
		)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
