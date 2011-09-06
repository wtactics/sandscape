<?php

/*
 * Backup.php
 *
 * (C) 2011, StaySimple team.
 *
 * This file is part of StaySimple.
 * http://code.google.com/p/stay-simple-cms/
 *
 * StaySimple is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * StaySimple is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with StaySimple.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Backup model to represent backup files.
 * 
 * The attributes are just strings that allow easier identification of the date 
 * and the page that relates to this backup.
 */
class Backup {

    private $date;
    private $page;

    public function __construct($page = '', $date = 0) {
        $this->date = $date;
        $this->page = $page;
    }

    /**
     * Gives back the date when this backup was created.
     * 
     * @return string The date when the backup was created.
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Returns the page name that this backup corresponds to.
     * 
     * @return string The page name.
     */
    public function getPage() {
        return $this->page;
    }

}
