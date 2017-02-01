<?php
$params = array_merge(
    //require(__DIR__ . '/../../common/config/params.php'),
    //require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-fbwidget',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'fbwidget\controllers',
    //'language' => 'nl',
    'components' => [
	
	'authClientCollection' => [
		'class' => 'yii\authclient\Collection',
		'clients' => [
		  'facebook' => [
		    'class' => 'yii\authclient\clients\Facebook',
		    'authUrl' => 'https://www.facebook.com/dialog/oauth',
		    'clientId' => '507775869326944',
		    'clientSecret' => 'f4c6162186b0eae53b01723e198f6365',
		    'attributeNames' => ['name', 'email', 'first_name', 'last_name',],
		  ],
		],
	      ],

	
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'en', // Developer language
                    'sourceMessageTable' => '{{%source_message}}',
                    'messageTable' => '{{%message}}',
//                    'cachingDuration' => 86400,
//                    'enableCaching' => true,
                ],
            ],
        ],
        'request' => [
//            'baseUrl' => '',
            'csrfParam' => '_csrf-fbwidget',
        ],
        'user' => [
            'identityClass' => 'frontend\models\Client',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-fbwidget',
            //'savePath' => __DIR__ . '/../runtime', // a temporary folder on frontend
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'merchant/widgetview',
		'checkout/widget-index' => 'checkout/widget-index',
		'merchant/auth' => 'merchant/auth',
                'logout' => 'site/logout',
                'dashboard' => 'client/dashboard',
                'login' => 'site/login',
                'forget-password' => 'site/request-password-reset',
                'reset-password' => 'site/reset-password',
                'search' => 'merchant/search',
                
                //'<controller>/<action>' => '<controller>/<action>',
                'merchant/paypal-ipn' => 'merchant/paypal-ipn',
                'merchant/sign-up' => 'merchant/sign-up',
                'merchant/payment' => 'merchant/payment',
                'merchant/final-payment' => 'merchant/final-payment',
                'merchant/verification' => 'merchant/verification',
                'merchant/refine-search' => 'merchant/refine-search',
                'merchant/service' => 'merchant/service',
                'merchant/widget' => 'merchant/widget',
                'merchant/get-subcategory' => 'merchant/get-subcategory',
                'merchant/delete-order' => 'merchant/delete-order',
                'merchant/widgetview' => 'merchant/widgetview',
                'merchant/<id:[a-zA-Z0-9-]+>' => 'merchant/view',
                
                 
                '/<slug:[a-zA-Z0-9-]+>' => 'mt-custom-page/view',
                'merchant/package/<packageid:\d+>' => 'merchant/create',
		
                
                
                
            ],
        ],
        
        
//        'cache' => [
//            /* 'class' => 'yii\caching\FileCache', */
//            'class' => 'yii\caching\MemCache',
//            'servers' => [
//                [
//                    'host' => 'localhost',
//                    'port' => 11211,
//                ],
//            ],
//            'useMemcached' => true,
//            'serializer' => false,
//            
//        ],
        
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],
    ],
    'params' => $params,
];
