<?php

/*
 * models/wtsengine/WTSPlayerSide.php
 * 
 * This file is part of SandScape.
 * http://sandscape.sourceforge.net/
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
class WTSPlayerSide {

    private $deck;
    private $graveyard;
    private $hand;
    private $playableArea;

    /**
     *
     * @param array $deck      WTSCard array
     */
    public function __construct($deck) {
        $this->deck = new WTSStack(false, false);
        $this->graveyard = new WTSStack(false, true);
        $this->hand = new WTSGrid(10, 10);
        $this->playableArea = new WTSGrid(30, 70);

        foreach ($deck as $card)
            $this->deck->push($card);
    }

    public function findCardContainer($id) {
        $container = $this->deck->findCardContainer($id);
        if (!$container)
            $container = $this->graveyard->findCardContainer($id);
        if (!$container)
            $container = $this->hand->findCardContainer($id);
        if (!$container)
            $container = $this->playableArea->findCardContainer($id);
        return $container;
    }

    public function find($id) {
        $obj = $this->deck->find($id);
        if (!$obj)
            $obj = $this->graveyard->find($id);
        if (!$obj)
            $obj = $this->hand->find($id);
        if (!$obj)
            $obj = $this->playableArea->find($id);
        return $obj;
    }

    public function getDeck() {
        return $this->deck;
    }

    public function getGraveyard() {
        return $this->graveyard;
    }

    public function getHand() {
        return $this->hand;
    }

    public function getPlayableArea() {
        return $this->playableArea;
    }

}

?>