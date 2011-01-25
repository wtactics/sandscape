<?php

class Deck extends CActiveRecord {

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }

    public function relations() {
        return array(
            'cards' => array(self::MANY_MANY, 'Card', 'DeckCard(deckId, cardId)'),
            'owner' => array(self::BELONGS_TO, 'User', 'userId'),
            'gamesAsA' => array(self::HAS_MANY, 'Game', 'deckIdPlayerA'),
            'gamesAsB' => array(self::HAS_MANY, 'Game', 'deckIdPlayerB')
        );
    }

}