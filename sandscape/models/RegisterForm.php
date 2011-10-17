<?php

/* RegisterForm.php
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

class RegisterForm extends CFormModel {

    public $email;
    public $password;
    public $password_repeat;
    public $name;

    public function rules() {
        return array(
            array('email, password', 'required'),
            array('email', 'unique'),
            array('email', 'email'),
            array('password', 'compare'),
            array('name', 'length', 'max' => 100),
        );
    }

    public function attributeLabels() {
        return array(
            'email' => 'E-mail',
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
            'name' => 'Name'
        );
    }

    public function register() {
        
    }

}
