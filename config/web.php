<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'pt-br',
    'timezone' => 'America/Manaus',

    'components' => [
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                header("Access-Control-Allow-Origin: *");
            }
        ],
        'formatter' => [
            'defaultTimeZone' => 'America/Manaus',
            'dateFormat' => 'php:d/m/Y',
            'timeFormat' => 'php:H:i',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            //'cookieValidationKey' => 'xHXvEKrKe9x5aZmM_h6cqX3AZGU01rfi',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'class' => 'yii\web\User',
            'enableSession' => false,
            //'enableAutoLogin' => false,
            'loginUrl' => null,
        ],

        'usuario' => [
            'identityClass' => 'app\models\Usuario',
            'class' => 'yii\web\Usuario',
            'enableSession' => false,
            //'enableAutoLogin' => false,
            'loginUrl' => null,
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => 'api/default',
                    //'POST <version:[\w-]+>/users/verify' => '<version>/user',

                    // OPTTIONS URI ENDPOINTS
                    //'OPTIONS <version:[\w-]+>/users/verify' => '<version>/user',
                ]
            ],
        ],

    ],
    'params' => $params,
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\ApiModule',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*'],
    ];
}

return $config;
