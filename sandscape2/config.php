<?php

//use 'index.php' if htaccess not allowed
$config['index_page'] = 'index.php';
//it correspont to .htaccess BASENAME, leave empty if you are in document_root, or set /foldername/ (both slashes) if not
$config['basename'] = "/sandscape/";
//alternative: "qs"  define if rapyd will use uri or query string for its semantic
$config['url_method'] = "uri";
$config['default_controller'] = 'about';
$config['default_method'] = 'index';


$config['include_paths'] = array('core', '../sandscape2');

$config['root_path'] = getenv("DOCUMENT_ROOT"); // or './../../';

$config['assets_path'] = RAPYD_PATH . 'core/assets/';
$config['cache_path'] = RAPYD_ROOT . 'cache/';
$config['locale_language'] = 'en_US';

$config['routes'] = array(
        //'product/(:num)/:str' => 'catalogmodule/product/$1';
);

$config['db']['hostname'] = "127.0.0.1";
$config['db']['username'] = "root";
$config['db']['password'] = "toor";
$config['db']['database'] = 'sandscape';
$config['db']['dbdriver'] = "mysql";
$config['db']['dbprefix'] = "";
$config['db']['db_debug'] = true;
/**
 * custom configurations
 *
 */
