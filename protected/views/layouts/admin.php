<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="language" content="en">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Begin CSS here -->
	<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/core.css'); ?>" rel="stylesheet">
	<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/components.css'); ?>" rel="stylesheet">
	<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/icons.css'); ?>" rel="stylesheet">
	<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/pages.css'); ?>" rel="stylesheet">
	<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/responsive.css'); ?>" rel="stylesheet">
	<?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->getClientScript();

	// $cs->registerCssFile($baseUrl.'/css/admin/bootstrap.min.css');
	// $cs->registerCssFile($baseUrl.'/css/admin/core.css');
	// $cs->registerCssFile($baseUrl.'/css/admin/components.css');
	// $cs->registerCssFile($baseUrl.'/css/admin/icons.css');
	// $cs->registerCssFile($baseUrl.'/css/admin/pages.css');
	// $cs->registerCssFile($baseUrl.'/css/admin/responsive.css');
	?>
	<!-- Ends CSS here -->
	<!-- Begin Javascript files here -->
   
    <!-- Ends Javascript files here -->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <div class="animationload">
        <div class="loader"></div>
    </div>

		<?php echo $content; ?>
<!-- page -->
	 <?php 
    Yii::app()->clientScript->registerCoreScript('jquery');
    // $cs->registerScriptFile($baseUrl.'/js/jquery.min.js');
    // $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
    // $cs->registerScriptFile($baseUrl.'/js/detect.js');
    // $cs->registerScriptFile($baseUrl.'/js/fastclick.js');
    // $cs->registerScriptFile($baseUrl.'/js/jquery.slimscroll.js');
    // $cs->registerScriptFile($baseUrl.'/js/jquery.blockUI.js');
    // $cs->registerScriptFile($baseUrl.'/js/waves.js');
    // $cs->registerScriptFile($baseUrl.'/js/wow.min.js');
    // $cs->registerScriptFile($baseUrl.'/js/jquery.nicescroll.js');
    // $cs->registerScriptFile($baseUrl.'/js/jquery.scrollTo.min.js');
    // $cs->registerScriptFile($baseUrl.'/js/jquery.core.js');
    // $cs->registerScriptFile($baseUrl.'/js/jquery.app.js');
    // $cs->registerScriptFile($baseUrl.'/js/modernizr.min.js');

    ?>
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/detect.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/fastclick.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.slimscroll.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.blockUI.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/waves.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/wow.min.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.nicescroll.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.scrollTo.min.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.core.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.app.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.min.js"></script> 
   

</body>
</html>
