<?php
/* @var $this ProductsController */
/* @var $model Products */

$this->breadcrumbs=array(
	'Products'=>array('index'),
$model->name=>array('view','id'=>$model->productId),
	'Update',
);

$this->menu=array(
array('label'=>'List Products', 'url'=>array('index')),
array('label'=>'Create Products', 'url'=>array('create')),
array('label'=>'View Products', 'url'=>array('view', 'id'=>$model->productId)),
array('label'=>'Manage Products', 'url'=>array('admin')),
);
?>

<!-- <h1 class="add-head-container fa fa-pencil fa-2x">
	<?php echo Yii::t('app','Edit sale'); ?>
</h1> -->

	<?php $this->renderPartial('_form', array('model'=>$model,
		'parentCategory'=>$parentCategory,'subCategory'=>$subCategory,'photos' => $photos,
		'options'=>$options, 'shippingTime' => $shippingTime, 'countryModel' => $countryModel, 
		'itemShipping' => $itemShipping,'shippingCountry'=>$shippingCountry, 
		'jsShippingDetails' => $jsShippingDetails,'topCurs' => $topCurs,'currencies' => $currencies)); ?>