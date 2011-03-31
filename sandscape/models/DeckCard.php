<?php

class DeckCard extends CActiveRecord {

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }

    /* public function relations() {
      return array(
      'decks' => array(self::HAS_MANY, 'Deck', 'userId'),
      'messages' => array(self::HAS_MANY, 'Message', 'userId'),
      'gamesAsA' => array(self::HAS_MANY, 'Game', 'userIdPlayerA'),
      'gamesAsB' => array(self::HAS_MANY, 'Game', 'userIdPlayerB'),
      );
      } */
}