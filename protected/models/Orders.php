<?php

/**
 * This is the model class for table "hts_orders".
 *
 * The followings are the available columns in table 'hts_orders':
 * @property integer $orderId
 * @property integer $userId
 * @property integer $sellerId
 * @property string $totalCost
 * @property string $totalShipping
 * @property string $discount
 * @property string $discountSource
 * @property integer $orderDate
 * @property integer $shippingAddress
 * @property string $currency
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Invoices[] $invoices
 * @property Orderitems[] $orderitems
 * @property Users $user
 * @property Users $seller
 */
class Orders extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('userId, sellerId, discount, discountSource', 'required'),
		array('userId, sellerId, orderDate, shippingAddress', 'numerical', 'integerOnly'=>true),
		array('totalCost', 'length', 'max'=>18),
		array('totalShipping', 'length', 'max'=>7),
		array('discount', 'length', 'max'=>15),
		array('discountSource', 'length', 'max'=>50),
		array('currency', 'length', 'max'=>3),
		array('status', 'length', 'max'=>20),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('orderId, userId, sellerId, totalCost, totalShipping,discount, discountSource, orderDate, shippingAddress, currency, status', 'safe', 'on'=>'search'),
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
			'invoices' => array(self::HAS_MANY, 'Invoices', 'orderId'),
			'orderitems' => array(self::HAS_MANY, 'Orderitems', 'orderId'),
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
			'seller' => array(self::BELONGS_TO, 'Users', 'sellerId'),
		    'tracking' => array(self::BELONGS_TO, 'Trackingdetails', 'orderId'),
            'shippingaddresses' =>  array(self::HAS_ONE, 'Shippingaddresses', 'shippingaddressId'),		
		    'trackingdetails' => array(self::HAS_MANY, 'Trackingdetails', 'orderid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'orderId' => Yii::t('admin','Order ID'),
			'userId' => Yii::t('admin','Buyer'),
			'sellerId' => Yii::t('admin','Seller'),
			'totalCost' => Yii::t('admin','Total Cost'),
			'totalShipping' => Yii::t('admin','Total Shipping'),
			'discount' => Yii::t('admin','Discount'),
			'discountSource' => Yii::t('admin','Discount Source'),
			'orderDate' => Yii::t('admin','Order Date'),
			'shippingAddress' => Yii::t('admin','Shipping Address'),
			'currency' => Yii::t('admin','Currency'),
			'status' => Yii::t('admin','Status'),
		);
	}

	function getCreatedDate()
	{
		if ($this->orderDate===null)
		return;

		return date("d-m-Y",$this->orderDate);
	}

	function getUserName()
	{
		if ($this->userId===null)
		return;

		return Myclass::getUserDetails($this->userId)->username;
	}
	function getSellerName()
	{
		if ($this->sellerId===null)
		return;

		return Myclass::getUserDetails($this->sellerId)->username;
	}
	function getTotalAmount() {
		$total = (($this->totalCost) - ($this->discount));
		return $total.' '.$this->currency;
	}
	function getCommission() {
		$siteSettings = Sitesettings::model()->find();
		$commissionStatus = $siteSettings->commission_status;

		if(!empty($this->discount)) {
			$finalPrice = ($this->orderitems[0]->itemunitPrice) * ($this->orderitems[0]->itemQuantity);
			$finalPrice = ($finalPrice - ($this->discount));
		} else {
			$finalPrice = $this->orderitems[0]->itemunitPrice;
		}
		if($commissionStatus == 1) {
			$criteria = new CDbCriteria;
			$criteria->condition = "minRate <= $finalPrice AND maxRate >= $finalPrice AND status = '1'";
			$criteria->order = 'id DESC';
			$comissionModel = Commissions::model()->find($criteria);
			if(!empty($comissionModel)) {
				$percentage = $comissionModel->percentage;
				if(empty($discount)) {
					$adminCommission = ($finalPrice * ($percentage/100));
					$adminCommission = $adminCommission * $this->orderitems[0]->itemQuantity;
				} else {
					$adminCommission = ($finalPrice * ($percentage/100));
				}
			} else {
				$adminCommission = 0;
			}
		} else {
			$adminCommission = 0;
		}
		return $adminCommission.' '.$this->currency;
	}

	function getSellerAmount() {
		$sellerAmount = $this->getTotalAmount() - $this->getCommission();
		return $sellerAmount.' '.$this->currency;
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
	public function search($status = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('invoices');
		//$criteria->join='LEFT JOIN hts_invoices ON hts_invoices.orderId=t.orderId';
		$criteria->compare('orderId',$this->orderId);
		$criteria->compare('sellerId',$this->sellerId);
		$criteria->compare('totalCost',$this->totalCost,true);
		$criteria->compare('totalShipping',$this->totalShipping,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('discountSource',$this->discountSource,true);
		$criteria->compare("from_unixtime(`orderDate`, '%d-%m-%Y')",$this->orderDate,true);
		/*if(!empty($this->orderDate))
		 $criteria->condition = "from_unixtime(`orderDate`, '%d-%m-%Y') = '$this->orderDate'";
		 else
		 $criteria->compare('orderDate',$this->orderDate); */
		$criteria->compare('shippingAddress',$this->shippingAddress);
		$criteria->compare('currency',$this->currency,true);


		if(Yii::app()->controller->action->id == 'scroworders') {
			$criteria->addCondition("trackPayment != ''");
			if($status == 'approved') {
				$criteria->addCondition("trackPayment = 'paid'");
			} elseif($status == 'delivered') {
				$criteria->addCondition("trackPayment = 'pending'");
				$criteria->addCondition("status = 'delivered'");
			} elseif($status == 'cancelled') {
				$criteria->addCondition("trackPayment = 'pending'");
				$criteria->addCondition("status = 'cancelled'");
			} elseif($status == 'refunded') {
				$criteria->addCondition("trackPayment = 'refunded'");
				$criteria->addCondition("status = 'cancelled'");
			} else {
				$criteria->compare('status',$status,true);
			}
		} else {
			$criteria->addCondition("trackPayment = ''");
			$criteria->compare('status',$status,true);
		}
		if(Yii::app()->request->isAjaxRequest) {
			if(!empty($status))
			$criteria->addCondition("status = '$status'");
			
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		'sort'=>array(
               'defaultOrder'=>'orderId DESC',
		)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}