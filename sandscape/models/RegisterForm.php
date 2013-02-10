<?php

/* RegisterForm.php
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
 * Form model for the registration process.
 * 
 * @property string $email
 * @property string $password
 * @property string $password_repeat
 * @property string $name
 */
class RegisterForm extends CFormModel {

    public $email;
    public $password;
    public $password_repeat;
    public $name;

    public function rules() {
        return array(
            array('email, password, password_repeat', 'required'),
            array('email', 'email'),
            array('email, name', 'unique', 'className' => 'User'),
            array('password', 'compare'),
            array('name', 'length', 'max' => 150),
        );
    }

    public function attributeLabels() {
        return array(
            'email' => Yii::t('register', 'E-mail'),
            'password' => Yii::t('register', 'Password'),
            'password_repeat' => Yii::t('register', 'Repeat Password'),
            'name' => Yii::t('register', 'Name')
        );
    }

    public function register() {
        $user = new User();

        $user->email = $this->email;
        $user->password = User::hash($this->password);
        $user->name = $this->name;

        return $user->save();
    }

}
