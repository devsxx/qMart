<?php

/**
 * This is the model class for table "hts_logs".
 *
 * The followings are the available columns in table 'hts_logs':
 * @property integer $id
 * @property string $type
 * @property string $notifyto
 * @property integer $sourceid
 * @property integer $itemid
 * @property string $notifymessage
 * @property integer $notification_id
 * @property string $message
 * @property integer $cdate
 */
class Logs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, notifyto, sourceid, notifymessage, notification_id, cdate', 'required'),
			array('sourceid, itemid, notification_id, cdate', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>9),
			array('message', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, notifyto, sourceid, itemid, notifymessage, notification_id, message, cdate', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'notifyto' => 'Notifyto',
			'sourceid' => 'Sourceid',
			'itemid' => 'Itemid',
			'notifymessage' => 'Notifymessage',
			'notification_id' => 'Notification',
			'message' => 'Message',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('notifyto',$this->notifyto,true);
		$criteria->compare('sourceid',$this->sourceid);
		$criteria->compare('itemid',$this->itemid);
		$criteria->compare('notifymessage',$this->notifymessage,true);
		$criteria->compare('notification_id',$this->notification_id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('cdate',$this->cdate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Logs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
