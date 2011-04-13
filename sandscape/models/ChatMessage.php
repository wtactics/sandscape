<?php

class ChatMessage extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array(
            'chat' => array(self::BELONGS_TO, 'Chat', 'chatId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

}