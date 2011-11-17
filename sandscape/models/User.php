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
 * http://wtactics.org
 */

/**
 * This is the model class for the <em>User</em> table.
 *
 * The followings are the available columns in table 'User':
 * @property int $userId
 * @property string $email
 * @property string $password
 * @property string $name
 * @property int $admin
 * @property int $active
 * @property string $avatar
 * @property int $gender
 * @property string $birthday
 * @property string $website
 * @property string $twitter
 * @property string $facebook
 * @property string $googleplus
 * @property string $skype
 * @property string $msn
 * 
 * The followings are the available model relations:
 * @property ChatMessage[] $chatMessages
 * @property Deck[] $decks
 * @property Game[] $gamesAsPlayer1
 * @property Game[] $gamesAsPlayer2
 * 
 * @since 1.0, Sudden Growth
 */
class User extends CActiveRecord {

    /**
     * @return User
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'User';
    }

    public function rules() {
        return array(
            array('email, password, name', 'required'),
            array('admin, gender', 'numerical', 'integerOnly' => true),
            array('email, avatar, website, twitter, facebook, googleplus, skype, msn', 'length', 'max' => 255),
            array('name', 'length', 'max' => 15),
            array('email', 'email'),
            array('name, email', 'unique', 'className' => 'User'),
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
            'avatar' => 'Avatar',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'website' => 'Website',
            'twitter' => 'Twitter',
            'facebook' => 'Facebook',
            'googleplus' => 'Google+',
            'skype' => 'Skype',
            'msn' => 'MSN'
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

        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('admin', $this->admin);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('User', array('criteria' => $criteria));
    }

    /**
     * Retrieves all users that were active in the last 15 minutes.
     * 
     * @return CActiveDataProvider
     */
    public function findAllAuthenticated() {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN SessionData ON t.userId = SessionData.userId';
        $criteria->condition = 'TOKEN IS NOT NULL AND tokenExpires > NOW() AND lastActivity > DATE_SUB(NOW(), INTERVAL 15 MINUTE)';

        return new CActiveDataProvider('User', array('criteria' => $criteria));
    }

    /**
     * Creates a hash from the given password using the correct hashing process.
     * This method should be prefered over manually hashing any password.
     * 
     * @param string $password The password you whish to hash.
     * 
     * @return string The hashed password. 
     */
    public final static function hash($password) {
        return sha1($password . Yii::app()->params['hash']);
    }

}