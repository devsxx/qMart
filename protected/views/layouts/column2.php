<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div id="content">
<?php
/* $flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
	echo '<ul class="flashes">';
	foreach($flashMessages as $key => $message) {
		echo '<div class="flash-' . $key . '">' . $message . "<div class='alert-close pull-right'>X</div></div>";
	}
	echo '</ul>';
} */
?>
<?php echo $content; ?>
</div>
<!-- content -->
<?php $this->endContent(); ?>