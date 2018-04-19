<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','View').' '.Yii::t('admin','Products'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Product').' '.Yii::t('admin','Details'); ?> </div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				<?php
				/* @var $this ReportitemController */
				/* @var $model Reportproducts */

				$this->breadcrumbs=array(
	'Products'=>array('index'),
				$model->name,
				);

				$this->menu=array(
				array('label'=>'List Products', 'url'=>array('index')),
				array('label'=>'Create Products', 'url'=>array('create')),
				array('label'=>'Update Products', 'url'=>array('update', 'id'=>$model->productId)),
				array('label'=>'Delete Products', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->productId),'confirm'=>'Are you sure you want to delete this item?')),
				array('label'=>'Manage Products', 'url'=>array('admin')),
				);
				?>


				<?php $options = json_decode($model->sizeOptions,true);
				if(isset($options) && !empty($options)){
					$jsOptions = "";$output = "";
					$output .= '<div class="option">';
					$output .= '<input class="disp-size" readonly = "true" type="text" style="width: 100px; margin-right: 4px;" name="Products[productOptions]" value="Option" >';
					$output .= '<input class="disp-qty" readonly = "true"  type="text" maxlength="3" style="width: 100px; margin-right: 4px;" name="Products[productOptions]" value="Quantity" >';
					$output .= '<input class="disp-price" readonly = "true"  type="text" maxlength="9" style="width: 100px; margin-right: 4px;" name="Products[productOptions]" value="Price" >';
					foreach($options as $option){
						$output .= '<div class="option-'.$option['option'].'">';
						$output .= '<input class="disp-size" readonly = "true" type="text" style="width: 100px; margin-right: 4px;" name="Products[productOptions]['.$option['option'].'][option]" value="'.$option['option'].'" >';
						$output .= '<input class="disp-qty" readonly = "true"  type="text" maxlength="3" style="width: 100px; margin-right: 4px;" name="Products[productOptions]['.$option['option'].'][quantity]" value="'.$option['quantity'].'" >';
						$output .= '<input class="disp-price" readonly = "true"  type="text" maxlength="9" style="width: 100px; margin-right: 4px;" name="Products[productOptions]['.$option['option'].'][price]" value="'.$option['price'].'" >';
						if($jsOptions == ""){
							$jsOptions .= '"'.$option['option'].'"';
						}else{
							$jsOptions .= ',"'.$option['option'].'"';
						}
					}
					echo "<script type='text/javascript'> globalSize= [".$jsOptions."]; </script>";
				}
				$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'productId',
				array('name' => 'userId','value' => Myclass::getUserDetails($model->userId)->name),
		'name',
		'description',
				array('name' => 'category','value' => Myclass::getCatName($model->category)),
				array('name' => 'subCategory','value' => Myclass::getCatName($model->subCategory)),
				array('name' => 'price','value' => Myclass::getCurrency($model->currency).' '.$model->price),
		'quantity',
		'productCondition',
				array('name' => 'createdDate','value' => date('d-m-Y',$model->createdDate)),
		'likes',
		'views',
				array('name' => 'chatAndBuy','value' => ($model->chatAndBuy == 1) ? Yii::t('admin','Enabled') : Yii::t('admin','Disabled')),
				array('name' => 'exchangeToBuy','value' => ($model->exchangeToBuy == 1) ? Yii::t('admin','Enabled') : Yii::t('admin','Disabled')),
				array('name' => 'instantBuy','value' => ($model->instantBuy == 1) ? Yii::t('admin','Enabled') : Yii::t('admin','Disabled')),
				array('name' => 'paypalid','value' => ($model->paypalid == '') ? 'NIL' :$model->paypalid ),
				),
				)); ?>
					<table id="yw0" class="detail-view">
						<tbody>
							<tr class="even">
								<th><?php echo Yii::t('admin','Size Options'); ?></th>
								<td><?php if(!empty($model->sizeOptions)) { ?> <?php echo $output; ?>

								<?php } else { echo Yii::t('admin','Not Set'); } ?></td>
							</tr>
						</tbody>
					</table>

				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
