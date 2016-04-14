<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'sandscape-management',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'dashboard',
    'components' => [
//TODO: ..
//        'i18n' => [
//            'translations' => [
//                '*' => [
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@app/messages'
//                ]
//            ]
//        ],
        'urlManager' => ['enablePrettyUrl' => true],
        'request' => [ 'cookieValidationKey' => '0S5_dBjBj92ikshC0BKrVeD0Lo_1S6YFb'],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['dashboard/login']
        ],
        'errorHandler' => [
            'errorAction' => 'dashboard/error'
        ]
    ],
    'params' => $params
];

return $config;
