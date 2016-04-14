<?php

$db = require(__DIR__ . '/db.php');
$params = require(__DIR__ . '/params.php');
$mail = require(__DIR__ . '/mail.php');

$config = [
    'version' => '- unset -',
    'vendorPath' => __DIR__ . '/../../../vendor',
    'components' => [
        'cache' => [ 'class' => 'yii\caching\FileCache'],
        'mailer' => $mail,
        'db' => $db
    ],
    'params' => $params
];

if (defined('YII_DEBUG')) {
    $config['components']['log'] = [
        'traceLevel' => 3,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning']
            ]
        ]
    ];
}

if (defined('YII_ENV') && YII_ENV == 'dev' && is_file(__DIR__ . '/config.local.php')) {
    include __DIR__ . '/config.local.php';
}

return $config;
