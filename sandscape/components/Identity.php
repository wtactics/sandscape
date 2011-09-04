<?php
/*
 * components/Identity.php
 * 
 * This file is part of SandScape.
 * http://sandscape.sourceforge.net/
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

/**
 * The <em>Identity<em> class connects to the authentication mechanism that Yii 
 * offers. It is a simple class that extends <em>CUserIdentity</em> and that 
 * provides user authetication based on SandScape users database.
 * 
 * @see CUserIdentity
 * @see IUserIdentity
 * 
 * @since 1.0
 * @author Sérgio Lopes
 */
class Identity extends CUserIdentity {

    private $userId;

    public function authenticate() {
        $user = User::model()->find("email = :email AND (`key` IS NULL OR `key` = '')", array(':email' => $this->username));

        if (!$user) {
            return self::ERROR_USERNAME_INVALID;
        }

        if ($user->password !== sha1($this->password)) {
            return self::ERROR_PASSWORD_INVALID;
        }

        $this->userId = $user->userId;
        $this->setState('role', ($user->admin ? 'admin' : ''));

        return self::ERROR_NONE;
    }

    public function getId() {
        return $this->userId;
    }
}
