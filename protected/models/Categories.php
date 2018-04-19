<?php

/**
 * This is the model class for table "hts_categories".
 *
 * The followings are the available columns in table 'hts_categories':
 * @property integer $categoryId
 * @property string $name
 * @property integer $parentCategory
 * @property integer $createdDate
 * @property string $categoryProperty
 *
 * The followings are the available model relations:
 * @property Products[] $products
 * @property Products[] $products1
 */
class Categories extends CActiveRecord
{
	public $catImage;
	public $itemCondition;
	public $exchangetoBuy;
	public $buyNow;
	public $myOffer;
	public $contactSeller;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		//array('name','unique'),
		array('name','required'),
		array('parentCategory', 'numerical', 'integerOnly'=>true),
		array('name','match','pattern'=>'/^[\p{L}\p{N} .-]+$/u','message'=>'Special Characters not allowed'),
		array('name,slug', 'length', 'max'=>30),
		//array('image','file','types'=>'jpg,gif,png,bmp,jpeg','allowEmpty'=>try),
		//array('image','file','types'=>'jpg,gif,png,bmp,jpeg', 'allowEmpty'=>false,'on'=>'update'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('categoryId, name, parentCategory, createdDate', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Products', 'category'),
			'products1' => array(self::HAS_MANY, 'Products', 'subCategory'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'categoryId' => Yii::t('admin','Category'),
			'name' => Yii::t('admin','Name'),
			'parentCategory' => Yii::t('admin','Parent Category'),
			'createdDate' => Yii::t('admin','Created Date'),
		    'image' => Yii::t('admin','Image'),
			'itemCondition' => Yii::t('admin','Enable').' '.Yii::t('admin','Item').' '.Yii::t('admin','Condition').' ',
			'exchangetoBuy' => Yii::t('admin','Enable').' '.Yii::t('admin','Exchange').' '.Yii::t('admin','Buy'),
			'buyNow' => Yii::t('admin','Enable').' '.Yii::t('admin','Buy Now'),
			'contactSeller' => Yii::t('admin','Enable').' '.Yii::t('admin','Contact').' '.Yii::t('admin','Seller'),
			'myOffer' => Yii::t('admin','Enable').' '.Yii::t('admin','My').' '.Yii::t('admin','Offer'),
		);
	}
	function getModDate()
	{
		if ($this->createdDate===null)
		return;

		return date("d-m-Y",strtotime($this->createdDate));
	}
	function getCatName() {
		if($this->parentCategory == 0) {
			return 'NIL';
		} else {
			$cat = Categories::model()->findByPk($this->parentCategory)->name;
			return $cat;
		}
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

		$criteria->compare('categoryId',$this->categoryId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parentCategory',$this->parentCategory);
		$criteria->compare("DATE_FORMAT(`createdDate`, '%d-%m-%Y')",$this->createdDate,true);
		/*if(!empty($this->createdDate))
		 $criteria->condition = "DATE_FORMAT(`createdDate`, '%d-%m-%Y') = '$this->createdDate'";
		 else
		 $criteria->compare('createdDate',$this->createdDate); */
		//$criteria->order = 'categoryId DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		    'sort'=>array(
               'defaultOrder'=>'createdDate DESC',
		)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function beforeValidate() {
		$this->createdDate = new CDbExpression('NOW()');
		$this->slug = Myclass::productSlug($this->name);
		if(is_null($this->parentCategory)) {
			$this->parentCategory = '0';
		}
		return parent::beforeValidate();
	}
	public function beforeSave() {
		$this->slug = Myclass::productSlug($this->name);
		$this->slug = str_replace(' ', '',$this->slug);
		if(is_null($this->parentCategory)) {
			$this->parentCategory = '0';
		}
		return parent::beforeSave();
	}
}
