<?php

/* User.php
 *  
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2016, WTactics Project <http://wtactics.org>
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

namespace common\models;

/**
 * //TODO: documentation
 * 
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $role 
 * @property string $avatar
 * @property string $gender
 * @property string $birthyear
 * @property string $website
 * @property string $twitter
 * @property string $facebook
 * @property string $googleplus
 * @property string $skype
 * @property string $country
 * @property integer $showChatTimes
 * @property integer $reverseCards
 * @property integer $onHoverDetails
 * @property string $handCorner
 * @property integer $active
 * 
 * @property Deck[] $decks
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
final class User extends \yii\db\ActiveRecord {
    //TODO: ...
    //const ADMIN_ROLE = 'administrator', PLAYER_ROLE = 'player', GAMEMASTER_ROLE = 'gamemaster';
    //TODO: public $hashed;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'User';
    }

//    public function rules() {
//        return array(
//            array('email, name', 'required'),
//            array('name', 'length', 'max' => 150),
//            array('email', 'email'),
//            array('email, name', 'unique'),
//            array('reverseCards, onHoverDetails, showChatTimes', 'boolean'),
//            array('email, avatar, website, twitter, facebook, googleplus, skype', 'length', 'max' => 255),
//            array('country', 'length', 'max' => 2),
//            array('birthyear', 'length', 'max' => 4),
//            array('role', 'in', 'range' => array('player', 'administrator', 'gamemaster')),
//            array('handCorner', 'in', 'range' => array('left', 'right')),
//            array('gender', 'in', 'range' => array('female', 'male')),
//            //search
//            array('email, name, role', 'safe', 'on' => 'search'),
//        );
//    }
//    public function relations() {
//        return array(
//            'decks' => array(self::HAS_MANY, 'Deck', 'ownerId'),
//        );
//    }
//    public function attributeLabels() {
//        return array(
//            'id' => Yii::t('user', 'ID'),
//            'email' => Yii::t('user', 'E-mail'),
//            'password' => Yii::t('user', 'Password'),
//            'name' => Yii::t('user', 'Name'),
//            'role' => Yii::t('user', 'Role'),
//            'avatar' => Yii::t('user', 'Avatar'),
//            'gender' => Yii::t('user', 'Gender'),
//            'birthyear' => Yii::t('user', 'Birth Year'),
//            'website' => Yii::t('user', 'Website'),
//            'twitter' => Yii::t('user', 'Twitter'),
//            'facebook' => Yii::t('user', 'Facebook'),
//            'googleplus' => Yii::t('user', 'Google+'),
//            'skype' => Yii::t('user', 'Skype/MSN'),
//            'country' => Yii::t('user', 'Country'),
//            'showChatTimes' => Yii::t('user', 'Show Message Time'),
//            'reverseCards' => Yii::t('user', 'Reverse Cards'),
//            'onHoverDetails' => Yii::t('user', 'Details <em>on hover</em>'),
//            'handCorner' => Yii::t('user', 'Hand Corner')
//        );
//    }
//    /**
//     * Retrieves all users that were active in the last 15 minutes.
//     * 
//     * @return User[]
//     */
//    public function findAllAuthenticated() {
//        return User::model()->with(array(
//                    'sessions' => array(
//                        'condition' => 'TOKEN IS NOT NULL AND tokenExpires > NOW() AND lastActivity > DATE_SUB(NOW(), INTERVAL 15 MINUTE)'
//            )))->findAll();
//    }
//
//    public static function hash($password) {
//        if (isset(Yii::app()->params['salt'])) {
//            $password = Yii::app()->params['salt'] . $password . Yii::app()->params['salt'];
//        }
//
//        return hash('sha512', $password);
//    }
//
//    public function beforeSave() {
//        if (empty($this->password) && empty($this->password2) && !empty($this->hashed)) {
//            $this->password = $this->password2 = $this->hashed;
//        }
//
//        return parent::beforeSave();
//    }
//
//    public function afterFind() {
//        $this->hashed = $this->password;
//        $this->password = null;
//
//        parent::afterFind();
//    }
//
//    public final static function rolesArray() {
//        return array(
//            'administrator' => Yii::t('user', 'Administrator'),
//            'player' => Yii::t('user', 'Player'),
//            'gamemaster' => Yii::t('user', 'Game Master')
//        );
//    }
//
//    public final function roleName() {
//        $roles = self::rolesArray();
//
//        return $roles[$this->role];
//    }
//
//    public final function getRoleName() {
//        $roles = self::rolesArray();
//
//        return (isset($roles[$this->role]) ? $roles[$this->role] : '');
//    }
}
