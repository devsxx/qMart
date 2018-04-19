<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
 	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php $metaInformation = Myclass::getMetaData();//echo "<pre>";print_r($metaInformation); ?>
	<meta name="description"
		content="<?php echo isset($this->fbdescription) ? $this->fbdescription : $metaInformation['description']; ?>" />
	<meta name="keywords" content="<?php echo $metaInformation['metaKeywords']; ?>" />
	
	<meta name="language" content="en">
	
	<!-- For Facebook meta values -->
	<meta property="og:site_name" content="<?php echo $metaInformation['sitename']; ?>"/>
	<?php //if(isset($this->fbtitle)) { ?>
	<meta property="og:title" content="<?php echo isset($this->fbtitle) ? $this->fbtitle : $metaInformation['title']; ?>" />
	<?php //} ?>
	<meta property="og:type" content="products" />
	<meta property="og:url"
		content="<?php echo Yii::app()->request->hostInfo . Yii::app()->request->url; ?>" />
	<?php if(isset($this->fbimg)) { ?>
	<meta property="og:image" content="<?php echo $this->fbimg; ?>" />
	<meta name="twitter:image" content="<?php echo $this->fbimg; ?>">
	<meta itemprop="image" content="<?php echo $this->fbimg; ?>">
	<?php } //if(isset($this->fbdescription)) ?>
	<meta property="og:description"
		content="<?php echo isset($this->fbdescription) ? $this->fbdescription : $metaInformation['description']; ?>" />
		
	<!-- For Twitter meta values -->
	<meta name="twitter:title" content="<?php echo CHtml::encode($this->pageTitle); ?>">
	<meta name="twitter:description" content="<?php echo isset($this->fbdescription) ? $this->fbdescription : $metaInformation['description']; ?>">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="<?php echo $metaInformation['sitename']; ?>">
	
	<!-- For Google+ meta values -->
	<meta itemprop="name" content="<?php echo $metaInformation['sitename']; ?>">
	<meta itemprop="description" content="<?php echo isset($this->fbdescription) ? $this->fbdescription : $metaInformation['description']; ?>">

<?php
if($this->uniqueid != "products" && $this->action->Id != "view"){
	echo '<link href="'.Yii::app()->request->hostInfo . Yii::app()->request->url.'" rel="canonical" />';
}

