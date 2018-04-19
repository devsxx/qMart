<?php

/**
 * This is the model class for table "hts_userdevices".
 *
 * The followings are the available columns in table 'hts_userdevices':
 * @property integer $id
 * @property string $deviceToken
 * @property integer $user_id
 * @property integer $badge
 * @property integer $type
 * @property integer $mode
 * @property integer $cdate
 */
class Userdevices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_userdevices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, mode', 'required'),
			array('user_id, badge, type, mode, cdate', 'numerical', 'integerOnly'=>true),
			array('deviceToken', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, deviceToken, user_id, badge, type, mode, cdate', 'safe', 'on'=>'search'),
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
			'deviceToken' => 'Device Token',
			'user_id' => 'User',
			'badge' => 'Badge',
			'type' => 'Type',
			'mode' => 'Mode',
			'cdate' => 'Cdate',
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
		$criteria->compare('deviceToken',$this->deviceToken,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('badge',$this->badge);
		$criteria->compare('type',$this->type);
		$criteria->compare('mode',$this->mode);
		$criteria->compare('cdate',$this->cdate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Userdevices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
