<?php

/* DeckCard.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * 
 * Properties;
 * @property int $cardId The database ID for the corresponding card.
 * @property int $deckId The database ID for the deck.
 *
 * Relations:
 * @property Deck $deck The <em>Deck</em> object.
 * @property Card $card The <em>Card</em> object.
 * 
 * @see Deck
 * @see Card
 * 
 * @since 1.0, Sudden Growth
 */
class DeckCard extends CActiveRecord {

    /**
     * @return DeckCard
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'DeckCard';
    }

    public function relations() {
        return array(
            'deck' => array(self::BELONGS_TO, 'Deck', 'deckId'),
            'card' => array(self::BELONGS_TO, 'Card', 'cardId'),
        );
    }

    public function attributeLabels() {
        return array(
            'cardId' => 'Card ID',
            'deckId' => 'Deck ID',
        );
    }

}