<?php

/*
 * Plugins.php
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

class Plugins extends Administration {

    public function __construct() {
        parent::__construct();
        $this->validateUser();
    }

    private function findAllInstalledPlugins() {
        $plugins = array();

        if (($dh = opendir(PLUGINROOT))) {
            while (($filename = readdir($dh)) !== false) {
                if (is_dir(PLUGINROOT . '/' . $filename) && $filename != '.' && $filename != '..') {
                    $plugins [] = basename($filename);
                }
            }
            closedir($dh);
        }

        return $plugins;
    }

    public function start() {
        $plugins = $this->findAllInstalledPlugins();

        $this->render('plugins', array('plugins' => $plugins));
    }

    public function disable($params = array()) {
        if (isset($params[0]) && Plugin::isActive($params[0])) {
            $plugin = $params[0];
            Plugin::deactivate($params[0]);
            StaySimple::app()->savePluginConfig();
            $this->queueMessage(new Message($this->getTranslatedString('STAY_PLUGINS_PLUGIN_DEACTIVATED', array($plugin))));
        }
        $this->redirect('plugins');
    }

    public function enable($params = array()) {
        if (isset($params[0]) && $params[0] && !Plugin::isActive($params[0])) {
            $plugin = $params[0];
            Plugin::activate(new $params[0]());
            StaySimple::app()->savePluginConfig();
            $this->queueMessage(new Message($this->getTranslatedString('STAY_PLUGINS_PLUGIN_ACTIVATED', array($plugin))));
            echo('success');
        }
    }

    public function activationError($params = array()) {
        if (isset($params[0])) {
            $plugin = $params[0];
            $this->queueMessage(new Message($this->getTranslatedString('STAY_PLUGINS_PLUGIN_ACTIVATION_ERROR', array($plugin))));
        }
        $this->redirect('plugins');
    }

    public function install($params = array()) {
        foreach ($_FILES as $file) {
            $file = (object) $file;
            if (!$file->error) {
                $zip = zip_open($file->tmp_name);
                if ($zip) {
                    while ($entry = zip_read($zip)) {
                        $filename = PLUGINROOT . '/' . zip_entry_name($entry);
                        if (!is_dir(dirname($filename)))
                            mkdir(dirname($filename), 0777, true);

                        if (zip_entry_filesize($entry)) {
                            file_put_contents($filename, zip_entry_read($entry, zip_entry_filesize($entry)));
                        }
                    }

                    $this->queueMessage(new Message($this->getTranslatedString('STAY_PLUGINS_PLUGIN_INSTALL_SUCCESS'), Message::$SUCESS));
                } else {
                    $this->queueMessage(new Message($this->getTranslatedString('STAY_PLUGINS_INVALID_FILETYPE'), Message::$ERROR));
                }
            } else {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PLUGINS_UPLOAD_ERROR'), Message::$ERROR));
            }
        }
        $this->redirect('plugins');
    }

    public function uninstall($params = array()) {
        if (isset($params[0]) && $params[0]) {
            if (Plugin::isActive($params[0]))
                Plugin::deactivate($params[0]);

            $pluginDir = PLUGINROOT . '/' . $params[0];
            if ($this->deleteDirectory($pluginDir))
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PLUGINS_PLUGIN_UNINSTALED')));
            else
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PLUGINS_PLUGIN_UNINSTALATION_ERROR'), Message::$ERROR));

            StaySimple::app()->savePluginConfig();
        }
        $this->redirect('plugins');
    }

    /**
     * Delete folder function 
     * 
     * Copied from: http://php.net/manual/en/function.rmdir.php
     */
    private function deleteDirectory($dir) {
        if (!file_exists($dir))
            return true;
        if (!is_dir($dir) || is_link($dir))
            return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..')
                continue;
            if (!$this->deleteDirectory($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!$this->deleteDirectory($dir . "/" . $item))
                    return false;
            };
        }
        return rmdir($dir);
    }

}