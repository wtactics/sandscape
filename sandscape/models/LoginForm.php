<?php

/* LoginForm.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
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

/**
 * @since 1.0, Sudden Growth
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
     * 
     * @since 1.0, Sudden Growth
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->credentials = new Credentials($this->email, $this->password);
            if (!$this->credentials->authenticate())
                $this->addError('password', 'Incorrect email or password.');
        }
    }

    /**
     * @return bool
     * 
     * @since 1.0, Sudden Growth
     */
    public function login() {
        if ($this->credentials === null) {
            $this->credentials = new Credentials($this->email, $this->password);
            $this->credentials->authenticate();
        }

        if ($this->credentials->errorCode === Credentials::ERROR_NONE) {
            //remember for 7 days
            $duration = $this->rememberMe ? 3600 * 24 * 7 : 0;
            Yii::app()->user->login($this->credentials, $duration);

            return true;
        }

        return false;
    }

}
