<?php

/* LoginForm.php
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
    private $credentials;

    public function rules() {
        return array(
            array('email, password', 'required'),
            array('email', 'email'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember my login',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->credentials = new Credentials($this->email, sha1($this->password));
            if (!$this->credentials->authenticate())
                $this->addError('password', 'Incorrect email or password.');
        }
    }

    public function login() {
        if ($this->credentials === null) {
            $this->credentials = new Credentials($this->username, sha1($this->password));
            $this->credentials->authenticate();
        }

        if ($this->credentials->errorCode === Credentials::ERROR_NONE) {
            //remember for 30 days
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0;
            Yii::app()->user->login($this->credentials, $duration);

            //mark user as logged in
            $user = User::model()->findByPk($this->credentials->getId());
            $user->authenticated = 1;
            $user->save();

            return true;
        }

        return false;
    }

}
