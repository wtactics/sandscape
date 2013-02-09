<?php

/* Deck.php
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
 * This is the model class for 'Deck' table that stores deck information. A 
 * <em>Deck</em> is just a name that is used to group cards.
 *
 * Properties:
 * @property int $id
 * @property string $name
 * @property string $createdOn
 * @property string $back
 * @property int $ownerId
 * @property int $active
 *
 * Relations:
 * @property User $user
 * @property Card[] $cards
 * 
 * @property Game[] $games
 * @property DeckStats $stats
 */
class Deck extends CActiveRecord {

    /**
     * @return Deck
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{Deck}}';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name, back', 'length', 'max' => 255),
            array('ownerId', 'numerical', 'integerOnly' => true),
            array('active', 'boolean'),
            //search
            array('name, createdOn', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'ownerId'),
            'cards' => array(self::MANY_MANY, 'Card', 'DeckCard(deckId, cardId)'),
            'games' => array(self::MANY_MANY, 'Game', 'GameDeck(deckId, gameId)'),
            'stats' => array(self::HAS_MANY, 'DeckStats', 'deckId')
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('deck', 'ID'),
            'name' => Yii::t('deck', 'Name'),
            'createdOn' => Yii::t('deck', 'Created On'),
            'back' => Yii::t('deck', 'Back Image'),
            'userId' => Yii::t('deck', 'Owner'),
            'active' => Yii::t('deck', 'Active'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * A filter is just an <em>Deck</em> instance whose attributes values are used 
     * to limit the search criteria.
     * 
     * @param integer $owner If the search is to be limited to a given user, this
     * parameter should contain that user's ID.
     * 
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('ownerId', $this->ownerId);
        $criteria->compare('createdOn', $this->createdOn, true);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

}
