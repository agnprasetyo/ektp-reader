<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Sistem Seleksi Beasiswa KIP',

    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'authTimeout' => 3600, // auth expire
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'class' => 'yii\web\Session',
            'cookieParams' => ['lifetime' => 1 * 1 *1 * 3],
            'timeout' => 3600*30, //session expire
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

        'assetManager' => [
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => false,
                'yii\bootstrap\BootstrapAsset' => false,
                'yii\bootstrap\BootstrapPluginAsset' => false,
                'wbraganca\dynamicform\DynamicFormAsset' => false,
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'gridview' =>  [
          'class' => '\kartik\grid\Module'
        ]
    ],

    'container' => [
        'definitions' => [
            \yii\widgets\LinkPager::class => \yii\bootstrap4\LinkPager::class,
        ],
    ],
];
