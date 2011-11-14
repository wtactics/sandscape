<?php

/* SSWebUSer.php
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
class SSWebUser extends CWebUser {

    /**
     *
     * @param type $id
     * @param type $states
     * @param type $fromCookie
     * @return type 
     * 
     * @since 1.0, Sudden Growth
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
