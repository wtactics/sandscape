<?php

/*
 * StaySimple.php
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

class StaySimple {

    public static $ADMIN = 1;
    public static $SITE = 2;
    private static $IGNORE = -1;
    private $config;
    private $uri;
    private $controller;
    private $method;
    private $params;
    private $url;
    private $location;
    private $i18n;
    private $mappings;

    public function __construct() {
        $this->config = Config::getInstance();
        $this->url = self::findURL();
        $this->mappings = array();

        $this->i18n = array();
        $file = DATAROOT . '/languages/' . Config::getInstance()->get('system.locale.language') . '.php';
        if (is_file($file)) {
            include $file;

            $this->i18n = $lang;
        }

        $this->loadPlugins();
    }

    public function execute() {
        $this->uri = trim((isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : getenv('PATH_INFO')), '/');
        $this->params = null;

        $this->route();

        $method = 'start';
        if ($this->method != '') {
            $method = $this->method;
        }

        if (!empty($this->params)) {
            $this->controller->$method($this->params);
        } else {
            $this->controller->$method();
        }
    }

    private function route() {
        $section = '';
        $segments = array();
        $this->location = self::$IGNORE;

        if (empty($this->uri) || !preg_match('/[^A-Za-z0-9\:\/\.\-\_\#]/i', $this->uri)) {

            if ($this->uri) {
                $segments = explode('/', $this->uri);
            }
        }

        if (count($segments)) {
            $section = array_shift($segments);

            $page = strtolower($section);
            if (PageManager::pageExists($page)) {
                $this->controller = new Site($page);
                $this->params = $this->filterParameters($segments);

                $this->location = self::$SITE;
            } else {
                $class = $section;
                if ($section === $this->config->get('system.path')) {
                    $class = 'Login';
                    if (count($segments)) {
                        $class = array_shift($segments);
                    }

                    $this->location = self::$ADMIN;
                }

                if (class_exists($class) && (is_subclass_of($class, 'Controller') || is_subclass_of($class, 'Plugin'))) {
                    $this->controller = new $class();

                    if (count($segments)) {
                        $this->method = array_shift($segments);
                    }

                    $this->params = $this->filterParameters($segments);
                } else if (($mapping = Plugin::getMapping($class)) !== null) {
                    $this->controller = new $mapping->controller();
                    $this->method = $mapping->method;

                    $this->params = $this->filterParameters($segments);
                } else {
                    $this->controller = new Site('404');

                    $this->location = self::$SITE;
                }
            }
        } else {
            $this->controller = new Site($this->config->get('site.home'));

            $this->location = self::$SITE;
        }
    }

    private function filterParameters($parameters) {
        $filtered = array();

        if (!empty($parameters) && is_array($parameters)) {
            foreach ($parameters as $value) {
                if (strpos($value, ':') !== false) {
                    $pieces = explode(':', $value);

                    $filtered[$pieces[0]] = array_slice($pieces, 1);
                } else {
                    $filtered[] = $value;
                }
            }
        }
        return $filtered;
    }

    public function getUser() {
        if (isset($_SESSION['loginData']) && $_SESSION['loginData'] != null && $_SESSION['loginData'] != '') {
            return unserialize($_SESSION['loginData']);
        }

        return null;
    }

    public function charStrip($original) {
        return strtolower(preg_replace('/\s/', '-', trim(preg_replace('/[\s-]+/', ' ', preg_replace('/[^a-z0-9\s-]/', '', $original)))));
    }

    private function listThemeFolders() {
        $files = array();
        if (($dh = opendir(APPROOT . '/themes'))) {
            while (($dirname = readdir($dh)) !== false) {
                if (strpos($dirname, '.') === false && is_dir(APPROOT . '/themes/' . $dirname)) {
                    if (is_file(APPROOT . '/themes/' . $dirname . '/theme.xml')) {
                        $files[] = $dirname;
                    }
                }
            }
            closedir($dh);
        }

        return $files;
    }

    public function listAdminTemplates() {
        $templates = array();

        foreach ($this->listThemeFolders() as $folder) {
            $xml = new XMLFile(APPROOT . '/themes/' . $folder . '/theme.xml');

            if (strval($xml->type) === 'administration') {
                $templates[] = new Theme($folder, strval($xml->type), strval($xml->name), strval($xml->author),
                                strval($xml->url->link), strval($xml->url->title), strval($xml->version),
                                strval($xml->description), strval($xml->screenshot), floatval($xml->minversion), null);
            }
        }

        return $templates;
    }

    public function listSiteTemplates() {
        $templates = array();

        foreach ($this->listThemeFolders() as $folder) {
            $xml = new XMLFile(APPROOT . '/themes/' . $folder . '/theme.xml');

            if (strval($xml->type) === 'site') {

                $pageTemplates = array();
                foreach ($xml->templates->template as $template) {
                    $pageTemplates[] = new PageTemplate($template->title, $template->file);
                }

                $templates[] = new Theme($folder, strval($xml->type), strval($xml->name), strval($xml->author),
                                strval($xml->url->link), strval($xml->url->title), strval($xml->version),
                                strval($xml->description), strval($xml->screenshot), floatval($xml->minversion),
                                $pageTemplates);
            }
        }

        return $templates;
    }

    public function listLanguages() {
        $languages = array();
        foreach ($this->listLanguageFiles() as $lfile) {
            $file = DATAROOT . '/languages/' . $lfile;
            $contents = file_get_contents($file);

            $found = array();
            if (preg_match_all('#/\*\*(.*?)\*/#sm', $contents, $found)) {
                if (count($found) == 2) {
                    $pieces = explode('*', $found[1][0]);

                    foreach ($pieces as $piece) {
                        $piece = trim($piece);
                        //* @author * @version * @name     
                        if (strpos($piece, '@name') === 0) {
                            $info = explode('@name', $piece);
                            $info = trim(end($info));

                            $lang = explode('.', $lfile);
                            $lang = $lang[0];

                            $languages[] = array($lang, $info);
                        }
                    }
                }
            }
        }

        return $languages;
    }

    private function listLanguageFiles() {
        $files = array();

        if (($dh = opendir(DATAROOT . '/languages'))) {
            while (($filename = readdir($dh)) !== false) {
                if (($pos = strpos($filename, '.php')) && $pos == (strlen($filename) - 4)) {
                    $files[] = $filename;
                }
            }
            closedir($dh);
        }

        return $files;
    }

    public static function app() {
        global $app;

        return $app;
    }

    public static function findURL($includeFilename = false) {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            $protocol = 'https';
        else
            $protocol = 'http';

        if (isset($_SERVER['SERVER_PORT'])) {
            if (($protocol == 'http' && $_SERVER['SERVER_PORT'] != 80) || ($protocol == 'https' && $_SERVER['SERVER_PORT'] != 443))
                $port = ":{$_SERVER['SERVER_PORT']}";
            else
                $port = '';
        } else
            $port = '';

        $server_name = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
        $php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
        $php_self = substr($php_self, 0, strpos($php_self, 'index.php'));
        if ($includeFilename) {
            return $protocol . '://' . $_SERVER['SERVER_NAME'] . $port . $php_self;
        }

        $self = explode('/', $php_self);
        $last = array_keys($self);
        $last = end($last);
        unset($self[$last]);
        $self = implode('/', $self);

        return $protocol . '://' . $server_name . $port . $self . '/';
    }

    public function getURL() {
        return $this->url;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getTranslatedString($key, $params = array()) {
        if (isset($this->i18n[$key])) {
            $string = $this->i18n[$key];
            if (($max = count($params)) > 0) {
                for ($i = 0; $i < $max; $i++) {
                    $string = str_replace('{' . $i . '}', $params[$i], $string);
                }
            }

            return $string;
        }

        return '{' . $key . '}';
    }

    public function loadPlugins() {
        $filename = DATAROOT . '/settings/plugins.xml';
        if (is_file($filename)) {
            $plugins = new XMLFile($filename);
            foreach ($plugins->plugin as $plugin) {
                $plugin = strval($plugin->attributes()->name);
                if (class_exists($plugin)) {
                    $pluginClass = new $plugin();
                    if ($pluginClass instanceof Plugin) {

                        //Read i18n first so that strings are available in the
                        //plugin's contructor.
                        $base = PLUGINROOT . '/' . $plugin . '/languages';
                        if (is_dir($base)) {
                            $language = $base . '/' . Config::getInstance()->get('system.locale.language') . '.php';
                            if (is_file($language)) {
                                include $language;

                                if (isset($lang)) {
                                    $this->i18n = array_merge($this->i18n, $lang);
                                }
                            } else if (is_file($base . '/en_US.php')) {
                                include $base . '/en_US.php';

                                if (isset($lang)) {
                                    $this->i18n = array_merge($this->i18n, $lang);
                                }
                            }
                        }

                        Plugin::activate(new $pluginClass());
                    }
                }
            }
        }
    }

    public function savePluginConfig() {
        $config = new XMLFile('<plugins version="' . SSVERSION . '"></plugins>');
        foreach (Plugin::getActivePlugins() as $name) {
            $child = $config->addChild('plugin');
            $child->addAttribute('name', $name);
        }
        $config->asXML(DATAROOT . '/settings/plugins.xml');
    }

    public function checkUpdates() {
        $xml = null;

        $file = DATAROOT . '/cache/updates.xml';
        if (is_file($file)) {
            $xml = new XMLFile($file);
        } else {
            $xml = new XMLFile('<upgrades version="' . SSVERSION . '"></upgrades>');
        }

        $doCheck = false;
        if (($last = strval($xml->lastcheck))) {
            $doCheck = (time() - $last >= (Config::getInstance()->get('system.updateinterval') * 24 * 60 * 60 * 1000));
        }

        if ($doCheck) {
            //TODO: ... 
        }
    }

}
