<?php

class GameController extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);

        $this->layout = '//layouts/game';
    }

    public function actionIndex() {
       $this->render('board');
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
