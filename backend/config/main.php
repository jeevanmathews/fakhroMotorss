<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
     'gii' => [
                'class' => 'yii\gii\Module',
                 // permits any and all IPs
                 // you should probably restrict this
                'allowedIPs' => ['*']
            ],
        ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'view' => [
            'theme' => [
                'basePath' => '@app/web/themes/adminLTE',
                'baseUrl' => '@web/themes/adminLTE',
                'pathMap' => [
                    '@app/views' => '@app/web/themes/adminLTE/views',
                ],
            ],
        ],
        
        'urlManager' => [
        'enablePrettyUrl' => false,
        'showScriptName' => false,
        'rules' => [
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            '<controller:\w+>/<id:\d+>/<slug:\w+>' => '<controller>/view',
            '<controller:\w+>/<id:\d+>'  =>'<controller>/<action>'
            ],
        ],
       
    ],
    'params' => $params,
];
