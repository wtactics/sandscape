<?php

/*
 * HTMLElement.php
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
 * Any HTML element with an id, a name and some extra parameters can be represented
 * by this class. If the elements are complex (e.g. WYSIWYG editors), than a 
 * <em>Component</em> class should be used instead.
 * 
 * Currently, HTML elements are very simple wrappers for common HTML code. They 
 * have little to no behaviour and aren't that useful. Still, the usage of these 
 * classes will allow for the creation of a complete HTML abstraction regarding 
 * input and user interaction controls.
 */
abstract class HTMLElement {

    private $id;
    private $name;
    private $extra;

    public function __construct($id, $name, $extra = array()) {
        $this->id = $id;
        $this->name = $name;
        $this->extra = $extra;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns the existing extra paramenters. These extras will depend on the 
     * exact HTML element type.
     * 
     * @return array The extra parameters if any.
     */
    public function getExtra() {
        return $this->extra;
    }

    public function setExtra($extra) {
        $this->extra = $extra;
    }

    /**
     * Returns a string representing the HTMLELement.
     * 
     * @return string The string representation of this element.
     */
    public function __toString() {
        $extra = '';
        foreach ($this->extra as $attr => $value) {
            $extra .= $attr . '="' . $value . '"';
        }

        return ($this->name ? ('name="' . $this->name . '" ') : '') .
                ( $this->id ? ('id="' . $this->id . '" ') : '') . $extra;
    }

}
