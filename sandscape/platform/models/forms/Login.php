<?php

/* Login.php
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

namespace app\models\forms;

use Yii;
use common\models\User;

/**
 * @property string $email
 * @property string $password
 * @property int $rememberMe
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
class Login extends yii\base\Model {

    const SESSION_DURATION = 3600;

    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var boolean */
    public $rememberMe;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['email, password'], 'required'],
            [['email'], 'email'],
            [['rememberMe'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email' => Yii::t('sandscape', 'E-mail'),
            'password' => Yii::t('sandscape', 'Password'),
            'rememberMe' => Yii::t('sandscape', 'Remember me'),
        ];
    }

    /**
     * Validates user input and authenticates the account if the credentials 
     * are valid.
     * 
     * @return boolean
     */
    public function authenticate() {
        if (!$this->validate()) {
            return false;
        }

        if (!($user = User::findOne(['email' => $this->email]))) {
            $this->addError('email', Yii::t('sandscape', 'Incorrect e-mail or password'));
            $this->addError('password', Yii::t('sandscape', 'Incorrect e-mail or password'));

            return false;
        }

        if (!$user->checkPassword($this->password)) {
            $this->addError('password', Yii::t('sandscape', 'Wrong password'));

            return false;
        }

        return Yii::$app->user->login($user, self::SESSION_DURATION);
    }

}
