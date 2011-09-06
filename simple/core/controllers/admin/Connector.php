<?php

/*
 * Connector.php
 *
 * (C) 2011, StaySimple team.
 *
 * This file is part of StaySimple.
 * http://code.google.com/p/stay-simple-cms/
 *
 * StaySimple is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * StaySimple is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with StaySimple.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Connects the elFinder component to StaySimple allowing the upload and 
 * download of files.
 */
class Connector extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function start() {
        header('HTTP/1.0 403 Forbidden');
    }

    public function get() {
        $options = array(
            'root' => DATAROOT . '/uploads',
            'URL' => StaySimple::app()->getURL() . '/index.php/resource/file/',
            'lang' => Config::getInstance()->get('system.locale.language'),
            'debug' => false,
            'arc' => '7za',
            'fileURL' => true,
            'dotFiles' => false,
            'dirSize' => false,
            'uploadAllow' => array('image/png'),
            'uploadDeny' => array('image', 'text'),
            'uploadOrder' => 'deny,allow',
            'disabled' => array('edit', 'rename'),
            'tmbDir' => '_tmb',
            'defaults' => array(
                'read' => true,
                'write' => true,
                'rm' => true
            ),
        );

        if (($date = Config::getInstance()->get('system.locale.shortdateformat')) &&
                ($time = Config::getInstance()->get('system.locale.timeformat'))) {

            $options['dateFormat'] = "$date $time";
        }

        $finder = new elFinder($options);
        $finder->run();
    }

}
