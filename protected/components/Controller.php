<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $fbtitle;
	public $fbimg;
	public $fbdescription;
	public $sitename;
	public $metaTitle;
	public $metaDescription;
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function init() {
		$app = Yii::app();
		$siteSetting = Sitesettings::model()->find();
		$sitename = $siteSetting->sitename;
		$metaData = json_decode($siteSetting->metaData, true);
		if(!empty($metaData)){
			$metaTitle = $metaData['metaTitle'];
			$metaDescription = $metaData['metaDescription'];
		}
		$app->name = $siteSetting->sitename;

		if (isset($_POST['_lang']))
		{
			$app->language = $_POST['_lang'];
			$app->session['_lang'] = $app->language;

			if(Yii::app()->controller->module == Yii::app()->getModule('admin') ) {
				$adtrans = new JsTrans('admin',$app->language);
			} else {
				$apptrans = new JsTrans('app',$app->language);
			}
			//$apptrans = new JsTrans('app',$app->language);
		}
		else if (isset($app->session['_lang']))
		{
			$app->language = $app->session['_lang'];
			if(Yii::app()->controller->module == Yii::app()->getModule('admin') ) {
				$adtrans = new JsTrans('admin',$app->language);
			} else {
				$apptrans = new JsTrans('app',$app->language);
			}
		} else {
			if(Yii::app()->controller->module == Yii::app()->getModule('admin') ) {
				$adtrans = new JsTrans('admin',$app->language);
			} else {
				$apptrans = new JsTrans('app',$app->language);
			}
		}
	}
}