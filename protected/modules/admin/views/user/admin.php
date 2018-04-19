<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
			<?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Users'); ?>
			</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				<?php echo Yii::t('admin','Users').' '.Yii::t('admin','List'); ?>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				
				<?php
$enableJs = 'js:function(__event)
{
    __event.preventDefault(); // disable default action

    var $this = $(this), // link/button
        confirm_message = $this.data("confirm"), // read confirmation message from custom attribute
        url = $this.attr("href"); // read AJAX URL with parameters from HREF attribute on the link
		//alert(url);
		
		//if(confirm(\' <?php echo Yii::t("admin","Are you sure you want to disable this user?"); ?>\')){
		if(confirm("Are you sure you want to disable this user?")){
		
			  $.ajax({
			            url : url ,
			            type : "POST",
			            success : function(data) {
							console.log("Success:", data);
			            	 jQuery("#users-grid").yiiGridView("update");  
								if(data != ""){
									 alert(data);
								}
			             }
			        });
			        return false;
		}
}';
				
				$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'htmlOptions' => array('class' => 'table-responsive'),
	'columns'=>array(
				array('name' => 'userId','filterHtmlOptions' => array('class' => 'small-input')),
				array('name' => 'username','htmlOptions' => array('class' => 'medium-input')),
				array('name' => 'name','htmlOptions' => array('class' => 'medium-input')),
				array('name' => 'email','htmlOptions' => array('class' => 'medium-input')),
				array(
			    'class'=>'CButtonColumn',
				'header' => Yii::t('admin','Manage'),
                 'template' => '{enable} {disable} {resend}', 
				'buttons'=>array
				(
				'enable' => array
				(
            'label'=> Yii::t('admin','Enable'),
            'url'=> 'Yii::app()->createAbsoluteUrl("admin/user/manage",array("status" => 1,"id"=>$data->userId))',
            'visible'=>'($data->activationStatus == 1 && $data->userstatus == 0)',
			'options' => array(
                        'class' => "manage btn btn-sm btn-success",
				        'id' => 'enable',
				),
				),
				'disable' => array
				(
             'label'=>Yii::t('admin','Disable'),
             'url'=>'Yii::app()->createAbsoluteUrl("admin/user/manage",array("status" => 2,"id"=>$data->userId))',
             'visible'=>'(($data->activationStatus == 1 && $data->userstatus == 1))',
				'options' => array(
                        'class' => "manage btn btn-sm btn-warning",
						'id' => 'disable',
				
				),
						'click'   => $enableJs,
				),
              'resend' => array
				(
             'label'=>Yii::t('admin','Resend'),
             'url'=>'Yii::app()->createAbsoluteUrl("admin/user/manage",array("status" => 3,"id"=>$data->userId))',
             'visible'=>'(($data->activationStatus == 0 && $data->userstatus == 0) || ($data->activationStatus == 0 && $data->userstatus == 1))',
				'options' => array(
                        'class' => "manage btn btn-sm btn-info",
				         'id' => 'resend',
				),
				),
				),
				),
				//array('name' => 'country', 'filter' => false),
				array(
			    'class'=>'CButtonColumn',
				'header' => Yii::t('admin','Action'),
				'buttons'=>array(
				    'delete'=>array(
					'visible'=>'false',
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
</div>
<script type='text/javascript'>
jQuery('#users-grid a.manage').live('click',function() {
        var label = $(this).attr('id');
       /* if(label == 'disable') {
            if(!confirm('<?php echo Yii::t("admin","Are you sure you want to disable this user?"); ?>')) return false;
        } else */ if(label == 'enable') {
            if(!confirm('<?php echo Yii::t("admin","Are you sure you want to enable this user?"); ?>')) return false;
        } else if(label == 'resend'){
            if(!confirm('<?php echo Yii::t("admin","Are you sure you want to resend the verification mail?"); ?>')) return false;
        }
        var url = $(this).attr('href');
        if(label == 'enable'  ||  label == 'resend') {
        $.ajax({
            url : url ,
            type : 'POST',
             success : function(data) {
            	 jQuery('#users-grid').yiiGridView('update');  
             }
        });
        return false;
        }
});

</script>
