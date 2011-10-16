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
 */

/**
 * This is the model class for table "Card".
 *
 * The followings are the available columns in table 'Card':
 * @property string $cardId
 * @property string $name
 * @property string $rules
 * @property string $image
 * @property string $cardscapeId
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property DeckCard[] $deckCards
 */
class Card extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Card the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Card';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name, rules', 'required'),
            array('name', 'length', 'max' => 150),
            array('cardscapeId', 'numerical', 'integerOnly' => true),
            //search
            array('name, rules, cardscapeId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'deckCards' => array(self::HAS_MANY, 'DeckCard', 'cardId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
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
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
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