<?php

class Card extends CActiveRecord {

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }

    public function relations() {
        return array(
            'decks' => array(self::MANY_MANY, 'Deck', 'DeckCard(deckId, cardId)')
        );
    }

}