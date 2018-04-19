<?php

/**
 * This is the model class for table "hts_chats".
 *
 * The followings are the available columns in table 'hts_chats':
 * @property integer $chatId
 * @property integer $user1
 * @property integer $user2
 * @property string $lastMessage
 * @property integer $lastToRead
 * @property integer $lastContacted
 */
class Chats extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_chats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user1, user2, lastMessage, lastToRead, lastContacted', 'required'),
			array('user1, user2, lastToRead, lastContacted', 'numerical', 'integerOnly'=>true),
			array('lastMessage', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('chatId, user1, user2, lastMessage, lastToRead, lastContacted', 'safe', 'on'=>'search'),
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
			'chatId' => 'Chat',
			'user1' => 'User1',
			'user2' => 'User2',
			'lastMessage' => 'Last Message',
			'lastToRead' => 'Last To Read',
			'lastContacted' => 'Last Contacted',
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

		$criteria->compare('chatId',$this->chatId);
		$criteria->compare('user1',$this->user1);
		$criteria->compare('user2',$this->user2);
		$criteria->compare('lastMessage',$this->lastMessage,true);
		$criteria->compare('lastToRead',$this->lastToRead);
		$criteria->compare('lastContacted',$this->lastContacted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Chats the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
