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
     */
    public function actionIndex() {
        $this->redirect(array('lobby'));
    }

    public function actionLobby() {
        $this->updateUserActivity();

        //TODO: not implemented yet
        $games = Game::model()->findAll('ended IS NULL AND private = 0');
        $users = User::model()->findAllAuthenticated()->getData();
        $messages = ChatMessage::model()->findAll('gameId IS NULL ORDER BY sent');

        $this->render('lobby', array('games' => $games, 'users' => $users, 'messages' => $messages));
    }

    /**
     * Registers a new message in the lobby chat.
     * 
     * A new message is sent by the chat client as a POST parameter and the 
     * correct database object is created and stored.
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
     */
    public function actionSendLobbyMessage() {
        $result = array('success' => 0);
        if (isset($_POST['chatmessage'])) {
            $cm = new ChatMessage();

            $cm->message = $_POST['chatmessage'];
            $cm->userId = Yii::app()->user->id;

            if ($cm->save()) {
                $result = array(
                    'success' => 1,
                    'id' => $cm->messageId,
                    'name' => Yii::app()->user->name,
                    //TODO: there is a bug while formating date, maybe date is not set yet
                    'date' => Yii::app()->dateFormatter->formatDateTime(strtotime($cm->sent), 'short')
                );
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
     */
    public function actionLobbyChatUpdate() {
        $result = array('has' => 0);
        if (isset($_POST['lastupdate'])) {
            $lastUpdate = intval($_POST['lastupdate']);
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
        }

        echo json_encode($result);
    }

    public function actionCreate() {
        //TODO: not implemented yet
        //$game = new Game();        
        $this->render('create');
    }

    public function actionJoin() {
        //TODO: not implemented yet
    }

    //u1: 2 - afonso
    //u2: 3 - alvaro
    public function actionPlay($id) {
        //TODO: not implemented yet
        $this->layout = '//layouts/game';
        //Game::model()->find('running = 0')
        $game = $this->loadGameById($id);
        if (isset($_POST['event'])) {

            switch ($_POST['event']) {
                case 'startup':
                    if ($game->state != '') {
                        $this->scGame = unserialize($game->state);
                    }
                    break;
                default:
            }
        }

        $this->render('board', array('gameId' => $id));
    }

    /**
     * Loads a Game object from the database.
     * 
     * @param integer $id The ID for the game being loaded.
     * @return Game The game or null if the ID is invalid.
     */
    private function loadGameById($id) {
        if (($game = Game::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $game;
    }

}
