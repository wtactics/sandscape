<?php
/*
 * controllers/GameController.php
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
class GameController extends Controller {

    private $wtsGame;
    private $game;

    public function __construct($id, $module) {
        parent::__construct($id, $module);

        $this->layout = '//layouts/game';
    }

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array('index', 'send', 'pull', 'startup', 'moveCard', 'updateOpponent', 'cardFromDeck'),
                'users' => array('@')
                )), parent::accessRules());
    }

    public function actionIndex($gameId) {       
        $this->game = Game::model()->findByPk($gameId);
        if ($this->game) {
            if (($cState = $this->game->currentState)) {
                $this->wtsGame = unserialize($cState);

                if (!$this->wtsGame->isStarted()) {
                    $this->wtsGame->init(Deck::model()->findByPk($this->game->deckA), Deck::model()->findByPk($this->game->deckB));
                }
                $this->saveGame();
            } else {
                //TODO: ... gerir erro, init do game, etc...
                $this->wtsGame = new WTSGame();
                $this->saveGame();
            }
        }

        $this->render('board');
    }

    private function saveGame() {
        $this->game->currentState = serialize($this->wtsGame);
        $this->game->save();
    }

    private function loadGame($gameId) {
        if (!$this->game) {
            $this->game = Game::model()->findByPk($gameId);
            if ($this->game) {
                $this->wtsGame = unserialize($this->game->currentState);
            }
        }
        //TODO: error on failed loading....
    }

    private function getPlayerSide($playerId) {
        if ($this->game->playerA == $playerId) {
            return $this->wtsGame->getPlayerASide();
        } else {
            return $this->wtsGame->getPlayerBSide();
        }
    }

    private function getOpponentSide($playerId) {
        if ($this->game->playerA != $playerId) {
            return $this->wtsGame->getPlayerASide();
        } else {
            return $this->wtsGame->getPlayerBSide();
        }
    }

    //TODO: remove/place in all mighty utilities
    private function JSONIndent($json) {

        $result = '';
        $pos = 0;
        $strLen = strlen($json);
        $indentStr = '  ';
        $newLine = "\n";
        $prevChar = '';
        $outOfQuotes = true;

        for ($i = 0; $i <= $strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

                // If this character is the end of an element,
                // output a new line and indent the next line.
            } else if (($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos--;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        return $result;
    }

    public function actionStartup($gameId, $playerId) {
        $this->loadGame($gameId);

        $player = $this->getPlayerSide($playerId);
        $opponent = $this->getOpponentSide($playerId);

        echo $this->JSONIndent(json_encode((object) array(
                            'deck' => (object) array(
                                'id' => $player->getDeck()->getId(),
                            ),
                            'graveyard' => (object) array(
                                'id' => $player->getGraveyard()->getId(),
                            ),
                            'hand' => (object) array(
                                'id' => $player->getHand()->getId(),
                                'html' => $player->getHand()->getHTML()
                            ),
                            'playableArea' => (object) array(
                                'id' => $player->getPlayableArea()->getId(),
                                'html' => $player->getPlayableArea()->getHTML()
                            ),
                            'opponentArea' => (object) array(
                                'id' => $opponent->getPlayableArea()->getId(),
                                'html' => $opponent->getPlayableArea()->getReversedHTML()
                            ),
                            'update' => $this->getUpdate($playerId),
                )));
    }

    private function getUpdate($playerId) {
        $player = $this->getPlayerSide($playerId);
        $opponent = $this->getOpponentSide($playerId);

        return array_merge(
                $player->getDeck()->getUpdate(), $player->getHand()->getUpdate(), $player->getPlayableArea()->getUpdate(), $player->getGraveyard()->getUpdate(), $opponent->getPlayableArea()->getUpdate()
        );
    }

    public function actionUpdateOpponent($gameId, $playerId) {
        $this->loadGame($gameId);
        //
        $player = $this->getPlayerSide($playerId);
        $opponent = $this->getOpponentSide($playerId);

        echo $this->JSONIndent(json_encode((object) array(
                            'update' => $opponent->getPlayableArea()->getUpdate()
                )));
    }

    public function actionCardFromDeck($gameId, $playerId) {
        $this->loadGame($gameId);
        //
        $player = $this->getPlayerSide($playerId);
        $opponent = $this->getOpponentSide($playerId);

        $card = $player->getDeck()->pop();
        $card->setFaceUp(true);
        $player->getHand()->push($card);

        $this->saveGame();

        echo $this->JSONIndent(json_encode((object) array(
                            'update' => $this->getUpdate($playerId)
                )));
    }

    public function actionMoveCard($gameId, $playerId, $id, $idDestination) {
        $this->loadGame($gameId);
        //
        $player = $this->getPlayerSide($playerId);
        $opponent = $this->getOpponentSide($playerId);

        $origin = $player->findCardContainer($id);
        $destination = $player->find($idDestination);
        if ($origin && $destination) {
            //error_log(sprintf('Mover de %s para %s', $origin->getId(), $destination->getId()));
            $card = $origin->getCard($id);
            $origin->removeCard($card->getId());
            $destination->push($card);
        }

        $this->saveGame();

        echo $this->JSONIndent(json_encode((object) array(
                            'update' => $this->getUpdate($playerId)
                )));
    }

    //TODO: implement this
    public function actionSend() {
        $message = new ChatMessage();

        //TODO: make safe?
        $message->message = $_POST['message'];
        $message->sent = date('Y-m-d H:m:s');
        //TODO: get correct user
        $message->userId = 2;
        //TODO: get correct chat
        $message->chatId = 2;

        $message->save();
    }

    //TODO: implement this
    public function actionPull($last) {
        
    }

}
