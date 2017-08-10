<?php
return [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'yourname@gmail.com',
                'password' => 'yourpassword',
                'port' => '587',
                'encryption' => 'tls',
            ],
            'htmlLayout' => '@vendor/yeesoft/yii2-yee-auth/views/mail/layouts/html',
            'textLayout' => '@vendor/yeesoft/yii2-yee-auth/views/mail/layouts/text',
        ],
    ],
];
