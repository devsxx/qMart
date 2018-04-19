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
Yii::app()->clientScript->registerScript('helpers','
  		yii = {
  		urls: {
		  	base: '.CJSON::encode(Yii::app()->baseUrl).'
		}
	  };',CClientScript::POS_HEAD);
$cs = Yii::app()->getClientScript();
// $cs->registerCssFile($baseUrl.'/css/plugins/metisMenu/metisMenu.min.css');
// $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
 $cs->registerCssFile($baseUrl.'/css/sb-admin-2.css');
// $cs->registerCssFile($baseUrl.'/css/plugins/morris.css');
// $cs->registerCssFile($baseUrl.'/css/plugins/timeline.css');
// $cs->registerCssFile($baseUrl.'/font-awesome-4.1.0/css/font-awesome.min.css');
?>

<link href="<?php echo Yii::app()->createAbsoluteUrl('css/plugins/morris/morris.css'); ?>" rel="stylesheet">
<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/core.css'); ?>" rel="stylesheet">
<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/components.css'); ?>" rel="stylesheet">
<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/icons.css'); ?>" rel="stylesheet">
<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/pages.css'); ?>" rel="stylesheet">
<link href="<?php echo Yii::app()->createAbsoluteUrl('css/admin/responsive.css'); ?>" rel="stylesheet">
<!-- Ends CSS here -->
<!-- Begin Javascript files here -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<?php


Yii::app()->clientScript->registerCoreScript('jquery');
// $cs->registerScriptFile($baseUrl.'/js/jquery-1.11.0.js');
// $cs->registerScriptFile($baseUrl.'/js/plugins/metisMenu/metisMenu.min.js');
// $cs->registerScriptFile($baseUrl.'/js/sb-admin-2.js');
// $cs->registerScriptFile($baseUrl.'/js/front.js');
// $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
?>

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<!-- Ends Javascript files here -->
<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.png">
<style>
.collapse {
  display: none;
}
</style>
<title><?php echo CHtml::encode($this->pageTitle);?></title>
</head>

<body class="fixed-left">

<!--         <div class="animationload">
            <div class="loader"></div>
        </div> -->

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('admin/'); ?>" class="logo">
                        	<?php $logo = Myclass::getLogo();
							echo CHtml::image(Yii::app()->createAbsoluteUrl('media/logo/'.$logo)); ?>
                        </a>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">

                            <ul class="nav navbar-nav navbar-right pull-right">
                                <!-- <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                                </li> -->
                               	<div class="lang-menu hidden-xs" style="display:inline-block;">
				 					 <?php $this->widget('Language'); ?>
								</div> 
                                <li class="dropdown profile-drop-li">
                                    <a href="#" class="dropdown-toggle profile waves-effect waves-light " data-toggle="dropdown" aria-expanded="true"><i class="icon-user"></i> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo Yii::app()->createAbsoluteUrl('admin/user/profile'); ?>"><i class="ti-user m-r-5"></i> <?php echo Yii::t('admin','Profile');?></a></li>
                                       <!--  <li><a href="javascript:void(0)"><i class="ti-settings m-r-5"></i> Settings</a></li>
                                        <li><a href="javascript:void(0)"><i class="ti-lock m-r-5"></i> Lock screen</a></li> -->
                                        <li><a href="<?php echo $baseUrl."/admin/action/logout" ?>"><i class="ti-power-off m-r-5"></i> <?php echo Yii::t('admin','Logout');?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->

                    <div id="sidebar-menu">
                       <ul>
						<?php //echo "Controller: ".$this->uniqueid; echo "</br>Action: ".$this->action->Id;
						$controllerName = explode('/', $this->uniqueid);
						//echo '<p>'.$controllerName[1].'</p>';
						$actionName = $this->action->Id;
						$active = '';$subActive = '';
						if ($controllerName[1] == 'action')
						$active = 'active';
						if ($actionName == 'dashboard')
						$subActive = 'active';
						$sitesetting = Myclass::getSitesettings();
						$paymentmode = json_decode($sitesetting->sitepaymentmodes,true);
						?>
							<li class="<?php echo $active; ?>"><a
								class=" waves-effect <?php echo $subActive; ?>"
								href="<?php echo $baseUrl."/admin/action/dashboard" ?>"><i class="ti-home"></i><span><?php echo Yii::t('admin','Dashboard'); ?></span>
							</a>
							</li>
							<?php $active = '';$subActive = '';
							if ($controllerName[1] == 'user')
							$active = 'active';
							?>
							<li class="has_sub <?php echo $active; ?>"><a class="waves-effect" href="#"><i
									class="icon-people"></i><span><?php echo Yii::t('admin','Users'); ?></span> </a>
								<ul class="">
								<?php if ($controllerName[1] == 'user' && ($actionName == 'admin' || $actionName == 'update' || $actionName == 'view'))
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/user/admin" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Users'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'user' && $actionName == 'create')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/user/create" ?>"><?php echo Yii::t('admin','Create').' '.Yii::t('admin','User'); ?>
									</a>
									</li>
								</ul> <!-- /.nav-second-level -->
							</li>
							<?php $active = '';$subActive = '';
							if ($controllerName[1] == 'item' || $controllerName[1] == 'productconditions' || $controllerName[1] == 'reportitem' )
							$active = 'active';
							?>
							<li class=" has_sub <?php echo $active; ?>"><a class="waves-effect" href="#"><i
									class=" icon-layers"></i> <?php echo Yii::t('admin','Items'); ?><span
									class="fa arrow"></span> </a>
								<ul class="">
								<?php if ($controllerName[1] == 'item' && ($actionName == 'admin' || $actionName == 'update' || $actionName == 'view'))
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/item/admin" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Items'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'productconditions')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/productconditions/admin" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Product Conditions'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'reportitem')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/reportitem/admin" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Report Items'); ?>
									</a>
									</li>
									<?php //$subActive = '';
									//if ($controllerName[1] == 'item' && $actionName == 'create')
									//	$subActive = 'active'; ?>
									<!--  <li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/item/create" ?>">Create Item</a>
									</li>  -->
								</ul> <!-- /.nav-second-level -->
							</li>
							<?php $active = '';$subActive = '';
							if ($controllerName[1] == 'categories')
							$active = 'active';
							?>
							<li class="has_sub <?php echo $active; ?>"><a class="waves-effect" href="#"><i
									class=" icon-vector"></i> <?php echo Yii::t('admin','Categories'); ?><span
									class="fa arrow"></span> </a>
								<ul class="">
								<?php if ($controllerName[1] == 'categories' && ($actionName == 'admin' || $actionName == 'update' || $actionName == 'view'))
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/categories/admin" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Categories'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'categories' && $actionName == 'create')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/categories/create" ?>"><?php echo Yii::t('admin','Create').' '.Yii::t('admin','Category'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'categories' && $actionName == 'showtopcategory')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/categories/showtopcategory" ?>"><?php echo Yii::t('admin','Header').' '.Yii::t('admin','Category'); ?>
									</a>
									</li>
								</ul> <!-- /.nav-second-level -->
							</li>
							<?php $active = '';$subActive = '';
							if ($controllerName[1] == 'promotion')
							$active = 'active';
							?>
							<li class="has_sub <?php echo $active; ?>"><a class="waves-effect" href="#"><i
									class=" icon-cursor"></i> <?php echo Yii::t('admin','Promotions'); ?><span
									class="fa arrow"></span> </a>
								<ul class="">
								<?php if ($controllerName[1] == 'promotion' && ($actionName == 'admin' || $actionName == 'update' || $actionName == 'view'))
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/promotion/admin" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Promotion'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'promotion' && $actionName == 'create')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/promotion/create" ?>"><?php echo Yii::t('admin','Create').' '.Yii::t('admin','Promotion'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'promotion' && $actionName == 'urgentpromotion')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/promotion/urgentpromotion" ?>"><?php echo Yii::t('admin','Urgent').' '.Yii::t('admin','Promotion'); ?>
									</a>
									</li>
									
								</ul> <!-- /.nav-second-level -->
							</li>
							<?php $active = '';$subActive = '';
							if ($controllerName[1] == 'currencies')
							$active = 'active';
							?>
							<li class="has_sub <?php echo $active; ?>"><a class="waves-effect" href="#"><i
									class=" icon-wallet"></i> <?php echo Yii::t('admin','Currency Management'); ?><span
									class="fa arrow"></span> </a>
								<ul class="">
								<?php if ($controllerName[1] == 'currencies' && ($actionName == 'admin' || $actionName == 'update' || $actionName == 'view'))
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/currencies/admin" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Currencies'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'currencies' && $actionName == 'create')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/currencies/create" ?>"><?php echo Yii::t('admin','Add').' '.Yii::t('admin','Currency'); ?>
									</a>
									</li>
								</ul> <!-- /.nav-second-level -->
							</li>
							<?php $active = '';$subActive = '';
							if ($controllerName[1] == 'commissions' || ($controllerName[1] == 'sitesettings' && $actionName == 'payment') || $controllerName[1] == 'orders' || $controllerName[1] == 'invoices')
							$active = 'active';
							?>
							<li class="has_sub <?php echo $active; ?>"><a class="waves-effect" href="#"><i
									class=" icon-settings"></i> <?php echo Yii::t('admin','Site Payment Options'); ?><span
									class="fa arrow"></span> </a>
								<ul class="">
								<?php if ($controllerName[1] == 'commissions')
								$subActive = 'active'; ?>
									<!--li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/buynow/commissions/index" ?>"> <?php echo Yii::t('admin','Commission setup'); ?>
									</a>
									</li-->
									<?php /* $subActive = '';
									if ($controllerName[1] == 'sitesettings' && $actionName == 'sitepaymentmodes')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/sitesettings/sitepaymentmodes" ?>"><?php echo Yii::t('admin','Site Payment Modes'); ?>
									</a>
									</li>
									<?php */ $subActive = '';
									if ($controllerName[1] == 'sitesettings' && $actionName == 'payment')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/sitesettings/payment" ?>"><?php echo Yii::t('admin','Paypal').' '.Yii::t('admin','Settings'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'sitesettings' && $actionName == 'braintreesettings')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/sitesettings/braintreesettings" ?>"><?php echo Yii::t('admin','Brain Tree Settings'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'orders' && ($actionName == 'admin' || $actionName == 'view'))
									$subActive = 'active'; ?>
									<!--li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/orders/admin" ?>"><?php echo Yii::t('admin','Orders'); ?>
									</a>
									</li-->
									<?php $subActive = '';
									if ($controllerName[1] == 'orders' && ($actionName == 'mobileorders'))
									$subActive = 'active'; ?>
									<!--li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/orders/mobileorders" ?>"><?php echo Yii::t('admin','Mobile and CC Orders'); ?>
									</a>
									</li-->
									<?php $subActive = '';
									if ($controllerName[1] == 'invoices')
									$subActive = 'active'; ?>
									<!--li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/invoices/admin" ?>"><?php echo Yii::t('admin','Invoices'); ?>
									</a>
									</li-->
								</ul> <!-- /.nav-second-level -->
							</li>

							<?php $active = '';$subActive = '';
							if ($controllerName[1] == 'commissions' || $controllerName[1] == 'invoices' || $controllerName[1] == 'orders')
							$active = 'active';
							if($paymentmode['buynowPaymentMode'] == 1) {
							?>
							<li class="has_sub <?php echo $active; ?>"><a class="waves-effect" href="#"><i
									class="icon-people"></i><span><?php echo Yii::t('admin','Buy Now Management'); ?></span> </a>
								<ul class="">
								<?php if ($controllerName[1] == 'commissions' && ($actionName == 'index' || $actionName == 'create' || $actionName == 'update'))
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/buynow/commissions/index" ?>"> <?php echo Yii::t('admin','Commission setup'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'invoices')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/buynow/invoices/admin" ?>"><?php echo Yii::t('admin','Invoices'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'orders')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/buynow/orders/scroworders" ?>"><?php echo Yii::t('admin','Orders'); ?>
									</a>
									</li>									
								</ul> <!-- /.nav-second-level -->
							</li>
							<?php } ?>
							<?php $active = '';$subActive = '';
							if (($controllerName[1] == 'sitesettings' && $actionName == 'sociallogin') ||
							($controllerName[1] == 'sitesettings' && $actionName == 'defaultsettings')
							|| ($controllerName[1] == 'sitesettings' && $actionName == 'showtop') ||
							($controllerName[1] == 'sitesettings' && $actionName == 'smtpsettings') ||
							($controllerName[1] == 'sitesettings' && $actionName == 'apidetails') ||
							($controllerName[1] == 'sitesettings' && $actionName == 'footersettings'))
							$active = 'active';
							?>
							<li class="has_sub <?php echo $active; ?>"><a class="waves-effect" href="#"><i
									class=" icon-info"></i> <?php echo Yii::t('admin','Site Settings'); ?><span
									class="fa arrow"></span> </a>
								<ul class="">
								<?php $subActive = '';
								if ($controllerName[1] == 'sitesettings' && $actionName == 'apidetails')
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/sitesettings/apidetails" ?>"><?php echo Yii::t('admin','API Credentials'); ?>
											</a>
									</li>

								<?php $subActive = '';
								if ($controllerName[1] == 'sitesettings' && $actionName == 'sociallogin')
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/sitesettings/sociallogin" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Social Networks'); ?>
									</a>
									</li>

								<?php $subActive = '';
								if ($controllerName[1] == 'sitesettings' && $actionName == 'footersettings')
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/sitesettings/footersettings" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Footer Settings'); ?>
									</a>
									</li>

								<?php $subActive = '';
								if ($controllerName[1] == 'sitesettings' && $actionName == 'defaultsettings')
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/sitesettings/defaultsettings" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Default').' '.Yii::t('admin','Settings'); ?>
									</a>
									</li>

								<?php /* $subActive = '';
								if ($controllerName[1] == 'sitesettings' && $actionName == 'showtop')
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/sitesettings/showtop" ?>"><?php echo Yii::t('admin','Currency').' '.Yii::t('admin','Settings'); ?>
									</a>
									</li>

								<?php */ $subActive = '';
								if ($controllerName[1] == 'sitesettings' && $actionName == 'smtpsettings')
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/sitesettings/smtpsettings" ?>"><?php echo Yii::t('admin','Email').' '.Yii::t('admin','Settings'); ?>
									</a>
									</li>
								</ul> <!-- /.nav-second-level -->
							</li>
							
							<?php $active = '';$subActive = '';
							if ($controllerName[1] == 'helppages')
							$active = 'active';
							?>
							<li class="has_sub <?php echo $active; ?>"><a class="waves-effect" href="#"><i
									class=" icon-anchor"></i> <?php echo Yii::t('admin','Help Pages'); ?><span
									class="fa arrow"></span> </a>
								
								<ul class="">
								<?php $subActive = '';
								if ($controllerName[1] == 'helppages' && $actionName == 'admin')
								$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/helppages/admin" ?>"><?php echo Yii::t('admin','Manage').' '.Yii::t('admin','Help Pages'); ?>
									</a>
									</li>
									<?php $subActive = '';
									if ($controllerName[1] == 'helppages' && $actionName == 'create')
									$subActive = 'active'; ?>
									<li><a class="<?php echo $subActive; ?>"
										href="<?php echo $baseUrl."/admin/helppages/create" ?>"><?php echo Yii::t('admin','Add').' '.Yii::t('admin','Help Pages'); ?>
									</a>
									</li>
								</ul>
							</li>
						</ul>
                        <div class="clearfix"></div>
                    </div>
                    </div>
            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
               	<div class="content">
		            <div class="row">
						<div class="col-lg-12 userinfo">
						<?php
						$flashMessages = Yii::app()->user->getFlashes();
						if ($flashMessages) {
							echo '<ul class="flashes">';
							foreach($flashMessages as $key => $message) {
								if(empty($key)) $key = 'success';
								echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
							}
							echo '</ul>';
						}
						?>
						</div>
					</div>

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
					</div>
				<div class="container">
				<?php echo $content; ?>
				</div>
				<div class="clear"></div>
	                <footer class="footer text-right">
	                    2016 © .
	                </footer>
	            </div>
            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->



        <script>
            var resizefunc = [];
        </script>
		<!-- page
	 <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>   -->
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/detect.js"></script> 
    <!-- -->
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/front.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/sb-admin-2.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/metisMenu/metisMenu.min.js"></script> 
    <!-- EO already existing js -->
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/fastclick.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.slimscroll.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.blockUI.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/waves.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/wow.min.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.nicescroll.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.scrollTo.min.js"></script> 

    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.min.js"></script> 

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/peity/jquery.peity.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <!-- KNOB JS -->
    <!--[if IE]>
    <script src="assets/plugins/jquery-knob/excanvas.js"></script>
    <![endif]-->

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/jquery-knob/jquery.knob.js"></script>
    
    <!--Morris Chart-->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/morris/morris.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/raphael/raphael-min.js"></script>

    <!-- jQuery  -->
		<!-- Flot chart -->


 <!--    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/waypoints/lib/jquery.waypoints.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/counterup/jquery.counterup.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/morris/morris.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/raphael/raphael-min.js"></script>
 -->


    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.core.js"></script> 
    <script	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.app.js"></script> 
		








		<script>
	setTimeout(function() {
			$(".flashes").slideUp();
		}, 4000);
</script>


</body>
</html>
<style>
.lang-menu {
    float: left;
    margin-top: 9px;
}
.page-header{
	margin:0 !important;
}

#language label {
    display: none;
}
</style>
