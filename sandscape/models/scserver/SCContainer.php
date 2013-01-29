<?php

/* SCContainer.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
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

    /**
     *
     * @param type $id 
     * 
     * @since 1.0, Sudden Growth
     */
    public function setId($id) {
        if ($this->id)
            $this->game->unregister($this);
        $this->id = $id;
        $this->game->register($this);
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
     * @param SCCard $scCard
     * @param type $xOffset
     * @param type $yOffset
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
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

    /**
     *
     * @param SCCard $card
     * @return SCCard 
     * 
     * @since 1.0, Sudden Growth
     */
    public function remove(SCCard $card) {
        $pos = array_search($card, $this->elements, true);
        if ($pos !== false) {
            unset($this->elements[$pos]);
            $card->setXOffset(0);
            $card->setYOffset(0);
            return $card;
        }

        return null;
    }

    /**
     * 
     * @return SCCard
     * 
     * @since 1.0, Sudden Growth
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

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getRoot() {
        $o = $this;
        while ($o->getParent())
            $o = $o->getParent();
        return $this->game->getRoot($o);
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     *
     * @param type $parent 
     * 
     * @since 1.0, Sudden Growth
     */
    public function setParent($parent) {
        $this->parent = $parent;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getXOffset() {
        return $this->xOffset;
    }

    /**
     *
     * @param type $xOffset 
     * 
     * @since 1.0, Sudden Growth
     */
    public function setXOffset($xOffset) {
        $this->xOffset = $xOffset;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getYOffset() {
        return $this->yOffset;
    }

    /**
     *
     * @param type $yOffset 
     * 
     * @since 1.0, Sudden Growth
     */
    public function setYOffset($yOffset) {
        $this->yOffset = $yOffset;
    }

    /**
     *
     * @return bool
     * 
     * @since 1.0, Sudden Growth
     */
    public function isMovable() {
        return $this->movable;
    }

    /**
     *
     * @param bool $movable 
     * 
     * @since 1.0, Sudden Growth
     */
    public function setMovable($movable) {
        $this->movable = $movable;
    }

    /**
     *
     * @param bool $droppable 
     * 
     * @since 1.0, Sudden Growth
     */
    public function setDropable($droppable) {
        $this->droppable = $droppable;
    }

    /**
     *
     * @return bool
     * 
     * @since 1.0, Sudden Growth
     */
    public function isDroppable() {
        return $this->droppable;
    }

    /**
     *
     * @return int
     * 
     * @since 1.0, Sudden Growth
     */
    public function getZIndex() {
        return 50;
    }

    /**
     *
     * @param type $invertView 
     * 
     * @since 1.0, Sudden Growth
     */
    public function setInvertView($invertView) {
        $this->invertView = $invertView;
    }

    /**
     *
     * @return bool
     * 
     * @since 1.0, Sudden Growth
     */
    public function invertView() {
        $o = $this;
        while ($o) {
            if ($o->invertView) {
                return true;
            }
            $o = $o->getParent();
        }
        return false;
    }

    /**
     *
     * @return StdClass 
     * 
     * @since 1.0, Sudden Growth
     */
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
     * Checks if the container is inside the other container.
     * 
     * @param SCContainer $container 
     * 
     * @return boolean
     * 
     * @since 1.0, Sudden Growth
     */
    public function isInside(SCContainer $container) {
        $o = $this;
        while ($o) {
            if ($o === $container)
                return true;
            $o = $o->getParent();
        }
        return false;
    }

    /**
     *
     * @return string
     * 
     * @since 1.0, Sudden Growth
     */
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