<?php

/* Game.php
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
 * 
 * @property int $gameId
 * @property int $player1
 * @property int $player2
 * @property string $created
 * @property string $started
 * @property string $ended
 * @property int $running
 * @property int $paused
 * @property string $state
 * 
 * @property int $maxDecks
 * @property int $graveyard
 * @property int $player1Ready
 * @property int $player2Ready
 * 
 * @property int $lastChange
 * @property int $acceptUser
 * @property int $winnerId
 * @property int $spectatorsSpeak
 *
 * Relations:
 * @property ChatMessage[] $chatMessages
 * @property User $creator
 * @property User $opponent
 * @property Deck[] $decks
 * @property Dice[] $dice
 * @property User $winner
 * @property User $accept
 * @property PlayerCounter[] $counters
 * @property DeckGameStats $stats
 */
class Game extends CActiveRecord {

    /**
     * @return Game
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{Game}}';
    }

    public function rules() {
        return array(
            array('running, paused', 'numerical', 'integerOnly' => true),
            array('started, ended', 'safe'),
            //search
            array(
                'player1, player2, created, started, ended, running, paused, winnerId, acceptUser',
                'safe',
                'on' => 'search'
            ),
        );
    }

    public function relations() {
        return array(
            'chatMessages' => array(self::HAS_MANY, 'ChatMessage', 'gameId'),
            'creator' => array(self::BELONGS_TO, 'User', 'player1'),
            'opponent' => array(self::BELONGS_TO, 'User', 'player2'),
            'decks' => array(self::MANY_MANY, 'Deck', 'GameDeck(gameId, deckId)'),
            'dice' => array(self::MANY_MANY, 'Dice', 'GameDice(gameId, diceId)'),
            'winner' => array(self::BELONGS_TO, 'User', 'winnerId'),
            'accept' => array(self::BELONGS_TO, 'User', 'acceptUser'),
            'counters' => array(self::MANY_MANY, 'PlayerCounter', 'GamePlayerCounter(gameId, playerCounterId)'),
            'stats' => array(self::HAS_MANY, 'DeckGameStats', 'gameId')
        );
    }

    public function attributeLabels() {
        return array(
            'gameId' => 'ID',
            'player1' => 'Player 1',
            'player2' => 'Player 2',
            'created' => 'Created',
            'started' => 'Started',
            'ended' => 'Ended',
            'running' => 'Running',
            'paused' => 'Paused',
            'maxDecks' => 'Max. number of decks',
            'graveyard' => 'Game has graveyard',
            'player1Ready' => 'Player 1 is ready',
            'player2Ready' => 'Player 2 is ready',
            'acceptUser' => 'Accept only',
            'winnerId' => 'Winner'
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

        $criteria->compare('player1', $this->player1);
        $criteria->compare('player2', $this->player2);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('started', $this->started, true);
        $criteria->compare('ended', $this->ended, true);
        $criteria->compare('running', $this->running);
        $criteria->compare('paused', $this->paused);
        $criteria->compare('winnerId', $this->winnerId);
        $criteria->compare('acceptUser', $this->acceptUser);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

}