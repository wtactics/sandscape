<?php

/*
 * IPluginAdministration.php
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
 * Any plugin that wants to add an administration section, and a corresponding
 * menu link/option, needs to implement this interface.
 * 
 * It also needs to provide on <em>Administration</em> controller that will be 
 * responsible to all the actions and views.
 */
interface IPluginAdministration {

    /**
     * Array with stdClass objects in the form of:
     * 
     * stdClass {
     *    name: 'text to display in the menu',
     *    controller: 'controller class' name'
     * }
     * 
     * @return array The options for this plugin's administration.
     */
    public function getAdminOptions();
}

?>