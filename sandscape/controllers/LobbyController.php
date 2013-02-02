<?php

/* LobbyController.php
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
 * Manages the lobby section allowing users to plan, create and join games.
 * 
 * This controller was created by extracting all lobby related actions from the 
 * <em>GameController</em> class.
 */
class LobbyController extends ApplicationController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * The lobby offers a way to create games, join existing games and exchange
     * messages between other users.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionIndex() {
        $this->updateUserActivity();

        $cardCount = intval(Card::model()->count('active = 1'));
        $games = Game::model()->findAll('ended IS NULL ORDER BY created');
        $users = User::model()->findAllAuthenticated()->getData();
        $messages = ChatMessage::model()->findAll('gameId IS NULL AND DATE_SUB(sent, INTERVAL 1 HOUR); ORDER BY sent');

        $decks = Deck::model()->findAll('userId = :id', array(':id' => (int) (Yii::app()->user->id)));

        $fixDeckNr = 0;
        $decksPerGame = 1;
        if (($fixDeckNr = Setting::model()->findByPk('fixdecknr')) !== null) {
            $fixDeckNr = (int) $fixDeckNr->value;
            if (($decksPerGame = Setting::model()->findByPk('deckspergame')) !== null) {
                $decksPerGame = (int) $decksPerGame->value;
            }
        }

        $this->render('lobby', array(
            'games' => $games,
            'users' => $users,
            'messages' => $messages,
            'decks' => $decks,
            'decksPerGame' => $decksPerGame,
            'fixDeckNr' => $fixDeckNr,
            'cardCount' => $cardCount
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
     * @since 1.2, Elvish Shaman
     */
    public function actionSendMessage() {
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
                        'date' => $cm->sent
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
     * @since 1.2, Elvish Shaman
     */
    public function actionLobbyUpdate() {
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
                        'date' => $cm->sent
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
     * @since 1.2, Elvish Shaman
     */
    public function actionCreate() {
        if (isset($_POST['CreateGame']) && isset($_POST['deckList'])) {

            $fixDeckNr = 0;
            $decksPerGame = 1;
            if (($fixDeckNr = Setting::model()->findByPk('fixdecknr')) !== null) {
                $fixDeckNr = (int) $fixDeckNr->value;
                if (($decksPerGame = Setting::model()->findByPk('deckspergame')) !== null) {
                    $decksPerGame = (int) $decksPerGame->value;
                }
            }

            if ($fixDeckNr && isset($_POST['maxDecks']) && ($decksPerGame != (int) $_POST['maxDecks'])) {
                //TODO: show correct error message
                $this->redirect(array('index'));
            } else {
                $game = new Game();
                $game->player1 = Yii::app()->user->id;
                $game->created = date('Y-m-d H:i');
                $game->maxDecks = isset($_POST['maxDecks']) ? (int) $_POST['maxDecks'] : $decksPerGame;
                $game->graveyard = isset($_POST['useGraveyard']) ? (int) $_POST['useGraveyard'] : 1;
                $game->player1Ready = 1;
                $game->spectatorsSpeak = intval($_POST['gameChatSpectators']);

                if (isset($_POST['limitOpponent']) && !empty($_POST['limitOpponent']) && intval($_POST['limitOpponent']) != 0) {
                    $game->acceptUser = intval($_POST['limitOpponent']);
                }

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
                        foreach (Dice::model()->findAll('enabled = 1') as $dice) {
                            $gd = new GameDice();
                            $gd->diceId = $dice->diceId;
                            $gd->gameId = $game->gameId;
                            if (!$gd->save()) {
                                $error = true;
                                break;
                            }
                        }
                    }

                    if (!$error) {
                        foreach (PlayerCounter::model()->findAll('available = 1') as $pc) {
                            $gpc = new GamePlayerCounter();
                            $gpc->playerCounterId = $pc->playerCounterId;
                            $gpc->gameId = $game->gameId;
                            if (!$gpc->save()) {
                                $error = true;
                                break;
                            }
                        }
                    }

                    if (!$error) {
                        $this->redirect(array('game/play', 'id' => $game->gameId));
                    }
                }
            }
        }
        $this->updateUserActivity();
        //TODO: show correct error message
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
     * @since 1.2, Elvish Shaman
     */
    public function actionJoin() {
        if (isset($_POST['JoinGame']) && isset($_POST['deckList']) && isset($_POST['game'])) {

            if (($game = Game::model()->findByPk((int) $_POST['game'])) === null) {
                throw new CHttpException(404, 'You\'re trying to join an invalid game.');
            }

            if ($game->player1 != Yii::app()->user->id) {

                $fixDeckNr = 0;
                $decksPerGame = 1;
                if (($fixDeckNr = Setting::model()->findByPk('fixdecknr')) !== null) {
                    $fixDeckNr = (int) $fixDeckNr->value;
                    if (($decksPerGame = Setting::model()->findByPk('deckspergame')) !== null) {
                        $decksPerGame = (int) $decksPerGame->value;
                    }
                }

                $deckCount = count($_POST['deckList']);
                if ($fixDeckNr && $decksPerGame != $deckCount) {
                    //TODO: show correct error message
                    $this->redirect(array('index'));
                } else {
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
                            $this->redirect(array('game/play', 'id' => $game->gameId));
                        }
                    }
                }
            }
        }
        $this->updateUserActivity();
        //TODO: show correct error message
        $this->redirect(array('lobby'));
    }

    public function actionAjaxUserComplete() {
        $users = array();
        if (isset($_REQUEST['term'])) {
            foreach (User::model()->findAll('name = :n', array(':n' => $_REQUEST['term'])) as $user) {
                $users[] = $user->name;
            }
        }

        echo json_encode($users);
        Yii::app()->end();
    }

    /**
     * Prepends new access rules to the default rules.
     * Only registered users can execute <em>GameController</em> actions.
     * @return array The new rules array
     * 
     * @since 1.2, Elvish Shaman
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'create', 'join', 'lobbyUpdate',
                            'sendMessage', 'ajaxusercomplete'
                        ),
                        'users' => array('@')
                    ),
            array(
                'deny',
                'users' => array('*')
            )
                        ), parent::accessRules());
    }

    /**
     * Applies a simple word filter to a chat message.
     * 
     * @param string $message The chat message to apply the filtering to.
     * @return string The message with words filtered, if any were found.
     * 
     * @since 1.2, Elvish Shaman
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