<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','View').' '.Yii::t('admin','Users'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','User').' '.Yii::t('admin','Details'); ?></div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				<?php
				/* @var $this UserController */
				/* @var $model Users */

				$this->breadcrumbs=array(
	'Users'=>array('index'),
				$model->name,
				);

				$this->menu=array(
				array('label'=>'List Users', 'url'=>array('index')),
				array('label'=>'Create Users', 'url'=>array('create')),
				array('label'=>'Update Users', 'url'=>array('update', 'id'=>$model->userId)),
				array('label'=>'Delete Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->userId),'confirm'=>'Are you sure you want to delete this item?')),
				array('label'=>'Manage Users', 'url'=>array('admin')),
				);
				?>

					

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'userId',
		'username',
		'name',
		//array('name'=>'password','value' => base64_decode($model->password)),
		'email',
		array(
			'name'=>'fbdetails',
			'type'=>'raw',
			'value'=> $model->generateFbdtails(),
			),
		),
	)); 
					?>