<?php

/* SCToken.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * @since 1.2, Elvish Shaman
 */
class SCToken {

    private $id;
    private $name;
    private $image;

    public function __construct($name, $image) {
        $this->id = uniqid('sc');
        $this->name = $name;
        $this->image = $image;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getName() {
        return $this->name;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getImage() {
        return $this->image;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getInfo() {
        return (object) array(
                    'id' => $this->id,
                    'name' => $this->name
        );
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getJSONData() {
        return (object) array(
                    'id' => $this->id,
                    'src' => $this->image,
        );
    }

}