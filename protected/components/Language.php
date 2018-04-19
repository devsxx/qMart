<?php
class Language extends CWidget
{
	public function run()
	{
		$currentLang = Yii::app()->language;
		$this->render('language', array('currentLang' => $currentLang));
	}
}
?>