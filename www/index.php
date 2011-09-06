<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('magic_quotes_runtime', 0);

session_start();


$filepath = str_replace('\\', '/', __FILE__);
$cwd = realpath(dirname(__FILE__) . '/../rapyd');
$app = realpath(dirname(__FILE__) . '/../sandscape2');
define('DOC_ROOT', substr($filepath, 0, strrpos($filepath, $_SERVER['SCRIPT_NAME'])));

define('RAPYD_ROOT', $cwd . DIRECTORY_SEPARATOR);
define('RAPYD_PATH', str_replace(DOC_ROOT, '', str_replace('\\', '/', RAPYD_ROOT)));
define('RAPYD_VERSION', '0.9');
define('RAPYD_BUILD_DATE', '2011-06-05');

define('RAPYD_BENCH_TIME', microtime(true));
define('RAPYD_BENCH_MEMORY', memory_get_usage());

define('RAPYD_APP_ROOT', $app . '/');

unset($filepath, $cwd, $app);


include_once(RAPYD_ROOT . 'core/helpers/compat.php');
include_once(RAPYD_ROOT . 'core/libraries/rapyd.php');

spl_autoload_register(array('rpd', 'auto_load'));

set_exception_handler(array('rpd', 'exception_handler'));
set_error_handler(array('rpd', 'error_handler'));

//include_once(RAPYD_ROOT . 'application/config.php');
include_once(RAPYD_APP_ROOT . 'config.php');

setlocale(LC_TIME, $config['locale_language'], $config['locale_language'] . ".utf8");


rpd::init($config);
rpd::connect();
rpd::run();
