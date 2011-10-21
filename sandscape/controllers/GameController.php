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

      $decks = Deck::model()->findAll('userId = :id', array(':id' => Yii::app()->user->id));

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
      //TODO: accept only AJAX by post
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
      //TODO: accept only AJAX by post
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
             'success' => 1,
             'id' => $cm->messageId,
             'name' => Yii::app()->user->name,
             //TODO: there is a bug while formating date, maybe date is not set yet
             'date' => Yii::app()->dateFormatter->formatDateTime(strtotime($cm->sent), 'short')
         );
      }

      echo json_encode($result);
   }

   public function actionSendGameMessage($id) {
      //TODO: accept only AJAX by post
      //TODO: validate user sending message, only players can send in-game messages
      $result = array('success' => 0);
      if (isset($_POST['gamemessage'])) {
         $cm = new ChatMessage();

         $cm->message = $_POST['gamemessage'];
         $cm->userId = Yii::app()->user->id;
         $cm->gameId = $id;

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

   public function actionCreate() {
      if (isset($_POST['CreateGame']) && isset($_POST['deckList'])) {

         $game = new Game();
         $game->player1 = Yii::app()->user->id;
         $game->created = date('Y-m-d H:i');
         $game->private = isset($_POST['private']) ? (int) $_POST['private'] : 0;
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
      }

      $this->redirect(array('lobby'));
   }

   //TODO: running, when?
   public function actionJoin($id) {
      //TODO: second user can't be the first
      //deck list can't be bigger than maxDecks
      if (isset($_POST['JoinGame']) && isset($_POST['deckList'])) {
         $game = $this->loadGameById($id);

         $game->player2 = Yii::app()->user->id;
         $game->player2Ready = 1;
         if ($game->save()) {


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
      }

      $this->redirect(array('lobby'));
   }

   //u1: 2 - afonso
   //u2: 3 - alvaro
   public function actionPlay($id) {
      //TODO: not implemented yet
      $this->layout = '//layouts/game';
      //Game::model()->find('running = 0')
      $game = $this->loadGameById($id);
      if (in_array(yii::app()->user->id, array($game->player1, $game->player2))) {
         if ($game->state)
            $this->scGame = unserialize($game->state);

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

                     // create the game status
                     $this->scGame = new SCGame($game->graveyard, $game->player1, $game->player2);

                     // decks in the game
                     foreach ($game->decks as $deck) {
                        $cards = array();
                        foreach ($deck->deckCards as $card) {
                           $cards[] = new SCCard($this->scGame, $deck->userId, $card->card->cardId, $card->card->image);
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
                     echo SCGame::JSONIndent(json_encode($result));
//                  die('died in '.get_class($this).' at ' . time() . '  ' . var_export($_REQUEST, true));
                  }
                  break;
               case 'moveCard':
                  if ($game->running && $this->scGame && isset($_REQUEST['card']) && isset($_REQUEST['location'])) {
                     $card = $_REQUEST['card'];
                     $location = $_REQUEST['location'];
                     $result = $this->scGame->moveCard(Yii::app()->user->id, $card, $location);
                     $result->result = 'ok';
                     echo SCGame::JSONIndent(json_encode($result));
                  }
                  break;
               default:
                  echo SCGame::JSONIndent(json_encode((object) array('result' => 'error', 'motive' => 'Unrecognized action')));
                  yii::app()->end();
            }

            $game->state = serialize($this->scGame);
            $game->save();
            yii::app()->end();
         }
         $this->render('board', array('gameId' => $id));
      } else {
         // TODO: the user accessing the game is not a player of the game. Show some error or something.
      }
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
