<?php

class Deck extends CActiveRecord {

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }

     public function relations() {
      return array(
      'cards' => array(self::HAS_MANY, 'Card', 'deckId'),
      'messages' => array(self::HAS_MANY, 'Message', 'userId'),
      'gamesAsA' => array(self::HAS_MANY, 'Game', 'userIdPlayerA'),
      'gamesAsB' => array(self::HAS_MANY, 'Game', 'userIdPlayerB'),
      );
      }
}







