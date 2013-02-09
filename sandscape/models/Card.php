<?php

/* Card.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * This is the model class for <em>Card</em> table that stores all the existing cards 
 * in the database.
 * 
 * Card images are not placed in the database, only their file name is.
 *
 * Properties:
 * @property int $id
 * @property string $name
 * @property string $rules
 * @property string $face
 * @property string $back
 * @property string $backFrom
 * @property int $cardscapeId If this is a card imported from or that exists in
 * Cardscape, this is the ID used by Cardscape to identify the card.
 * 
 * @property int $active
 * 
 * Relations:
 * @property Deck[] $decks
 */
class Card extends CActiveRecord {

    /**
     * @return Card
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{Card}}';
    }

    public function rules() {
        return array(
            array('name, rules, face', 'required'),
            array('name, face, back', 'length', 'max' => 255),
            array('backFrom', 'in', 'range' => array('default', 'own', 'deck')),
            array('cardscapeId', 'numerical', 'integerOnly' => true),
            //search
            array('name, rules, cardscapeId', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'decks' => array(self::MANY_MANY, 'Deck', 'DeckCard(deckId, cardId)'),
        );
    }

    public function attributeLabels() {
        return array(
            'cardId' => Yii::t('card', 'ID'),
            'name' => Yii::t('card', 'Card Name'),
            'rules' => Yii::t('card', 'Card Rules'),
            'face' => Yii::t('card', 'Card Face'),
            'back' => Yii::t('card', 'Card Back'),
            'backFrom' => Yii::t('card', 'Use Back From'),
            'cardscapeId' => Yii::t('carde', 'Cardscape ID'),
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
        $criteria->compare('cardscapeId', $this->cardscapeId);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

}
