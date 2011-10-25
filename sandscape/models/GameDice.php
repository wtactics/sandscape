<?php

/* GameDice.php
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
 * @property integer $diceId
 * @property integer $gameId
 *
 * @property Deck $deck
 * @property Card $card
 * 
 * @since 1.2, Elvish Shaman
 */
class GameDice extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'GameDice';
    }

    public function relations() {
        return array(
            'game' => array(self::BELONGS_TO, 'Game', 'gameId'),
            'dice' => array(self::BELONGS_TO, 'Dice', 'diceId'),
        );
    }

    public function attributeLabels() {
        return array(
            'gameId' => 'Game ID',
            'diceId' => 'Dice ID',
        );
    }

}