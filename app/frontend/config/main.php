<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ],
        'view' => [
             'theme' => [
                 'pathMap' => [
                    '@app/views' => '@frontend/views'
                 ],
             ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-green',
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                 'assignment' => [
                    'class'            => 'mdm\admin\controllers\AssignmentController',
                    /* 'userClassName' => 'app\models\User', */
                    'idField'          => 'user_id',
                    'usernameField'    => 'username',
                    'fullnameField'    => 'profile.full_name',
                    'extraColumns'     => [
                        [
                            'attribute' => 'full_name',
                            'label'     => 'Full Name',
                            'value'     => function($model, $key, $index, $column) {
                                return $model->profile->full_name;
                            },
                        ],
                        // [
                        //     'attribute' => 'dept_name',
                        //     'label'     => 'Department',
                        //     'value'     => function($model, $key, $index, $column) {
                        //         return $model->profile->dept->name;
                        //     },
                        // ],
                        // [
                        //     'attribute' => 'post_name',
                        //     'label'     => 'Post',
                        //     'value'     => function($model, $key, $index, $column) {
                        //         return $model->profile->post->name;
                        //     },
                        // ],
                    ],
                    'searchClass' => 'app\models\UserSearch'
                ],
            ],
        ],
        'gridview' => ['class' => 'kartik\grid\Module']
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'gii/*',
            'crm/*',
            'status-crm/*',
            'contact/*',
            'client/*',
            'client-type/*',
            'type-crm/*',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
];
