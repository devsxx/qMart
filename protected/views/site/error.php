<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<?php //echo $code.'<br>'.$message; ?>
				<div class="error-main">
						<div class="modal-dialog modal-dialog-width">
							<div class="col-xs-8 col-sm-12 col-md-12 col-lg-12 no-hor-padding" style="margin-bottom:100px;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
									<div class="payment-decline-status-info-txt"><img src="<?php echo Yii::app()->createAbsoluteUrl("/images/oops.jpg");?>"></br><span class="payment-red"> <?php echo Yii::t('app','Oops...!'); ?></span><?php echo Yii::t('app','Something went wrong.'); ?></div>
									<div class="col-lg-12 no-hor-padding"><a class="payment-promote-btn login-btn" href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"><?php echo Yii::t('app','Go to home'); ?></a></div>
								</div>
							</div>
						</div>
						</div>