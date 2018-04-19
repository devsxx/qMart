<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=> '10Qmart',

// preloading 'log' component
	'preload'=>array('log','Controller'),

// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.vendors.*',
		'ext.YiiMailer.YiiMailer',
        'application.helpers.*',
        'ext.JsTrans.*',
),

	'aliases' => array(
    	'xupload' => 'ext.XUpload'
    	),

	'modules'=>array(
    	// uncomment the following to enable the Gii tool
		'admin', 'item', 'useractivity','buynow',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'happysale',
    	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
    	),
		'sitemap' => array(
				'class' => 'ext.sitemap.SitemapModule',     //or whatever the correct path is
				//'actions' => array(...),                    //optional
				'absoluteUrls' => true,               //optional
				'protectedControllers' => array('admin'),   //optional
				'protectedActions' =>array('site/error'),   //optional
				'priority' => '0.5',                        //optional
				'changefreq' => 'daily',                    //optional
				//'lastmod' => '1985-11-05',                  //optional
				'cacheId' => 'cache',                       //optional
				'cachingDuration' => 3600,                  //optional
		),
    ),

    	// application components
	'components'=>array(
    	'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
    	// GD or ImageMagick
            'driver'=>'GD',
    	// ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
    	),

    	/* 'user'=>array(
    	 // enable cookie-based authentication
    	 'allowAutoLogin'=>true,
    	 ), */
		'HybridAuth',
		'user' => array(	// Webuser for the frontend
			'class'             => 'CWebUser',
			'loginUrl'          => array('login'),
			'stateKeyPrefix'    => 'frontend_',
			'allowAutoLogin'	=> true,
    	),
		'adminUser' => array(	// Webuser for the admin area (admin)
			'class'             => 'CWebUser',
			'loginUrl'          => array('/admin'),
			'stateKeyPrefix'    => 'admin_',
			'allowAutoLogin'	=> true,
    	),
    	// uncomment the following to enable URLs in path-format

    	 
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
					
				'sitemap.xml'   => 'sitemap/default/index',
				'sitemap.html'  => 'sitemap/default/index/format/html',
					
				"category/<category:\w+>"=>"/",
				"category/<category:\w+>/<subcategory:\w+>"=>"/",
				'<action:(verify)>/<details>'=>'user/<action>',
				'<action:(login)>'=>'user/<action>',
				'<action:(signup)>'=>'user/<action>',
				'<action:(forgotpassword)>'=>'user/<action>',
				'<action:(resetpassword)>'=>'user/<action>',
				'<action:(promotioncron)>'=>'site/<action>',

				'<action:(addshipping)>'=>'buynow/useraction/<action>',
				'<action:(addshipping)>/<id:\d+>'=>'buynow/useraction/<action>',
                '<action:(shippingaddress)>'=>'buynow/useraction/<action>',
                '<action:(orders)>'=>'buynow/useraction/<action>',
    	        '<action:(vieworders)>/<id:\w+>'=>'buynow/useraction/<action>',
    	        '<action:(viewsales)>/<id:\w+>'=>'buynow/useraction/<action>',
    	    	'<action:(shippingconfirm)>/<id:\w+>'=>'useractivity/useraction/<action>',
    	    	'<action:(tracking)>/<id:\w+>'=>'buynow/useraction/<action>',
             	'<action:(addcoupon)>'=>'useractivity/useraction/<action>',
    	    	'<action:(coupons)>/*'=>'useractivity/useraction/<action>',
				'<action:(help)>/<details>'=>'useractivity/useraction/<action>',

    	        '<action:(viewsales)>/<id:\w+>'=>'buynow/useraction/<action>',
    	        '<action:(sales)>'=>'buynow/useraction/<action>',

                '<action:(message)>'=>'useractivity/useraction/<action>',
                '<action:(message)>/<id:\w+>'=>'useractivity/useraction/<action>',
                '<action:(postmessage)>'=>'useractivity/useraction/<action>',
                '<action:(initiatechat)>'=>'useractivity/useraction/<action>',
                '<action:(updatechat)>'=>'useractivity/useraction/<action>',
                '<action:(notification)>'=>'useractivity/useraction/<action>',

				'<action:(cart)>'=>'buynow/checkout/<action>',
				'<action:(revieworder)>/<details>'=>'buynow/checkout/<action>',
				'<action:(creditcardcheckout)>'=>'buynow/checkout/<action>',
				'<action:(placeorder)>'=>'buynow/checkout/<action>',
				'<action:(placeorder)>/<details>'=>'buynow/checkout/<action>',
				'<action:(ipnprocess)>'=>'buynow/checkout/<action>',
				'<action:(adaptiveipnprocess)>'=>'buynow/checkout/<action>',
				'<controller:(checkout)>/<action:(canceled)>'=>'buynow/checkout/<action>',
				'<controller:(checkout)>/<action:(success)>'=>'buynow/checkout/<action>',
				'<controller:(checkout)>/<action:(addshipping)>'=>'buynow/checkout/<action>',
				'<controller:(checkout)>/<action:(addshipping)>/<id:\d+>'=>'buynow/checkout/<action>',
				
				'<action:(canceled)>'=>'item/products/<action>',
				'<action:(success)>'=>'item/products/<action>',
				'<action:(promotionpayment)>'=>'item/products/<action>',
				'<action:(promotionipnprocess)>'=>'item/products/<action>',

            	'<controller:(products)>/<action:\w+>/<id:\w+>/*'=>'item/<controller>/<action>',
				'<controller:(products)>/<action:\w+>'=>'item/<controller>/<action>',
    	        '<controller:(products)>/<id:\w+>'=>'item/<controller>/view',

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
            	'<controller:(user)>/<action:(profiles)>/<id:\w+>'=>'<controller>/<action>',
    	        '<controller:(user)>/<action:(liked)>/<id:\w+>'=>'<controller>/<action>',
				'<controller:(user)>/<action:(review)>/<id:\w+>'=>'<controller>/<action>',
				'<controller:(user)>/<action:(follower)>/<id:\w+>'=>'<controller>/<action>',
				'<controller:(user)>/<action:(following)>/<id:\w+>'=>'<controller>/<action>',
    	        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
            	'<controller:(api)>/<action:\w+>/<type:\w+>'=>'<controller>/<action>',
				"<controller:\w+>/<action:\w+>"=>"<controller>/<action>",
    	    	"<module:(admin)>/<controller:\w+>/<action:\w+>/<id:\d+>"=>"<module>/<controller>/<action>",
    	        "<module:(admin)>/<controller:\w+>/<action:\w+>"=>"<module>/<controller>/<action>",
    	    	"<module:(buynow)>/<controller:\w+>/<action:\w+>/<id:\d+>"=>"<module>/<controller>/<action>",
    	        "<module:(buynow)>/<controller:\w+>/<action:\w+>"=>"<module>/<controller>/<action>",    	        
    	),
    	),


    	// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
    	// use 'site/error' action to display errors
			'errorAction'=>'site/error',
    	),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
    	array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
    	),
    	// uncomment the following to show log messages on web pages
    	/*
    	array(
    	'class'=>'CWebLogRoute',
    	),
    	*/
    	),
    	),

			'cache' => array(
					'class' => 'system.caching.CFileCache'
					),
					 'clientScript' => array(
   'class' => 'application.vendors.yii-EClientScript.EClientScript',
   'combineScriptFiles' => false, // By default this is set to true, set this to true if you'd like to combine the script files
   'combineCssFiles' => true, // By default this is set to true, set this to true if you'd like to combine the css files
   'optimizeScriptFiles' => false, // @since: 1.1
   'optimizeCssFiles' => true, // @since: 1.1
					),
					),
					'sourceLanguage' => 'en', // Source language from which should get conversion
					'language'=>'en', // Default language settings
					// application-level parameters that can be accessed
					// using Yii::app()->params['paramName']
	'params'=>array(
					// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'DEFAULT_CURRENCY' => '$',

					),
					);
