<?php

/* Register.php
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
 * @property string $password2
 * @property string $name
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
class Register extends yii\base\Model {
//    public $email;
//    public $password;
//    public $password2;
//    public $name;
//    public function rules() {
//        return array(
//            array('name, email, password, password2', 'required'),
//            array('email', 'email'),
//            array('email, name', 'unique', 'className' => 'User'),
//            array('password', 'compare', 'compareAttribute' => 'password2'),
//            array('name', 'length', 'max' => 150),
//        );
//    }
//    public function attributeLabels() {
//        return array(
//            'email' => Yii::t('sandscape', 'E-mail'),
//            'password' => Yii::t('sandscape', 'Password'),
//            'password2' => Yii::t('regsandscapeister', 'Repeat Password'),
//            'name' => Yii::t('sandscape', 'Name')
//        );
//    }
//    public function register() {
//        if ($this->validate()) {
//            $user = new User();
//
//            $user->email = $this->email;
//            $user->password = User::hash($this->password);
//            $user->name = $this->name;
//
//            return $user->save();
//        }
//        return false;
//    }
}
