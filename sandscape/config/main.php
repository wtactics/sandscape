<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Sandscape',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
        )
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=sandscape',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'toor',
            'charset' => 'utf8',
            'enableProfiling' => true
        ),
        'urlManager' => array(
            'urlFormat' => 'path'
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'trace, info, error, warning',
                ),
                array(
                  'class' => 'CWebLogRoute',
                    'levels' => 'trace, info, error, warning',
                    'categories' => 'system.db.CDbCommand'
                    
                ),
                array(
                    'class' => 'CProfileLogRoute',
                    'report' => 'summary',
                ),
            ),
        ),
    ),
);
