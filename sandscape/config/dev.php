<?php

return array(
    'basePath' => dirname(__FILE__) . '/..',
    'name' => 'Sandscape',
    'preload' => array('log'),
    'charset' => 'utf-8',
    'import' => array(
        'application.models.*',
        'application.models.scserver.*',
        'application.components.*',
        'application.extensions.*',
    ),
    // application components
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=sandscape',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'toor',
            'charset' => 'utf8'
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                ),
            //array(
            //    'class' => 'CWebLogRoute',
            //    'categories' => 'system.db.*'
            //)
            )
        )
    ),
    'params' => include('params.dev.php')
);