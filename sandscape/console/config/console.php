<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'sandscape-console',
    'basePath' => dirname(__DIR__),
    'params' => $params,
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationTable' => 'YiiMigrationCtl',
            'templateFile' => '@console/views/migration.php',
            'migrationPath' => '@container/migrations',
            'interactive' => 0
        ]
    ]
];

return $config;

