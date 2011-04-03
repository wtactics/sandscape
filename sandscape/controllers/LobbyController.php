<?php

class LobbyController extends Controller {

    private $chat;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->chat = Chat::model()->find('');
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionCreate() {
        
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