$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerScript('helpers','
  		yii = {
  		urls: {
		  	base: '.CJSON::encode(Yii::app()->baseUrl).'
		}
	  };',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->getClientScript();
$cs->scriptMap=array(
		'jquery.js'=>false
);

//design integration
$cs->registerScriptFile($baseUrl.'/js/design/salvattore.min.js');
//$cs->registerScriptFile($baseUrl.'/js/design/jquery.js');
$cs->registerScriptFile($baseUrl.'/js/design/jquery.easing.1.3.js');
$cs->registerScriptFile($baseUrl.'/js/design/jquery.magnific-popup.min.js');
//$cs->registerScriptFile($baseUrl.'/js/design/jquery.min.js');
$cs->registerScriptFile($baseUrl.'/js/design/jquery.waypoints.min.js');
$cs->registerScriptFile($baseUrl.'/js/design/modernizr-2.6.2.min.js');
$cs->registerScriptFile($baseUrl.'/js/design/modernizr.js');
$cs->registerScriptFile($baseUrl.'/js/design/respond.min.js');


//$cs->registerScriptFile($baseUrl.'/js/design/jquery.js');
$cs->registerScriptFile($baseUrl.'/js/design/bootstrap.min.js');
//$cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
$cs->registerScriptFile($baseUrl.'/js/front.js');
//$cs->registerScriptFile($baseUrl.'/js/design/bootstrap.js');
//$cs->registerScriptFile($baseUrl.'/js/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js');
//$cs->registerScriptFile($baseUrl.'/js/nodeClient.js');
//$cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
$cs->registerCssFile($baseUrl.'/css/design/bootstrap.min.css');
$cs->registerCssFile($baseUrl.'/css/form.css');
//$cs->registerCssFile($baseUrl.'/css/design/qMart-style.css');
//$cs->registerCssFile($baseUrl.'/css/design/animate.css');
$cs->registerCssFile($baseUrl.'/font-awesome-4.1.0/css/font-awesome.min.css');

//$cs->registerCssFile($baseUrl.'/css/main.css');


//$cs->registerScriptFile($baseUrl.'/js/design/maps.js');
//$cs->registerScriptFile($baseUrl.'/js/design/main.js');


//$cs->registerCssFile($baseUrl.'/css/design/bootstrap.css'); 
/*
$cs->registerCssFile($baseUrl.'/css/design/bootstrap.css.map');*/
//$cs->registerCssFile($baseUrl.'/css/design/bootstrap.min.css'); 
/*
$cs->registerCssFile($baseUrl.'/css/design/bootstrap.min.css.map');
$cs->registerCssFile($baseUrl.'/css/design/bootstrap.theme.css');
$cs->registerCssFile($baseUrl.'/css/design/bootstrap.theme.css.map');
$cs->registerCssFile($baseUrl.'/css/design/bootstrap.theme.min.css.map');
$cs->registerCssFile($baseUrl.'/css/design/bootstrap.theme.min.css');*/
//$cs->registerCssFile($baseUrl.'/css/qMart-style.css');
//$cs->registerCssFile($baseUrl.'/css/animate.css');
?>
 
<!-- <link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print"> 
-->
<!-- blueprint CSS framework
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"> 
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"> 
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css"> 
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->request->baseUrl; ?>/font-awesome-4.1.0/css/font-awesome.min.css"> 
 -->
<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
<![endif]-->


<!-- Bootstrap -->
<link href="<?php echo Yii::app()->createAbsoluteUrl('css/bootstrap.min.css'); ?>" rel="stylesheet">
<!-- <link href="<?php echo Yii::app()->createAbsoluteUrl('css/bootstrap.css'); ?>" rel="stylesheet">
 E O Bootstrap -->	

<!--qMart style -->
<link href="<?php echo Yii::app()->createAbsoluteUrl('css/qMart-style.css'); ?>" rel="stylesheet">


<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.png">

<!-- <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
<script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/front.js"></script> -->
<?php 
$siteSettings = Myclass::getSitesettings();
if(!empty($siteSettings) && isset($siteSettings->googleapikey) && $siteSettings->googleapikey!="")
$googleapikey = "&key=".$siteSettings->googleapikey;
else
$googleapikey = "";
?>
<script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/design/jquery.js"></script> 
<script	src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places<?php echo $googleapikey;?>"></script>
	
<title><?php echo CHtml::encode(isset($this->fbtitle) ? $metaInformation['sitename']." | ".$this->fbtitle : $metaInformation['sitename']." | ".$metaInformation['title']); ?></title>
</head>

<body>
<?php $footerSettings = Myclass::getFooterSettings();?>
<?php $logoDark = Myclass::getLogoDarkVersion(); ?>
<?php $sitePaymentModes = Myclass::getSitePaymentModes();
//echo "<pre>";print_r($sitePaymentModes); die;?>
<?php //if(!empty(Yii::app()->user->id)) {?>
	<!-- mobile Sidebar -->
	<div id="wrapper">        
		<div id="sidebar-wrapper">	
		
			<ul class="nav navbar-nav sidebar-nav">
			<?php  $categorypriority = Myclass::getCategoryPriority();?>
					<li class="qMart-mobile-Category">Category</li>
					<?php foreach($categorypriority as $key => $category): 
						if($category != "empty"){
							//$getcaname =  Myclass::getCatName($category);
							$getcatdet = Myclass::getCatDetails($category);
							$getcatimage = Myclass::getCatImage($category);
							$subCategory = Myclass::getSubCategory($category);
					
					?>
					<li class="dropdown">
					<a class="dropdown-toggle qMart-for-sale disabled" data-toggle="dropdown" href="<?php echo Yii::app()->createAbsoluteUrl('/category/'.$getcatdet->slug); ?>" style="background:url(<?php echo Yii::app()->createAbsoluteUrl('admin/categories/resized/70/'.$getcatimage); ?>) no-repeat scroll left center / 24px auto; " ><?php echo $getcatdet->name; ?></a>
						<?php if(!empty($subCategory)) {?>
						<ul  class="dropdown-menu qMart-dropdown-submenu">
							<?php foreach($subCategory as $key => $subCategory): 
							//echo $key;
									$subCatdet = Myclass::getCatDetails($key);
							?>
							<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/category/'.$getcatdet->slug.'/'.$subCatdet->slug); ?>"><?php echo $subCategory; ?></a></li>
							<?php endforeach;?>
				  		</ul>
				  		<?php }?>
				  	</li>
					<?php } endforeach;?>	
			</ul>
			<?php if(!empty(Yii::app()->user->id)) {?>
			<div class="al-mobile-user-area">
				<a href="<?php echo Yii::app()->createAbsoluteUrl('item/products/create'); ?>" class="qMart-stuff-mob"><?php echo Yii::t('app','Sell your stuff'); ?></a>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles'); ?>" class="qMart-account"><?php echo Yii::t('app','My account'); ?></a>
				<?php if($sitePaymentModes['exchangePaymentMode'] == 1){ ?>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges',array('type' => 'incoming')); ?>" class="qMart-exchange"><?php echo Yii::t('app','My Exchanges'); ?></a>				
				<?php } ?>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('user/logout'); ?>" class="qMart-logout"><?php echo Yii::t('admin','Logout'); ?></a>
			</div>
			<?php }else {?>
			<div class="mobile-user-area">
				<a href="#" data-toggle="modal" data-target="#login-modal" class="qMart-login"><?php echo Yii::t('app','Login'); ?></a>
				<a href="#" data-toggle="modal" data-target="#signup-modal" class="qMart-signup"><?php echo Yii::t('app','Sign up'); ?></a>
			</div>
			<?php }?>
			
		</div> 
		
		
	</div>
  <?php //}?>
	 
	<!-- E o mobile Sidebar -->
	
	<!--Header code-->
	<?php if(!empty(Yii::app()->user->id)) {?>
	<div class="qMart-header">		
		<div class="container">
			<div class="row">
			  <div class="qMart-header-bar col-xs-12 col-sm-12 col-md-12 col-lg-12">
			  
			  	<div class="col-md-5 col-lg-4 no-hor-padding">
					<div class="qMart-header-nav col-md-3 col-lg-3 dropdown">
						<a class="sticky-header-menu-icon dropdown-toggle" data-toggle="dropdown" href="#">
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/nav.png" alt="Message">
						</a>
						<?php  $categorypriority = Myclass::getCategory();
						if(count($categorypriority) > 5) { 
							$scrollbar = '';//'height:205px; overflow-y:scroll;';
						} else {
							$scrollbar = '';
						}
						?>
						<ul id="dropdown-block" class="sticky-header-dropdown dropdown-menu" style="<?php echo $scrollbar; ?>">
							
							<?php foreach($categorypriority as $key => $category): 
								if($category != "empty"){
									//$getcaname =  Myclass::getCatName($category);
									$getcatdet = $category;
									$getcatimage = !empty($category) ? $category->image : "";
									$subCategory = Myclass::getSubCategory($category->categoryId);
							
							?>
							<li>
								<a class="sticky-header-dropdown-height dropdown-toggle qMart-for-sale-sticky" 
									href="<?php echo Yii::app()->createAbsoluteUrl('/category/'.$getcatdet->slug); ?>" 
									 style="background:url(<?php echo Yii::app()->createAbsoluteUrl('admin/categories/resized/70/'.$getcatimage); ?>) no-repeat scroll 10px 9px / 24px auto; ">
									<span><?php echo $getcatdet->name; ?></span>
								</a>
							</li>
							<?php } endforeach;?>
						</ul>
					</div>		
					
					  <div class="qMart-search-bar col-md-9 col-lg-9 no-hor-padding">
						<form role="form" onSubmit="return dosearch();" class="navbar-form- navbar-left- search-form" style="padding-left: 0;"
							action="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>" method="get">
							<input type="text" maxlength="30" placeholder="<?php echo Yii::t('app','Search products'); ?>" class="qMart-search-icon form-control input-search <?php echo !empty(Yii::app()->user->id) ? "" : "sign" ?>" name="search"></input>
						</form>		  
						</div>				 
				</div>
				 <!-- <div class="qMart-search-bar col-md-3 col-lg-3 no-hor-padding form-group search-input-container">
				  <form role="form" class="navbar-form- navbar-left- search-form"
					style="padding-left: 0;"
					action="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"
					method="get">
					<input type="text" maxlength="30" placeholder="<?php echo Yii::t('app','Search products'); ?>" class="qMart-search-icon form-control input-search <?php echo !empty(Yii::app()->user->id) ? "" : "sign" ?>" name="search"></input>
					</form>		  
					</div> -->
				
						<div class="qMart-logo col-xs-5 col-sm-5 col-md-2 col-lg-4 no-hor-padding">
						<?php $logo = Myclass::getLogo();
							  
							echo CHtml::link(CHtml::image(Yii::app()->createAbsoluteUrl('media/logo/'.$logo),"Logo", 
									array('style'=>'')),Yii::app()->createAbsoluteUrl('/')); ?>
							
						<!-- <a href="#"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/qMart-logo.png'); ?>" alt="Menu"></a>-->
						</div>
										
			  
					<div class="qMart-login-user-nav col-xs-7 col-sm-7 col-md-5 col-lg-4 no-hor-padding pull-right">
					  <ul class="navbar-nav">
								<li class="qMart-header-message">
									<a href="<?php echo Yii::app()->createAbsoluteUrl('message'); ?>">
									<img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/message.png'); ?>" alt="Message">
								<?php 
								$messageCount = Myclass::getMessageCount(Yii::app()->user->id); ?>
								<script>
									var liveCount = <?php echo $messageCount; ?>;
								</script>
								<?php 
								$messageStatus = "";
								if($messageCount == 0){
									$messageStatus = "message-hide";
								} 
								?>
								<span class="message-counter message-count <?php echo $messageStatus; ?>"><?php echo $messageCount; ?></span>
								
								</a></li>
								<span class="qMart-header-har-line"></span>	
								<li class="qMart-header-message">
									<a href="<?php echo Yii::app()->createAbsoluteUrl('notification'); ?>">
										<img alt="Notification" src="<?php echo Yii::app()->createAbsoluteUrl('/images/notification.png'); ?>">
										<?php $notificationCount = Myclass::getNotificationCount(Yii::app()->user->id);
											$notificationStatus = "";
											if($notificationCount == 0 || Yii::app()->controller->action->id == 'notification'){
												$notificationStatus = "message-hide";
											} 
											?>
										<span class="message-counter <?php echo $notificationStatus; ?>"><?php echo $notificationCount; ?></span>
									</a>
								</li>
								
								<span class="qMart-header-har-line"></span>							
									<?php 
									$userImage = Myclass::getUserDetails(Yii::app()->user->id);
									if(!empty($userImage->userImage)) {
										$userimg = Yii::app()->createAbsoluteUrl('user/resized/35/'.$userImage->userImage);
										//echo CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/35/'.$userImage->userImage),$userImage->username);
									} else {
										$userimg = Yii::app()->createAbsoluteUrl('user/resized/35/default/'.Myclass::getDefaultUser());
										//echo CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/35/default/'.Myclass::getDefaultUser()),$userImage->username);
									}
									?>
									<li class="dropdown qMart-header-profile">
									  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
									  <span class="qMart-header-profile-img img-responsive" style=" background: rgba(0, 0, 0, 0) url(<?php echo $userimg; ?>) no-repeat scroll 0 0 / cover ;"></span>
										<span class="qMart-header-down-arrow"></span>									  
									  </a>
									  <ul class="dropdown-menu dropdown-submenu">
										<li><a href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles'); ?>"><?php echo Yii::t('app','Profile'); ?></a></li>										
										<li><a href="<?php echo Yii::app()->createAbsoluteUrl('user/promotions',array(
												'id'=>Myclass::safe_b64encode(Yii::app()->user->id.'-'.rand(0,999)))); ?>"><?php echo Yii::t('app','My Promotions'); ?></a></li>
										<?php if($sitePaymentModes['exchangePaymentMode'] == 1){ ?>
										<li><a href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges',array('type' => 'incoming')); ?>"><?php echo Yii::t('app','My Exchanges'); ?></a></li>
										<?php } ?>
										<!-- <li><a href="<?php echo Yii::app()->createAbsoluteUrl('orders'); ?>"><?php echo Yii::t('app','My Orders'); ?></a></li>
										<li><a href="<?php echo Yii::app()->createAbsoluteUrl('sales'); ?>"><?php echo Yii::t('app','My Sales'); ?></a></li>
										<li><a href="<?php echo Yii::app()->createAbsoluteUrl('coupons',array('type' => 'item')); ?>"><?php echo Yii::t('app','Coupons'); ?></a></li>	
										<li><a href="<?php echo Yii::app()->createAbsoluteUrl('shippingaddress'); ?>"><?php echo Yii::t('app','Shipping Addresses'); ?></a></li>
										<li><a href="#">Chat</a></li> -->
										<li class="logout"><a href="<?php echo Yii::app()->createAbsoluteUrl('user/logout'); ?>"><?php echo Yii::t('admin','Logout'); ?></a></li>
									  </ul>
									</li>									
								<li class="qMart-header-stuff"><a class="qMart-camera-icon" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/create'); ?>"><?php echo Yii::t('app','Sell your stuff'); ?></a></li>
					   </ul>
					   <!-- Mobile sidebar Content -->		
							<div id="page-content-wrapper">            
								<a class="col-xs-2 col-sm-1 col-md-1 no-hor-padding" href="#menu-toggle" id="menu-toggle"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/3-line.png'); ?>" alt="Menu"></a>                  
							</div>		
						<!-- /E o Mobile sideba -->							 
					</div>
					
					<!-- /#sidebar-wrapper -->
					
				</div>
			</div>
		</div>			
	</div>	
	

	


	
	<!--Mobile search bar code-->	
	
				 
	<div class="qMart-search-bar-bg">
		<div class="container">
			<div class="app-responsive-adjust"></div>
		
			<div class="qMart-search-bar-mobile col-xs-12 col-sm-12 col-md-12 no-hor-padding form-group search-input-container">
			<form role="form"  class="navbar-form- navbar-left- search-form"
					style="padding-left: 0;"
					action="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"
					method="get">
				<input type="text" maxlength="30" placeholder="<?php echo Yii::t('app','Search products'); ?>" class="qMart-search-icon-mobile  form-control input-search" <?php echo !empty(Yii::app()->user->id) ? "" : "sign" ?>" name="search"></input>
				</form>		  
			</div>
			
		</div>
	</div>
	<!--Mobile search bar code-->     
	
	<div class="qMart-menu">
		<div class="container">
			<div class="row" style="height: 64px;"></div>
			<div class="row">
				<nav class="navbar col-xs-12 col-sm-12 col-md-12">
					<ul class="nav navbar-nav">			
					<?php  $categorypriority = Myclass::getCategoryPriority();?>
					
					<?php foreach($categorypriority as $key => $category): 
						if($category != "empty"){
							//$getcaname =  Myclass::getCatName($category);
							$getcatdet = Myclass::getCatDetails($category);
							$getcatimage = Myclass::getCatImage($category);
							$subCategory = Myclass::getSubCategory($category);
					
					?>
					<li class="dropdown">
					<a class="dropdown-toggle qMart-for-sale disabled" data-toggle="dropdown" href="<?php echo Yii::app()->createAbsoluteUrl('/category/'.$getcatdet->slug); ?>" style="background:url(<?php echo Yii::app()->createAbsoluteUrl('admin/categories/resized/70/'.$getcatimage); ?>) no-repeat scroll left center / 24px auto; " ><?php echo $getcatdet->name; ?></a>
						<?php if(!empty($subCategory)) {?>
						<ul id="dropdown-block" class="dropdown-menu qMart-dropdown-submenu">
							<?php foreach($subCategory as $key => $subCategory): 
							//echo $key;
									$subCatdet = Myclass::getCatDetails($key);
							?>
							<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/category/'.$getcatdet->slug.'/'.$subCatdet->slug); ?>"><?php echo $subCategory; ?></a></li>
							<?php endforeach;?>
				  		</ul>
				  		<?php }?>
				  	</li>
					<?php } endforeach;?>		
									
					</ul>				
				</nav>
			</div>
		</div>
	</div>
	
	
		
	
	
	<?php }else{ ?>
		<!--Header code-->
		<div class="qMart-header">
		<div class="container">
		<div class="row">
		<div class="qMart-header-bar col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-5 col-lg-4 no-hor-padding">
				<div class="qMart-header-nav col-md-3 col-lg-3 dropdown">
					<a class="sticky-header-menu-icon dropdown-toggle" data-toggle="dropdown" href="#">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/nav.png" alt="Message">
					</a>
					<?php  $categorypriority = Myclass::getCategory();
					if(count($categorypriority) > 5) { 
						$scrollbar = '';'height:205px; overflow-y:scroll;';
					} else {
						$scrollbar = '';
					}
					?>
					<ul id="dropdown-block" class="sticky-header-dropdown dropdown-menu" style="<?php echo $scrollbar; ?>">
					
						<?php foreach($categorypriority as $key => $category): 
							if($category != "empty"){
								//$getcaname =  Myclass::getCatName($category);
								$getcatdet = $category;
								$getcatimage = !empty($category) ? $category->image : "";
								$subCategory = Myclass::getSubCategory($category->categoryId);
						
						?>
						<li>
							<a class="sticky-header-dropdown-height dropdown-toggle qMart-for-sale-sticky" 
								href="<?php echo Yii::app()->createAbsoluteUrl('/category/'.$getcatdet->slug); ?>" 
								 style="background:url(<?php echo Yii::app()->createAbsoluteUrl('admin/categories/resized/70/'.$getcatimage); ?>) no-repeat scroll 10px 9px / 24px auto; ">
								<span><?php echo $getcatdet->name; ?></span>
							</a>
						</li>
						<?php } endforeach;?>
					</ul>
				</div>		
				
				  <div class="qMart-search-bar col-md-9 col-lg-9 no-hor-padding">
					<form role="form" onSubmit="return dosearch();" class="navbar-form- navbar-left- search-form" style="padding-left: 0;"
						action="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>" method="get">
						<input type="text" maxlength="30" placeholder="<?php echo Yii::t('app','Search products'); ?>" class="qMart-search-icon form-control input-search <?php echo !empty(Yii::app()->user->id) ? "" : "sign" ?>" name="search"></input>
					</form>		  
					</div>				 
			</div>
				  <!-- <div class="qMart-search-bar col-md-3 col-lg-3 no-hor-padding form-group search-input-container">
				  <form role="form" class="navbar-form- navbar-left- search-form"
					style="padding-left: 0;"
					action="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"
					method="get">
					<input type="text" maxlength="30" placeholder="<?php echo Yii::t('app','Search products'); ?>" class="qMart-search-icon form-control input-search <?php echo !empty(Yii::app()->user->id) ? "" : "sign" ?>" name="search"></input>
					</form>		  
					</div>	 -->
				
		
		<div class="qMart-logo col-xs-5 col-sm-5 col-md-2 col-lg-4 no-hor-padding">
		<?php $logo = Myclass::getLogo();
			echo CHtml::link(CHtml::image(Yii::app()->createAbsoluteUrl('media/logo/'.$logo),"Logo", 
					array('style'=>'')),Yii::app()->createAbsoluteUrl('/')); ?>
			
		<!-- <a href="#"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/qMart-logo.png'); ?>" alt="Menu"></a>-->
		</div>
		
			
		<div class="qMart-user-nav col-sm-3 col-md-5 col-lg-3 no-hor-padding">
		<ul class="navbar-nav pull-right">
		<?php if((Yii::app()->controller->action->id != 'login') && (Yii::app()->controller->action->id != 'signup') && (Yii::app()->controller->action->id != 'forgotpassword') && (Yii::app()->controller->action->id != 'socialLogin')){  ?>
		<li class="qMart-header-login"><a href="#login-modal" data-toggle="modal" data-target="#login-modal" id="qMart-login"><?php echo Yii::t('app','Login'); ?></a></li>
		<li class="qMart-header-signup"><a href="#" data-toggle="modal" data-target="#signup-modal"><?php echo Yii::t('app','Sign up'); ?></a></li>
		<?php } ?>
		<li class="qMart-header-stuff"><a class="qMart-camera-icon" href="<?php echo Yii::app()->createAbsoluteUrl('item/products/create'); ?>"><?php echo Yii::t('app','Sell your stuff'); ?></a></li>
		</ul>
		</div>
		<!-- /#sidebar-wrapper --><!-- Mobile sidebar Content -->
		<div id="page-content-wrapper pull-right open-overlay">
		<a class="col-xs-1 col-sm-1 col-md-1 no-hor-padding" href="#menu-toggle" id="menu-toggle"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/3-line.png'); ?>" alt="Menu"></a>
		</div>
		<!-- /E o Mobile sideba -->
			
			
		</div>
		</div>
		</div>
		</div>
		
		<?php if((Yii::app()->controller->action->id != 'login') && (Yii::app()->controller->action->id != 'signup') && (Yii::app()->controller->action->id != 'socialLogin') && (Yii::app()->controller->action->id != 'forgotpassword')){  ?>
		<!--Login modal-->
		
		<div class="modal fade" id="login-modal" role="dialog">
		<div class="modal-dialog modal-dialog-width">
		<div class="login-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<h2 class="login-header-text"><?php echo Yii::t('app','Login to '.Myclass::getSiteName()); ?></h2>
		<button data-dismiss="modal" class="close login-close" type="button">×</button>
		<p class="login-sub-header-text"><?php echo Yii::t('app','Signup or login to explore the great things available near you'); ?></p>
		</div>
		
		<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
			
		<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
			<div class="login-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="login-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					
					 <?php 
				         $model=new LoginForm();
				         $socialLogin = Myclass::getsocialLoginDetails();
	                     /*$siteSettingsModel = Sitesettings::model()->findByAttributes(array('id'=>1));
	                     $socialLogin = json_decode($siteSettingsModel->socialLoginDetails, true);*/
	                   $form=$this->beginWidget('CActiveForm', array(
	                                  'id'=>'login-form',
	                                 'action'=>Yii::app()->request->baseUrl.'/login', 
	                                'enableAjaxValidation'=>true,
	                               'enableClientValidation'=>true,
	                           'clientOptions'=>array(
	                           		'validateOnSubmit'=>true,
	                           		'validateOnChange'=>false,
	                           		),
	                           		'htmlOptions' => array(
	                           				'onSubmit' => 'return validsigninfrm()',
	                           		),
	                           							)); ?>
		
					
					<?php echo $form->textField($model,'username',array('class'=>'popup-input', 'placeholder'=>Yii::t('app','Enter your email address'))); ?>
					<?php echo $form->error($model,'username'); ?>
					<?php echo $form->passwordField($model,'password',array('class'=>'popup-input', 'placeholder'=>Yii::t('app','Enter your password'))); ?>
					<?php echo $form->error($model,'password'); ?>
				
				
				<?php echo CHtml::submitButton(Yii::t('app','Login'), array('class'=>'col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding login-btn')); ?>
				
			
			<div class="remember-pwd col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
				<div class="checkbox remember-me-checkbox ">
					<label><input type="checkbox" class="remember-me-checkbox cust_checkbox" value="" name="sport[]" ><?php echo Yii::t('app','Remember me'); ?></label>
				</div>
				<span class="remember-div">l</span>
				<a href="#" data-toggle="modal" data-target="#forgot-password-modal" data-dismiss="modal" class="forgot-pwd"><?php echo Yii::t('app','Forgot Password ?'); ?></a>
			</div>	
			</div>
			<?php $this->endWidget(); ?>
			</div>
		</div>
		<?php $lineMaring = "no-margin"; ?>
		<?php if($socialLogin['facebook']['status'] == 'enable' || $socialLogin['twitter']['status'] == 'enable'
		|| $socialLogin['google']['status'] == 'enable'){ ?>
		<div class="login-div-line col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="left-div-line"></div>
			<div class="right-div-line"></div>
			<span class="login-or"><?php echo Yii::t('app','or'); ?></span>
		</div>
		<div class="social-login col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<?php if($socialLogin['facebook']['status'] == 'enable'){ ?>
			<div class="facebook-login">
				<a href='<?php echo Yii::app()->createAbsoluteUrl("/user/socialLogin/type/facebook"); ?>' title='Facebook'>
					<img src="<?php echo Yii::app()->createAbsoluteUrl("/images/design/facebook-login.png"); ?>" alt="Facebook">
				</a>
			</div>
			<?php } ?>
			<?php if($socialLogin['twitter']['status'] == 'enable'){ ?>
			<div class="twitter-login">
				<a href='<?php echo Yii::app()->createAbsoluteUrl("/user/socialLogin/type/twitter"); ?>' title='Twitter'>
					<img src="<?php echo Yii::app()->createAbsoluteUrl("/images/design/twitter-login.png"); ?>" alt="Twitter">
				</a>
			</div>
			<?php } ?>
			<?php if($socialLogin['google']['status'] == 'enable'){ ?>
			<div class="googleplus-login">
				<a href="<?php echo Yii::app()->createAbsoluteUrl("/user/socialLogin/type/google"); ?>" title='Google'>
					<img src="<?php echo Yii::app()->createAbsoluteUrl("/images/design/googleplus-login.png"); ?>" alt="Google">
				</a>
			</div>
			<?php } ?>
		</div>
		<?php $lineMaring = ""; ?>
		<?php } ?>
		<div class="login-line-2 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding <?php echo $lineMaring; ?>"></div>
		<div class="new-signup col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		
		<span><?php echo Yii::t('app','Not a member yet ?'); ?></span><a class="signup-link" data-dismiss="modal" data-toggle="modal" data-target="#signup-modal" href="#signup-modal"><?php echo Yii::t('app','click here'); ?></a>
		</div>
		
		</div>
		</div>
		</div>
		
		<!--E O Login modal-->
		
		<!--signup modal-->
		
		<div class="modal fade" id="signup-modal" role="dialog">
		<div class="modal-dialog modal-dialog-width">
		<div class="signup-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<div class="signup-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<h2 class="signup-header-text"><?php echo Yii::t('app','Signup'); ?></h2>
		<button data-dismiss="modal" class="close signup-close" type="button">×</button>
			
		</div>
		<div class="sigup-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
		
		<div class="signup-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
		<div class="signup-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<div class="signup-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
			
			<?php 
			$model=new Users('register');
			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'users-signup-form',
				'action'=>Yii::app()->createURL('/user/signup'),
				// Please note: When you enable ajax validation, make sure the corresponding
				// controller action is handling ajax validation correctly.
				// See class documentation of CActiveForm for details on this,
				// you need to use the performAjaxValidation()-method described there.
				    'enableAjaxValidation' => true,
				    'enableClientValidation'=>true,
			     	'clientOptions'=>array(
						'validateOnSubmit'=>true,
						'validateOnChange'=>false,
				    ),
					'htmlOptions'=>array(
						'onsubmit'=> 'return signform()',
				        //'onchange' => 'return signform()',
					),
				)); ?>
				
				<?php echo $form->textField($model,'name',array('class'=>'popup-input', 'placeholder'=>Yii::t('app','Enter your name'), 'onkeypress' => 'return IsAlphaNumeric(event)')); ?>
				<?php echo $form->error($model,'name', array('id'=>'Users_name_em_')); ?>
				
				<?php echo $form->textField($model,'username',array('class'=>'popup-input', 'placeholder'=>Yii::t('app','Enter your username'), 'onkeypress' => 'return IsAlphaNumeric(event)')); ?>
				<?php echo $form->error($model,'username', array('id'=>'Users_username_em_')); ?>
				
				<?php echo $form->textField($model,'email',array('class'=>'popup-input', 'placeholder'=>Yii::t('app','Enter your email address'))); ?>
				<?php echo $form->error($model,'email', array('id'=>'Users_email_em_')); ?>
				
				<?php echo $form->passwordField($model,'password',array('class'=>'popup-input', 'placeholder'=>Yii::t('app','Enter your password'))); ?>
				<?php echo $form->error($model,'password', array('id'=>'Users_password_em_')); ?>
				
				<?php echo $form->passwordField($model,'confirm_password',array('class'=>'popup-input', 'placeholder'=>Yii::t('app','Confirm your password'))); ?>
				<?php echo $form->error($model,'confirm_password', array('id'=>'Users_confirm_password_em_')); ?>
		
		</div>
		<?php echo CHtml::submitButton(Yii::t('app','Sign Up'), array('class'=>'col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding login-btn')); ?>
		<?php $this->endWidget(); ?>
		
		</div>
		</div>
		<?php if($socialLogin['facebook']['status'] == 'enable' || $socialLogin['twitter']['status'] == 'enable'
		|| $socialLogin['google']['status'] == 'enable'){ ?>
		<div class="signup-div-line col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="left-div-line"></div>
		<div class="right-div-line"></div>
		<span class="signup-or"><?php echo Yii::t('app','or');?></span>
		</div>
		
		<div class="social-login col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<?php if($socialLogin['facebook']['status'] == 'enable'){ ?>
			<div class="facebook-login">
				<a href='<?php echo Yii::app()->createAbsoluteUrl("/user/socialLogin/type/facebook"); ?>' title='Facebook'>
					<img src="<?php echo Yii::app()->createAbsoluteUrl("/images/design/facebook-login.png"); ?>" alt="Facebook">
				</a>
			</div>
			<?php } ?>
			<?php if($socialLogin['twitter']['status'] == 'enable'){ ?>
			<div class="twitter-login">
				<a href='<?php echo Yii::app()->createAbsoluteUrl("/user/socialLogin/type/twitter"); ?>' title='Twitter'>
					<img src="<?php echo Yii::app()->createAbsoluteUrl("/images/design/twitter-login.png"); ?>" alt="Twitter">
				</a>
			</div>
			<?php } ?>
			<?php if($socialLogin['google']['status'] == 'enable'){ ?>
			<div class="googleplus-login">
				<a href="<?php echo Yii::app()->createAbsoluteUrl("/user/socialLogin/type/google"); ?>" title='Google'>
					<img src="<?php echo Yii::app()->createAbsoluteUrl("/images/design/googleplus-login.png"); ?>" alt="Google">
				</a>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		
		<div class="login-line-2 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding <?php echo $lineMaring; ?>"></div>
		<div class="user-login col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<span><?php echo Yii::t('app','Already a member?'); ?></span><a class="login-link" href="#login-modal" data-dismiss="modal" data-toggle="modal" data-target="#login-modal"><?php echo Yii::t('app','login'); ?></a>
		</div>
		
		</div>
		</div>
		</div>
		
		<!--E O signup modal-->
		<?php } ?>
		<?php if((Yii::app()->controller->action->id != 'signup') && (Yii::app()->controller->action->id != 'socialLogin') && (Yii::app()->controller->action->id != 'forgotpassword')){  ?>
		<!--Forgot password-->
		
		<div class="modal fade" id="forgot-password-modal" role="dialog">
		<div class="modal-dialog modal-dialog-width">
		<div class="login-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<h2 class="forgot-header-text"><?php echo Yii::t('app','Forgot Password'); ?></h2>
		<button data-dismiss="modal" class="close login-close" type="button">×</button>
		<p class="forgot-sub-header-text"><?php echo Yii::t('app',"Enter your email address and we'll send you a link to reset your password."); ?></p>
					</div>
		
						<div class="forgot-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
			
							<div class="forgot-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
								<div class="forgot-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="forgot-text-box col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<?php 
									$models = new Users('forgetpassword');
									$form = $this->beginWidget('CActiveForm', array(
										'id'=>'forgetpassword-form',
										'action'=>Yii::app()->createURL('/forgotpassword'),
										'enableAjaxValidation'=>true,
										'htmlOptions'=>array(
											'onsubmit'=>'return validforgot()',
									),
									)); ?>
									<?php echo $form->textField($models,'email',array('class' => 'forgetpasswords popup-input forget-input', 
											'placeholder'=>"Enter your email address")); ?>
									<?php echo $form->error($models,'emails'); ?>
									<?php echo CHtml::submitButton(Yii::t('app','Reset Password'), 
											array('class'=>'col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding forgot-btn','style'=>'margin-top:10px;')); ?>
									<?php $this->endWidget(); ?>
									</div>
								</div>
					
							</div>
		
			
		
			</div>
		</div>
	</div>
		
<!--E O Forgot password--->
	<?php } ?>	
		
	<!--Mobile search bar code-->
	<div class="qMart-search-bar-bg">
		<div class="container">
			<div class="app-responsive-adjust"></div>
			
			<div class="qMart-search-bar-mobile col-xs-12 col-sm-12 col-md-12 no-hor-padding form-group search-input-container">
			<form role="form" class="navbar-form- navbar-left- search-form"
					style="padding-left: 0;"
					action="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"
					method="get">
				<input type="text" maxlength="30" placeholder="<?php echo Yii::t('app','Search products'); ?>" class="qMart-search-icon-mobile  form-control input-search" <?php echo !empty(Yii::app()->user->id) ? "" : "sign" ?>" name="search"></input>
				</form>		  
			</div>
			
		</div>
	</div>
	<!--Mobile search bar code-->
		
	<div class="qMart-menu" >
		<div class="container">
			<div class="row" style="height: 64px;"></div>
			<div class="row">
				<nav class="navbar col-xs-12 col-sm-12 col-md-12">
					<ul class="nav navbar-nav">
					<?php  $categorypriority = Myclass::getCategoryPriority();?>
					
					<?php foreach($categorypriority as $key => $category): 
						if($category != "empty"){
							//$getcaname =  Myclass::getCatName($category);
							$getcatdet = Myclass::getCatDetails($category);
							$getcatimage = Myclass::getCatImage($category);
							$subCategory = Myclass::getSubCategory($category);
					
					?>
					<li class="dropdown">
					<a class="dropdown-toggle qMart-for-sale disabled" data-toggle="dropdown" href="<?php echo Yii::app()->createAbsoluteUrl('/category/'.$getcatdet->slug); ?>" style="background:url(<?php echo Yii::app()->createAbsoluteUrl('admin/categories/resized/70/'.$getcatimage); ?>) no-repeat scroll left center / 24px auto; " ><?php echo $getcatdet->name; ?></a>
						<?php if(!empty($subCategory)) {?>
						<ul id="dropdown-block" class="dropdown-menu qMart-dropdown-submenu">
							<?php foreach($subCategory as $key => $subCategory): 
							//echo $key;
									$subCatdet = Myclass::getCatDetails($key);
							?>
							<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/category/'.$getcatdet->slug.'/'.$subCatdet->slug); ?>"><?php echo $subCategory; ?></a></li>
							<?php endforeach;?>
				  		</ul>
				  		<?php }?>
				  	</li>
					<?php } endforeach;?>	
						
					</ul>
				</nav>
			</div>
		</div>
	</div>
		
	<?php if(!empty($footerSettings['appLinks']) && count($footerSettings['appLinks']) > 0){ ?>	
	<div class="qMart-app-download">
		<div class="container">
			<div class="row">
				<div class="qMart-app-section col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 no-hor-padding">
						<h1 class="qMart-app-heading "><?php echo Yii::t('app','Get your online classifieds apps now'); ?></h1>
						<p class="qMart-app-text"><?php echo Yii::t('app','Start earning by selling or buying stuffs nearer to your locality by using this great online classifieds.'); ?></p>
						</div>
							<div class="qMart-app-logo col-xs-12 col-sm-6 col-md-4 col-lg-4 no-hor-padding">
								<?php if(isset($footerSettings['appLinks']['ios'])){ ?>
								<div class="qMart-app-store">
									<a href="<?php echo $footerSettings['appLinks']['ios']; ?>" target="_blank"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/app-store.png'); ?>" alt="IOS"></a>
								</div>
								<?php } if(isset($footerSettings['appLinks']['android'])){ ?>
									<div class="qMart-play-store">
										<a href="<?php echo $footerSettings['appLinks']['android']; ?>" target="_blank"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/play-store.png'); ?>" alt="ANDRIOD"></a>
									</div>
								<?php } ?>
							</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>
	<?php }?>
	<?php /*?>  <div class="container">
		<header class="navbar navbar-fixed-top bg-white">
			<div class="col-md-2">
			<?php $logo = Myclass::getLogo();
			echo CHtml::link(CHtml::image(Yii::app()->createAbsoluteUrl('media/logo/'.$logo),"Logo", 
					array('style'=>'height: 36px; margin: 3px 0px;float:left;')),Yii::app()->createAbsoluteUrl('/')); ?>
			</div>
			<?php if(!empty(Yii::app()->user->id)) { ?>
			<div class="pull-right after-login col-md-6" style="text-align: center">
			<?php }else{ ?>
			<div class="pull-right before-login col-md-6" style="text-align: center">
			<?php } ?>
				<div class="lang-menu-front  navbar-form navbar-left">
				<?php $this->widget('Language'); ?>
				</div>
				<div class="btn-group navbar-form navbar-left"
					style="padding-left: 0;">
					<a class="btn btn-primary sell-button"
						href="<?php echo Yii::app()->createAbsoluteUrl('item/products/create'); ?>">
						<i class="fa fa-plus"> </i> <?php echo Yii::t('app','SELL'); ?>
					</a>
				</div>

				<?php $category = Myclass::getCategory(); ?>
				<div class="btn-group navbar-form navbar-left shop-menu"
					style="paddidng-left: 0;">
					<a class="btn btn-primary dropdown-toggle shop-button"
						data-toggle="dropdown" href="#"><?php echo Yii::t('app','SHOP'); ?>
						<!-- <span class="caret"></span> -- > </a>
					<ul
						class="dropdown-menu <?php echo count($category) > 10 ? 'more-menu' : ""; ?>">
						<?php foreach($category as $cat): ?>
						<li><a
							href="<?php echo Yii::app()->createAbsoluteUrl('/category/'.$cat->slug); ?>">
							<?php echo CHtml::image(Yii::app()->createAbsoluteUrl('admin/categories/resized/70/'.$cat->image),$cat->name);
							/* $count = strlen($cat->name);
							if($count > 10){
								$substring = substr($cat->name,0,6).'...';
							} else {
								$substring = $cat->name;
							} * /
							echo "<p>".$cat->name."</p>"; ?>
						</a>
						</li>
						<?php endforeach;?>
					</ul>
				</div>

				<form role="form" class="navbar-form navbar-left search-form"
					style="padding-left: 0;"
					action="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"
					method="get">
					<div class="form-group search-input-container">
						<input type="text" name="search"
							class="form-control input-search <?php echo !empty(Yii::app()->user->id) ? "" : "sign" ?>"
							placeholder="<?php echo Yii::t('app','Search'); ?>"> <i
							class="fa fa-search input-search-icon"></i>
					</div>
					<!-- <button class="btn btn-success" type="submit">Search</button> -- >
				</form>

				<?php if(!empty(Yii::app()->user->id)) {
					$messageCount = Myclass::getMessageCount(Yii::app()->user->id); ?>
				<script>
					var liveCount = <?php echo $messageCount; ?>;
				</script>
				<div class="btn-group navbar-form navbar-left" style="padding-left: 0;">
					<a class="message-linkk"
						href="<?php echo Yii::app()->createAbsoluteUrl('message'); ?>"> <i
						class="fa fa-envelope-o fa-2x"></i> 
						<?php 
						$messageStatus = "";
						if($messageCount == 0){ 
							$messageStatus = "message-hide";
						} ?>
						<div class="message-count <?php echo $messageStatus; ?>">
							<?php echo $messageCount; ?>
						</div> 
					</a>
				</div>

				<div class="btn-group navbar-form navbar-right profile-left" style="padding-left: 0;">

					<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <?php $userImage = Myclass::getUserDetails(Yii::app()->user->id);
					if(!empty($userImage->userImage)) {
						echo CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/35/'.$userImage->userImage),$userImage->username);
					} else {
						echo CHtml::image(Yii::app()->createAbsoluteUrl('user/resized/35/default/'.Myclass::getDefaultUser()),$userImage->username);
					}
					?>
					</a>
					<ul class="dropdown-menu">
						<li><a
							href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles'); ?>"><?php echo Yii::t('app','Profile'); ?>
						</a>
						</li>
						<li><a
							href="<?php echo Yii::app()->createAbsoluteUrl('shippingaddress'); ?>"><?php echo Yii::t('app','Shipping Addresses'); ?>
						</a>
						</li>
						<li role="presentation" class="divider"></li>
						<li><a
							href="<?php echo Yii::app()->createAbsoluteUrl('item/exchanges',array('type' => 'incoming')); ?>">
							<?php echo Yii::t('app','My Exchanges'); ?>
						</a>
						</li>
						<li><a
							href="<?php echo Yii::app()->createAbsoluteUrl('orders'); ?>"><?php echo Yii::t('app','My Orders'); ?>
						</a>
						</li>
						<li><a
							href="<?php echo Yii::app()->createAbsoluteUrl('sales'); ?>"><?php echo Yii::t('app','My Sales'); ?>
						</a>
						</li>
						<li><a
							href="<?php echo Yii::app()->createAbsoluteUrl('coupons',array('type' => 'item')); ?>"><?php echo Yii::t('app','Coupons'); ?>
						</a>
						</li>
						<li role="presentation" class="divider"></li>
						<li><a
							href="<?php echo Yii::app()->createAbsoluteUrl('user/logout'); ?>"><?php echo Yii::t('admin','Logout'); ?>
						</a>
						</li>
					</ul>

				</div>
				<?php } else { ?>
				<div class="btn-group navbar-form navbar-left" style="padding-left: 0px;padding-top: 2px;">
					<ul class="login-menu" style="float: right; display: inline;">
						<li><a href="<?php echo Yii::app()->createAbsoluteUrl('user/login'); ?>"><i
								class="fa fa-sign-in" style="font-size: 2em;"></i> </a>
						</li>
						<!-- <li><a style="padding: 0; height: 100%"
							href="<?php echo Yii::app()->createAbsoluteUrl('user/signup'); ?>"><i
								class="fa fa-user" style="font-size: 2em;"></i> </a>
						</li> -- >

					</ul>

				</div>


				<?php } ?>
			</div>

		</header>
		<!-- header -- >

		<div class="row">
			<div class="col-lg-12 userinfo">
			<?php
			$flashMessages = Yii::app()->user->getFlashes();
			if ($flashMessages) {
				echo '<ul class="flashes">';
				foreach($flashMessages as $key => $message) {
					echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
				}
				echo '</ul>';
			}
			?>
			</div>
		</div>
		<?php */ ?>
		
		<!--Confirmation popup-->
		<div class="modal fade" id="confirm_popup_container" role="dialog" aria-hidden="true"> 
			<div id="confirm-popup" class="modal-dialog modal-dialog-width confirm-popup">
				<div class="login-modal-content col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
					<div class="login-modal-header col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="login-header-text"><?php echo Yii::t('app','Confirm'); ?></h2>
													
					</div>
						
					<div class="login-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
				
					<div class="login-content col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
						<span class="delete-sub-text col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<?php echo Yii::t('app','Are you sure you want to proceed ?'); ?>
						</span>
						<span class="confirm-btn">
							<a class="margin-bottom-0 post-btn" href="#" onclick="closeConfirm()">
								<?php echo Yii::t('app','ok'); ?>
							</a>
						</span>
						<a class="margin-bottom-0 delete-btn margin-10" href="#" onclick="closeConfirm()">
							<?php echo Yii::t('app','cancel'); ?>
						</a>			
					</div>			
				</div>
			</div>
		</div>
				
		<!--E O Confirmation popup
		<div id="confirm_popup_container">
			<div id="confirm-popup" style="display: none;" class="popup ly-title update confirm-popup">
				<p class="ltit">
				<?php echo Yii::t('app','Confirm'); ?>
				</p>
				<div class="confirm-popup-content">
					<div class="confirm-message">
						<?php echo Yii::t('app','Are you sure you want to proceed ?'); ?>
					</div>
					<div class="btn-area">
						<button type="button" class="btn-confirm-cancel btn-done" id="btn-doneid" 
							onclick="closeConfirm()">
							<?php echo Yii::t('app','cancel'); ?>
						</button>
						<div class="confirm-btn">
							<button type="button" class="btn-confirm-cancel btn-done" id="btn-doneid" 
								onclick="closeConfirm()">
								<?php echo Yii::t('app','ok'); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div> -->


		<div class="container-fluid no-hor-padding">
			<?php $flashMessages = Yii::app()->user->getFlashes();
			if ($flashMessages) { 
				foreach($flashMessages as $key => $message) { ?>
			<div class=" flashes message-floating-div-cnt col-xs-12 col-sm-4 col-md-3 col-lg-3 no-hor-padding">
				<div class="flash-<?php echo $key; ?> floating-div no-hor-padding pull-right" style="width:auto;">
					<div class="message-user-info-cnt no-hor-padding" style="width:auto;">
						<div class="message-user-info"><?php echo $message; ?></div>
					</div>
				</div>
			</div>
			<?php } } ?>
		</div>	  


		<?php echo $content; ?>
		<div class="footer">
			<div class="container">
			
				<div class="row">
					<div class="qMart-footer-head col-xs-12 col-sm-12 col-md-12 col-lg-12">					
						<div class="qMart-social-connect col-xs-12 col-sm-6 col-md-3 col-lg-3 no-hor-padding">
							<span class="qMart-social-head"><?php echo Yii::t('app','Stay Connect with qMart - an online classifieds'); ?></span>
							<?php if(!empty($footerSettings['socialLinks']) && count($footerSettings['socialLinks']) > 0){ ?>
								<div class="qMart-social-icon">
								  <?php if(isset($footerSettings['socialLinks']['facebook'])){ ?>	
									<a href="<?php echo $footerSettings['socialLinks']['facebook']; ?>" target="_blank"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/facebook.png'); ?>" alt="facebook"></a>
								  <?php }if(isset($footerSettings['socialLinks']['twitter'])){ ?>
									<a href="<?php echo $footerSettings['socialLinks']['twitter']; ?>" target="_blank"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/twitter.png'); ?>" alt="twitter"></a>
								  <?php }if(isset($footerSettings['socialLinks']['google'])){ ?>
									<a href="<?php echo $footerSettings['socialLinks']['google']; ?>" target="_blank"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/google-plus.png'); ?>" alt="google plus"></a>
								  <?php }?>
									<!-- <a href="#"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/instagram.png'); ?>" alt="instagram"></a>-->
								</div>
							<?php }else{ ?>
								<div class="qMart-nosocial-icon"><?php echo Yii::t('app','Yet no sociallinks are not updated.'); ?></div>
							<?php } ?>
						</div>						
						
						<div class="qMart-app-links col-xs-12 col-sm-6 col-md-2 col-lg-2 no-hor-padding">
							<span class="qMart-app-head"><?php echo Yii::t('app','Download Apps'); ?> </span>
							<?php if(!empty($footerSettings['appLinks']) && count($footerSettings['appLinks']) > 0){ ?>
							<div class="qMart-app-icon">
							  <?php if(isset($footerSettings['appLinks']['ios'])){ ?>
								<a class="qMart-ios-app" href="<?php echo $footerSettings['appLinks']['ios']; ?>" target="_blank"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/ios.png'); ?>" alt="ios app"></a>
							  <?php } if(isset($footerSettings['appLinks']['ios']) && isset($footerSettings['appLinks']['android']) ){?>
								<span class="qMart-footer-vertical-line"></span>
							  <?php } if(isset($footerSettings['appLinks']['android'])){ ?>
								<a href="<?php echo $footerSettings['appLinks']['android']; ?>" target="_blank" class="qMart-android-app"><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/design/android.png'); ?>" alt="android app"></a>
							  <?php } ?>								
							</div>	
							<?php }else{ ?>
							<div class="qMart-noapp-icon"><?php echo Yii::t('app','Yet no applinks are not updated.'); ?></div>
							<?php }?>		
						</div>		
						<?php if(empty(Yii::app()->user->id)) {?>				
							<div class="qMart-new-account col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding">
								<p class="qMart-new-account-info col-xs-12 col-sm-9 col-md-9 col-lg-9 no-hor-padding">
									<?php echo Yii::t('app','Create your qMart online classifieds account to chat around with the sellers and buyers near you.'); ?>
								</p>
								
								<a href="<?php echo Yii::app()->createAbsoluteUrl('user/signup'); ?>" 
									class="qMart-create-btn col-xs-12 col-sm-3 col-md-3 col-lg-3 no-hor-padding">
									<?php echo Yii::t('app','Create a account'); ?>
								</a>
															
							</div>		
						<?php }else{ ?>
							<div class="qMart-new-account col-xs-12 col-sm-12 col-md-7 col-lg-7 no-hor-padding">
								<p class="qMart-new-account-info col-xs-12 col-sm-9 col-md-9 col-lg-9 no-hor-padding">
								<?php echo Yii::t('app','Happy selling your products. Chat around with the sellers and buyers near you.'); ?>
								</p>
									
								<a href="<?php echo Yii::app()->createAbsoluteUrl(
										'user/profiles',array('id'=>Myclass::safe_b64encode(Yii::app()->user->id.'-'.rand(0,999)))); ?>" 
									class="qMart-create-btn col-xs-12 col-sm-3 col-md-3 col-lg-3 no-hor-padding">
									<?php echo Yii::t('app','Promote your list'); ?>
								</a>
							
							</div>
						<?php }?>			
					</div>				
				</div>
				
				<div class="row">
					<div class="qMart-footer-horizontal-line col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding"></div>
					<div class="qMart-footer-bottom col-xs-12 col-sm-12 col-md-8 col-lg-10 no-hor-padding">
						<div class="qMart-footer-menu-links col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<ul>
							<?php $footerLinks = Myclass::getFooterLinks(); 
								if (!empty($footerLinks)){ 
							?>
							<li>
							<?php 
								foreach ($footerLinks as $footerKey => $footerLink){
								$pageLink = Yii::app()->createAbsoluteUrl('help/'.$footerLink->slug);
							?>
							<a class="" href="<?php echo $pageLink; ?>"><?php echo $footerLink->page; ?></a>
							</li>
							<?php if(count($footerLinks) > ($footerKey + 1)){ ?>
							<li class="qMart-footer-dev"><?php echo Yii::t('app','l'); ?></li>
							<?php 
									}	
								}
							?>
							
							<?php }?>
																
							<!--<li><a href="#">Contact</a></li>
							<li class="qMart-footer-dev">l</li>								
							<li><a href="#">Terms of sales</a></li>
							<li class="qMart-footer-dev">l</li>	
							<li><a href="#">Terms of Services</a></li>
							<li class="qMart-footer-dev">l</li>	
							<li><a href="#">Privacy policy </a></li>
							<li class="qMart-footer-dev">l</li>	
							<li><a href="#">Terms and conditions</a></li>-->								
							</ul>
						</div>				
						
						
						<div class="qMart-footer-Copyright col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<?php if(!empty($footerSettings['footerCopyRightsDetails'])){
								echo $footerSettings['footerCopyRightsDetails'];
							}else{ ?>
							<span><?php echo Yii::t('app','© Copyright 2016 Hitasoft.com Limited. All rights reserved.'); ?> </span>
							<?php } ?>
						</div>
						
					</div>
					<div class="language col-xs-12 col-sm-12 col-md-4 col-lg-2 no-hor-padding">									
						<?php $this->widget('Language'); ?>
					</div>
				</div>
				
			</div>
			<div class="analytics-codes">
				<?php if(!empty($footerSettings['analytics'])){
					echo $footerSettings['analytics'];
				} ?>
			</div>
		</div>

	
    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        $("#wrapper.toggled").css("display", "block");
        $("body").toggleClass("scroll-hidden");
        //$("#wrapper.toggled").parent("body").css('overflow':'hidden');
    });
    </script>
	<style>
	.scroll-hidden{
	overflow:hidden;
	}
	</style>

