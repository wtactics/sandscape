<?php

/*
 * WTSGame.php
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
class WTSGame {

    private $playerASide;
    private $playerBSide;
    //TODO: //NOTE: ...
    private $started;

    public function __construct() {
        //WTSCard::$defaultFaceDown = myURL() . '/images/cards/CardBack.png';
        $this->started = false;
    }

    public function getPlayerASide() {
        return $this->playerASide;
    }

    public function getPlayerBSide() {
        return $this->playerBSide;
    }

    public function init($playerADeck, $playerBDeck) {

        if (!$this->started) {
            $cards = array();
            foreach ($playerADeck->cards as $card) {
                $cards[] = new WTSCard($card);
            }
            $this->playerASide = new WTSPlayerSide($cards);


            $cards = array();
            foreach ($playerBDeck->cards as $card) {
                $cards[] = new WTSCard($card);
            }
            $this->playerBSide = new WTSPlayerSide($cards);

            $this->started = true;
        }
    }

    public function isStarted() {
        return $this->started;
    }

}

?>