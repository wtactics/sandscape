<?php

//If needed, change the paths below:
$app = '../simple';
$data = '../simple/data';
$themes = '../simple/themes';
$plugins = '../simple/plugins';

//finding the absolute paths and creating constants
$base = dirname(__FILE__);

define('WEBROOT', realpath($base));
define('APPROOT', realpath($base . '/' . $app));
define('DATAROOT', realpath($base . '/' . $data));
define('THEMEROOT', realpath($base . '/' . $themes));
define('PLUGINROOT', realpath($base . '/' . $plugins));

unset($app, $data, $themes, $plugins, $base);

define('SSVERSION', '1.4');

//checking development mode
if (is_file(WEBROOT . '/dev.unlock')) {
    define('DEVELOPMENTMODE', true);
}