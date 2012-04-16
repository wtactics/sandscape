<?php

return array(
    'basePath' => dirname(__FILE__) . '/..',
    'name' => 'Sandscape',
    'charset' => 'utf-8',
    'import' => array(
        'application.models.*',
        'application.models.scserver.*',
        'application.components.*',
    ),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        //CONFIGURE THE FOLLOWING SETTINGS:
        /*'db' => array(
            'connectionString' => 'mysql:host=<HOST ADDRESS>;dbname=<DATABASE NAME>',
            'emulatePrepare' => true,
            'username' => '<DATABASE USER>',
            'password' => '<DATABASE PASSWORD>',
            'charset' => 'utf8'
        ),*/
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    ),
    'params' => include('params.php')
);