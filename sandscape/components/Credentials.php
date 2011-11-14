<?php

/* Credentials.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * @since 1.0, Sudden Growth
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

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function authenticate() {
        $this->errorCode = self::ERROR_NONE;
        $user = User::model()->findByAttributes(array('email' => $this->email));

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ($user->password !== User::hash($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->id = $user->userId;
                $this->name = ($user->name ? $user->name : $user->email);


                $sd = null;
                if (($sd = SessionData::model()->findByPk($user->userId)) === null) {
                    $sd = new SessionData();
                    $sd->userId = $user->userId;
                }

                $time = time();
                $token = md5($time . $this->id . $user->email);

                $expires = $time + (3600 * 24 * 7);

                $this->setState('token', $token);
                $this->setState('class', $user->admin);

                $sd->token = $token;
                $sd->tokenExpires = date('Y-m-d H:i', $expires);
                $sd->lastActivity = date('Y-m-d H:i', $time);
                $sd->save();
            }
        }

        return!$this->errorCode;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getName() {
        return $this->name;
    }

}