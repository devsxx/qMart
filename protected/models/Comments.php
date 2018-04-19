<?php

/**
 * This is the model class for table "hts_comments".
 *
 * The followings are the available columns in table 'hts_comments':
 * @property integer $commentId
 * @property integer $userId
 * @property integer $productId
 * @property string $comment
 * @property integer $createdDate
 *
 * The followings are the available model relations:
 * @property Products $product
 * @property Users $user
 */
class Comments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comment', 'required'),
			//array('userId, productId, createdDate', 'numerical', 'integerOnly'=>true),
			array('comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('commentId, userId, productId, comment, createdDate', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Products', 'productId'),
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'commentId' => 'Comment',
			'userId' => 'User',
			'productId' => 'Product',
			'comment' => 'Comment',
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

		$criteria->compare('commentId',$this->commentId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('productId',$this->productId);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('createdDate',$this->createdDate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
