<?php

class LobbyController extends Controller {

    private $chat;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->chat = Chat::model()->find('lobby = 1');

        if (!$this->chat) {
            $this->chat = new Chat();
            $this->chat->lobby = 1;
            $this->chat->save();
        }
    }

    public function actionIndex() {

        $criteria = new CDbCriteria();

        $criteria->select = 'playerA, created, started, hash';
        $criteria->condition = 'private = 0 AND ended IS NULL';

        $viewData = array(
            'chat' => $this->chat,
            'games' => Game::model()->findAll($criteria),
            //TODO: change this....
            'decks' => Deck::model()->findAll('userId = :id', array(':id' => 2))
        );

        $this->render('index', $viewData);
    }

    public function actionCreate() {

        if (isset($_POST['ajax']) && $_POST['ajax'] == 'newgame-form') {
            $now = date('Y-m-d H:i:s');

            $game = new Game();

            $chat = new Chat();
            $chat->lobby = 0;
            $chat->started = $now;
            $chat->save();

            $game->chat = $chat;

            //TODO: change this....
            $deckId = (int) $_POST['deck'];
            $game->playerA = 2;
            $game->deckA = $deckId;

            $game->created = $now;

            if (isset($_POST['private']) && (int) $_POST['private'])
                $game->private = 1;

            $game->hash = crc32(($now . 2 . $deckId . $game->private));

            //TODO: validation and messages...
            $game->save();
            //TODO: SAVE THE GAME....
        }
    }

    public function actionSearch() {
        
    }

    public function actionJoin() {
        
    }

    public function actionSend() {
        if ($this->chat) {
            $message = new ChatMessage();
            $message->message = '';
            $message->sent = date('Y-m-d H:m:s');
            $message->user = null;
            $message->chat = null;
            $message->save();
        }
    }

}

