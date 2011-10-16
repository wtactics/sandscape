<?php

return array(
    'basePath' => dirname(__FILE__) . '/..',
    'name' => 'SandScape',
    // preloading 'log' component
    'preload' => array('log'),
    'charset' => 'utf-8',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    // application components
    'components' => array(
        'assetManager' => array(
            'basePath' => dirname(__FILE__) . '/../../www/_resources/assetscache/',
            'baseUrl' => '_resources/assetscache/'
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        //IMPORNTAT!!: UPDATE DATABASE SETTINGS
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=<the name of your database>',
            'emulatePrepare' => true,
            'username' => '<the name of your database user>',
            'password' => '<the database user password>',
            'charset' => 'utf8'
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                )
            )
        )
    )
);