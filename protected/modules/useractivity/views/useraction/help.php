<?php $currentslug = $helppageModel->slug; ?>

<div class="container">	
	<div class="row">		
			<div class="qMart-breadcrumb add-product col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				 <ol class="breadcrumb">
					<li><a href="#"><?php echo Yii::t('app','Home'); ?></a></li>
					<li><a href="#"><?php echo Yii::t('app','Help'); ?></a></li>					 
				 </ol>			
			</div>			
		</div>	
		
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<div class="full-horizontal-line col-xs-12 col-sm-12 col-md-12 col-lg-12 "></div>
				</div>	
			</div>
			
		<div class="row">
				<div class="help col-xs-12 col-sm-12 col-md-12 col-lg-12">								
					
					<ul class="nav nav-tabs col-xs-12 col-sm-3 col-md-3 col-lg-2 no-hor-padding ">
						<div class="help-heading col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
							<h2 class="top-heading-text"><?php echo Yii::t('app','Help'); ?></h2>						
						</div>
						<?php foreach ($allhelppageModel as $helppage) { ?>
							<?php ($currentslug == $helppage->slug)? $status=' active' : $status=''; ?>
							<li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding<?php echo $status ?>">
								<a href="<?php echo Yii::app()->createAbsoluteUrl('/help/'.$helppage->slug); ?>"><?php echo $helppage->page; ?></a>
							</li>
						<?php } ?>
					</ul>

					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 no-hor-padding">
					  <div style="word-wrap: break-word;" class="active col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding ">
						<h3><?php echo $helppageModel->page; ?></h3>
						<?php echo $helppageModel->pageContent; ?>
						
					  </div>
					</div>
				</div>
		</div>		
	</div>