<?php

/* PlayerSide.php
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

namespace engine\models;

/**
 * Pedro Serra
 * @copyright (c) 2016, WTactics Project
 */
final class PlayerSide {

    private $game;
    private $playerId;
    private $decks;
    private $graveyard;
    private $hand;
    private $playableArea;
    private $counters;

    public function __construct(SCGame $game, $playerId, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight) {
        $this->game = $game;
        $this->playerId = $playerId;
        $this->hand = new SCContainer($game, false, true); // new SCGrid($game, $handHeight, $handWidth);
        $this->playableArea = new SCContainer($game, false, true); // new SCGrid($game, $gameHeight, $gameWidth);
        if ($hasGraveyard)
            $this->graveyard = new Graveyard($game);

        $this->decks = array();
        $this->counters = array();
    }

    /**
     *
     * @param SCDeck $deck 
     */
    public function addDeck(SCDeck $deck) {
        $this->decks[$deck->getId()] = $deck;
    }

    /**
     *
     * @return int
     */
    public function getPlayerId() {
        return $this->playerId;
    }

    /**
     *
     * @return SCGraveyard
     */
    public function getGraveyard() {
        return $this->graveyard;
    }

    /**
     *
     * @return SCContainer
     */
    public function getHand() {
        return $this->hand;
    }

    /**
     *
     * @return SCContainer
     */
    public function getPlayableArea() {
        return $this->playableArea;
    }

    /**
     *
     * @return array
     */
    public function getDecks() {
        return $this->decks;
    }

    /**
     *
     * @return array
     */
    public function getDecksInitialization() {
        $output = array();
        foreach ($this->decks as $deck) {
            $output [] = (object) array(
                        'id' => $deck->getId(),
                        'name' => $deck->getName(),
            );
        }
        return $output;
    }

    /**
     *
     * @param string $deckId
     * @param bool $toHand 
     * 
     * @return SCCard
     */
    public function drawCard($deckId, $toHand = true) {
        if (isset($this->decks[$deckId])) {
            $deck = $this->decks[$deckId];
            $card = $deck->pop();
            if ($card) {
                $card->setMovable(true);
                if ($toHand) {
                    $card->setFaceUp(true);
                    $this->hand->push($card);
                } else {
                    $this->playableArea->push($card);
                }
            }

            return $card;
        }

        return null;
    }

    /**
     *
     * @param string $deckId
     * @return bool
     */
    public function shuffleDeck($deckId) {
        if (isset($this->decks[$deckId])) {
            return $this->decks[$deckId]->shuffle();
        }

        return false;
    }

    /**
     *
     * @param bool $toHand 
     */
    public function drawFromGraveyard($toHand = true) {
        if ($this->graveyard) {
            $card = $this->graveyard->pop();
            if ($card) {
                $card->setMovable(true);
                if ($toHand) {
                    $card->setFaceUp(true);
                    $this->hand->push($card);
                } else {
                    $this->playableArea->push($card);
                }
            }
        }
    }

    /**
     *
     * @return bool
     */
    public function shuffleGraveyard() {
        if ($this->graveyard) {
            return $this->graveyard->shuffle();
        }

        return false;
    }

    /**
     *
     * @param string $deckId
     * 
     * @return SCDeck
     */
    public function getDeck($deckId) {
        return (isset($this->decks[$deckId]) ? $this->decks[$deckId] : null);
    }

    /**
     *
     * @param SCCounter $counter
     * 
     * @return bool
     */
    public function addCounter(SCCounter $counter) {
        if (!isset($this->counters[$counter->getId()])) {

            if ($counter->getId() === null) {
                $counter->setId(('uc-' . $this->playerId . '-' . (count($this->counters) + 1)));
            }

            $this->counters[$counter->getId()] = $counter;

            return true;
        }

        return false;
    }

    /**
     *
     * @param string $name
     */
    public function removeCounter($id) {
        unset($this->counters[$id]);
    }

    /**
     *
     * @param string $name
     * @param bool $discardStart 
     */
    public function resetCounter($id, $discardStart = false) {
        if (isset($this->countes[$id])) {
            if ($discardStart) {
                $this->counters[$id]->setValue(0);
            } else {
                $this->counters[$id]->reset();
            }
        }
    }

    /**
     *
     * @param string $name
     * 
     * @return int
     */
    public function increaseCounterValue($id) {
        if (isset($this->counters[$id])) {
            $this->counters[$id]->increase();

            return $this->counters[$id]->getValue();
        }

        return 0;
    }

    /**
     *
     * @param string $name 
     * 
     * @return int
     */
    public function decreaseCounterValue($id) {
        if (isset($this->counters[$id])) {
            $this->counters[$id]->decrease();

            return $this->counters[$id]->getValue();
        }

        return 0;
    }

    /**
     *
     * @return int
     */
    public function getCounterCount() {
        return count($this->counters);
    }

    /**
     * Converts the counters owned by this player so that they can be easily 
     * enconded as JSON.
     * 
     * @return array All existing counters as ready to encode objects.
     */
    public function getEncodedCounters() {
        $jsonData = array();
        foreach ($this->counters as $counter) {
            $jsonData[] = $counter->getJSONData();
        }

        return $jsonData;
    }

}
