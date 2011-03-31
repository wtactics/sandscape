<?php

class User extends CActiveRecord {

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }

    public function relations() {
        return array(
            'decks' => array(self::HAS_MANY, 'Deck', 'userId'),
            'messages' => array(self::HAS_MANY, 'ChatMessage', 'userId'),
            'gamesAsA' => array(self::HAS_MANY, 'Game', 'playerA'),
            'gamesAsB' => array(self::HAS_MANY, 'Game', 'playerB'),
        );
    }

}