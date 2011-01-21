<?php

error_reporting(E_ALL);

$sandscape = '../sandscape/';

if (strpos($sandscape, '/') === FALSE) {
    if (function_exists('realpath') AND realpath(dirname(__FILE__)) !== FALSE) {
        $sandscape = realpath(dirname(__FILE__)) . '/' . $sandscape;
    }
} else {
    $sandscape = str_replace("\\", "/", $sandscape);
}

define('DATAPATH', $sandscape . 'data/');
define('SYSTEMPATH', $sandscape . 'system/');
define('VIEWSPATH', $sandscape . 'views/');
define('LANGPATH', $sandscape . 'lang/');

function __autoload($class) {
    include SYSTEMPATH . strtolower($class) . '.php';
}

function app() {
    global $controller;
    return $controller;
}

function url() {
    return 'http://localhost/sandscape/';
}

$controller = new SandController();
$controller->doRequest();