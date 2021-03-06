<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-mapi',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'article/index',
    'controllerNamespace' => 'mapi\controllers',
    'components' => [

        'urlManager' => [
            'class' => 'yeesoft\web\MultilingualUrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'suffix' => '.json',
            'rules' => [
                'cms/<action:(category|tag)>/<slug:[\w \-]+>' => 'article/<action>',
                [
                    'pattern' => 'article/<year:\d{4}>/<month:\d{2}>/<slug:[\w \-]+>',
                    'route' => 'article/index/',
                    'suffix' => '.html',
                ],
                'cms/<action:[\w \-]+>' => 'article/<action>',
                'cms/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],

        'request' => [
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],

        'response' => [
            'class' => 'common\components\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $data = [
                    'status' => $response->statusCode,
                    'errno' => 0,
                    'errmsg' => '操作成功',
                    'data' => []
                ];

                if ($response->statusCode != 200) {
                    //log_access('errno', $response->data['code']);
                    //log_access('error', $response->data['message']);
                    $response->data = array_merge($data, [
                        'errno' => $response->data['code'] != 0 ? $response->data['code'] : intval('9'.$response->statusCode),
                        'errmsg' => $response->data['message'],
                    ]);
                    $response->statusCode = 200;
                } elseif (!isset($response->data['errno'])) {
                    $response->data = array_merge($data, [
                        'data' => $response->data,
                    ]);
                } else {
                    $response->data = array_merge($data, $response->data);
                }
                $response->data['data'] = is_array($response->data['data']) && empty($response->data['data']) ? new \StdClass() : $response->data['data'];
            },
        ],


        'session' => [
            // this is the name of the session cookie used for login on the mapi
            'name' => 'advanced-mapi',
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
