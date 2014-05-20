<?php

/* WebUser.php
 *  
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2014, Sérgio Lopes <knitter@wtactics.org>
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

class WebUser extends CWebUser {

    private $_user;

    public function getUser() {
        if ($this->isGuest) {
            return null;
        }

        if ($this->_user === null) {
            $this->_user = User::model()->findByPk($this->id);
        }

        return $this->_user;
    }

    public function isAdministrator() {
        if ($this->isGuest) {
            return false;
        }

        return $this->user->role == User::ADMIN_ROLE;
    }

    public function isGameMaster() {
        if ($this->isGuest) {
            return false;
        }

        return ($this->user->role == User::ADMIN_ROLE || $this->user->role == User::GAMEMASTER_ROLE);
    }

    public function isPlayer() {
        if ($this->isGuest) {
            return false;
        }

        return true;
    }

}
