<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'sandscape',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'sandscape',
    'components' => [
        //TODO: ..
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages'
                ]
            ]
        ],
        'urlManager' => ['enablePrettyUrl' => true],
        'request' => [ 'cookieValidationKey' => '0S5_dBjBj92ikshC0BKrVeD0Lo_1S6YFb'],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['sandscape/login']
        ],
        'errorHandler' => [
            'errorAction' => 'sandscape/error'
        ]
    ],
    'params' => $params
];

return $config;