<!-- Sticky menu -->	
<script>	
$(document).ready(function(){
	$(window).scroll(function() {    
	    var scroll = $(window).scrollTop();
	    var headerHeightTrack = ($('.qMart-menu').height() - 64);

	    if (scroll >= headerHeightTrack) {
	        $(".qMart-header").addClass("affix");
	    } else {
	        $(".qMart-header").removeClass("affix");
	    }
	});
});
</script>	


	
<!-- E O sticky menu -->

<!-- Tooltip menu -->	
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<!-- E o tooltip menu -->
	
    <!-- Bootstrap -->
	<link href="<?php echo Yii::app()->createAbsoluteUrl('css/bootstrap.min.css'); ?>" rel="stylesheet">
   <!-- <link href="<?php echo Yii::app()->createAbsoluteUrl('css/bootstrap.css'); ?>" rel="stylesheet">
	 E O Bootstrap -->	
	
	<!--qMart style -->
	<link href="<?php echo Yii::app()->createAbsoluteUrl('css/qMart-style.css'); ?>" rel="stylesheet">
	<!--check box customization-->
	<script type="text/javascript" src="<?php echo Yii::app()->createAbsoluteUrl('js/design/check_script.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->createAbsoluteUrl('js/design/check_script_1.js'); ?>"></script>
	
		
		<?php /*?>

		<div class="clear"></div>
		<footer class="container-fluid no-hor-padding hidden">
			<div class="container footer-links no-hor-padding">
				<ul>
				<?php $footerLinks = Myclass::getFooterLinks(); 
					if (!empty($footerLinks)){
						echo '<li>';
						foreach ($footerLinks as $footerKey => $footerLink){
							$pageLink = Yii::app()->createAbsoluteUrl('help/'.$footerLink->slug);
				?>
					<a href="<?php echo $pageLink; ?>"><?php echo $footerLink->page; ?></a>
					<?php if(count($footerLinks) > ($footerKey + 1)){ ?>
						<span class="menu-divider">|</span>
					<?php } ?>
				<?php }	echo '</li>'; } ?>
				</ul>
			</div>
			<div class="container-fluid download-follow no-hor-padding hidden">
				<div class="col-md-12 no-hor-padding">
					<?php $footerSettings = Myclass::getFooterSettings();?>
					<?php if(!empty($footerSettings['appLinks']) && count($footerSettings['appLinks']) > 0){ ?>
					<div class="col-md-6 download-app" style="margin-left: 5px;">
						<span class="download-app-text" style="margin-top: 6px;"><?php echo Yii::t('app','Download apps'); ?> :</span>
						<?php if(isset($footerSettings['appLinks']['ios'])){ ?>
							<a href="<?php echo $footerSettings['appLinks']['ios']; ?>" 
								target="_blank">
								<div class="app-store-button"></div>
							</a>
						<?php } 
							if(isset($footerSettings['appLinks']['android'])){ ?> &nbsp; 
							<a href="<?php echo $footerSettings['appLinks']['android']; ?>" 
								target="_blank">
								<div class="play-store-button"></div>
							</a>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if(!empty($footerSettings['socialLinks']) && count($footerSettings['socialLinks']) > 0){ ?>
					<div class="col-md-3 follow-us pull-right" style="margin-right: 5px;">
						<?php  
						if(isset($footerSettings['socialLinks']['google'])){ ?>
						<a href="<?php echo $footerSettings['socialLinks']['google']; ?>" 
							target="_blank" style="text-decoration: none">
							<div class="google-icon"></div>
						</a>
						<?php } 
						if(isset($footerSettings['socialLinks']['twitter'])){ ?>
						<a href="<?php echo $footerSettings['socialLinks']['twitter']; ?>" 
							target="_blank" style="text-decoration: none">
							<div class="twitter-icon"> </div>
						</a> 
						<?php } ?>
						<?php if(isset($footerSettings['socialLinks']['facebook'])){ ?>
						<a href="<?php echo $footerSettings['socialLinks']['facebook']; ?>" 
							target="_blank" style="text-decoration: none">
							<div class="fb-icon"> </div>
						</a> 
						<?php } ?>						
						<span class="download-app-text" style="margin-top: 6px;float: right;"><?php echo Yii::t('app','Follow Us'); ?> :</span>
					</div>
					<?php } ?>
				</div>
			</div>
		</footer>
		<?php /* ?><div class="footer">
			<div class="col-md-12">
				<?php $footerLinks = Myclass::getFooterLinks(); 
					if (!empty($footerLinks)){
						echo '<div class="col-md-12 link-to-support">';
						foreach ($footerLinks as $footerLink){
							$pageLink = Yii::app()->createAbsoluteUrl('help/'.$footerLink->slug);
				?>
					<a href="<?php echo $pageLink; ?>"><?php echo $footerLink->page; ?></a>
				<?php }	echo '</div>'; } ?>
				<?php $footerSettings = Myclass::getFooterSettings();?>
				<?php if(!empty($footerSettings['socialLinks']) && count($footerSettings['socialLinks']) > 0){ ?>
				<div class="col-md-12">
					<div class="col-md-6" style="float: right; padding-top: 1px">
						<p class="pull-right follow-us" style="color: #2FDAB8">
						<?php echo Yii::t('app','Follow Us'); ?>
							: &nbsp; 
							<?php if(isset($footerSettings['socialLinks']['facebook'])){ ?>
							<a href="<?php echo $footerSettings['socialLinks']['facebook']; ?>" 
								target="_blank" style="text-decoration: none">
								<i class="fa fa-facebook-square follow-fb fa-2x" style="color: #888"></i> 
							</a> 
							<?php } 
							if(isset($footerSettings['socialLinks']['twitter'])){ ?>
							<a href="<?php echo $footerSettings['socialLinks']['twitter']; ?>" 
								target="_blank" style="text-decoration: none">
								<i class="fa fa-twitter-square fa-2x follow-tweet" style="color: #888"></i> 
							</a> 
							<?php } 
							if(isset($footerSettings['socialLinks']['google'])){ ?>
							<a href="<?php echo $footerSettings['socialLinks']['google']; ?>" 
								target="_blank" style="text-decoration: none">
								<i class="fa fa-google-plus-square fa-2x follow-google" 
									style="color: #888"></i> 
							</a>
							<?php } ?>
						</p>
					</div>
					<?php } ?>
					<?php if(!empty($footerSettings['appLinks']) && count($footerSettings['appLinks']) > 0){ ?>
					<div class="col-md-6">
						<p class="pull-left follow-us" style="color: #2FDAB8">
						<?php echo Yii::t('app','Download apps'); ?>: &nbsp; 
						<?php if(isset($footerSettings['appLinks']['ios'])){ ?>
							<a href="<?php echo $footerSettings['appLinks']['ios']; ?>" 
								class="fa fa-2x fa-apple" target="_blank"></a>
						<?php } 
							if(isset($footerSettings['appLinks']['android'])){ ?> &nbsp; 
							<a href="<?php echo $footerSettings['appLinks']['android']; ?>" 
								class="fa fa-2x fa-android" target="_blank"></a>
						<?php } ?>
						</p>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php * / ?>
		<!--<div class="clear"></div>
	</div> <?php */ ?>
	<!-- page -->
	<style type="text/css">
		.flashes{
			 -webkit-transition: all 3s ease-out;
		    -moz-transition: all 3s ease-out;
		    -ms-transition: all 3s ease-out;
		    -o-transition: all 3s ease-out;
		    transition: all 3s ease-out;
		    
		}
		.move{
			 
			 position: absolute;
		    -webkit-transition: all 3s ease-out;
		    -moz-transition: all 3s ease-out;
		    -ms-transition: all 3s ease-out;
		    -o-transition: all 3s ease-out;
		    transition: all 3s ease-out;
		    left: 200%;
		}
	</style>
	<script>

	$(document).keyup(function(e) {
		if (e.keyCode === 27){
	   		
	   		if ($('#login-modal').css('display') == 'block'){
		       $('#login-modal').modal('hide');
			}

	   		if ($('#signup-modal').css('display') == 'block'){
 			   $('#signup-modal').modal('hide');
			}
			
	   		if ($('#forgot-password-modal').css('display') == 'block'){
		       $('#forgot-password-modal').modal('hide');
			}

			if ($('#nearmemodals').css('display') == 'block'){
		       $('#nearmemodals').modal('hide');
			}

			if ($('#post-your-list').css('display') == 'block'){
		       $('#post-your-list').modal('hide');
			}

			if ($('#mobile-otp').css('display') == 'block'){
		       $('#mobile-otp').modal('hide');
			}

			if ($('#chat-with-seller-success-modal').css('display') == 'block'){
		       $('.modal').modal('hide');
		       $('#chat-with-seller-success-modal').css('display','none');
			}

			if ($('#offer-success-modal').css('display') == 'block'){
		       $('.modal').modal('hide');
		       $('#offer-success-modal').css('display','none');
			}
		}
	});

	var loginSession = readCookie('PHPSESSID');
	setTimeout(function() {
			//$(".flashes").slideRight();
			 //$('.flashes').toggle( "slide" );
			$(".flashes").addClass('move');
		}, 4000);
	function readCookie(name) {
	    var nameEQ = escape(name) + "=";
	    var ca = document.cookie.split(';');//console.log(document.cookie);
	    for (var i = 0; i < ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
	        if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
	    }
	    return null;
	}
	if (typeof timerId != 'undefined'){
		clearInterval(timerId);
	}
	var timerId = setInterval(function() {
		var currentSession = readCookie('PHPSESSID');
	    if(loginSession != currentSession) {
		    //console.log('in reload '+loginSession+" "+currentSession);
		    window.location = '<?php echo Yii::app()->createAbsoluteUrl('/'); ?>';
		    clearInterval(timerId);
	        //Or whatever else you want!
	    }
	    
	},1000);
</script>
</body>
</html>

<style>
#language {
	float: left;
	//margin-right: 25px;
	margin-top: 3px;
	color: #2DAA98;
}
.lang-menu-front.pull-left {
    margin-top: 9px;
}

.affix >.container {
   	//background:url("<?php echo Yii::app()->createAbsoluteUrl('/media/logo/'.$logoDark); ?>") no-repeat scroll left 15px;
}
</style>

