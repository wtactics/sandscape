<?php

/* main.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
return array(
    'basePath' => dirname(__FILE__) . '/..',
    'name' => 'Sandscape',
    'preload' => array('log', 'bootstrap'),
    'import' => array(
        'application.models.*',
        'application.models.scserver.*',
        'application.components.*',
        'application.extensions.*',
    ),
    // application components
    'components' => array(
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap'
        ),
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.css' => false
            )
        ),
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
            'showScriptName' => false,
            'caseSensitive' => false,
        ),
        // setup mysql, please check Yii's documentation on how to use other database 
        // engines.
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=sandscape',
            'emulatePrepare' => true,
            'username' => '<YOUR DB USERNAME>',
            'password' => '<YOUR DB PASSWORD>',
            'charset' => 'utf8',
            'tablePrefix' => ''
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    // activates logs, make sure runtime is writable and debug.php exists in 
    // you www folder.
    // 
    //'log' => array(
    //    'class' => 'CLogRouter',
    //    'routes' => array(
    //        array(
    //            'class' => 'CFileLogRoute',
    //            'levels' => 'error',
    //        ),
    //    )
    //)
    ),
    'params' => include('params.php')
);
