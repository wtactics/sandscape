<?php

/* SCCard.php
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

class SCCard extends SCContainer {

    private $dbId;
    private $face;
    private $back;
    private $faceUp = false;
    private $player;
    private $states;
    private $tokens;
    private $label;

    public function __construct(SCGame $game, $player, $dbId, $face, $back = 'cardback.jpg') {
        parent::__construct($game, false, true, 1);
        $this->player = $player;
        $this->dbId = $dbId;
        $this->face = $face;
        $this->back = $back;
        $this->states = array();
        $this->tokens = array();
    }

    public function addToken(SCToken $token) {
        $this->tokens[$token->getId()] = $token;
    }

    public function removeToken(SCToken $token) {
        unset($this->tokens[$token->getId()]);
    }

    public function toggleToken(SCToken $token) {
        if (isset($this->tokens[$token->getId()]))
            $this->removeToken($token);
        else
            $this->addToken($token);
    }

    public function addState(SCState $state) {
        $this->states[$state->getId()] = $state;
    }

    public function removeState(SCState $state) {
        unset($this->states[$state->getId()]);
    }

    public function toggleState(SCState $state) {
        if (isset($this->states[$state->getId()]))
            $this->removeState($state);
        else
            $this->addState($state);
    }

    public function getPlayer() {
        return $this->player;
    }

    public function isFaceUp() {
        return $this->faceUp;
    }

    public function setFaceUp($faceUp) {
        $this->faceUp = $faceUp;
    }

    public function getSrc() {
        if ($this->isFaceUp() && $this->getRoot())
            return $this->face;
        else
            return $this->back;
    }

    //NOTE: Serra doesn't like this code, I don't blame him, but he wrote it!
    public function getVisibility() {
        $o = $this->getParent();
        while ($o) {
            if ($o instanceof SCDeck || $o instanceof SCGraveyard)
                return 'hidden';

            $o = $o->getParent();
        }
        return 'visible';
    }

    public function getStatus() {
        $status = parent::getStatus();
        $status->src = $this->getSrc();
        $status->visibility = $this->getVisibility();

        $status->tokens = array();
        foreach ($this->tokens as $token)
            $status->tokens [] = $token->getJSONData();

        $status->states = array();
        foreach ($this->states as $state)
            $status->states[] = $state->getJSONData();

        $status->label = $this->label;
        return $status;
    }

    /**
     * Returns the database ID for this card.
     * 
     * @return integer
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

}