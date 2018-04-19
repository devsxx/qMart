<?php

/**
 * This is the model class for table "hts_products".
 *
 * The followings are the available columns in table 'hts_products':
 * @property integer $productId
 * @property integer $userId
 * @property string $name
 * @property string $description
 * @property integer $category
 * @property integer $subCategory
 * @property integer $price
 * @property integer $quantity
 * @property string $sizeOptions
 * @property string $productCondition
 * @property string $paymentTypes
 * @property integer $createdDate
 * @property integer $likeCount
 * @property integer $commentCount
 *
 * The followings are the available model relations:
 * @property Comments[] $comments
 * @property Orderitems[] $orderitems
 * @property Categories $category0
 * @property Categories $subCategory0
 * @property Users $user
 */
class Products extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hts_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price, quantity, name, productCondition, category, subCategory, description, paymentTypes', 'required'),
			array('price, quantity', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('productCondition', 'length', 'max'=>13),
			array('description, sizeOptions, paymentTypes', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('productId, userId, name, description, category, subCategory, price, quantity, sizeOptions, productCondition, paymentTypes, createdDate, likeCount, commentCount', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comments', 'productId'),
			'orderitems' => array(self::HAS_MANY, 'Orderitems', 'productId'),
			'category0' => array(self::BELONGS_TO, 'Categories', 'category'),
			'subCategory0' => array(self::BELONGS_TO, 'Categories', 'subCategory'),
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'productId' => 'Product',
			'userId' => 'User',
			'name' => 'Name',
			'description' => 'Description',
			'category' => 'Category',
			'subCategory' => 'Sub Category',
			'price' => 'Price',
			'quantity' => 'Quantity',
			'sizeOptions' => 'Size Options',
			'productCondition' => 'Product Condition',
			'paymentTypes' => 'Payment Types',
			'createdDate' => 'Created Date',
			'likeCount' => 'Like Count',
			'commentCount' => 'Comment Count',
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

		$criteria->compare('productId',$this->productId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('name',$this->name,true);
		/* $criteria->compare('description',$this->description,true);
		$criteria->compare('category',$this->category);
		$criteria->compare('subCategory',$this->subCategory); */
		$criteria->compare('price',$this->price);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('sizeOptions',$this->sizeOptions,true);
		$criteria->compare('productCondition',$this->productCondition,true);
		$criteria->compare('paymentTypes',$this->paymentTypes,true);
		/* $criteria->compare('createdDate',$this->createdDate);
		$criteria->compare('likeCount',$this->likeCount);
		$criteria->compare('commentCount',$this->commentCount); */

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Products the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function afterSave( ) {
		$this->addImages( );
		parent::afterSave( );
	}
	
	public function addImages( ) {
		//If we have pending images
		if( Yii::app( )->user->hasState( 'images' ) ) {
			$userImages = Yii::app( )->user->getState( 'images' );
			//Resolve the final path for our images
			$path = Yii::app( )->getBasePath( )."/../media/item/{$this->productId}/";
			//Create the folder and give permissions if it doesnt exists
			if( !is_dir( $path ) ) {
				mkdir( $path );
				chmod( $path, 0777 );
			}
	
			//Now lets create the corresponding models and move the files
			foreach( $userImages as $image ) {
				if( is_file( $image["path"] ) ) {
					if( rename( $image["path"], $path.$image["filename"] ) ) {
						chmod( $path.$image["filename"], 0777 );
						$img = new Photos( );
						//$img->size = $image["size"];
						//$img->mime = $image["mime"];
						$img->name = $image["filename"];
						//$img->source = "/media/item/{$this->productId}/".$image["filename"];
						$img->productId = $this->productId;
						$img->createdDate = time();
						if( !$img->save( ) ) {
							//Its always good to log something
							Yii::log( "Could not save Image:\n".CVarDumper::dumpAsString(
									$img->getErrors( ) ), CLogger::LEVEL_ERROR );
							//this exception will rollback the transaction
							throw new Exception( 'Could not save Image');
						}
					}
				} else {
					//You can also throw an execption here to rollback the transaction
					Yii::log( $image["path"]." is not a file", CLogger::LEVEL_WARNING );
				}
			}
			//Clear the user's session
			Yii::app( )->user->setState( 'images', null );
		}
	}
}
