<?php

/*
 * models/wtsengine/WTSContainer.php
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
abstract class WTSContainer {

    private $id;
    private $movable = false;
    private $dropable = false;
    private $max;
    protected $elements = array();

    public function __construct($movable, $dropable, $max = null) {
        $this->id = uniqid('wt');
        $this->movable = $movable;
        $this->dropable = $dropable;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function push(WTSCard $WTSCard) {
        if ($this->max === null || count($this->elements < $this->max))
            array_push($this->elements, $WTSCard);
    }

    /**
     *
     * @return WTSCard
     */
    public function pop() {
        return array_pop($this->elements);
    }

    public function getCard($id) {
        foreach ($this->elements as $e)
            if ($e instanceof WTSCard && $e->getId() == $id)
                return $e;
    }

    public function removeCard($id) {
        foreach ($this->elements as $i => $e)
            if ($e instanceof WTSCard && $e->getId() == $id) {
                unset($this->elements[$i]);
                return $e;
            }
    }

    public function getUpdate() {
        $output = array();
        foreach ($this->elements as $e)
            if ($e instanceof WTSCard) {
                $output [] = $e->jsonCreate($this->getId());
                $output [] = $e->jsonImage();
//            $output [] = $e->jsonActive();
                $output [] = $e->jsonMove($this->getId());
                $output = array_merge($output, $e->getUpdate());
            }
        return $output;
    }

    public function findCardContainer($id) {
        foreach ($this->elements as $e) {
            if ($e instanceof WTSCard && $e->getId() == $id)
                return $this;
            elseif ($e->findCardContainer($id))
                return $e->findCardContainer($id);
        }

        return null;
    }

    public function find($id) {
        if ($this->getId() == $id)
            return $this;
        foreach ($this->elements as $e) {
            if ($e->getId() == $id)
                return $e;
            $result = $e->find($id);
            if ($result)
                return $result;
        }
        return null;
    }

}

?>