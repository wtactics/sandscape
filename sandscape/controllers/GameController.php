<?php

/* GameController.php
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
                    && isset($_POST['gamemessage'])) {

                $cm = new ChatMessage();

                $cm->message = $this->chatWordFilter($_POST['gamemessage']);
                $cm->userId = Yii::app()->user->id;
                $cm->gameId = $id;

                if ($cm->save()) {
                    $cm->refresh();
                    $result = array(
                        'success' => 1,
                        'id' => $cm->messageId,
                        'name' => Yii::app()->user->name,
                        'date' => Yii::app()->dateFormatter->formatDateTime(strtotime($cm->sent), 'short')
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
            if (($game->player1 == Yii::app()->user->id || $game->player2 == Yii::app()->user->id)
                    && isset($_POST['lastupdate'])) {

                $lastUpdate = (int) $_POST['lastupdate'];
                $messages = array();

                $cms = ChatMessage::model()->findAll('messageId > :last AND gameId = :id', array(
                    ':last' => $lastUpdate,
                    ':id' => (int) $id
                        ));

                foreach ($cms as $cm) {
                    $messages[] = array(
                        'name' => $cm->user->name,
                        'message' => $cm->message,
                        'date' => Yii::app()->dateFormatter->formatDateTime(strtotime($cm->sent), 'short')
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
     * 
     * [since Green Shield]
     * cardInfo:
     *      Gets the requested card's information. This event should provide the 
     *      card image, name, rules and any associated token/state that affects 
     *      the card in-game.
     * 
     * [since Elvish Shaman]
     * gamePause:
     *      Pauses a game allowing users to leave and resume game play at a later time.
     * roll:
     *      Generates a dice roll for the specified dice ID. If the dice is set 
     *      available for this game and is a valid dice (active), than a random
     *      will be generated between 1 and $dice->face.
     * 
     * @param integer $id The game ID.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionPlay($id) {
        $this->layout = '//layouts/game';

        //lock record
        $id = intval($id);
        $lock = Yii::app()->db->createCommand("SELECT GET_LOCK('game.$id', 10)")->queryScalar();
        if ($lock != 1) {
            throw new CHttpException(500, 'Failed to get game lock');
        }

        $game = $this->loadGameById($id);
        if (in_array(yii::app()->user->id, array($game->player1, $game->player2))) {
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
                        } elseif ($game->player1Ready && $game->player2Ready && !$game->running && yii::app()->user->id == $game->player1) {
                            $game->running = 1;
                            $game->started = date('Y-m-d H:i:s');

                            // tokens
                            $tokens = array(
                                new SCToken('jumper', 'debugToken.gif'),
                                new SCToken('badge', 'debugToken2.png')
                            );

                            // card states
                            $states = array(
                                new SCState('yellow', 'debugState1.png'),
                                new SCState('shadow', 'debugState2.png'),
                            );

                            // create the game status
                            $this->scGame = new SCGame($game->graveyard, $game->player1, $game->player2, $tokens, $states);

                            // decks in the game
                            foreach ($game->decks as $deck) {
                                $cards = array();
                                foreach ($deck->deckCards as $card) {
                                    $cards[] = $c = new SCCard($this->scGame, $deck->userId, $card->card->cardId, $card->card->image);
                                }
                                $scdeck = new SCDeck($this->scGame, $deck->name, $cards);

                                if ($deck->userId == $game->player1)
                                    $this->scGame->addPlayer1Deck($scdeck);
                                elseif ($deck->userId == $game->player2)
                                    $this->scGame->addPlayer2Deck($scdeck);
                            }
                            $game->lastChange = time();
                            echo json_encode((object) array('result' => 'ok'));
                        }
                        else {
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
                            $result = $this->scGame->clientInitialization(yii::app()->user->id);
                            $result->result = 'ok';
                            $result->lastChange = $game->lastChange;
                            echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        }
                        else
                            echo json_encode((object) array('result' => 'wait', 'motive' => 'Game not started'));
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
                                $result = $this->scGame->clientUpdate(Yii::app()->user->id);
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
                     * DRAWCARD: draws a card from a deck
                     * 
                     * Params:
                     *    deck - id from deck element
                     * 
                     * out.result:
                     *    'ok'
                     */
                    case 'drawCard':
                        if ($game->running && $this->scGame && isset($_REQUEST['deck'])) {
                            $deck = $_REQUEST['deck'];
                            $result = $this->scGame->drawCard(Yii::app()->user->id, $deck);
                            $result->result = 'ok';
                            $result->clientTime = $_REQUEST['clientTime'];
                            echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        }
                        break;
                    case 'moveCard':
                        if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['location'])) {
                            $card = $_REQUEST['card'];
                            $location = $_REQUEST['location'];
                            $xOffset = isset($_REQUEST['xOffset']) ? floatval($_REQUEST['xOffset']) : 0;
                            $yOffset = isset($_REQUEST['yOffset']) ? floatval($_REQUEST['yOffset']) : 0;
                            $result = $this->scGame->moveCard(Yii::app()->user->id, $card, $location, $xOffset, $yOffset);
                            $result->result = 'ok';
                            $result->clientTime = $_REQUEST['clientTime'];
                            echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        }
                        break;
                    case 'toggleCardToken':
                        if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['token'])) {
                            $card = $_REQUEST['card'];
                            $token = $_REQUEST['token'];
                            $result = $this->scGame->toggleCardToken(Yii::app()->user->id, $card, $token);
                            $result->result = 'ok';
                            $result->clientTime = $_REQUEST['clientTime'];
                            echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        }
                        break;
                    case 'toggleCardState':
                        if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['state'])) {
                            $card = $_REQUEST['card'];
                            $state = $_REQUEST['state'];
                            $result = $this->scGame->toggleCardState(Yii::app()->user->id, $card, $state);
                            $result->result = 'ok';
                            $result->clientTime = $_REQUEST['clientTime'];
                            echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        }
                        break;
                    case 'cardInfo':
                        $result = array('success' => 0);
                        if ($game->running && $this->scGame && isset($_REQUEST['card'])) {
                            if (($cardId = $this->scGame->getCardDBId($_REQUEST['card'])) != 0) {
                                $card = Card::model()->findByPk((int) $cardId);
                                $result = array(
                                    'success' => 1,
                                    'name' => $card->name,
                                    'rules' => $card->rules,
                                    'image' => $card->image,
                                    //TODO: add states when they become available
                                    'states' => ''
                                );
                            }
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
                    case 'gamePause':
                        //TODO: not implemented yet
                        break;
                    case 'roll':
                        //TODO: proper error message
                        $result = array('success' => 0);
                        if (isset($_POST['dice']) && (int) $_POST['dice']) {
                            $dice = null;
                            if (GameDice::model()->find('gameId = :id AND diceId = :dice', array(
                                        ':id' => $game->gameId,
                                        ':face' => (int) $_POST['dice']
                                    )) !== null) {

                                $dice = Dice::model()->find('active = 1 AND diceId = :id', array(':id' => (int) $_POST['dice']));
                            }

                            if ($dice !== null) {
                                $result['success'] = 1;
                                $result['roll'] = rand(1, $dice->face);
                                $result['dice'] = $dice->name;
                                $result['face'] = $dice->face;
                                $result['user'] = Yii::app()->user->name;
                            }
                        }
                        echo (YII_DEBUG ? $this->jsonIndent(json_encode($result)) : json_encode($result));
                        break;
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

            //getting game dice
            $dice = $game->dice;

            $this->updateUserActivity();
            $this->render('board', array(
                'gameId' => $id,
                'messages' => $messages,
                'paused' => $game->paused,
                'dice' => $dice
            ));
        } else {
            // TODO: the user accessing the game is not a player of the game. Show some error or something.
        }
        Yii::app()->db->createCommand("select release_lock('game.$id')");
    }

    //TODO: not implemented yet
    public function actionSpectate($id) {
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
        $this->redirect(array('lobby'));
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
            throw new CHttpException(404, 'The requested page does not exist.');
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
                        'actions' => array('index', 'play', 'sendMessage', 'chatUpdate', 'leave', 'spectate'),
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

}
