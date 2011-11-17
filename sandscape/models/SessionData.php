<?php

/* SessionData.php
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
 * The <strong>SessionData</strong> table stores session information for 
 * authenticated users. The table is queried to determine what users are active 
 * and allows security tokens to be stored.
 * 
 * Properties for the <em>SessionData</em> class:
 * 
 * @property integer $userId The user ID this data relates to, also the primary key
 * @property string $token The security token for authenticated users
 * @property string $tokenExpires The date in which the security token will expire
 * @property string $lastActivity The last time this user made an action in the system
 * 
 * @since 1.0, Sudden Growth
 */
class SessionData extends CActiveRecord {

    /**
     * @return SessionData
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'SessionData';
    }

}