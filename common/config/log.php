<?php
/**
 * 日志配置
 *
 **/

return [
    /**
     * 'flushInterval' => 1, targets = [ 'exportInterval' => 1] 立即导出日志
     */
    'traceLevel' => YII_DEBUG ? 0 : 0, //traceLevel=3 ， debug模式下将被追加最多3个
    'targets' => [
        //自定义错误和警告
        [
            'class' 	 => 'yii\log\FileTarget',
            'levels' 	 => ['error', 'warning'],
            'logVars' 	 => [],
            'logFile' 	 => '@logRoot/app.wf.' . date('Ymd')
        ],
        //系统错误和警告
        [
            'class' 	 => 'yii\log\FileTarget',
            'levels' 	 => ['error', 'warning'],
            'logVars' 	 => [],
            'logFile' 	 => '@logRoot/framework.wf.' . date('Ymd')
        ],
        //SQL
        [
            'class' 	 => 'yii\log\FileTarget',
            'levels' 	 => ['info'],
            'logVars' 	 => [],
            'enableRotation' => false,
            'categories' => ['yii\db\*'],
            'logFile' 	 => '@logRoot/db.log.' . date('Ymd')
        ]

    ]
];