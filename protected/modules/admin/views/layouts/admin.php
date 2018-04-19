<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="language" content="en">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Begin CSS here -->
	<?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
	$cs->registerCssFile($baseUrl.'/css/plugins/metisMenu/metisMenu.min.css');
	$cs->registerCssFile($baseUrl.'/css/sb-admin-2.css');
	$cs->registerCssFile($baseUrl.'/css/plugins/morris.css');
	$cs->registerCssFile($baseUrl.'/css/plugins/timeline.css');
	$cs->registerCssFile($baseUrl.'/font-awesome-4.1.0/css/font-awesome.min.css');
	?>
	<!-- Ends CSS here -->
	<!-- Begin Javascript files here -->
    <?php 
    Yii::app()->clientScript->registerCoreScript('jquery');
    $cs->registerScriptFile($baseUrl.'/js/jquery-1.11.0.js');
    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
    $cs->registerScriptFile($baseUrl.'/js/plugins/metisMenu/metisMenu.min.js');
    $cs->registerScriptFile($baseUrl.'/js/plugins/morris/raphael.min.js');
    $cs->registerScriptFile($baseUrl.'/js/plugins/morris/morris.min.js');
    $cs->registerScriptFile($baseUrl.'/js/plugins/morris/morris-data.js');
    $cs->registerScriptFile($baseUrl.'/js/sb-admin-2.js');
    ?>
    <!-- Ends Javascript files here -->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<?php echo $content; ?>

	<div class="clear"></div>

</div><!-- page -->

</body>
</html>
