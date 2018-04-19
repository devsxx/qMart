<?php

/**
 * This is the model class for table "hts_commissions".
 *
 * The followings are the available columns in table 'hts_commissions':
 * @property integer $id
 * @property string $percentage
 * @property string $minRate
 * @property string $maxRate
 * @property integer $status
 * @property integer $date
 */
class Commissions extends CActiveRecord
{
	const ACTIVE = 1;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_commissions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('percentage, minRate, maxRate', 'required'),
		array('id, status, date', 'numerical', 'integerOnly'=>true),
		array('percentage, minRate, maxRate', 'length', 'max'=>25),
		array('percentage','checkValue'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, percentage, minRate, maxRate, status, date', 'safe', 'on'=>'search'),
		);
	}
	public function checkValue($attribute) {
		if($this->percentage < 1 || $this->percentage > 100) {
			$this->addError('percentage','Commission percentage should be between 1% to 100%.');
		}
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
			'percentage' => Yii::t('admin','Commission Amount In Percentage'),
			'minRate' => Yii::t('admin','Minimum Range'),
			'maxRate' => Yii::t('admin','Maximum Range'),
			'status' => Yii::t('admin','Status'),
			'date' => Yii::t('admin','Date'),
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
		$criteria->compare('percentage',$this->percentage,true);
		$criteria->compare('minRate',$this->minRate,true);
		$criteria->compare('maxRate',$this->maxRate,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date',$this->date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Commissions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeValidate() {
		if($this->isNewRecord) {
			$this->date = time();
			$this->status = self::ACTIVE;
		}
		return parent::beforeValidate();
	}
}
