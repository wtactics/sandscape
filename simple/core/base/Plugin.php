<?php

/*
 * Plugin.php
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

abstract class Plugin {

    protected $path;
    private static $plugins = array();
    private static $outputHooks = array();
    private static $mappings = array();

    public function __construct($path) {
        $this->path = $path;
        $this->registered = array();
    }

    protected function hook($outputID, $methodName = null) {
        Plugin::hookPlugin($this, $outputID, $methodName);
    }

    public static function activate(Plugin $plugin) {
        $name = get_class($plugin);
        if (!isset(self::$plugins[$name]))
            self::$plugins[$name] = $plugin;
    }

    public static function deactivate($pluginName) {
        if (isset(self::$plugins[$pluginName]))
            unset(self::$plugins[$pluginName]);
    }

    public static function isActive($pluginName) {
        return isset(self::$plugins[$pluginName]);
    }

    public static function hookPlugin(Plugin $plugin, $outputID, $methodName = null) {
        $name = get_class($plugin);
        if (!$methodName)
            $methodName = $outputID;
        self::$outputHooks[$outputID][$name] = (object) array(
                    'instance' => $plugin,
                    'method' => $methodName
        );
    }

    public static function getOutput($outputID, View $view) {
        if (isset(self::$outputHooks[$outputID])) {
            foreach (self::$outputHooks[$outputID] as $plugin) {
                $method = $plugin->method;
                if (method_exists($plugin->instance, $method))
                    return $plugin->instance->$method($view);
            }
        }

        return '';
    }

    public static function getActivePlugins() {
        $plugins = array();
        foreach (self::$plugins as $plugin) {
            $plugins[] = get_class($plugin);
        }
        return $plugins;
    }

    /**
     *
     * @param string $pluginName
     * @return Plugin
     */
    public static function plugin($pluginName) {
        if (isset(self::$plugins[$pluginName])) {
            return self::$plugins[$pluginName];
        }

        return null;
    }

    public static function getPlugins($outputID) {
        if (isset(self::$outputHooks[$outputID])) {
            return self::$outputHooks[$outputID];
        }

        return array();
    }

    public function map($url, $method = 'start') {
        self::$mappings[$url] = (object) array(
                    'controller' => get_class($this),
                    'method' => $method
        );
    }

    public static function getMapping($url) {
        return isset(self::$mappings[$url]) ? self::$mappings[$url] : null;
    }

}