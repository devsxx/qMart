<?php

/**
 * This is the model class for table "hts_currencies".
 *
 * The followings are the available columns in table 'hts_currencies':
 * @property integer $id
 * @property string $currency_name
 * @property string $currency_shortcode
 * @property string $currency_image
 */
class Currencies extends CActiveRecord
{
	private $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_currencies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('currency_name, currency_shortcode,currency_shortcode,currency_symbol', 'required'),
		array('currency_name, currency_shortcode, currency_image', 'length', 'max'=>255),
		array('currency_shortcode', 'ext.UniqueAttributesValidator','with'=>'currency_name,currency_symbol'),
		//array('currency_symbol','match','pattern' => '/\\p{Sc}/','message'=> 'Invalid Currency Symbol'),
		array('currency_image', 'file','types'=>'jpg, gif, png,jpeg', 'allowEmpty'=>true),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, currency_name, currency_shortcode,priority, currency_image', 'safe', 'on'=>'search'),
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
			'currency_name' => Yii::t('admin','Name'),
			'currency_shortcode' => Yii::t('admin','Shortcode'),
			'currency_symbol' => Yii::t('admin','Symbol'),
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
		$criteria->compare('currency_name',$this->currency_name,true);
		$criteria->compare('currency_shortcode',$this->currency_shortcode,true);
		$criteria->compare('currency_symbol',$this->currency_symbol,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		 'sort'=>array(
               'defaultOrder'=>'id DESC',
		)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Currencies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
