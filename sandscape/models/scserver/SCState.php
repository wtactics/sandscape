<?php

/* SCState.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
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
 * @since 1.2, Elvish Shaman
 */
class SCState {

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

?>