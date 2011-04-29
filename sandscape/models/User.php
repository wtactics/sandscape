<?php

/*
 * User.php
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
 * 
 * From the table 'User' and it's relationships we get:
 *
 * @property int $userId
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $key
 * @property datetime $visited
 * @property integer $emailVisibility
 * @property integer $acceptMessages
 * @property integer $admin
 * @property integer $active
 *
 * @property Card[] $cards
 * @property Deck[] $decks
 * @property Game[] $gamesAsA
 * @property Game[] $gamesAsB
 * @property Message[] $privateMessages
 * @property Chat[] $chats
 * @property Game[] $wonGames
 */
class User extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('name, email', 'required'),
            array('name, email', 'unique'),
            array('emailVisibility, acceptMessages', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 20),
            array('email', 'length', 'max' => 200),
            // search rule
            array('name, email', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'cards' => array(self::MANY_MANY, 'Card', 'Create(userId, cardId)'),
            'decks' => array(self::HAS_MANY, 'Deck', 'userId'),
            'gamesAsA' => array(self::HAS_MANY, 'Game', 'playerA'),
            'gamesAsB' => array(self::HAS_MANY, 'Game', 'playerB'),
            'privateMessages' => array(self::HAS_MANY, 'Message', 'sender'),
            'chats' => array(self::MANY_MANY, 'Chat', 'Participate(userId, chatId)'),
            'wonGames' => array(self::HAS_MANY, 'Game', 'Win(userId, gameId)'),
        );
    }

    public function attributeLabels() {
        return array(
            'userId' => 'ID',
            'name' => 'Name',
            'password' => 'Password',
            'email' => 'E-mail',
            'key' => 'Validation key',
            'visited' => 'Last Visit',
            'emailVisibility' => 'E-mail visible to',
            'acceptMessages' => 'Accept messages',
            'admin' => 'Type'
        );
    }

    /**
     * Searches the database for records that match the given criteria. It is 
     * used mainly in grids.
     * 
     * @return CActiveDataProvider with all the found records.
     */
    public function search() {
        $criteria = new CDbCriteria();
        $criteria->order = 'name ASC';

        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('admin', $this->admin);
        $criteria->compare('active', 1);

        return new CActiveDataProvider(
                get_class($this),
                array(
                    'criteria' => $criteria,
                    'pagination' => array('pageSize' => 25)
        ));
    }

}