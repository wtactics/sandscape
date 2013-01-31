<?php

/* SSWebUser.php
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
 */
class SandscapeWebUser extends CWebUser {

    /**
     *
     * @param int $id
     * @param array $states
     * @param boolean $fromCookie
     * 
     * @return boolean 
     */
    public function beforeLogin($id, $states, $fromCookie) {

        if (!$fromCookie) {
            return true;
        }

        $sd = SessionData::model()->findByPk($id);
        if ($sd === null || $sd->token !== $states['token'] || strtotime($sd->tokenExpires) < time()) {
            return false;
        }

        return false;
    }

}
