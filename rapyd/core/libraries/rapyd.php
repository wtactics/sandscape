<?php

/**
 * Rapyd Superclass provides all main functions (autoload, routing, run, db initialization)
 * 
 *
 * @package    Core
 * @author     Felice Ostuni
 * @copyright  (c) 2011 Rapyd Team
 * @license    http://www.rapyd.com/license
 */
class rpd {

    public static $config;
    public static $lang;
    public static $working_path;
    public static $ob_level;
    public static $qs;
    public static $uri;
    public static $auth;
    public static $uri_string;
    public static $controller;
    public static $method;
    public static $params = array();
    public static $db;
    public static $routed = false;
    public static $main_controller;

    /**
     * init is called (from index.php or include.php) one time per execution
     * it parse config.php (from each inclusion path) and load all language/i18n strings
     * @param array $config 
     */
    public static function init($config) {
        self::$config = $config;
        self::$qs = new rpd_url_helper(); //keep compatibility
        self::$uri = new rpd_url_helper();
        self::$auth = new rpd_auth_library();

        if (!defined('RAPYDASSETS')) {
            define('RAPYDASSETS', $config['assets_path']);
        }
        include_once RAPYD_ROOT . 'core/i18n/' . self::$config['locale_language'] . '.php';
        self::$lang = $lang;

        //init application & modules
        foreach (self::$config['include_paths'] as $path) {
            if (is_file(RAPYD_ROOT . $path . '/config.php')) {
                $config = array();
                require_once RAPYD_ROOT . $path . '/config.php';
                self::$config = array_merge_recursive(self::$config, $config);
            }
            if (is_file(RAPYD_ROOT . $path . '/init.php')) {
                include_once RAPYD_ROOT . $path . '/init.php';
            }
            if (is_file(RAPYD_ROOT . $path . '/i18n/' . self::$config['locale_language'] . '.php')) {
                $lang = array();
                include_once RAPYD_ROOT . $path . '/i18n/' . self::$config['locale_language'] . '.php';
                self::$lang = array_merge(self::$lang, $lang);
            }
        }
    }

    /**
     * return a config value from (/application/config.php)
     * 
     *  <code>
     * rpd::config('itemname');
       * </code>
     * @param string $item
     * @return mixed item value
     */
    public static function config($item) {
        if (strpos($item, '.') !== false) {
            $item_arr = explode('.', $item);
            $path = self::$config;
            foreach ($item_arr as $i) {
                if (!isset($path[$i]))
                    return false;
                $path = $path[$i];
            }
            return $path;
        }
        if (!isset(self::$config[$item])) {
            return FALSE;
        }
        return self::$config[$item];
    }

