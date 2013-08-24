<?php

/* Game.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
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
 * @property int $id
 * @property int $playerId
 * @property int $opponentId
 * @property int $limitOpponentId
 * @property int $winnerId
 * @property string $createdOn
 * @property string $startedOn
 * @property string $endedOn
 * @property string $state
 * @property int $running
 * @property int $paused
 * @property int $useGraveyard
 * @property int $playerReady
 * @property int $opponentReady 
 * @property int $spectatorsSpeak
 * @property int $lastChange
 * 
 * Relations:
 * @property ChatMessage[] $messages
 * @property User $creator
 * @property User $opponent
 * @property Deck[] $decks
 * @property Dice[] $dice
 * @property User $winner
 * @property User $limitOpponent
 * @property Counter[] $counters
 * @property DeckStats $stats
 */
class Game extends CActiveRecord {

    /**
     * @return Game
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{Game}}';
    }

    public function rules() {
        return array(
            array('playerId, createdOn', 'required'),
            array('playerId, opponentId, limitOpponentId, winnerId', 'numerical', 'integerOnly' => true),
            array('startedOn, endedOn, state', 'safe'),
            array('running, paused, useGraveyard, playerReady, opponentReady, spectatorsSpeak', 'boolean'),
            //search
            array('playerId, opponentId, createdOn, startedOn, endedOn, running, paused, winnerId, limitOpponentId', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'messages' => array(self::HAS_MANY, 'ChatMessage', 'gameId'),
            'creator' => array(self::BELONGS_TO, 'User', 'playerId'),
            'opponent' => array(self::BELONGS_TO, 'User', 'opponentId'),
            'decks' => array(self::MANY_MANY, 'Deck', 'GameDeck(gameId, deckId)'),
            'dice' => array(self::MANY_MANY, 'Dice', 'GameDice(gameId, diceId)'),
            'winner' => array(self::BELONGS_TO, 'User', 'winnerId'),
            'limitOpponent' => array(self::BELONGS_TO, 'User', 'limitOpponetId'),
            'counters' => array(self::MANY_MANY, 'Counter', 'GameCounter(gameId, counterId)'),
            'stats' => array(self::HAS_MANY, 'DeckStats', 'gameId')
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('game', 'ID'),
            'playerId' => Yii::t('game', 'Player'),
            'opponentId' => Yii::t('game', 'Opponent'),
            'limitOpponentId' => Yii::t('game', 'Limit Opponent'),
            'winnerId' => Yii::t('game', 'Winner'),
            'createdOn' => Yii::t('game', 'Created On'),
            'startedOn' => Yii::t('game', 'Started On'),
            'endedOn' => Yii::t('game', 'Ended On'),
            'state' => Yii::t('game', 'Game Internal State'),
            'running' => Yii::t('game', 'Running'),
            'paused' => Yii::t('game', 'Paused'),
            'useGraveyard' => Yii::t('game', 'Uses Graveyard'),
            'playerReady' => Yii::t('game', 'Player Is Ready'),
            'opponentReady' => Yii::t('game', 'Opponent Is Ready'),
            'spectatorsSpeak' => Yii::t('game', 'Spectators Can Speak'),
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

        $criteria->compare('playerId', $this->playerId);
        $criteria->compare('opponentId', $this->opponentId);
        $criteria->compare('createdOn', $this->createdOn, true);
        $criteria->compare('startedOn', $this->startedOn, true);
        $criteria->compare('endedOn', $this->endedOn, true);
        $criteria->compare('running', $this->running);
        $criteria->compare('paused', $this->paused);
        $criteria->compare('winnerId', $this->winnerId);
        $criteria->compare('limitOpponentId', $this->limitOpponentId);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

    public function isRunningString() {
        return ($this->running ? Yii::t('sandscape', 'Yes') : Yii::t('sandscape', 'No'));
    }

    public function isPausedString() {
        return ($this->paused ? Yii::t('sandscape', 'Yes') : Yii::t('sandscape', 'No'));
    }

    public function usesGraveyardString() {
        return ($this->useGraveyard ? Yii::t('sandscape', 'Yes') : Yii::t('sandscape', 'No'));
    }

}
