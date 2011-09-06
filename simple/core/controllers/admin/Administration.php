<?php

/*
 * Administration.php
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
 * Base class for any administration controllers, including the controllers 
 * provided by plugins.
 */
abstract class Administration extends ViewController {

    public function __construct($layout = '//layouts/admin-layout') {
        parent::__construct(Config::getInstance()->get('system.theme'), $layout);
    }

    /**
     * Redirects the user to another controller or controller/action.
     * 
     * @param string $controller The controller to which you want to redirect 
     * the user to.
     */
    public function redirect($controller) {
        parent::redirect(Config::getInstance()->get('system.path') . '/' . $controller);
    }

    /**
     * Checks for an authenticated user. This is just a convinience method.
     * 
     * @return boolean True if there is an authenticaded user or false otherwise.
     */
    public function authenticatedUserExists() {
        return StaySimple::app()->getUser() !== null;
    }

    /**
     * Checks for an authenticated user and redirects to login if none is found.
     * 
     * This method should be used by all controller classes when checking if 
     * the existing user is valid and can execute the action being requested.
     */
    public function validateUser() {
        if (!$this->authenticatedUserExists()) {
            $this->redirect('login');
        }
    }

}