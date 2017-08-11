<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'backend',
    'name' => '观天数据管理后台',
    'homeUrl' => '/cms',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'settings' => [
            'class' => 'yeesoft\settings\SettingsModule',
        ],
        'menu' => [
            'class' => 'yeesoft\menu\MenuModule',
        ],
        'translation' => [
            'class' => 'yeesoft\translation\TranslationModule',
        ],
        'user' => [
            'class' => 'yeesoft\user\UserModule',
        ],
        'media' => [
            'class' => 'yeesoft\media\MediaModule',
            'routes' => [
                'baseUrl' => '', // Base absolute path to web directory
                'basePath' => '@root', // Base web directory url
                'uploadPath' => 'uploads', // Path for uploaded files in web directory
            ],
        ],
        'post' => [
            'class' => 'yeesoft\post\PostModule',
            'viewPath' => '@yeesoft/yii2-yee-post/views',
            'viewList' => [
                'article' => '资讯',
            ],
            'layoutList' => [
                'mobile' => '移动端',
            ],
        ],
        'page' => [
            'class' => 'yeesoft\page\PageModule',
        ],
        'seo' => [
            'class' => 'yeesoft\seo\SeoModule',
        ],
        'comment' => [
            'class' => 'yeesoft\comment\CommentModule',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '/cms',
            'csrfParam' => '_csrf-backend',
        ],
        'view' => [
            'class' => 'yii\web\View',
            'theme' => [
                'basePath' => '@app/themes/post',
                'baseUrl' => '@web/themes/post',
                'pathMap' => [
                    '@vendor/yeesoft/yii2-yee-post/views' => '@app/themes/post',
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yeesoft\web\MultilingualUrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'multilingualRules' => false,
            'rules' => array(
                //add here local frontend controllers
                //'<controller:(test)>' => '<controller>/index',
                //'<controller:(test)>/<id:\d+>' => '<controller>/view',
                //'<controller:(test)>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                //'<controller:(test)>/<action:\w+>' => '<controller>/<action>',
                //yee cms and other modules routes
                '<module:\w+>/' => '<module>/default/index',
                '<module:\w+>/<action:\w+>/<id:\d+>' => '<module>/default/<action>',
                '<module:\w+>/<action:(create)>' => '<module>/default/<action>',
                '<module:\w+>/<controller:\w+>' => '<module>/<controller>/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            )
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
    ],
    'params' => $params,
];
