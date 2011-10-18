<?php

/* User.php
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
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property string $userId
 * @property string $email
 * @property string $password
 * @property string $name
 * @property integer $admin
 * @property integer $active
 * @property integer $seeTopDown
 * @property string $token
 * @property string $tokenExpires
 * 
 * The followings are the available model relations:
 * @property ChatMessage[] $chatMessages
 * @property Deck[] $decks
 * @property Game[] $gamesAsPlayer1
 * @property Game[] $gamesAsPlayer2
 */
class User extends CActiveRecord {

    public function __construct($scenario = 'insert') {
        parent::__construct($scenario);
    }

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'User';
    }

    public function rules() {
        return array(
            array('email, password', 'required'),
            array('admin, active, seeTopDown', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 255),
            array('name', 'length', 'max' => 100),
            //search
            array('email, name, admin', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'chatMessages' => array(self::HAS_MANY, 'ChatMessage', 'userId'),
            'decks' => array(self::HAS_MANY, 'Deck', 'userId'),
            'gamesAsPlayer1' => array(self::HAS_MANY, 'Game', 'player1'),
            'gamesAsPlayer2' => array(self::HAS_MANY, 'Game', 'player2'),
        );
    }

    public function attributeLabels() {
        return array(
            'userId' => 'ID',
            'email' => 'E-mail',
            'password' => 'Password',
            'name' => 'Name',
            'admin' => 'Administrator',
            'seeTopDown' => 'See inverted cards'
        );
    }

    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('admin', $this->admin);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('User', array('criteria' => $criteria));
    }

    public function findAllAuthenticated() {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN SessionData ON t.userId = SessionData.userId';
        $criteria->condition = 'TOKEN IS NOT NULL AND tokenExpires > NOW() AND lastActivity > DATE_SUB(NOW(), INTERVAL 15 MINUTE)';

        return new CActiveDataProvider('User', array('criteria' => $criteria));
    }

}