
<?php if(!empty($history)) { ?>
<div class="messgage-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
<ul class="exchange-history-ul col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
	<?php foreach($dataProvider->getData() as $record): ?>
		<li class="exchange-history-li col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<div class="exchange-history-list-left col-xs-12 col-sm-12 col-md-6 col-lg-6 no-hor-padding">
			<?php $useridvalue = Myclass::getUserDetails($record['user'])->userId; ?>
			<?php $useridurl =  Yii::app()->createAbsoluteUrl('user/profiles',array('id'=>Myclass::safe_b64encode($useridvalue.'-'.rand(0,999)))); ?>
			<?php echo Yii::t('app',strtoupper($record['status'])).' '.Yii::t('app','By').' <a href='.$useridurl.' target="_blank">'.Myclass::getUserDetails($record['user'])->name.'</a>'; ?>
			
		</div>
		<div class="exchange-history-list-right col-xs-12 col-sm-12 col-md-6 col-lg-6 no-hor-padding">
			<?php echo date("d-M-y G:i A",$record['date']); ?>
		</div>
		</li>
		<?php endforeach; ?>
	<!-- <li class="exchange-history-li col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
		<div class="exchange-history-load-more col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">Load more history</div>
		
	</li> -->
</ul>
</div>

		<?php  $this->widget('CLinkPager',array('pages'=>$pages));
} else { ?>
<p align="center"><?php echo Yii::t('app','No Exchange History Found'); ?></p>
<?php } ?>

<script>
$(document).ready(function(){
	var exchangeId = '<?php echo $slug; ?>';
	$('ul.yiiPager > li > a').each(function(){
                    $(this).click(function(ev){
                            ev.preventDefault();
                            $.get(this.href,{ajax:true,exchangeId :exchangeId},function(html){
                                            $('#exchangeHistory').html(html);
                                    });
                            });
            });
    });
</script>
