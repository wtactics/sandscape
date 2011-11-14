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
        'application.extensions.*'
    ),
    'components' => array(
        'assetManager' => array(
            'basePath' => dirname(__FILE__) . '/../../www/_resources/assetscache/',
            'baseUrl' => '_resources/assetscache/'
        ),
        'user' => array(
            'allowAutoLogin' => true,
        ),
        //IMPORTANT!!: UPDATE DATABASE SETTINGS
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=<the name of your database>',
            'emulatePrepare' => true,
            'username' => '<the name of your database user>',
            'password' => '<the database user password>',
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
                    'levels' => 'error, warning',
                )
            )
        )
    ),
    //defaul parameters
    //IMPORTANT!!: CHANGE THE HASH VALUE WHEN IN PRODUCTION.
    //Note: Changing the hash value will invalidate any password you have, you will 
    //be locking your users out.
    'params' => array(
        'hash' => 'Demo, development hash, please change this in a production server'
    )
);