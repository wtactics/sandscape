<?php

class Game extends CActiveRecord {

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }

    public function relations() {
        return array(
            'deckFromA' => array(self::BELONGS_TO, 'Deck', 'deckIdPlayerA'),
            'deckFromB' => array(self::BELONGS_TO, 'Deck', 'deckIdPlayerB'),
            'playerA' => array(self::BELONGS_TO, 'User', 'userIdPlayerA'),
            'playerB' => array(self::BELONGS_TO, 'User', 'userIdPlayerB'),
            'messages' => array(self::HAS_MANY, 'Message', 'gameId')
        );
    }

}