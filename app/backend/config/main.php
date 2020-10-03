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
        'gridview' => ['class' => 'kartik\grid\Module'],
        'rbac'     => 'dektrium\rbac\RbacWebModule',
        'user' => [
            // following line will restrict access to profile, recovery, registration and settings controllers from backend
            // 'as backend'             => 'dektrium\user\filters\BackendFilter',
            'class'                  => 'dektrium\user\Module',
            // 'controllers'            => ['profile', 'recovery', 'registration', 'settings'],
            'enableUnconfirmedLogin' => true,
            'confirmWithin'          => 21600,
            'cost'                   => 12,
            'admins'                 => ['admin'],
            // 'urlPrefix'              => 'auth'
        ],
    ],
    'components' => [
        'mailer' => [
        ],
        // 'authManager' => [
        //     'class' => 'yii\rbac\DbManager',
        // ],
        'view' => [
             'theme' => [
                 'pathMap' => [
                    // '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app',
                    '@app/views'           => '@backend/views',
                    '@dektrium/user/views' => '@backend/views/user'
                 ],
             ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-black',
                ],
                '@app\assets\AdminAsset',
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        // 'user' => [
        //     'identityCookie' => [
        //         'name'     => '_backendIdentity',
        //         'path'     => '/admin',
        //         'httpOnly' => true,
        //     ],
        // ],
        'session' => [
            'name' => 'BACKENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path'     => '/admin',
            ],
        ],
        // 'user' => [
        //     'enableAutoLogin' => true,
        //     'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        // ],
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
                    'categories' => ['yii\swiftmailer\Logger::add'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '<controller:\w+>/<id:\d+>'              => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
            ],
        ],
        
    ],
    'params' => $params,
];
