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

namespace app\models\forms;

use common\models\User;

/**
 * @property string $email
 * @property string $password
 * @property string $name
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
class Register extends yii\base\Model {

    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var string */
    public $name;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'email', 'password'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return array(
            'email' => Yii::t('sandscape', 'E-mail'),
            'password' => Yii::t('sandscape', 'Password'),
            'name' => Yii::t('sandscape', 'Name')
        );
    }

    /**
     * @return boolean
     */
    public function register() {
        //TODO: e-mail user ...
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->email = $this->email;
        $user->password = $this->password;
        $user->name = $this->name;
        $user->role = User::ROLE_PLAYER;

        return $user->save();
    }

}
