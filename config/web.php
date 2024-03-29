<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'StoCout',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '6u6w2pbtzykLSEl0J5WT1LLo6uggnEcv',
            //'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/security/login/'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'stockoutapp@gmail.com',
                'password' => 'STOCKOUTsoapp@2016',
                'port' => '587',
                'encryption' => 'tls',
            ],
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
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user',
                ],
            ],
        ],

        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'currencyCode' => 'RWF',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'dateFormat' => 'php:d-m-Y',
            'timeFormat' => 'php:H:i:s',
            'timeZone' => 'CAT'
        ],

    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableConfirmation' => false,
            'controllerMap' => [
                'register' => 'app\controllers\user\RegisterController'
            ],
            'modelMap' => [
                'RegistrationForm' => 'app\models\RegistrationForm',
                'User' => 'app\models\User',
            ]
        ],
        'utility' => [
            'class' => 'c006\utility\migration\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
