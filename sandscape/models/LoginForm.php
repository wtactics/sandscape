<?php

/*
 * models/LoginForm.php
 * http://sandscape.sourceforge.net/
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

class LoginForm extends CFormModel {

    public $email;
    public $password;
    public $rememberMe;
    private $identity;

    public function rules() {
        return array(
            array('email, password', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels() {
        return array(
            'email' => 'E-mail',
            'password' => 'Password',
            'rememberMe' => 'Remember me next time'
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->identity = new Identity($this->email, $this->password);
            switch ($this->identity->authenticate()) {
                case CUserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                    Yii::app()->user->login($this->identity, $duration);
                    return true;
                case CUserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError('email', 'Email address is incorrect.');
                    break;
                case CUserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError('password', 'Wrong password.');
                    break;
            }
        }

        return false;
    }

}
