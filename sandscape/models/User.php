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
 * @property integer $authenticated
 * @property integer $active
 * @property integer $seeTopDown
 *
 * The followings are the available model relations:
 * @property ChatMessage[] $chatMessages
 * @property Deck[] $decks
 * @property Game[] $gamesAsPlayer1
 * @property Game[] $gamesAsPlayer2
 */
class User extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'User';
    }

    /**
     * @return array validation rules for model attributes.
     */
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

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'chatMessages' => array(self::HAS_MANY, 'ChatMessage', 'userId'),
            'decks' => array(self::HAS_MANY, 'Deck', 'userId'),
            'gamesAsPlayer1' => array(self::HAS_MANY, 'Game', 'player1'),
            'gamesAsPlayer2' => array(self::HAS_MANY, 'Game', 'player2'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'userId' => 'ID',
            'email' => 'E-mail',
            'password' => 'Password',
            'name' => 'Name',
            'admin' => 'Administrator',
            'seeTopDown' => 'See inverted card'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('admin', $this->admin);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('User', array('criteria' => $criteria));
    }

}