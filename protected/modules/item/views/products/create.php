<?php
/* @var $this ProductsController */
/* @var $model Products */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Products', 'url'=>array('index')),
array('label'=>'Manage Products', 'url'=>array('admin')),
);
?>
	<!-- <h1 class="add-head-container fa fa-2x fa-plus-square-o"> 
		<?php echo Yii::t('app','Create A Sale'); ?>
	</h1> -->

	<?php $this->renderPartial('_form', array('model'=>$model,
		'parentCategory'=>$parentCategory,'subCategory'=>$subCategory,'photos' => $photos, 
		'shippingTime' => $shippingTime, 'countryModel' => $countryModel,'topCurs' => $topCurs,
		'currencies' => $currencies, 'promotionCurrency'=>$promotionCurrency,
		'urgentPrice'=>$urgentPrice, 'promotionDetails'=>$promotionDetails, 
		'geoLocationDetails' => $geoLocationDetails)); ?>


