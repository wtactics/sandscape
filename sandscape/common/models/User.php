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

use Yii;

/**
 * //TODO: documentation
 * 
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $role 
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
final class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    const ROLE_ADMINISTRATOR = 'administrator',
            ROLE_PLAYER = 'player',
            ROLE_GAMEMASTER = 'gamemaster';

    private $hashed;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function afterFind() {
        $this->hashed = $this->password;
        $this->password = null;

        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (!empty($this->password)) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            } else if (!empty($this->hashed)) {
                $this->password = $this->hashed;
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return md5($this->id . $this->email . $this->hashed);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $authKey == $this->getAuthKey();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return self::findOne((int) $id);
    }

    /**
     * @param mixed $token
     * @param mixed $type
     * @throws \yii\web\NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException();
    }

    /**
     * @param string $password
     * @return boolean
     */
    public function checkPassword($password) {
        try {
            return Yii::$app->security->validatePassword($password, $this->hashed);
        } catch (InvalidParamException $ex) {
            //IGNORE
        }

        return false;
    }

    /**
     * @return string
     */
    public static function getRandomPassword() {
        return Yii::$app->security->generateRandomString(8);
    }

    /**
     * @return array
     */
    public final static function roleList() {
        return [
            self::ROLE_ADMINISTRATOR => Yii::t('sandscape', 'Administrator'),
            self::ROLE_PLAYER => Yii::t('sandscape', 'Player'),
            self::ROLE_GAMEMASTER => Yii::t('sandscape', 'Game Master')
        ];
    }

    /**
     * @return string
     */
    public final function roleLabel() {
        $roles = self::rolesArray();

        return $roles[$this->role];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecks() {
        return $this->hasMany(Deck::className(), ['ownerId' => 'id'])->inverseOf('owner');
    }

}
