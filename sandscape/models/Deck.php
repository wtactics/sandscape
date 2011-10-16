<?php

/* Deck.php
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
 */

/**
 * This is the model class for table "Deck".
 *
 * The followings are the available columns in table 'Deck':
 * @property string $deckId
 * @property string $name
 * @property string $userId
 * @property string $created
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property User $user
 * @property DeckCard[] $deckCards
 * @property Game[] $gamesAs1
 * @property Game[] $gamesAs2
 */
class Deck extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Deck the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Deck';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name', 'length', 'max' => 100),
            //search
            array('name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'deckCards' => array(self::HAS_MANY, 'DeckCard', 'deckId'),
            'gamesAs1' => array(self::HAS_MANY, 'Game', 'deck1'),
            'gamesAs2' => array(self::HAS_MANY, 'Game', 'deck2'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'deckId' => 'ID',
            'name' => 'Name',
            'userId' => 'Owner',
            'created' => 'Created',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('Deck', array('criteria' => $criteria));
    }

}