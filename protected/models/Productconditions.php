<?php

/**
 * This is the model class for table "hts_productconditions".
 *
 * The followings are the available columns in table 'hts_productconditions':
 * @property integer $id
 * @property string $condition
 * @property integer $status
 */
class Productconditions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_productconditions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('condition', 'required'),
		array('id', 'numerical', 'integerOnly'=>true),
		array('condition','unique'),
		array('condition', 'length', 'max'=>30),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, condition', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('admin','ID'),
			'condition' => Yii::t('admin','Product Conditions'),
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.condition',$this->condition,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			    'pagination'=>array(
                'pageSize'=>10,
		),
		'sort'=>array(
               'defaultOrder'=>'id DESC',
		)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Productconditions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
