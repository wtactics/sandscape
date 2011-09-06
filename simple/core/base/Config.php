<?php

/*
 * Config.php
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
 * Class that stores all configuration settings allowing easy access and 
 * modification throughout the system.
 * 
 * This class implementas <em>Iterator</em> so that it can be used in 
 * <em>foreach</em> constructs.
 * 
 * <em>Config</em> is a <em>Singleton</em> class.
 */
class Config implements Iterator {

    private $def;
    private static $instance;
    //iterator related variables
    private $iterator;
    private $keys;

    private function __construct() {

        $file = DATAROOT . '/settings/settings.xml';
        if (is_file($file)) {
            $xml = new XMLFile($file);

            $this->def = array();
            $this->def['site.home'] = strval($xml->site->home);
            $this->def['site.name'] = html_entity_decode(strval($xml->site->name), ENT_NOQUOTES, 'UTF-8');
            $this->def['site.theme'] = strval($xml->site->theme);
            $this->def['site.hideindex'] = strval($xml->site->hideindex);
            $this->def['system.email'] = strval($xml->system->email);
            $this->def['system.path'] = strval($xml->system->path);
            $this->def['system.theme'] = strval($xml->system->theme);
            $this->def['system.locale.language'] = strval($xml->system->locale->language);
            $this->def['system.locale.shortdateformat'] = strval($xml->system->locale->shortdateformat);
            $this->def['system.locale.longdateformat'] = strval($xml->system->locale->longdateformat);
            $this->def['system.locale.timeformat'] = strval($xml->system->locale->timeformat);
            $this->def['system.hash'] = strval($xml->system->hash);
            $this->def['system.updateinterval'] = intval($xml->system->updateinterval);

            $this->keys = array_keys($this->def);
        } else {
            throw new Exception('Unable to load settings file.');
        }

        $this->iterator = 0;
    }

    /**
     * Provides access to the configuration object.
     * 
     * @return Config The configuration instance.
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    /**
     * Retrieves a configuration option based on a key. For a list of possible 
     * keys please see StaySimple CMS documentation.
     * 
     * @param string $key The string that identifies option to retriev.
     * @param mixed $default The default value to use if there is no option set 
     * for the given key.
     * 
     * @return mixed The value for the used key or the default value if the key 
     * is invalid. If not given, the default value is an empty string.
     */
    public function get($key, $default = '') {
        return isset($this->def[$key]) ? $this->def[$key] : $default;
    }

    /**
     * Sets one of the configuration values. Only keys that exist in the current
     * XML file version can be set as no new keys are defined.
     * 
     * @param string $key The key to set.
     * @param mixed $value The value to define.
     */
    public function set($key, $value) {
        if (isset($this->def[$key])) {
            $this->def[$key] = $value;
        }
    }

    /**
     * Saves the current configuration keys to the settings.xml file.
     * 
     * @return boolean True if the file was successfully saved, false otherwise.
     */
    public function save() {
        $xml = new XMLFile(DATAROOT . '/settings/settings.xml');

        $xml->site->home = $this->def['site.home'];
        $xml->site->name = '';
        $xml->addCData($xml->site->name, $this->def['site.name']);
        $xml->site->theme = $this->def['site.theme'];
        $xml->site->hideindex = $this->def['site.hideindex'];
        $xml->system->email = $this->def['system.email'];
        $xml->system->path = $this->def['system.path'];
        $xml->system->theme = $this->def['system.theme'];
        $xml->system->locale->language = $this->def['system.locale.language'];
        $xml->system->locale->shortdateformat = $this->def['system.locale.shortdateformat'];
        $xml->system->locale->longdateformat = $this->def['system.locale.longdateformat'];
        $xml->system->locale->timeformat = $this->def['system.locale.timeformat'];
        $xml->system->hash = $this->def['system.hash'];
        $xml->system->updateinterval = $this->def['system.updateinterval'];

        return $xml->asXML(DATAROOT . '/settings/settings.xml');
    }

    public function current() {
        return $this->def[$this->keys[$this->iterator]];
    }

    public function key() {
        return $this->keys[$this->iterator];
    }

    public function next() {
        $this->iterator++;
    }

    public function rewind() {
        $this->iterator = 0;
    }

    public function valid() {
        return (isset($this->keys[$this->iterator]) && isset($this->def[$this->keys[$this->iterator]]));
    }

}