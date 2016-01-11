<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;dbname=school',
            'username' => 'school_user',
            'password' => '98Ffew7hyF8_d',
            'charset' => 'utf8',
            'tablePrefix' => 'school_',
            'schemaMap' => [
                'pgsql'=> [
                    'class'=>'yii\db\pgsql\Schema',
                    'defaultSchema' => 'public' //specify your schema here
                ]
            ], // PostgreSQL
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@bower/jquery/dist' : null,   // do not publish the bundle
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                    ]
                ],
            ],
            // принудительн обновит файлы
            'appendTimestamp' => true,
        ],
    ],
];
