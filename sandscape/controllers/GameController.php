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
        $this->redirect(array('lobby'));
    }

    /**
     * Default action is to send users to the game lobby.
     * 
     * The game lobby offers a way to create games, join existing games and exchange
     * messages between other users.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionLobby() {
        $this->updateUserActivity();

        $games = Game::model()->findAll('ended IS NULL AND private = 0');
        $users = User::model()->findAllAuthenticated()->getData();

        $start = ChatMessage::model()->count('gameId IS NULL ORDER BY sent');
        if ($start >= 15) {
            $start -= 15;
        } else {
            $start = 0;
        }
        $messages = ChatMessage::model()->findAll('gameId IS NULL ORDER BY sent LIMIT :start, 15', array(':start' => (int) $start));

        $decks = Deck::model()->findAll('userId = :id', array(':id' => (int) (Yii::app()->user->id)));

        $this->render('lobby', array(
            'games' => $games,
            'users' => $users,
            'messages' => $messages,
            'decks' => $decks
        ));
    }

    /**
     * Registers a new message in the lobby chat.
     * 
     * A new message is sent by the chat client as a POST parameter and the 
     * correct database object is created and stored. Simple word filtering is 
     * applied to the message before being stored, due to the way chats work
     * the user that sent the message will still see the unfiltered message.
     * 
     * If successful, a JSON object is sent back with the message information 
     * that the client didn't had, like the author's name or the new message's ID.
     * 
     * The JSON object format is:
     * 
     * success: integer, 0 or 1 telling the client if the action was successful
     * id: integer, the new ID for the registered message
     * name: string, the name of the user sending the message
     * date: string, the date in which the message was sent, as created by the 
     *  database and formatted using Yii's settings
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionSendLobbyMessage() {
        $result = array('success' => 0);
        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST['chatmessage'])) {
                $cm = new ChatMessage();

                $cm->message = $this->chatWordFilter($_POST['chatmessage']);
                $cm->userId = Yii::app()->user->id;

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
     * Allows for clients to request updates on existing lobby chat messages.
     * 
     * The messages are encoded as a JSON object that is sent to the client. For 
     * a proper request the client must send the ID of the last message he has 
     * received, only messages with IDs above the given one will be provided.
     * 
     * The JSON object is as following:
     * 
     * has: integer, the number of messages sent in the response
     * messages: array, the messages sent
     *      name: string, the name of the message author
     *      message: string, the message text
     *      date: string, the date in which the message was sent, formatted using Yii's settings 
     * 
     * last: integer, the ID for the last message being sent
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionLobbyChatUpdate() {
        $result = array('has' => 0);
        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST['lastupdate'])) {
                $lastUpdate = (int) $_POST['lastupdate'];
                $messages = array();

                $cms = ChatMessage::model()->findAll('messageId > :last AND gameId IS NULL', array(':last' => $lastUpdate));
                foreach ($cms as $cm) {
                    $messages[] = array(
                        'name' => $cm->user->name,
                        'message' => $cm->message,
                        'date' => Yii::app()->dateFormatter->formatDateTime(strtotime($cm->sent), 'short')
                    );
                }
            }
        }
        echo json_encode($result);
    }

    /**
     * Allows for clients to request updates on existing lobby chat messages.
     * 
     * The messages are encoded as a JSON object that is sent to the client. For 
     * a proper request the client must send the ID of the last message he has 
     * received, only messages with IDs above the given one will be provided.
     * 
     * The JSON object is as following:
     * 
     * has: integer, the number of messages sent in the response
     * messages: array, the messages sent
     *      name: string, the name of the message author
     *      message: string, the message text
     *      date: string, the date in which the message was sent, formatted using Yii's settings 
     * 
     * last: integer, the ID for the last message being sent
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionLobbyChatUpdate() {
        $result = array('has' => 0);
        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST['lastupdate'])) {
                $lastUpdate = (int) $_POST['lastupdate'];
                $messages = array();

                $cms = ChatMessage::model()->findAll('messageId > :last AND gameId IS NULL', array(':last' => $lastUpdate));
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
     * Sends messages to the game chat. Only the two players can send messages, 
     * any spectator will be able to see the messages but not write in the chat.
     *  
     * Simple word filtering is applied to the message before being stored, due 
     * to the way chats work the user that sent the message will still see the 
     * unfiltered message.
     *  
     * @param integer $id The game ID.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionSendGameMessage($id) {
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
    public function actionGameChatUpdate($id) {
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
     * Creates a new game and redirects the first player to the game area.
     * 
     * The game is created with the configuration submitted by the user (number 
     * of decks, if the game uses graveyard), the user is added to the game and 
     * marked as ready.
     * 
     * If the game was successfully created, the user is redirected to game/play
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionCreate() {
        if (isset($_POST['CreateGame']) && isset($_POST['deckList'])) {

            $game = new Game();
            $game->player1 = Yii::app()->user->id;
            $game->created = date('Y-m-d H:i');
            $game->maxDecks = isset($_POST['maxDecks']) ? (int) $_POST['maxDecks'] : 1;
            $game->graveyard = isset($_POST['useGraveyard']) ? (int) $_POST['useGraveyard'] : 1;
            $game->player1Ready = 1;

            if ($game->save()) {
                $error = false;

                foreach ($_POST['deckList'] as $deckId) {
                    $gameDeck = new GameDeck();
                    $gameDeck->gameId = $game->gameId;
                    $gameDeck->deckId = $deckId;
                    if (!$gameDeck->save()) {
                        $error = true;
                        break;
                    }
                }

                if (!$error) {
                    $this->redirect(array('play', 'id' => $game->gameId));
                }
            }
            $this->updateUserActivity();
        }

        $this->redirect(array('lobby'));
    }

    /**
     * Allows a user to join a previously created game. The game ID will be given 
     * as a POST parameter and the uer ID will be taken from the user making the 
     * request.
     * 
     * If the user is allowed to join the game, then it is set as player 2 and 
     * made ready. After that the user will be redirected to the play area.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionJoin() {
        if (isset($_POST['JoinGame']) && isset($_POST['deckList']) && isset($_POST['game'])) {
            $game = $this->loadGameById($_POST['game']);

            if ($game->player1 != Yii::app()->user->id) {
                $game->player2 = Yii::app()->user->id;
                $game->player2Ready = 1;
                if ($game->save()) {
                    $error = false;
                    foreach ($_POST['deckList'] as $deckId) {
                        $gameDeck = new GameDeck();
                        $gameDeck->gameId = $game->gameId;
                        $gameDeck->deckId = (int) $deckId;
                        if (!$gameDeck->save()) {
                            $error = true;
                            break;
                        }
                    }

                    if (!$error) {
                        $this->redirect(array('play', 'id' => $game->gameId));
                    }
                }
            }
            $this->updateUserActivity();
        }

        $this->redirect(array('lobby'));
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
                            echo SCGame::JSONIndent(json_encode((object) array('result' => 'wait')));
                        } elseif ($game->running) {
                            echo SCGame::JSONIndent(json_encode((object) array('result' => 'ok')));
                        } elseif ($game->player1Ready && $game->player2Ready && !$game->running && yii::app()->user->id == $game->player1) {
                            $game->running = 1;
                            $game->started = date('Y-m-d H:i:s');

                            // tokens
                            $tokens = array(
//                         new SCToken('debugToken', 'debugToken.gif'),
                                new SCToken('debugToken', 'debugToken2.png')
                            );

                            // card states
                            $states = array(
                                new SCState('debugState1', 'debugState1.png'),
                                new SCState('debugState2', 'debugState2.png'),
                            );

                            // create the game status
                            $this->scGame = new SCGame($game->graveyard, $game->player1, $game->player2, $tokens, $states);

                            // decks in the game
                            foreach ($game->decks as $deck) {
                                $cards = array();
                                foreach ($deck->deckCards as $card) {
                                    $cards[] = $c = new SCCard($this->scGame, $deck->userId, $card->card->cardId, $card->card->image);

                                    // Debug
                                    if (rand(0, 10) > 5)
                                        $c->addToken($tokens[0]);
//                           if (rand(0, 10) > 5)
//                              $c->addToken($tokens[1]);

                                    $x = rand(0, 10);
                                    if ($x > 8)
                                        $c->addState($states[1]);
                                    elseif ($x < 2)
                                        $c->addState($states[0]);
                                }
                                $scdeck = new SCDeck($this->scGame, $deck->name, $cards);

                                if ($deck->userId == $game->player1)
                                    $this->scGame->addPlayer1Deck($scdeck);
                                elseif ($deck->userId == $game->player2)
                                    $this->scGame->addPlayer2Deck($scdeck);
                            }
                            $game->lastChange = time();
                            echo SCGame::JSONIndent(json_encode((object) array('result' => 'ok')));
                        }
                        else {
                            echo SCGame::JSONIndent(json_encode((object) array('result' => 'wait')));
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
                            echo SCGame::JSONIndent(json_encode($result));
                        }
                        else
                            echo SCGame::JSONIndent(json_encode((object) array('result' => 'wait', 'motive' => 'Game not started')));
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
                                echo SCGame::JSONIndent(json_encode($result));
                            } else {
                                echo SCGame::JSONIndent(json_encode((object) array('result' => 'wait', 'motive' => 'Game not changed since last updade')));
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
                            echo SCGame::JSONIndent(json_encode($result));
                        }
                        break;
                    case 'moveCard':
                        if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['location'])) {
                            $card = $_REQUEST['card'];
                            $location = $_REQUEST['location'];
                            $result = $this->scGame->moveCard(Yii::app()->user->id, $card, $location);
                            $result->result = 'ok';
                            $result->clientTime = $_REQUEST['clientTime'];
                            echo SCGame::JSONIndent(json_encode($result));
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
                        echo json_encode($result);
                        break;
                    case 'gamePause':
                        //TODO: not implemented yet
                        break;
                    case 'roll':
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
                            }
                        }
                        echo json_encode($result);
                        break;
                    default:
                        echo SCGame::JSONIndent(json_encode((object) array('result' => 'error', 'motive' => 'Unrecognized action')));
                        Yii::app()->db->createCommand("select release_lock('game.$id')");
                        yii::app()->end();
                }

                $game->state = serialize($this->scGame);
                $game->save();
                Yii::app()->db->createCommand("select release_lock('game.$id')");
                yii::app()->end();
            }

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
            $this->render('board', array(
                'gameId' => $id,
                'messages' => $messages,
                'paused' => $game->paused
            ));
        } else {
            // TODO: the user accessing the game is not a player of the game. Show some error or something.
        }
        Yii::app()->db->createCommand("select release_lock('game.$id')");
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
                        'actions' => array('index', 'create', 'join', 'lobby',
                            'lobbyChatUpdate', 'play', 'sendGameMessage', 'sendLobbyMessage',
                            'gameChatUpdate', 'leave'),
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

}
