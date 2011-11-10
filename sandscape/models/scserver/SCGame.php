<?php

/* SCGame.php
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

class SCGame {

    /**
     *
     * @var SCContainer[]  
     */
    private $all = array();
    private $roots = array();
    private $availableTokens = array();
    private $availableStates = array();

    /**
     *
     * @var SCPlayerSide 
     */
    private $player1Side;

    /**
     *
     * @var SCPlayerSide 
     */
    private $player2Side;

    /**
     * If a card is not anywhere, is in void
     * @var SCContainer
     */
    private $void;

    /**
     * TODO: document this....
     */
    public function __construct($hasGraveyard, $player1, $player2, $availableTokens, $availableStates, $handWidth = 20, $handHeight = 20, $gameWidth = 100, $gameHeight = 30) {
        $this->player1Side = new SCPlayerSide($this, $player1, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
        $this->player2Side = new SCPlayerSide($this, $player2, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
        $this->void = new SCContainer($this, false, false);

        foreach ($availableTokens as $token)
            $this->availableTokens[$token->getId()] = $token;

        foreach ($availableStates as $state)
            $this->availableStates[$state->getId()] = $state;
    }

    public function __wakeup() {
        $this->roots = array();
    }

    public function register(SCContainer $c) {
        $this->all[$c->getId()] = $c;
    }

    public function unregister(SCContainer $c) {
        unset($this->all[$c->getId()]);
    }

    public function getRoot(SCContainer $scc) {
        if (isset($this->roots[$scc->getId()]))
            return $this->roots[$scc->getId()];
        return null;
    }

    public function addPlayer1Deck(SCDeck $deck) {
        $this->player1Side->addDeck($deck);
    }

    public function addPlayer2Deck(SCDeck $deck) {
        $this->player2Side->addDeck($deck);
    }

    /**
     * Returns the current player side.
     * 
     * @param  integer $userId User who originated the request.
     * @return SCPlayerSide 
     */
    public function getPlayerSide($userId) {
        $side = ($this->player1Side->getPlayerId() == $userId ? $this->player1Side :
                        ($this->player2Side->getPlayerId() == $userId ? $this->player2Side : null));

        $this->roots[$side->getHand()->getId()] = $side->getHand();
        $this->roots[$side->getPlayableArea()->getId()] = $side->getPlayableArea();
        if ($side->getGraveyard())
            $this->roots[$side->getGraveyard()->getId()] = $side->getGraveyard();
        foreach ($side->getDecks() as $deck)
            $this->roots[$deck->getId()] = $deck;

        return $side;
    }

    /**
     * Returns the opponent side of the game.
     * 
     * @param  integer $userId  User who originated the request.
     * 
     * @return SCPlayerSide
     */
    public function getOpponentSide($userId) {
        $side = ($this->player1Side->getPlayerId() == $userId ? $this->player2Side :
                        ($this->player2Side->getPlayerId() == $userId ? $this->player1Side : null));

        $this->roots [$side->getPlayableArea()->getId()] = $side->getPlayableArea();
        $side->getPlayableArea()->setInvertView(true);

        return $side;
    }

    public function getVoid() {
        return $this->void;
    }

    /**
     * Returns the cards initialization.
     * 
     * @return array
     */
    public function getCardInitialization() {
        $update = array();

        foreach ($this->all as $c) {
            if ($c instanceof SCCard) {
                $update [] = $c->getStatus();
            }
        }

        return $update;
    }

    /**
     * Returns all elements positions.
     * I have the feeling that this one will try to bite me in the ass later. 
     * 
     * @return array
     */
    public function getGameStatus() {
        $update = array();

        foreach ($this->all as $c) {
            if ($c->isMovable()) {
                $update [] = $c->getStatus();
            }
        }

        return $update;
    }

    public function drawCard($userId, $deck, $toHand = true) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $player->drawCard($deck, $toHand);

        return (object) array('update' => $this->getGameStatus());
    }

    public function moveCard($userId, $card, $location, $xOffset = 0, $yOffset = 0) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$card]) ? $this->all[$card] : null;
        $location = isset($this->all[$location]) ? $this->all[$location] : null;

        if ($card && $location && $card instanceof SCCard && $card->isMovable()
                && $location->isDroppable() && $card->getPlayer() == $userId) {

            if ($card !== $location && !$location->isInside($card)) {
                if ($card->getParent())
                    $oldLocation = $card->getParent();
                if ($location->push($card) && $oldLocation) {
                    $oldLocation->remove($card);
                }
            }
            if ($card) {
                $card->setXOffset($xOffset);
                $card->setYOffset($yOffset);
            }
        }

        return (object) array(
                    'update' => $this->getGameStatus()
        );
    }

    public function toggleCardToken($userId, $card, $token) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$card]) ? $this->all[$card] : null;
        $token = isset($this->availableTokens[$token]) ? $this->availableTokens[$token] : null;

        if ($card && $token && $card instanceof SCCard && $card->getPlayer() == $userId) {
            $card->toggleToken($token);

            return (object) array(
                        'update' => $this->getGameStatus()
            );
        }
    }

    public function toggleCardState($userId, $card, $state) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$card]) ? $this->all[$card] : null;
        $state = isset($this->availableStates[$state]) ? $this->availableStates[$state] : null;

        if ($card && $state && $card instanceof SCCard && $card->getPlayer() == $userId) {
            $card->toggleState($state);

            return (object) array(
                        'update' => $this->getGameStatus()
            );
        }
    }

    public function clientUpdate($userId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        return (object) array(
                    'update' => $this->getGameStatus()
        );
    }

    public function clientInitialization($userId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $tokens = array();
        foreach ($this->availableTokens as $token)
            $tokens [] = $token->getInfo();

        $states = array();
        foreach ($this->availableStates as $state)
            $states[] = $state->getInfo();

        return (object) array(
                    'createThis' => (object) array(
                        'nowhere' => (object) array(
                            'id' => $this->void->getId(),
                        ),
                        'player' => (object) array(
                            'hand' => (object) array(
                                'id' => $player->getHand()->getId(),
                            ),
                            'playableArea' => (object) array(
                                'id' => $player->getPlayableArea()->getId(),
                            ),
                            'decks' => $player->getDecksInitialization(),
                            'graveyard' => $player->getGraveyard() ? (object) array(
                                        'id' => $player->getGraveyard()->getId(),
                                    ) : null,
                        ),
                        'opponent' => (object) array(
                            'playableArea' => (object) array(
                                'id' => $opponent->getPlayableArea()->getId(),
                            )
                        ),
                        'cards' => $this->getCardInitialization(),
                    ),
                    'gameInfo' => (object) array(
                        'tokens' => $tokens,
                        'cardStates' => $states
                    )
        );
    }

    /**
     *
     * @param type $cardId
     * @return StdClass 
     */
    public function getCardStatus($userId, $cardId) {
        if (isset($this->all[$cardId])) {
            $player = $this->getPlayerSide($userId);
            $opponent = $this->getOpponentSide($userId);

            return $this->all[$cardId]->getStatus();
        }

        return null;
    }

    /**
     *
     * @param int $userId
     * @param int $cardId
     * 
     * @return SCCard
     */
    public function flipCard($userId, $cardId) {
        if (isset($this->all[$cardId])) {
            $player = $this->getPlayerSide($userId);
            $opponent = $this->getOpponentSide($userId);

            $this->all[$cardId]->flip();

            return $this->all[$cardId];
        }

        return null;
    }

    public function shuffleDeck($userId, $deckId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        return $player->shuffleDeck($deckId);
    }

}