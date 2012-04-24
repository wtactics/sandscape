<?php

/* SCCard.php
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
 * @since 1.0, Sudden Growth
 */
class SCCard extends SCContainer {

    private $dbId;
    private $face;
    private $back;
    private $faceUp = false;
    private $player;
    private $states;
    private $tokens;
    private $label;

    /**
     * @var SCCounter[]
     */
    private $counters;

    /**
     *
     * @param SCGame $game
     * @param type $player
     * @param type $dbId
     * @param type $face
     * @param type $back 
     * 
     * @since 1.0, Sudden Growth
     */
    public function __construct(SCGame $game, $player, $dbId, $face, $back = 'cardback.png') {
        parent::__construct($game, false, true, 1);
        $this->player = $player;
        $this->dbId = $dbId;
        $this->face = $face;
        $this->back = $back;
        $this->states = array();
        $this->tokens = array();
        $this->counters = array();
    }

    /**
     *
     * @param SCToken $token 
     * 
     * @since 1.0, Sudden Growth
     */
    public function addToken(SCToken $token) {
        $this->tokens[$token->getId()] = $token;
    }

    /**
     *
     * @param SCToken $token 
     * 
     * @since 1.0, Sudden Growth
     */
    public function removeToken(SCToken $token) {
        unset($this->tokens[$token->getId()]);
    }

    /**
     *
     * @param SCToken $token 
     * 
     * @since 1.0, Sudden Growth
     */
    public function toggleToken(SCToken $token) {
        if (isset($this->tokens[$token->getId()])) {
            $this->removeToken($token);
        } else {
            $this->addToken($token);
        }
    }

    /**
     *
     * @param SCState $state 
     * 
     * @since 1.0, Sudden Growth
     */
    public function addState(SCState $state) {
        $this->states[$state->getId()] = $state;
    }

    /**
     *
     * @param SCState $state 
     * 
     * @since 1.0, Sudden Growth
     */
    public function removeState(SCState $state) {
        unset($this->states[$state->getId()]);
    }

    /**
     *
     * @param SCState $state 
     * 
     * @since 1.0, Sudden Growth
     */
    public function toggleState(SCState $state) {
        if (isset($this->states[$state->getId()]))
            $this->removeState($state);
        else
            $this->addState($state);
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getPlayer() {
        return $this->player;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function isFaceUp() {
        return $this->faceUp;
    }

    /**
     *
     * @param type $faceUp 
     * 
     * @since 1.0, Sudden Growth
     */
    public function setFaceUp($faceUp) {
        $this->faceUp = $faceUp;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getSrc() {
        if ($this->isFaceUp() && $this->getRoot())
            return $this->face;
        else
            return $this->back;
    }

    /**
     *
     * @return string 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getVisibility() {
        //NOTE: Serra doesn't like this code, I don't blame him, but he wrote it!
        $o = $this->getParent();
        while ($o) {
            if ($o instanceof SCDeck || $o instanceof SCGraveyard) {
                return 'hidden';
            }

            $o = $o->getParent();
        }
        return 'visible';
    }

    public function getStatus() {
        $status = parent::getStatus();
        $status->src = $this->getSrc();
        $status->visibility = $this->getVisibility();

        $status->tokens = array();
        foreach ($this->tokens as $token) {
            $status->tokens [] = $token->getJSONData();
        }

        $status->states = array();
        foreach ($this->states as $state) {
            $status->states[] = $state->getJSONData();
        }

        $status->counters = array();
        foreach ($this->counters as $counter) {
            $status->counters[] = $counter->getJSONData();
        }

        $status->label = $this->label;
        return $status;
    }

    /**
     * Returns the database ID for this card.
     * 
     * @return integer
     * 
     * @since 1.0, Sudden Growth
     */
    public function getDbId() {
        return $this->dbId;
    }

    public function getZIndex() {
        $z = 50;
        $o = $this;
        while ($o) {
            $o = $o->getParent();
            $z++;
        }
        return $z;
    }

    /**
     * @since 1.2, Elvish Shaman
     */
    public function flip() {
        $this->faceUp = !$this->faceUp;
    }

    /**
     *
     * @param string $label 
     * 
     * @since 1.2, Elvish Shaman
     */
    public function setLabel($label) {
        $this->label = $label;
    }

    /**
     *
     * @param type $name
     * @param type $value
     * @param type $step
     * @param type $class
     * @return SCCounter
     * 
     * @since 1.3, Soulharvester 
     */
    public function addCounter($name, $value = 0, $step = 1, $class = 'cl-default') {
        if (!isset($this->counters[$name])) {
            $id = ($this->getId() . '-c' . (count($this->counters) + 1));
            $this->counters[$name] = new SCCounter($id, $name, $value, $step, $class);

            return $this->counters[$name];
        }

        return null;
    }

    /**
     *
     * @param type $name
     * 
     * @since 1.3, Soulharvester 
     */
    public function removeCounter($name) {
        unset($this->counters[$name]);
    }

    /**
     *
     * @param string $name
     * @param bool $discardStart 
     * 
     * @since 1.3, Soulharvester
     */
    public function resetCounter($name, $discardStart = false) {
        if (isset($this->countes[$name])) {
            if ($discardStart) {
                $this->counters[$name]->setValue(0);
            } else {
                $this->counters[$name]->reset();
            }
        }
    }

    /**
     *
     * @param string $name
     * 
     * @return int
     * 
     * @since 1.3, Soulharvester
     */
    public function increaseCounterValue($name) {
        if (isset($this->counters[$name])) {
            $this->counters[$name]->increase();

            return $this->counters[$name]->getValue();
        }

        return 0;
    }

    /**
     *
     * @param string $name 
     * 
     * @return int
     * 
     * @since 1.3, Soulharvester
     */
    public function decreaseCounterValue($name) {
        if (isset($this->counters[$name])) {
            $this->counters[$name]->decrease();

            return $this->counters[$name]->getValue();
        }

        return 0;
    }

    /**
     *
     * @return int
     * 
     * @since 1.3, Soulharvester
     */
    public function getCounterCount() {
        return count($this->counters);
    }

}