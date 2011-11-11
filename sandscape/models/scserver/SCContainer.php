<?php

/* SCContainer.php
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
 * http://wtactics.org
 */

/**
 * @since 1.0, Sudden Growth
 */
class SCContainer {

    /**
     *
     * @var SCGame 
     */
    private $game;
    private $id;
    private $movable = false;
    private $droppable = false;
    private $max;
    protected $elements;
    private $parent = null;
    // @var float location inside parent, in percentage
    private $xOffset = 0;
    private $yOffset = 0;
    // @var boolean 
    private $invertView = false;

    public function __construct(SCGame $game, $movable, $droppable, $max = null) {
        $this->game = $game;
        $this->setId(uniqid('sc'));
        $this->movable = $movable;
        $this->droppable = $droppable;

        $this->elements = array();
    }

    public function __wakeup() {
        $this->invertView = false;
    }

    public function setId($id) {
        if ($this->id)
            $this->game->unregister($this);
        $this->id = $id;
        $this->game->register($this);
    }

    public function getId() {
        return $this->id;
    }

    public function push(SCCard $scCard, $xOffset = 0, $yOffset = 0) {
        if ($this->max === null || count($this->elements < $this->max)) {
            array_push($this->elements, $scCard);
            $scCard->setParent($this);
            $scCard->setXOffset($xOffset);
            $scCard->setYOffset($yOffset);
            return true;
        }
        else
            return false;
    }

    public function remove(SCCard $card) {
        $pos = array_search($card, $this->elements, true);
        if ($pos !== false) {
            unset($this->elements[$pos]);
            $card->setXOffset(0);
            $card->setYOffset(0);
            return $card;
        }
        else
            return null;
    }

    /**
     * 
     * @return SCCard
     */
    public function pop() {
        $e = array_pop($this->elements);
        if ($e) {
            $e->setParent(null);
            $e->setXOffset(0);
            $e->setYOffset(0);
        }
        return $e;
    }

    public function getRoot() {
        $o = $this;
        while ($o->getParent())
            $o = $o->getParent();
        return $this->game->getRoot($o);
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function getXOffset() {
        return $this->xOffset;
    }

    public function setXOffset($xOffset) {
        $this->xOffset = $xOffset;
    }

    public function getYOffset() {
        return $this->yOffset;
    }

    public function setYOffset($yOffset) {
        $this->yOffset = $yOffset;
    }

    public function isMovable() {
        return $this->movable;
    }

    public function setMovable($movable) {
        $this->movable = $movable;
    }

    public function setDropable($droppable) {
        $this->droppable = $droppable;
    }

    public function isDroppable() {
        return $this->droppable;
    }

    public function getZIndex() {
        return 50;
    }

    public function setInvertView($invertView) {
        $this->invertView = $invertView;
    }

    public function invertView() {
        $o = $this;
        while ($o) {
            if ($o->invertView)
                return true;
            $o = $o->getParent();
        }
        return false;
    }

    public function getStatus() {
        $root = $this->getRoot();

        return (object) array(
                    'id' => $this->getId(),
                    'location' => ($root && $this->getParent() ? $this->getParent()->getId() : $this->game->getVoid()->getId()),
                    'xOffset' => $this->getXOffset(),
                    'yOffset' => $this->getYOffset(),
                    'invertView' => $this->invertView(),
                    'zIndex' => $this->getZIndex()
        );
    }

    /**
     * Checks if the container is inside the other container
     * @param SCContainer $container 
     * @return boolean
     */
    public function isInside(SCContainer $container) {
        $o = $this;
        while ($o->getParent()) {
            if ($o === $container)
                return true;
            $o = $o->getParent();
        }
        return false;
    }

    public function __toString() {
        return 'ID: ' . $this->id . ', isMovable: ' . ($this->movable ? 'true' : 'false')
                . ', isDroppable: ' . ($this->droppable ? 'true' : 'false') . ', max of '
                . $this->max . ', element count: ' . count($this->elements);
    }

    /**
     *
     * @return bool 
     * 
     * @since 1.2, Elvish Shaman
     */
    public function shuffle() {
        return shuffle($this->elements);
    }

}