<?php

/*
 * Properties.php
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
 * The <em>Properties</em> class allows for an easy way to store key/value pairs 
 * of settings.
 * 
 * It can be used by plugin developers to store settings related to their plugins.
 */
class Properties {

    private $file;
    private static $instance;

    private function __construct() {
        $this->file = (DATAROOT . '/settings/properties.xml');
    }

    /**
     * Returns the properties instance that allows programmers to access this 
     * class' methods.
     * 
     * @return Properties The properties instance.
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Properties();
        }

        return self::$instance;
    }

    /**
     * Gets one property from the properties file.
     * 
     * @param string $owner The name of the owner for the properties, since 
     * there are several properties being stored in the properties file the name 
     * of the plugin should be used to prevent collisions.
     * @param string $key The name of the property to retrieve.
     * @param mixed $default The value to return if the property isn't found.
     * @param boolean $save If the property isn't found and a default value is 
     * given, you can request that the default value be stored in the properties 
     * file.
     * @return mixed The value found or the default if any.
     */
    public function retrieveProperty($owner, $key, $default = null, $save = false) {
        $found = null;
        $xml = $this->loadPropertiesXML();

        if ($xml->$owner->$key) {
            $found = strval($xml->$owner->$key->attributes()->value);
        }

        if ($save && $default && !$found) {
            $xml->addChild($owner)->addChild($key)->addAttribute('value', $default);
            $xml->asXML($this->file);
        }

        return $found ? $found : $default;
    }

    /**
     * Stores one property in the properties file.
     * 
     * @param string $owner The name of the owner.
     * @param string $key The key that identifies this property.
     * @param mixed $value The value to store, it will be converted to string.
     * 
     * @return boolean True if the file was saved, false otherwise. 
     */
    public function storeProperty($owner, $key, $value) {
        $xml = $this->loadPropertiesXML();
        if ($xml->$owner->$key) {
            $xml->$owner->$key->attributes()->value = strval($value);
        } else {
            $xml->addChild($owner)->addChild($key)->addAttribute('value', $value);
        }

        return $xml->asXML($this->file);
    }

    /**
     * Returns a group of properties belonging to the same owner.
     * 
     * @param string $owner The owner of the group.
     * 
     * @return array An array of key/value properties.
     */
    public function retrieveProperties($owner) {
        $xml = $this->loadPropertiesXML();

        if ($xml->$owner) {
            $props = array();
            foreach ($xml->$owner->children() as $child) {
                $props[strval($child)] = strval($child->attributes()->value);
            }
            return (object) $props;
        }

        return null;
    }

    /**
     * Stores an array of properties in the properties file. The array keys may 
     * not be numeric since they are used to create XML elements.
     * 
     * @param string $owner The name of this group's owner.
     * @param array $values An array of key/value pairs.
     * 
     * @return boolean True if the file was saved, false otherwise.
     */
    public function storeProperties($owner, $values) {
        $xml = self::loadPropertiesXML();

        foreach ($values as $key => $value) {
            if ($xml->$key) {
                $xml->$key->attributes()->value = strval($value);
            } else {
                $xml->addChild($owner)->addChild($key)->addAttribute('value', $value);
            }
        }

        return $xml->asXML($this->file);
    }

    /**
     * Loads the properties file if it exists.
     * 
     * @return XMLFile The loaded XML file or a new instance if the file doesn't 
     * exist.
     */
    private function loadPropertiesXML() {
        if (is_file($this->file)) {
            $xml = new XMLFile($this->file);
        } else {
            $xml = new XMLFile('<properties version="' . SSVERSION . '"></properties>');
        }

        return $xml;
    }

}
