<?php

/* Card.php
 * 
 * This file is part of SandScape.
 *
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 * http://wtactics.org
 */

/**
 * This is the model class for <em>Card</em> table that stores all the existing cards 
 * in the database.
 * 
 * Card images are not placed in the database, only their file name is.
 *
 * The followings are the available columns in table 'Card':
 * @property integer $cardId The card ID in the database.
 * @property string $name The name of the card.
 * @property string $rules The rules text for this card.
 * @property string $image The image file for this card.
 * @property integer $cardscapeId If this is a card imported from or that exists in
 * Cardscape, this is the ID used in Cardscape to identify the card.
 * @property integer $active Active cards are available cards, inactive are deleted cards.
 * 
 * Relations:
 * @property DeckCard[] $deckCards
 * 
 * @since 1.0, Sudden Growth
 */
class Card extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Card';
    }

    public function rules() {
        return array(
            array('name, rules', 'required'),
            array('name', 'length', 'max' => 150),
            array('cardscapeId', 'numerical', 'integerOnly' => true),
            //search
            array('name, rules, cardscapeId', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'deckCards' => array(self::HAS_MANY, 'DeckCard', 'cardId'),
        );
    }

    public function attributeLabels() {
        return array(
            'cardId' => 'ID',
            'name' => 'Name',
            'rules' => 'Rules',
            'image' => 'Image',
            'cardscapeId' => 'Cardscape ID',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * A filter is just an <em>Card</em> instance whose attribute values are used 
     * to limit the search criteria.
     * 
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('rules', $this->rules, true);
        $criteria->compare('cardscapeId', $this->cardscapeId, true);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('Card', array('criteria' => $criteria));
    }

}