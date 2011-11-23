<?php

/* GameController.php
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
 * Handles all game related actions, from lobby to in-game actions.
 * 
 * @since 1.0, Sudden Growth
 */
class GameController extends AppController {

    /**
     * @var SCGame
     */
    private $scGame;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * As a convenience, the index action has been invalidated by making a redirect
     * whenever this action is requested. All actions in the game controller need 
     * to have an explicit name.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionIndex() {
        $this->redirect('lobby/index');
    }

    /**
     * Sends messages to the game chat. Only the two players can send messages, 
     * any spectator will be able to see the messages but not write in the chat.
     *  
     * Simple word filtering is applied to the message before being stored, due 
     * to the way chats work the user that sent the message will still see the 
     * unfiltered message.
     *  
     * @param integer $id The game ID.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionSendMessage($id) {
        $result = array('success' => 0);
        if (Yii::app()->request->isPostRequest) {
            $game = $this->loadGameById($id);
            if (($game->player1 == Yii::app()->user->id || $game->player2 == Yii::app()->user->id)
                    && isset($_REQUEST['gamemessage'])) {

                $cm = new ChatMessage();

                $cm->message = $this->chatWordFilter($_REQUEST['gamemessage']);
                $cm->userId = Yii::app()->user->id;
                $cm->gameId = $id;

                if ($cm->save()) {
                    $cm->refresh();
                    $result = array(
                        'success' => 1,
                        'id' => $cm->messageId,
                        'date' => date('H:i', strtotime($cm->sent)),
                        'message' => $cm->message,
                        'order' => ($game->player1 == Yii::app()->user->id ? 1 : 2)
                    );
                }
                $this->updateUserActivity();
            }
        }

        echo json_encode($result);
    }

    /**
     * Retrieves chat messages from the game. Only the users participating in a 
     * game can request chat messages.
     * 
     * @param integer $id The game ID
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionChatUpdate($id) {
        $result = array('has' => 0);
        if (Yii::app()->request->isPostRequest) {
            $game = $this->loadGameById($id);
            if (isset($_REQUEST['lastupdate'])) {

                $lastUpdate = (int) $_REQUEST['lastupdate'];
                $messages = array();

                $cms = ChatMessage::model()->findAll('messageId > :last AND gameId = :id', array(
                    ':last' => $lastUpdate,
                    ':id' => (int) $id
                        ));

                foreach ($cms as $cm) {
                    $messages[] = array(
                        'message' => $cm->message,
                        'date' => date('H:i', strtotime($cm->sent)),
                        'order' => ($game->player1 == Yii::app()->user->id ? 1 :
                                ($game->player2 == Yii::app()->user->id ? 2 : 3)),
                        'system' => $cm->system
                    );
                }
                $count = count($messages);

                $last = $lastUpdate;
                if ($count) {
                    $last = end($cms)->messageId;
                }
                $result = array(
                    'has' => $count,
                    'messages' => $messages,
                    'last' => $last
                );
                $this->updateUserActivity();
            }
        }
        echo json_encode($result);
    }

    /**
     * The main action that offers all "game" features allowing users to play games.
     * This action will continually evolve to untill the game actions are stable.
     * 
     * Current actions:
     * 
     * [since Sudden Growth]
     * startGame:
     * startUp:
     * update:
     * drawCard:
     * moveCard:
     * 
     * [since Green Shield]
     * cardInfo:
     *      Gets the requested card's information. This event should provide the 
     *      card image, name, rules and any associated token/state that affects 
     *      the card in-game.
     * 
     * [since Elvish Shaman]
     * drawCardToTable:
     * toggleCardToken:
     * toggleCardState:
     * flipCard:
     * shuffleDeck:
     * roll:
     *      Generates a dice roll for the specified dice ID. If the dice is set 
     *      available for this game and is a valid dice (active), than a random
     *      will be generated between 1 and $dice->face.
     * label:
     * toGraveyard:
     * fromGraveyardToTable:
     * fromGraveyard:
     * shuffleGraveyard:
     * 
     * [since Soulharvester]
     * addCounter:
     * 
     * @param int $id The game ID.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionPlay($id) {
        $this->layout = '//layouts/game';
        $currentUserId = Yii::app()->user->id;
        //flag used by moveCard and moveCardToTable, defaults to hand 
        $toHand = true;

        //lock record
        $id = intval($id);
        $lock = Yii::app()->db->createCommand("SELECT GET_LOCK('game.$id', 10)")->queryScalar();
        if ($lock != 1) {
            throw new CHttpException(500, 'Failed to get game lock');
        }

        $game = $this->loadGameById($id);
        if (in_array($currentUserId, array($game->player1, $game->player2))) {
            if ($game->state) {
                $this->scGame = unserialize($game->state);
            }
            if (isset($_REQUEST['event'])) {
                switch ($_REQUEST['event']) {
                    /**
                     * START GAME: Player 1 starts the game.
                     * Only the player that creates the game can start it.
                     * This action can be automatized somewhere in the interface.
                     * 
                     * out.result:
                     *    'ok'   -> game started; use startUp to configure area
                     *    'wait' -> wait a few seconds and repeat this later
                     */
                    case 'startGame':
                        if (!$game->player1Ready || !$game->player2Ready) {
                            echo json_encode((object) array('result' => 'wait'));
                        } elseif ($game->running) {
                            echo json_encode((object) array('result' => 'ok'));
                        } elseif ($game->player1Ready && $game->player2Ready && !$game->running && $currentUserId == $game->player1) {
                            $game->running = 1;
                            $game->started = date('Y-m-d H:i:s');

                            // tokens
                            $tokens = array();
                            foreach (Token::model()->findAll('active = 1') as $token) {
                                $tokens[] = new SCToken($token->name, $token->image);
                            }

                            // card states
                            $states = array();
                            foreach (State::model()->findAll('active = 1') as $state) {
                                $states[] = new SCState($state->name, $state->image);
                            }

                            // create the game status
                            $this->scGame = new SCGame($game->graveyard, $game->player1, $game->player2, $tokens, $states);

                            // decks in the game
                            foreach ($game->decks as $deck) {
                                $cards = array();
                                foreach ($deck->deckCards as $card) {
                                    $cards[] = $c = new SCCard($this->scGame, $deck->userId, $card->card->cardId, $card->card->image);
                                }
                                $scdeck = new SCDeck($this->scGame, $deck->name, $cards, $deck->deckId);

                                if ($deck->userId == $game->player1) {
                                    $this->scGame->addPlayer1Deck($scdeck);
                                } elseif ($deck->userId == $game->player2) {
                                    $this->scGame->addPlayer2Deck($scdeck);
                                }
                            }

                            // player counters
                            $counters = array();
                            foreach ($game->counters as $counter) {
                                $this->scGame->addPlayer1Counters(new SCCounter(null, $counter->name, $counter->startValue, $counter->step));
                                $this->scGame->addPlayer2Counters(new SCCounter(null, $counter->name, $counter->startValue, $counter->step));
                            }

                            $game->lastChange = time();
                            echo json_encode((object) array('result' => 'ok'));
                        } else {
                            echo json_encode((object) array('result' => 'wait'));
                        }
                        break;
                    /**
                     * STARTUP: initialization of client state
                     * 
                     * out.result:
                     *    'ok'  ->  returns game info for client configuration
                     *    'wait' -> game not running; wait a minute please
                     */
                    case 'startUp':
                        if ($game->running && $this->scGame) {
                            $result = $this->scGame->clientInitialization($currentUserId);
                            $result->result = 'ok';
                            $result->lastChange = $game->lastChange;
                            echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        } else {
                            echo json_encode((object) array('result' => 'wait', 'motive' => 'Game not started'));
                        }
                        break;
                    /**
                     * UPDATE: updates the client status
                     * 
                     * obj.result:
                     *    'ok'   -> Game has changed since last time; update included
                     *    'wait' -> Game has not changed; ask again later
                     */
                    case 'update':
                        if ($game->running && $this->scGame) {
                            if (!isset($_REQUEST['lastChange']) || $game->lastChange != $_REQUEST['lastChange']) {
                                $result = $this->scGame->clientUpdate($currentUserId);
                                $result->result = 'ok';
                                $result->lastChange = $game->lastChange;
                                $result->clientTime = $_REQUEST['clientTime'];
                                echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                            } else {
                                echo json_encode((object) array('result' => 'wait', 'motive' => 'Game not changed since last updade'));
                            }
                        }
                        break;
                    /**
                     * Draws a card from a deck.
                     * 
                     * Params:
                     *  deck - id from deck element
                     * 
                     * out.result:
                     *    'ok'
                     */
                    case 'drawCardToTable':
                        //default is set in the method's first lines
                        $toHand = false;
                    case 'drawCard':
                        if ($game->running && $this->scGame && isset($_REQUEST['deck'])) {
                            $deck = $_REQUEST['deck'];
                            if (($card = $this->scGame->drawCard($currentUserId, $deck, $toHand)) !== null) {
                                $result = array(
                                    'result' => 'ok',
                                    'clientTime' => $_REQUEST['clientTime'],
                                    'update' => $this->scGame->getGameStatus()
                                );
                                $msg = Yii::app()->user->name;
                                if ($toHand) {
                                    $msg .= ' draws a new card to his/her hand.';
                                } else {
                                    $msg .= ' places a new card on the table.';
                                }
                                $this->putChatMessage($msg, $game->gameId, $currentUserId);
                            }
                            echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        }
                        break;
                    case 'moveCard':
                        if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['location'])) {
                            $card = $_REQUEST['card'];
                            $location = $_REQUEST['location'];
                            $xOffset = isset($_REQUEST['xOffset']) ? floatval($_REQUEST['xOffset']) : 0;
                            $yOffset = isset($_REQUEST['yOffset']) ? floatval($_REQUEST['yOffset']) : 0;
                            $result = $this->scGame->moveCard($currentUserId, $card, $location, $xOffset, $yOffset);
                            $result->result = 'ok';
                            $result->clientTime = $_REQUEST['clientTime'];
                            echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        }
                        break;
                    case 'toggleCardToken':
                        if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['token'])) {
                            $card = $_REQUEST['card'];
                            $token = $_REQUEST['token'];

                            if (($result = $this->scGame->toggleCardToken($currentUserId, $card, $token)) !== null) {
                                $result->result = 'ok';
                                $result->clientTime = $_REQUEST['clientTime'];

                                $card = $this->scGame->getCard($currentUserId, $card);
                                $tokenName = $this->scGame->getToken($token)->getName();
                                $msg = Yii::app()->user->name . ' toggles <span class="token-name">'
                                        . $tokenName . '</span>';

                                if ($card->isFaceUp()) {
                                    $cardName = Card::model()->findByPk($card->getDbId())->name;
                                    $msg .= ' on <span class="card-name">' . $cardName . '</span>.';
                                } else {
                                    $msg .= ' on a card.';
                                }

                                $this->putChatMessage($msg, $game->gameId, $currentUserId);

                                echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                            }
                        }
                        break;
                    case 'toggleCardState':
                        if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['state'])) {
                            $card = $_REQUEST['card'];
                            $state = $_REQUEST['state'];

                            if (($result = $this->scGame->toggleCardState($currentUserId, $card, $state)) !== null) {
                                $result->result = 'ok';
                                $result->clientTime = $_REQUEST['clientTime'];

                                $card = $this->scGame->getCard($currentUserId, $card);
                                $stateName = $this->scGame->getState($state)->getName();

                                $msg = Yii::app()->user->name . ' toggles <span class="state-name">'
                                        . $stateName . '</span>';

                                if ($card->isFaceUp()) {
                                    $cardName = Card::model()->findByPk($card->getDbId())->name;
                                    $msg .= ' on <span class="card-name">' . $cardName . '</span>.';
                                } else {
                                    $msg .= ' on a card.';
                                }

                                $this->putChatMessage($msg, $game->gameId, $currentUserId);

                                echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                            }
                        }
                        break;
                    /**
                     * Gets the card information for clients to show as bigger
                     * images in the top left information area.
                     * 
                     * Params:
                     *  card - The card element ID
                     * 
                     * out.success:
                     * out.status:
                     */
                    case 'cardInfo':
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['card'])) {
                            $result = array(
                                'success' => 1,
                                'status' => $this->scGame->getCardStatus($currentUserId, $_REQUEST['card'])
                            );
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    /**
                     * Flips a card. If the card is facing up it will be changed 
                     * to face down, if it's facing down then the card will be changed
                     * so that it is facinf up.
                     */
                    case 'flipCard':
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['card'])) {

                            if (($card = $this->scGame->flipCard($currentUserId, $_REQUEST['card'])) !== null) {
                                $result = array(
                                    'success' => 1,
                                    'status' => $card->getStatus()
                                );

                                if (!$card->isInside($this->scGame->getPlayerSide($currentUserId)->getHand())) {
                                    $cardName = Card::model()->findByPk($card->getDbId())->name;
                                    $msg = Yii::app()->user->name;

                                    if ($card->isFaceUp()) {
                                        $msg .= ' reveals';
                                    } else {
                                        $msg .= ' flips';
                                    }
                                    $msg .= ' <span class="card-name">' . $cardName . '</span>.';
                                    $this->putChatMessage($msg, $game->gameId, $currentUserId);
                                }
                            }
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    /**
                     * Shuffles the array of cards for the given deck.
                     */
                    case 'shuffleDeck':
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['deck'])) {

                            if ($this->scGame->shuffleDeck($currentUserId, $_REQUEST['deck'])) {
                                $result = array('success' => 1);

                                $deckName = $this->scGame->getPlayerSide($currentUserId)->getDeck($_REQUEST['deck'])->getName();

                                $msg = Yii::app()->user->name . ' suffled <span class="deck-name">'
                                        . $deckName . '</span>.';

                                $this->putChatMessage($msg, $game->gameId, $currentUserId);
                            }
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    /**
                     * Rolls one of the existing dice.
                     */
                    case 'roll':
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['dice']) && (int) $_REQUEST['dice']) {
                            if (($gd = GameDice::model()->find('gameId = :id AND diceId = :dice', array(
                                ':id' => $game->gameId,
                                ':dice' => (int) $_REQUEST['dice']
                                    ))) !== null) {

                                $dice = $gd->dice;
                                $roll = rand(1, $dice->face);

                                $result = array(
                                    'success' => 1,
                                    'roll' => $roll,
                                    'dice' => $dice->name,
                                    'face' => $dice->face
                                );

                                $msg = Yii::app()->user->name . ' rolled <span class="die-name">' .
                                        $dice->name . '</span> for (1 - ' . $dice->face . '): ' . $roll . '.';
                                $this->putChatMessage($msg, $game->gameId, $currentUserId);
                            }
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    case 'label':
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['label']) && isset($_REQUEST['card'])) {
                            $card = $this->scGame->placeLabel($currentUserId, $_REQUEST['card'], $_REQUEST['label']);

                            $result = array(
                                'success' => 1,
                                'status' => $card !== null ? $card->getStatus() : null
                            );
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    case 'toGraveyard':
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['card'])) {
                            $result = $this->scGame->moveToGraveyard($currentUserId, $_REQUEST['card']);

                            $card = $this->scGame->getCard($currentUserId, $_REQUEST['card']);
                            $cardName = Card::model()->findByPk($card->getDbId())->name;
                            $msg = Yii::app()->user->name . ' sends';

                            if ($card->isFaceUp()) {
                                $msg .= ' <span class="card-name">' . $cardName . '</span>';
                            } else {
                                $msg .= ' a card';
                            }
                            $msg .= ' to the graveyard.';

                            $this->putChatMessage($msg, $game->gameId, $currentUserId);
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    case 'fromGraveyardToTable':
                        //default is set in the method's first lines
                        $toHand = false;
                    case 'fromGraveyard':
                        if ($game->running && $this->scGame) {
                            $result = $this->scGame->drawFromGraveyard($currentUserId, $toHand);
                            $result->result = 'ok';
                            $result->clientTime = $_REQUEST['clientTime'];

                            $msg = Yii::app()->user->name;
                            if ($toHand) {
                                $msg .= ' draws a card from the <span class="deck-name">graveyard</span> to his/her hand.';
                            } else {
                                $msg .= ' takes a card from the <span class="deck-name">graveyard</span> and places it on the table.';
                            }
                            $this->putChatMessage($msg, $game->gameId, $currentUserId);

                            echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        }
                        break;
                    case 'shuffleGraveyard':
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame) {

                            $result = array(
                                'success' => $this->scGame->shuffleGraveyard($currentUserId)
                            );

                            $msg = Yii::app()->user->name . ' suffled the <span class="deck-name">graveyard</span>.';
                            $this->putChatMessage($msg, $game->gameId, $currentUserId);
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    case 'addCounter':
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['card'])) {
                            if (($card = $this->scGame->getCard($currentUserId, $_REQUEST['card'])) !== null) {
                                $counter = $card->addCounter($_REQUEST['name'], $_REQUEST['start'], $_REQUEST['step'], $_REQUEST['color']);

                                if ($counter !== null) {
                                    $result = array(
                                        'success' => 1,
                                        'counter' => $counter->getJSONData(),
                                        'count' => $card->getCounterCount()
                                    );

                                    $msg = Yii::app()->user->name . ' adds the counter <span class="counter-name">'
                                            . $_REQUEST['name'] . '</span> to';
                                    if ($card->isFaceUp()) {
                                        $cardName = Card::model()->findByPk($card->getDbId())->name;
                                        $msg .= ' <span class="card-name">' . $cardName . '</span>.';
                                    } else {
                                        $msg .= ' a card.';
                                    }
                                    $this->putChatMessage($msg, $game->gameId, $currentUserId);
                                }
                            }
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    case 'increaseCounter':
                        //TODO: may be used for generic counters if card is made optional
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['counter'])) {
                            if (($card = $this->scGame->getCard($currentUserId, $_REQUEST['card'])) !== null) {
                                $value = $card->increaseCounterValue($_REQUEST['counter']);

                                $result = array(
                                    'success' => 1,
                                    'value' => $value
                                );

                                $msg = Yii::app()->user->name . ' increased <span class="counter-name">'
                                        . $_REQUEST['counter'] . '</span>';
                                if ($card->isFaceUp()) {
                                    $cardName = Card::model()->findByPk($card->getDbId())->name;
                                    $msg .= ' on <span class="card-name">' . $cardName . '</span>';
                                }

                                $msg .= ' to <strong>' . $value . '</strong>.';
                                $this->putChatMessage($msg, $game->gameId, $currentUserId);
                            }
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    case 'decreaseCounter':
                        //TODO: may be used for generic counters if card is made optional
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['counter'])) {
                            if (($card = $this->scGame->getCard($currentUserId, $_REQUEST['card'])) !== null) {
                                $value = $card->decreaseCounterValue($_REQUEST['counter']);

                                $result = array(
                                    'success' => 1,
                                    'value' => $value
                                );

                                $msg = Yii::app()->user->name . ' decreased <span class="counter-name">'
                                        . $_REQUEST['counter'] . '</span>';
                                if ($card->isFaceUp()) {
                                    $cardName = Card::model()->findByPk($card->getDbId())->name;
                                    $msg .= ' on <span class="card-name">' . $cardName . '</span>';
                                }

                                $msg .= ' to <strong>' . $value . '</strong>.';
                                $this->putChatMessage($msg, $game->gameId, $currentUserId);
                            }
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    /**
                     * Defaults to unrecognized action message and terminates the 
                     * execution.
                     */
                    default:
                        echo json_encode((object) array('result' => 'error', 'motive' => 'Unrecognized action'));
                        Yii::app()->db->createCommand("select release_lock('game.$id')");
                        yii::app()->end();
                }

                $game->state = serialize($this->scGame);
                $game->save();
                Yii::app()->db->createCommand("select release_lock('game.$id')");
                yii::app()->end();
            }

            //getting chat messages
            $messages = ChatMessage::model()->findAll('gameId = :id ORDER BY sent', array(
                ':id' => (int) $game->gameId
                    )
            );

            //getting game dice
            $dice = $game->dice;

            $this->updateUserActivity();
            $this->render('board', array(
                'gameId' => $id,
                'messages' => $messages,
                'paused' => $game->paused,
                'dice' => $dice,
                'user' => (object) array(
                    'id' => $currentUserId,
                    'name' => Yii::app()->user->name,
                    'isOne' => ($currentUserId === $game->player1)
                ),
                'player1' => $game->player1,
                'player2' => $game->player2
            ));
        } else {
            //unlock the game record before redirecting
            Yii::app()->db->createCommand("select release_lock('game.$id')");
            $this->redirect(array('spectate', 'id' => $id));
        }
        Yii::app()->db->createCommand("select release_lock('game.$id')");
    }

    public function actionSpectate($id) {
        //TODO: not implemented yet
        $this->layout = '//layouts/game';

        //lock record
        $id = intval($id);
//        $lock = Yii::app()->db->createCommand("SELECT GET_LOCK('game.$id', 10)")->queryScalar();
//        if ($lock != 1) {
//            throw new CHttpException(500, 'Failed to get game lock');
//        }
        $game = $this->loadGameById($id);
//        if (in_array(yii::app()->user->id, array($game->player1, $game->player2))) {
//        if ($game->state) {
//            $this->scGame = unserialize($game->state);
//        }
        //getting chat messages
        $start = ChatMessage::model()->count('gameId = :id ORDER BY sent', array(':id' => (int) $game->gameId));
        if ($start >= 15) {
            $start -= 15;
        } else {
            $start = 0;
        }

        $messages = ChatMessage::model()->findAll('gameId = :id ORDER BY sent LIMIT :start, 15', array(
            ':id' => (int) $game->gameId,
            ':start' => (int) $start
                ));

        $this->updateUserActivity();
        $this->render('watch', array(
            'gameId' => $id,
            'messages' => $messages,
            'paused' => $game->paused,
        ));
//        } else {
//        }
//        Yii::app()->db->createCommand("select release_lock('game.$id')");
    }

    public function actionLeave($id) {
        $this->updateUserActivity();
        //TODO: not implemented yet, close game, notify all clients, dispose states.
        $this->redirect('lobby/index');
    }

    /**
     * Loads a Game object from the database.
     * 
     * @param integer $id The ID for the game being loaded.
     * @return Game The game or null if the ID is invalid.
     * 
     * @since 1.0, Sudden Growth
     */
    private function loadGameById($id) {
        if (($game = Game::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The game you\'re requestion doesn\'t exist.');
        }

        return $game;
    }

    /**
     * Prepends new access rules to the default rules.
     * Only registered users can execute <em>GameController</em> actions.
     * @return array The new rules array
     * 
     * @since 1.0, Sudden Growth
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'play', 'sendMessage',
                            'chatUpdate', 'leave', 'spectate'),
                        'users' => array('@')
                    )
                        ), parent::accessRules());
    }

    /**
     * Applies a simple word filter to a chat message.
     * 
     * @param string $message The chat message to apply the filtering to.
     * @return string The message with words filtered, if any were found.
     * 
     * @since 1.1, Green Shield
     */
    private function chatWordFilter($message) {
        if (($setting = Setting::model()->findByPk('wordfilter')) !== null) {
            if (trim($setting->value) != '') {
                $words = explode(',', $setting->value);
                //remove any spaces, support for PHP < 5.3, it could be replaced 
                //by a simple lambda in the future
                array_walk($words, create_function('&$val', '$val = trim($val);'));

                return str_ireplace($words, '***', $message);
            }
        }

        return $message;
    }

    /**
     * This method will indent a JSON string with proper spaces and alignment in 
     * order to ease debug of JSON messages.
     * 
     * This should only be used in development mode, please use the 
     * <strong>YII_DEBUG</strong> macro to check if this method should be used.
     * 
     * @param string $json The JSON string to indent.
     * 
     * @return string Indented JSON string.
     */
    private function jsonIndent($json) {
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

    /**
     * Inserts a system message in the <em>ChatMessage</em> table.
     * 
     * @param string $text
     * @param int $game 
     */
    private function putChatMessage($text, $gameId, $userId) {
        $msg = new ChatMessage();
        $msg->gameId = $gameId;
        $msg->userId = $userId;
        $msg->system = 1;
        $msg->message = $text;

        $msg->save();
    }

}