    /**
     * class autoloader
     *
     * @param string $class
     * @return bool loaded or not 
     */
    public static function auto_load($class) {
        if (class_exists($class, FALSE))
            return TRUE;
        if (($suffix = strrpos($class, '_')) > 0) {
            // Find the class prefix and suffix
            $prefix = substr($class, 0, $suffix);
            $suffix = substr($class, $suffix + 1);
        }

        $path = '';
        $file = str_replace('rpd_', '', str_replace('_' . $suffix, '', $class));

        if ($suffix === 'field') {
            $suffix = 'library';
            $path = 'fields/';
        } elseif ($suffix === 'driver') {
            $suffix = 'library';
            $path = 'drivers/';
        } elseif (in_array($class, array('dataset', 'datagrid'))) {
            $suffix = 'library';
        }
        //hack for CI integration (nota.. i file creati in CI non devono avere suffisso _helper _field ecc..)
        if (@$prefix != 'CI' AND (in_array($suffix, array('helper', 'field', 'driver', 'library', 'controller', 'model')) OR strpos(@$prefix, 'rpd_') !== false)) {
            self::load($suffix, $path . $file);
        } else {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * find and load a php file (if controller instancing it)
     *
     * @param type $directory
     * @param type $file_name
     * @return void 
     */
    public static function load($directory, $file_name) {
        if ($file_name == 'rpd')
            return null;

        $file = self::find_file($directory, $file_name);
        if ($file) {
            require_once $file;

            //if we loaded a controller, need to save $working_path for speedup views inclusion
            if ($directory == 'controller') {
                self::$working_path = dirname($file) . '/';
                self::$ob_level = ob_get_level();
            }
            // If name contains segments, get last segment for function and class
            if (preg_match("/^.*\/(\w+)$/", $file_name, $matches)) {
                $file_name = $matches[1];
            }

            return null;
        }
        else
            self::error(ucfirst($directory) . ' file doesn\'t exist: ' . $file_name);
    }

    /**
     * plural helper function is needed because you can add custom folders in include_paths
     * (application, modules/modulex, system), for example: "resources/"
     * then find_file('resource', 'name') will search in:
     * /application/resourcES/name.php
     * /modules/modulex/resourcES/name.php
     * /system/resourcES/name.php

     * @param string $str
     * @return string plural version of $str
     */
    protected static function plural($str) {
        if (preg_match('/[sxz]$/', $str) OR preg_match('/[^aeioudgkprt]h$/', $str)) {
            $str .= 'es';
        } elseif (preg_match('/[^aeiou]y$/', $str)) {
            $str = substr_replace($str, 'ies', -1);
        } else {
            $str .= 's';
        }
        return $str;
    }

    /**
     * find a file-path according with configured include_paths 
     * and passed type and name of file
     *
     * @param string $type
     * @param string $file_name
     * @param string $ext
     * @return mixed full file-path (or false on fnf)
     */
    public static function find_file($type, $file_name, $ext = 'php') {
        static $file_cache;


        if ($type != "" && !strpos($type, '/'))
            $type = self::plural($type);
        $search = $type . '/' . $file_name . '.' . $ext;

        if (isset($file_cache['paths'][$search]))
            return $file_cache['paths'][$search];

        $file_found = FALSE;
        if (strpos($search, "modules") !== false) {
            if (is_file(RAPYD_ROOT . $search)) {
                $file_found = RAPYD_ROOT . $search;
            }
        } else {
            foreach (self::config('include_paths') as $path) {

                if (is_file(RAPYD_ROOT . $path . '/' . $search)) {
                    $file_found = RAPYD_ROOT . $path . '/' . $search;
                    break;
                }
            }
        }
        return $file_cache['paths'][$search] = $file_found;
    }

    /**
     * parses current application URI to determine which controller and method to call.
     * it's called by run() function (inside index.php)
     *
     *
     * @return mixed true on success, 404 page on error  
     */
    public static function router() {

        self::$uri_string = rpd_url_helper::get_uri();
        self::$uri_string = self::reroute(self::$uri_string, self::config('routes'));

        if (!preg_match('/[^A-Za-z0-9\:\/\.\-\_\#]/i', self::$uri_string) || empty(self::$uri_string)) {
            if (self::$uri_string == '')
                $segment_arr = array();
            else
                $segment_arr = explode('/', self::$uri_string);

            // defaults
            $controller_name = self::config('default_controller');
            $method_name = self::config('default_method');
            $params = array();


            // if URL segments exist, overwrite defaults
            $controller = true;
            if (count($segment_arr) > 0) {
                $controller = false;
                $arr_segment = array();

                while ($segment_arr) {
                    $path = implode('/', $segment_arr);
                    $arr_segments[] = array_pop($segment_arr);

                    // starting from last segment.. searching for a valid controller
                    // when is found, next segment is the method and others are params
                    $controller = self::find_file('controller', $path);
                    if ($controller) {
                        $controller_name = $path;

                        $arr_segments = array_reverse($arr_segments);
                        if (isset($arr_segments[1]))
                            $method_name = $arr_segments[1];
                        if (isset($arr_segments[2]))
                            $params = array_slice($arr_segments, 2);

                        break;
                    }
                }
            }

            if (!$controller) {
                self::error('404');
            } else {
                $controller_name .='_controller';
                self::$controller = new $controller_name;
                self::$method = str_replace('-', '_', $method_name);
                self::$params = $params;
            }
            return true;
        }
        else
            self::error('The URL you entered contains illegal characters.');
    }

    /**
     * reroute function is called by router(), it check routes array to find a route
     * inspired by caffeinephp
     * 
     * @param string $uri
     * @param array $routes
     * @return string uri or (if route exists) routed uri 
     */
    public static function reroute($uri, $routes=array()) {
        if ($routes) {
            foreach ($routes as $regex => $dest) {
                $regex = '^' . $regex;
                $regex = str_replace(':num', '[0-9]{1,}', $regex);
                $regex = str_replace(':str', '[A-Za-z]{1,}$', $regex);
                $regex = str_replace(':any', '[A-Za-z0-9-_/]{1,}$', $regex);
                $regex = $regex . '$';
                if (preg_match_all('@' . $regex . '@', $uri, $matches, PREG_SET_ORDER)) {
                    $count = 0;
                    foreach ($matches[0] as $match) {
                        $dest = str_replace('$' . $count, $match, $dest);
                        $count++;
                    }
                    return $dest;
                }
            }
        }
        return $uri;
    }

    /**
     * load a view file, passing it an associative array of
     * php vars we need in page
     *
     * @param string $file_name not a full path, just view name
     * @param array $input_data  array key=>val for subtitutions
     * @return string the output "parsed" content
     */
    public static function view($file_name, $input_data=array()) {
        $rpd = rpd::$main_controller;

        $input_data = (array) $input_data;

        if (strpos($file_name, '/')) {
            //die(dirname($file_name).' '.basename($file_name));
            $view_path = self::find_file(dirname($file_name), basename($file_name));
        } else {
            $view_path = str_replace('controllers', 'views', self::$working_path) . $file_name . '.php';
        }

        if (is_a($rpd, 'admin_controller') || is_subclass_of($rpd, 'admin_controller')) {
            $view_path = self::find_file('view', 'admin/' . $file_name);
        }
        if (!is_file($view_path)) {
            $view_path = self::find_file('view', $file_name);
        }
        if (!is_file($view_path) && self::config('cms.theme')) {

            $view_path = self::config('cms.theme') . $file_name . '.php';
        }

        ob_start();

        extract($input_data, EXTR_SKIP);

        //$trace = debug_backtrace(false); 


        include $view_path;

        $output = ob_get_contents();
        //ob_end_clean();

        $output = ob_get_clean();
        $output = str_replace('{time}', self::benchmarks('time'), $output);
        $output = str_replace('{memory}', self::benchmarks('memory'), $output);

        /*
          if (ob_get_level() > self::$ob_level + 1)
          {
          ob_end_flush();
          }
         */
        return $output;
    }

    /**
     * benchmarks return execution time or memory usage 
     * you can use it in views with this placeholder: {time} {memory}
     * 
     * @param string $aspect time or memory
     * @return string 
     */
    public static function benchmarks($aspect='time') {
        if ($aspect == 'time') {
            return number_format((microtime(true) - RAPYD_BENCH_TIME), 3) . 'sec';
        } elseif ($aspect == 'memory') {
            return number_format((memory_get_usage() - RAPYD_BENCH_MEMORY) / 1024 / 1024, 2) . 'MB';
        }
    }

    /**
     *  display application errors
     *
     * @param string $message 
     */
    public static function error($message) {
        self::run('error', 'error_message', array($message));
        exit(1);
    }

    /**
     * error handling
     *
     * @param int $code
     * @param type $error
     * @param string $file
     * @param int $line
     * @return mixed 
     */
    public static function error_handler($code, $error, $file = NULL, $line = NULL) {
        if (error_reporting() & $code) {
            throw new ErrorException($error, $code, 0, $file, $line);
        }
        return TRUE;
    }

    /**
     * error handling
     * 
     * @param Exception $e 
     */
    public static function exception_handler(Exception $e) {
        try {
            $type = get_class($e);
            $code = $e->getCode();
            $message = $e->getMessage();
            $file = $e->getFile();
            $line = $e->getLine();
            $trace = $e->getTraceAsString();

            $errors = array(
                E_ERROR => 'Fatal Error',
                E_USER_ERROR => 'User Error',
                E_PARSE => 'Parse Error',
                E_WARNING => 'Warning',
                E_USER_WARNING => 'User Warning',
                E_STRICT => 'Strict',
                E_NOTICE => 'Notice',
                E_RECOVERABLE_ERROR => 'Recoverable Error',
            );
            if (isset($errors[$code])) {
                $code = $errors[$code];
            }

            if (!headers_sent())
                header('HTTP/1.1 500 Internal Server Error');
            self::run('error', 'error_message', array("'$message' in $file($line)\n\nCall Stack:\n$trace"));
            //self::run('error','error_message',array($code.', '.$message.', '.$file.', '.$line));
            //return TRUE;
        } catch (Exception $e) {
            echo strip_tags($e->getMessage()) . ' on ' . $e->getFile() . ' line [' . $e->getLine() . "]\n";
            exit(1);
        }
    }

    /**
     * lang get i18n string in the configured language
     * 
     * @param string $key
     * @param array $args  needed only for string with substitutions placeholders
     * @return strung  a language string
     */
    public static function lang($key = null, $args = array()) {
        if (strpos($key, '.*')) {
            $namespace = str_replace('*', '', $key);
            $array = array();
            foreach (self::$lang as $subkey => $value) {
                if (strpos($subkey, $namespace) !== false) {
                    $subkey = str_replace($namespace, '', $subkey);
                    $array[$subkey] = $value;
                }
            }
            return $array;
        }
        if ($key == '' OR !isset(self::$lang[$key])) {
            return $key;
        }

        $string = self::$lang[$key];
        if ($args == '') {
            return $string;
        } else if (is_array($args)) {
            return vsprintf($string, $args);
        } else {
            return sprintf($string, $args);
        }
    }

    /**
     * run() instance a controller and execute one of it's methods
     * (using parameters or detecting it by current url), 
     * if no valid controller/method was found it throw 404 error
     * 
     * @param string $controller
     * @param string $method
     * @param array $params
     * @return mixed 
     */
    public static function run($controller=null, $method=null, $params=array()) {
        if (isset($controller) && strpos($controller, '{controller}') !== false) {
            $controller = str_replace('{controller}', str_replace('_controller', '', get_class(self::$main_controller)), $controller);
        }

        if (isset($controller) AND is_array($controller)) {
            $controller = $controller[1];
            self::$uri_string = $controller;
        }

        //this case we have a rpd::run('controller/method/..')
        if (isset($controller) AND !isset($method) AND strpos($controller, '/')) {
            $segment_arr = explode('/', $controller);
            self::$uri_string = $controller;
            while ($segment_arr) {
                $path = implode('/', $segment_arr);
                $arr_segments[] = array_pop($segment_arr);

                $controller = self::find_file('controller', $path);
                if ($controller) {
                    $controller = $path;

                    $arr_segments = array_reverse($arr_segments);
                    if (isset($arr_segments[1]))
                        $method = $arr_segments[1];
                    if (isset($arr_segments[2]))
                        $params = array_slice($arr_segments, 2);

                    break;
                }
            }
            //if controller is still false, i must stop here with empty result, because the resource was not found
            if ($controller === false)
                return false;
        }




        //controller called using parameters
        if (isset($controller, $method)) {
            self::$uri_string = $controller . '/' . $method . '/' . implode('/', $params);
            $controller .= '_controller';
            self::$controller = new $controller(); //self::load('controller', $controller);
            self::$method = str_replace('-', '_', $method);
            self::$params = $params;
            self::$routed = false;
        }
        //autodetect controller by router
        else {
            self::$routed = true;
            self::router();
        }

        $controller = self::$controller;
        $method = self::$method;
        $params = self::$params;

        if (is_object($controller)) {
            if (isset(self::$db))
                $controller->db = self::$db;
            $controller->qs = self::$qs;
            $controller->uri = self::$uri;
            $controller->uri_string = self::$uri_string;
            $controller->auth = self::$auth;

            if (!isset(self::$main_controller))
                self::$main_controller = $controller;

            $cached = self::get_cache();
            if ($cached != '') {
                echo $cached;
                exit;
            }

            if (method_exists($controller, $method)) {
                if (is_callable(array($controller, $method))) {
                    return call_user_func_array(array($controller, $method), $params);
                } else {
                    self::error('404');
                }
            } elseif (is_callable(array($controller, 'remap'))) {
                array_unshift($params, $method);
                return call_user_func_array(array($controller, 'remap'), $params);
            }
        }
        self::error('404');
    }

    /**
     * shortcut for rpd_url_helper::url
     * 
     * @param string $uri
     * @return object 
     */
    public static function redirect($url, $method = 'location', $http_response_code = 302) {
        return rpd_url_helper::redirect($url, $method, $http_response_code);
    }

    /**
     * shortcut for rpd_url_helper::current_page
     * 
     * @param mixed $page can be an uri path, or an array of
     * @param string $output
     * @return string 
     */
    public static function current_page($page, $output=null) {
        return rpd_url_helper::current_page($page, $output);
    }

    /**
     * shortcut for rpd_url_helper::url
     * 
     * @param string $uri
     * @return object 
     */
    public static function url($uri) {
        return rpd_url_helper::url($uri);
    }

    /**
     * shortcut for rpd_html_helper::anchor
     * 
     * @param string $uri
     * @param string $text
     * @param string $attributes
     * @return object 
     */
    public static function anchor($uri, $text='', $attributes='') {
        return rpd_html_helper::anchor($uri, $text, $attributes);
    }

    /**
     * shortcut for rpd_url_helper::uri
     *
     * @param string $url
     * @return object 
     */
    public static function uri($url) {
        return rpd_url_helper::uri($url);
    }

    /**
     * return a web path of given resource, using self::$working_path
     *  
     * @param string $resource
     * @return string  web path of given resource
     */
    public static function asset($resource) {
        return RAPYD_PATH . dirname(str_replace(RAPYD_ROOT, '', self::$working_path)) . '/assets/' . $resource;

        //CI fix
        //return RAPYDASSETS.$resource;
    }

    /**
     * shortcut for rpd_html_helper::head()
     * 
     * @return string 
     */
    public function head() {
        return rpd_html_helper::head();
    }

    /**
     * add a css resource link to head section
     *
     * @param string $css
     * @param bool $external
     * @return void 
     */
    public function css($css, $external=false) {
        return rpd_html_helper::css($css, $external);
    }

    /**
     * add a js resource link to head section
     *
     * @param string $css
     * @param bool $external
     * @return void 
     */
    public function js($js, $external=false) {
        return rpd_html_helper::js($js, $external);
    }

    /**
     * called inside index.php start a database connection (if defined inside config.php)
     *
     * @return object connection resource 
     */
    public static function connect() {

        if (isset(self::$db))
            return;

        $db_class = 'rpd_database_' . self::$config['db']['dbdriver'] . '_driver';

        self::$db = new $db_class();
        self::$db->hostname = self::$config['db']['hostname'];
        self::$db->username = self::$config['db']['username'];
        self::$db->password = self::$config['db']['password'];
        self::$db->database = self::$config['db']['database'];
        self::$db->dbprefix = self::$config['db']['dbprefix'];
        self::$db->dbdriver = self::$config['db']['dbdriver'];
        self::$db->db_debug = self::$config['db']['db_debug'];
        self::$db->db_attached = array();
        $result = self::$db->connect();
        if ($result !== false) {
            self::$db->select_db();
        }

        //connect modules (check custom script for each module, to override or attach dbs)
        foreach (self::$config['include_paths'] as $path) {
            if (is_file(RAPYD_ROOT . $path . '/connect.php')) {
                require_once RAPYD_ROOT . $path . '/connect.php';
            }
        }

        return $result;
    }

    /**
     * internal cache related
     * 
     * @return cached content 
     */
    public static function get_cache() {

        if (!is_dir(self::config('cache_path')) OR !is_writable(self::config('cache_path'))) {
            return FALSE;
        }

        $cache_path = self::config('cache_path') . str_replace('/', '.', self::$uri_string . '.cache');

        if (!@file_exists($cache_path)) {
            return FALSE;
        }

        if (!$cp = @fopen($cache_path, 'rb')) {
            return FALSE;
        }

        flock($cp, LOCK_SH);

        $cache = '';
        if (filesize($cache_path) > 0) {
            $cache = fread($cp, filesize($cache_path));
        }

        flock($cp, LOCK_UN);
        fclose($cp);

        if (!preg_match("/(<tstamp>(\d+)<\/tstamp><callback>([A-Za-z0-9\_]*)<\/callback>)/", $cache, $match)) {
            return FALSE;
        }

        if (time() >= $match['2']) {
            @unlink($cache_path);
            return FALSE;
        }
        $output = str_replace($match['0'], '', $cache);
        $output = str_replace('{time}', self::benchmarks('time'), $output);
        $output = str_replace('{memory}', self::benchmarks('memory'), $output);
        //$output = preg_replace("/{rpd::([^}]+)}/", '\\1', $output);
        /* if (preg_match('/{rpd::([^}]+)}/', $output, $dmatch))
          {
          $output = str_replace($dmatch[0], rpd::run($dmatch[1]), $output);
          //$output = preg_replace_callback('/{rpd::([^}]+)}/', 'rpd::run', $output);
          } */



        if ($match['3'] != '') {
            $controller = self::$controller;
            $method = $match['3'];
            if (is_callable(array($controller, $method))) {
                $output = $controller->$method($output);
            }
        }

        return $output;
    }

    /**
     * internal cache related
     * 
     * @param type $output content to cache
     * @param type $expiration cache time in seconds
     * @param type $callback parsing method to execute even if the cache not expired
     * @return bool if cached or not 
     */
    public static function set_cache($output, $expiration=0, $callback='') {
        $cache_path = rtrim(self::config('cache_path'), '/');

        if (!is_dir($cache_path) OR !is_writable($cache_path)) {
            die($cache_path);
            return FALSE;
        }

        $stamp = time() + $expiration;
        $cache_path .= '/' . str_replace('/', '.', self::$uri_string . '.cache');

        if (!$cp = fopen($cache_path, 'wb')) {
            return FALSE;
        }

        if (flock($cp, LOCK_EX)) {
            fwrite($cp, '<tstamp>' . $stamp . '</tstamp><callback>' . $callback . '</callback>' . $output);
            flock($cp, LOCK_UN);
        } else {
            return FALSE;
        }
        fclose($cp);
        @chmod($cache_path, 0777);
        return TRUE;
    }

    /**
     * cache to be used in conjunction of a view:
     * 
     *  <code>
     *   echo $this->cache($this->view('viewfile'), 60);
     *   //this will cache a page for 60 seconds
       * </code>
     * 
     * @param string $output
     * @param int $expiration
     * @param string $callback callback method (usually to str_replace/preg_replace placeholders)
     * @return string $output or cached content 
     */
    public static function cache($output, $expiration, $callback='') {
        rpd::set_cache($output, $expiration, $callback);
        $controller = self::$controller;
        if ($callback != '' AND is_callable(array($controller, $callback))) {
            $output = $controller->$callback($output);
        }
        //$output = preg_replace("/{rpd::([^}]*)}/", '\\1',   $output);
        $output = str_replace('{time}', self::benchmarks('time'), $output);
        $output = str_replace('{memory}', self::benchmarks('memory'), $output);
        return $output;
    }

}

