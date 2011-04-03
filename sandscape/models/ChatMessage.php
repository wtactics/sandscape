<?php

class ChatMessage extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'chat' => array(self::BELONGS_TO, 'Chat', 'chatId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

    public function __toString() {
        //TODO: 
        return $this->message;
    }

}