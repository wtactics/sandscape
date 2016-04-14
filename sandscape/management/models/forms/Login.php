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

namespace management\models\forms;

/**
 * @property string $email
 * @property string $password
 * @property int $rememberMe
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
class Login extends yii\base\Model {
//    public $email;
//    public $password;
//    public $rememberMe;
//    private $identity;
//    public function rules() {
//        return array(
//            array('email, password', 'required'),
//            array('email', 'email'),
//            array('rememberMe', 'boolean'),
//            array('password', 'authenticate'),
//        );
//    }
//    public function attributeLabels() {
//        return array(
//            'email' => Yii::t('sandscape', 'E-mail'),
//            'password' => Yii::t('sandscape', 'Password'),
//            'rememberMe' => Yii::t('sandscape', 'Remember me'),
//        );
//    }
//    public function authenticate($attribute, $params) {
//        if (!$this->hasErrors()) {
//            $this->identity = new UserIdentity($this->email, $this->password);
//            if (!$this->identity->authenticate()) {
//                $this->addError('password', Yii::t('sandscape', 'Incorrect e-mail or password.'));
//            }
//        }
//    }
//    public function login() {
//        if ($this->validate()) {
//
//            if ($this->identity === null) {
//                $this->identity = new UserIdentity($this->email, $this->password);
//                $this->identity->authenticate();
//            }
//
//            if ($this->identity->errorCode === UserIdentity::ERROR_NONE) {
//                //remember for 7 days
//                $duration = $this->rememberMe ? 3600 * 24 * 7 : 0;
//                Yii::app()->user->login($this->identity, $duration);
//
//                return true;
//            }
//        }
//
//        return false;
//    }
}
