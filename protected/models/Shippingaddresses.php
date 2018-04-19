<?php

/**
 * This is the model class for table "hts_shippingaddresses".
 *
 * The followings are the available columns in table 'hts_shippingaddresses':
 * @property integer $shippingaddressId
 * @property integer $userId
 * @property string $nickname
 * @property string $name
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $zipcode
 * @property string $phone
 * @property integer $countryCode
 *
 * The followings are the available model relations:
 * @property Country $countryCode0
 * @property Users $user
 */
class Shippingaddresses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_shippingaddresses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, countryCode', 'numerical', 'integerOnly'=>true),
			array('nickname', 'length', 'max'=>45),
			array('name, country', 'length', 'max'=>50),
			array('address1, address2', 'length', 'max'=>60),
			array('city, state', 'length', 'max'=>40),
			array('zipcode, phone', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('shippingaddressId, userId, nickname, name, address1, address2, city, state, country, zipcode, phone, countryCode', 'safe', 'on'=>'search'),
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
			'countryCode0' => array(self::BELONGS_TO, 'Country', 'countryCode'),
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'shippingaddressId' => 'Shippingaddress',
			'userId' => 'User',
			'nickname' => 'Nickname',
			'name' => 'Name',
			'address1' => 'Address1',
			'address2' => 'Address2',
			'city' => 'City',
			'state' => 'State',
			'country' => 'Country',
			'zipcode' => 'Zipcode',
			'phone' => 'Phone',
			'countryCode' => 'Country Code',
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

		$criteria->compare('shippingaddressId',$this->shippingaddressId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('countryCode',$this->countryCode);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Shippingaddresses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
