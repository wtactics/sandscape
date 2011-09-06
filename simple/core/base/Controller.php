<?php

/*
 * Controller.php
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
 * Base class for all controllers.
 * 
 * A controller is an object that responds to requested URLs, it is the entity 
 * responsible for creating the functionality that the user sees.
 */
abstract class Controller {

    public function __construct() {
        
    }

    /**
     * Default controller action. All subclasses must implement this default 
     * action that is used whenever a request is made to the controller but no
     * action is specified.
     */
    public abstract function start();

    /**
     * Redirects the user to another controller and action.
     * 
     * @param string $relative The controller and action to redirect to.
     */
    public function redirect($relative = '') {
        $destination = StaySimple::app()->getURL() . ($relative ? "index.php/{$relative}" : '');
        header("Location: {$destination}");
        exit;
    }

    public function getTranslatedString($key, $params = array()) {
        return StaySimple::app()->getTranslatedString($key, $params);
    }

    /**
     * Places a message in the message queue so that other controllers can 
     * access it.
     * 
     * @param Message $message Message to store.
     * 
     * @see Message
     */
    public function queueMessage($message) {
        if (!isset($_SESSION['messageQueue'])) {
            $_SESSION['messageQueue'] = array();
        }
        array_push($_SESSION['messageQueue'], serialize($message));
    }

    /**
     * Removes a message from the message queue and returns it.
     * 
     * @return Message The message retrieved or null if there is no messages left 
     * in the queue.
     * 
     * @see Message
     */
    public function popMessage() {
        if (isset($_SESSION['messageQueue']))
            return unserialize(array_pop($_SESSION['messageQueue']));

        return null;
    }

}