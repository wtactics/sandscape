<?php

/* Game.php
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
 * This is the model class for table "Game".
 *
 * The followings are the available columns in table 'Game':
 * @property string $gameId
 * @property string $player1
 * @property string $player2
 * @property string $created
 * @property string $started
 * @property string $ended
 * @property integer $running
 * @property string $deck1
 * @property string $deck2
 * @property integer $private
 *
 * The followings are the available model relations:
 * @property ChatMessage[] $chatMessages
 * @property User $player10
 * @property User $player20
 * @property Deck $deck10
 * @property Deck $deck20
 */
class Game extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Game the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Game';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('player1, deck1', 'required'),
            array('running, private', 'numerical', 'integerOnly' => true),
            array('started, ended', 'safe'),
            //search
            array('player1, player2, created, started, ended, running, deck1, deck2, private', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'chatMessages' => array(self::HAS_MANY, 'ChatMessage', 'gameId'),
            'player10' => array(self::BELONGS_TO, 'User', 'player1'),
            'player20' => array(self::BELONGS_TO, 'User', 'player2'),
            'deck10' => array(self::BELONGS_TO, 'Deck', 'deck1'),
            'deck20' => array(self::BELONGS_TO, 'Deck', 'deck2'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'gameId' => 'ID',
            'player1' => 'Player 1',
            'player2' => 'Player 2',
            'created' => 'Created',
            'started' => 'Started',
            'ended' => 'Ended',
            'running' => 'Running',
            'deck1' => 'Player 1 Deck',
            'deck2' => 'Player 2 Deck',
            'private' => 'Private',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('player1', $this->player1, true);
        $criteria->compare('player2', $this->player2, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('started', $this->started, true);
        $criteria->compare('ended', $this->ended, true);
        $criteria->compare('running', $this->running);
        $criteria->compare('deck1', $this->deck1, true);
        $criteria->compare('deck2', $this->deck2, true);
        $criteria->compare('private', $this->private);

        return new CActiveDataProvider('Game', array('criteria' => $criteria));
    }

}