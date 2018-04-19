

<?php
//echo "fg<pre>";print_r($reviews);die;
foreach($reviews as $review):
	$senderdet = Myclass::getUserDetails($review->senderId);
$image = $senderdet->userImage;
if(!empty($image)) {
	$img = 'user/resized/150/'.$image;
} else {
	$img = 'user/resized/150/default/'.Myclass::getDefaultUser();
}
?>
<div class="col-md-12 reviews">

	<div class="reviews_view">
		
		<div class="review_content col-md-12">
			<a class="col-lg-1" style="text-decoration: none;"
			href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($review->senderId.'-'.rand(0,999)))); ?>">
			<div class="senderimage "style="background-image: url('<?php echo Yii::app()->createAbsoluteUrl($img); ?>');background-color:<?php echo $colorvalue; ?>;">
			
			</div>
			</a>
			<a class="col-lg-8" style="text-decoration: none;"
			href="<?php echo Yii::app()->createAbsoluteUrl('user/profiles',array('id' => Myclass::safe_b64encode($review->senderId.'-'.rand(0,999)))); ?>">
			
			<div class="review_sender"><?php echo $senderdet->name; ?></div>
			</a>
			<div class="review_rating col-md-1 pull-right">
			<?php 
			for($i=1;$i<=5;$i++)
 			{	
 				if($i<=$review->rating)
 					echo '<i class="fa fa-star edit-'.$i.$review->reviewId.' static-rating"></i>';
 				    
 				else
 					echo '<i class="fa fa-star-o edit-'.$i.$review->reviewId.' static-rating"></i>';
 			}
 			?>
 			</div>
 			<div class="review_type col-lg-3 pull-right text-right"><?php echo "Review Type:" .$review->reviewType; ?></div>
			<div class="review_subject review_subject<?php echo $review->reviewId;?> col-md-11"><?php echo $review->review; ?></div>
			<?php $today = date('Y-m-d');
				  $createdDate = $review->createdDate;
				  $created_date = date('Y-m-d',$createdDate);
				  $stop_date = date('Y-m-d', strtotime($created_date . ' +1 day'));
				 				  
			if($senderdet->userId == Yii::app()->user->id && $today == $created_date){?>
			
			<div class="edit-review buy-button pull-right" onclick="editreview('<?php echo $review->reviewId?>')"><?php echo Yii::t('app','Edit');?></div>
			<input type="hidden" id="ratings<?php echo $review->reviewId;?>" value="<?php echo $review->rating;?>">
			<input type="hidden" id="review<?php echo $review->reviewId;?>" value="<?php echo $review->review;?>">
			
			
			<?php }?>
		</div>
	</div>

</div>
			<?php 
			endforeach; ?>


<div id="popup_container" style="display: none; opacity: 0;">
	<div id="review-edit-popup" style="display: none;" class="popup ly-title update review-me-popup">
			<p class="ltit"><?php echo Yii::t('app','Edit Review and Rating'); ?></p>
			<button type="button" class="ly-close" id="btn-browses">x</button>
			
			<div class="review-body-section">
				<div class="review-user-rating">
				  <div class="rating-title"><?php echo Yii::t('app','Give your Ratings');?>: </div>
					<i class="fa fa-2x  fa-star-o static-rating rating one" id="rateone" onclick="ratingClick('1');"></i>
					<i class="fa fa-2x  fa-star-o static-rating rating two" id="ratetwo" onclick="ratingClick('2');"></i>
					<i class="fa fa-2x  fa-star-o static-rating rating three" id="ratethree" onclick="ratingClick('3');"></i>
					<i class="fa fa-2x  fa-star-o static-rating rating four" id="ratefour" onclick="ratingClick('4');"></i>
					<i class="fa fa-2x  fa-star-o static-rating rating five" id="ratefive" onclick="ratingClick('5');"></i>
					<span class="current-rate">0</span> <?php echo Yii::t('app','Out of 5'); ?>
					<input type="hidden" id="rateval">
					
				</div>
				
				<div class="review-user-textarea">
				<div class="rating-title"><?php echo Yii::t('app','Write your Review');?>: </div>
					<textarea class="review-textarea" rows="5" cols="48" id="contact-textarea" ></textarea>
					<div class="review-error error"></div>
				</div>
				<input type="hidden" class='reviewid'>
				<div class="review-btn-area">
				
					<div class="cancel-button close-contact"> <?php echo Yii::t('app','Cancel')?></div>
					<div onclick="editsavereview()" class="send-button"> <?php echo Yii::t('app','Send'); ?> </div>
								
				</div>
			</div>
			<div class="review-response-message" style="display:none">
			 
			</div>
			
			<input type="hidden" class="review-sender" value="<?php echo Yii::app()->user->id; ?>" />
			<input type="hidden" class="review-receiver" value="" />
			<input type="hidden" class="exchangeid" value=""/>
	</div>
	</div>


