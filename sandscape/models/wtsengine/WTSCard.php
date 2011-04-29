<?php

/*
 * WTSCard.php
 * 
 * This file is part of SandScape.
 * 
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 */

/**
 * @since 1.0
 * @author Pedro Serra
 */
class WTSCard extends WTSContainer {

    public static $defaultFaceDown;
    private $card;
    private $urlFaceDown;
    private $faceUp = false;
    private $active = true;

    public function __construct($card) {
        parent::__construct(true, true);
        $this->card = $card;
        $this->urlFaceDown = self::$defaultFaceDown;
    }

    public function jsonCreate($idLocation) {
        return (object) array('f' => 'create', 'id' => $this->getId(), 'idLocation' => $idLocation);
    }

    public function jsonImage() {
        //TODO:... 
        //return (object) array('f' => 'image', 'id' => $this->getId(), 'src' => ($this->faceUp ? $this->url : $this->urlFaceDown));
    }

    public function jsonActive() {
        return (object) array('f' => 'active', 'id' => $this->getId(), 'active' => $this->active);
    }

    public function jsonMove($idDestination) {
        return (object) array('f' => 'move', 'id' => $this->getId(), 'idDestination' => $idDestination);
    }

    public function setFaceUp($faceUp) {
        $this->faceUp = $faceUp;
    }

}

?>