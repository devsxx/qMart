<?php

/**
 * This is the model class for table "hts_exchanges".
 *
 * The followings are the available columns in table 'hts_exchanges':
 * @property integer $id
 * @property integer $requestFrom
 * @property integer $requestTo
 * @property integer $mainProductId
 * @property integer $exchangeProductId
 * @property integer $status
 * @property string $date
 * @property string $slug
 * @property string $exchangeHistory
 * @property integer $reviewFlagSender
 * @property integer $reviewFlagReceiver
 */
class Exchanges extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_exchanges';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('requestFrom, requestTo, mainProductId, exchangeProductId, status, date', 'required'),
		array('requestFrom, requestTo, mainProductId, exchangeProductId, status', 'numerical', 'integerOnly'=>true),
		array('slug','unique'),
		//array('mainProductId', 'ext.UniqueAttributesValidator','with'=>'exchangeProductId'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, requestFrom, requestTo, mainProductId, exchangeProductId, status, date', 'safe', 'on'=>'search'),
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
			'exchangeproduct' => array(self::BELONGS_TO, 'Products', 'exchangeProductId'),
			'mainproduct' => array(self::BELONGS_TO, 'Products', 'mainProductId'),
			'requestfrom' => array(self::BELONGS_TO, 'Users', 'requestFrom'),
			'requestto' => array(self::BELONGS_TO, 'Users', 'requestTo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'requestFrom' => 'Request From',
			'requestTo' => 'Request To',
			'mainProductId' => 'Main Product',
			'exchangeProductId' => 'Exchange Product',
			'status' => 'Status',
			'date' => 'Date',
			'slug' => 'Slug',
			'exchangeHistory' => 'Exchange History',
			'reviewFlagSender' => 'Review Flag Sender',
			'reviewFlagReceiver' => 'Review Flag Receiver',
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
		$criteria->compare('requestFrom',$this->requestFrom);
		$criteria->compare('requestTo',$this->requestTo);
		$criteria->compare('mainProductId',$this->mainProductId);
		$criteria->compare('exchangeProductId',$this->exchangeProductId);
		$criteria->compare('status',$this->status);
		$criteria->compare('date',$this->date);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('exchangeHistory',$this->exchangeHistory,true);
		$criteria->compare('reviewFlagSender',$this->reviewFlagSender);
		$criteria->compare('reviewFlagReceiver',$this->reviewFlagReceiver);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Exchanges the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
