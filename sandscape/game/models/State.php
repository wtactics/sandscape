<?php

/* State.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2016, WTactics Project <http://wtactics.org>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @author Pedro Serra
 * @copyright (c) 2016, WTactics Project
 */
final class State {

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
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     *
     * @return stdClass
     */
    public function getInfo() {
        return (object) array(
                    'id' => $this->id,
                    'name' => $this->name
        );
    }

    /**
     *
     * @return stdClass
     */
    public function getJSONData() {
        return (object) array(
                    'id' => $this->id,
                    'src' => $this->image,
        );
    }

}
