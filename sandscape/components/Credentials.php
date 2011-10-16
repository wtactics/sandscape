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

class Credentials extends CUserIdentity {

    public function __construct($username, $password) {
        parent::__construct($username, $password);
    }

    public function authenticate() {
        //TODO: remove demo code and implement proper security
        $users = array(
            // username => password
            'demo' => 'demo',
            'admin' => 'admin',
        );
        if (!isset($users[$this->username]))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($users[$this->username] !== $this->password)
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
            $this->errorCode = self::ERROR_NONE;
        return!$this->errorCode;
    }

}