<?php

/* Credentials.php
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

class Credentials extends CBaseUserIdentity {

    private $email;
    private $password;
    private $id;
    private $name;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function authenticate() {
        $this->errorCode = self::ERROR_NONE;
        $user = User::model()->find('email = :email AND password = :hash', array(
            ':email' => $this->username,
            ':hash' => $this->password
                )
        );

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }

        $this->id = $user->userId;
        $this->name = ($user->name ? $user->name : $user->email);

        $this->setState('name', $this->name);

        return true;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

}