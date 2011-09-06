<?php

/*
 * XMLFile.php
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
 * XMLFile class implements the delegate pattern for SimpleXMLIterator allowing 
 * the use of SimpleXMLIterator features with more ease and focus in files 
 * instead of XML strings.
 * 
 * It offers a simpler way to manage XML files and is use throught the system 
 * whenever an XML needs to be used.
 */
class XMLFile implements Iterator {

    private $delegate;

    /**
     * Creates a new XMLFile instance from an existing XML file.
     * 
     * @param string $path XML file path
     */
    public function __construct($path, $options = LIBXML_NOCDATA) {
        if (is_file($path)) {
            $this->delegate = new SimpleXMLIterator($path, $options, true);
        } else {
            $this->delegate = new SimpleXMLIterator('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $path);
        }
    }

    public function __get($name) {
        if ($this->delegate)
            return $this->delegate->$name;

        return null;
    }

    public function __set($name, $value) {
        if ($this->delegate) {
            $this->delegate->$name = $value;
        }
    }

    public function current() {
        return $this->delegate->current();
    }

    public function key() {
        return $this->delegate->key();
    }

    public function next() {
        $this->delegate->next();
    }

    public function rewind() {
        $this->delegate->rewind();
    }

    public function valid() {
        return $this->delegate->valid();
    }

    public function addAttribute($name, $value, $namespace = null) {
        return $this->delegate->addAttribute($name, $value, $namespace);
    }

    public function addChild($name, $value = null, $namespace = null) {
        return $this->delegate->addChild($name, $value, $namespace);
    }

    public function asXML($filename = null) {
        return $this->delegate->asXML($filename);
    }

    public function attributes($ns = null, $is_prefix = false) {
        return $this->delegate->attributes($ns, $is_prefix);
    }

    public function children($ns = null, $is_prefix = false) {
        return $this->delegate->children($ns, $is_prefix);
    }

    public function count() {
        return $this->delegate->count();
    }

    public function getDocNamespaces($recursive = false) {
        return $this->delegate->getDocNamespaces($recursive);
    }

    public function getName() {
        return $this->delegate->getName();
    }

    public function getNamespaces($recursive = false) {
        return $this->delegate->getNamespaces($recursive);
    }

    public function registerXPathNamespace($prefix, $ns) {
        return $this->delegate->registerXPathNamespace($prefix, $ns);
    }

    public function xpath($path) {
        return $this->delegate->xpath($path);
    }

    /**
     * Creates a child node that uses CDATA to escape it's contents.
     * 
     * @param string $name The name of the XML tag
     * @param mixed $value The content to place in the XML tag
     */
    public function addChildWithCData($name, $value) {
        $child = $this->addChild($name);
        $this->addCData($child, $value);
    }

    /**
     * Escapes XML content with CDATA.
     * 
     * @param mixed $value The content to escape
     */
    public function addCData($child, $value) {
        $node = dom_import_simplexml($child);
        $cdata = $node->ownerDocument->createCDATASection($value);
        $node->appendChild($cdata);
    }

    /**
     * //TODO: make XMLFile instances print their contents
     * 
     * public function __toString() { }
     */
}