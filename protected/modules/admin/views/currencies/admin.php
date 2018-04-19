<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Currencies'); ?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Yii::t('admin','Currencies').' '.Yii::t('admin','List'); ?></div>
				<!-- /.panel-heading -->
				<?php
				/* $flashMessages = Yii::app()->user->getFlashes();
				 if ($flashMessages) {
					echo '<ul class="flashes">';
					foreach($flashMessages as $key => $message) {
					echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
					}
					echo '</ul>';
					} */
				?>
				<div class="panel-body">


				<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'currencies-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'columns'=>array(
				array('name' =>'currency_name','filterHtmlOptions' => array('class' => 'small-input')),
		
		 array('name' =>'currency_shortcode','filterHtmlOptions' => array('class' => 'small-input')),
        array('name' =>'currency_symbol','filterHtmlOptions' => array('class' => 'small-input')),
				array(
			'class'=>'CButtonColumn', 
			'header' => Yii::t('admin','Action'),
			'template'=>'{update}{view}{delete}',
			'buttons' => array(
				'delete' => array(
	            	'visible'=>"'$deleteStatus'",
				),
				'view' => array(
		            'visible'=>'true',
	        	),
				'update' => array(
		            'visible'=>'true',
	        	),
        	),
			'afterDelete'=>'function(link,success,data){ if(success) {$(".userinfo").html(data); setTimeout(function() { $(".userinfo").fadeOut(); },3000); } }',
				),
				),
				)); ?>

				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->