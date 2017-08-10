<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['comments', 'yee'],
    'language' => 'zh-CN',
    'sourceLanguage' => 'en-US',
    'components' => [
        'yee' => [
            'class' => 'yeesoft\Yee',
            'languages' => ['zh-CN' => '中文', 'en-US' => 'English'],
            'languageRedirects' => ['zh-CN' => 'zh', 'en-US' => 'en'],
            'dashboardLayout' => '@backend/views/layouts/main.php'
        ],
        'settings' => [
            'class' => 'yeesoft\components\Settings'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'yeesoft\components\User',
            'on afterLogin' => function ($event) {
                \yeesoft\models\UserVisitLog::newVisitor($event->identity->id);
            },
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            'class' => 'yii\web\Session',
            // this is the name of the session cookie used for login on the backend
            'name' => 'guantian-backend',
        ],

        'log' => require_once dirname(__FILE__).'/log.php',

        'db' => require_once dirname(__FILE__).'/db.php',
    ],
    'modules' => [
        'comments' => [
            'class' => 'yeesoft\comments\Comments',
            'userModel' => 'yeesoft\models\User',
            'userAvatar' => function ($user_id) {
                $user = yeesoft\models\User::findIdentity((int)$user_id);
                if ($user instanceof yeesoft\models\User) {
                    return $user->getAvatar();
                }
                return false;
            }
        ],
    ],
];
