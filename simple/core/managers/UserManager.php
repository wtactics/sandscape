<?php

/*
 * UserManager.php
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
 * Manages users in the system. Offers methods to load, save, remove and 
 * authenticate users.
 */
class UserManager extends Manager {

    private $users;
    private $actives;
    private $inactives;

    public function __construct() {
        parent::__construct();

        $this->users = array();
        $this->loadAll();
    }

    /**
     * Loads all users from the <em>users.xml</em> file with their respective 
     * information. The password hash is never loaded.
     * 
     * This method is useful in places where it's needed to manage all the 
     * existing users.
     * 
     * @return array An array with all the existing users. 
     */
    public function loadAll() {
        $file = new XMLFile(DATAROOT . '/settings/users.xml');

        foreach ($file->user as $user) {
            $u = new User(strval($user->name), null, strval($user->email), intval($user->active));

            $this->users[$u->getId()] = $u;

            if ($u->getActive()) {
                $this->actives[$u->getId()] = $u;
            } else {
                $this->inactives[$u->getId()] = $u;
            }
        }

        return $this->users;
    }

    /**
     *
     * @param string $id The ID that identifies the user, created by generateId 
     * method of the User class.
     * 
     * @return User The user identified by the given ID or null.
     * 
     * @see User
     * @see User::generateId()
     */
    public function getUserById($id) {
        if (isset($this->users[$id])) {
            return $this->users[$id];
        }

        return null;
    }

    /**
     * Returns the users that are loaded in the manager. If this method is called 
     * before <em>loadAll()</em> it's possible that an empty array is returned.
     * 
     * @return array An array with all the previously loaded users.
     */
    public function getAllUsers() {
        return $this->users;
    }

    /**
     * Returns the list of existing active users. An active user is a user that 
     * existis in the <em>users.xml</em> file but is marked as active.
     * 
     * @return array An array with the users that are considered <em>active</em>.
     */
    public function getActiveUsers() {
        return $this->actives;
    }

    /**
     * Returns the list of existing inactive users. An inactive user is a user 
     * that  existis in the <em>users.xml</em> file but is marked as <em>inactive</em>.
     * 
     * @return array An array with the users that are considered inactive.
     */
    public function getInactiveUsers() {
        return $this->inactives;
    }

    /**
     * Updates the internal user' arrays. This method <em>does NOT</em> save the 
     * <em>users.xml</em> file.
     * 
     * @param User $user The user to update.
     */
    public function update($user) {
        if (!$user->getId()) {
            $user->generateId();
        }

        if ($user->getActive()) {
            $this->actives[$user->getId()] = $user;
        } else {
            $this->inactives[$user->getId()] = $user;
        }

        $this->users[$user->getId()] = $user;
    }

    /**
     * Saves the current loaded users into the <em>users.xml</em> file.
     * 
     * @return boolean Returns <em>true</em> if the process was successful, 
     * <em>false</em> otherwise.
     */
    public function save() {
        $success = false;
        $file = new XMLFile(DATAROOT . '/settings/users.xml');

        foreach ($this->users as $live) {
            $found = false;

            foreach ($file->user as $stored) {
                if (User::generateId($stored->email) === $live->getId()) {
                    $stored->name = $live->getName();
                    if ($live->getPassword() != '') {
                        $stored->password = $live->getPassword();
                    }
                    $stored->email = $live->getEmail();
                    $stored->active = $live->getActive() ? 1 : 0;

                    $found = true;
                }
            }

            if (!$found) {
                $uNode = $file->addChild('user');
                $uNode->addChild('name', $live->getName());
                $uNode->addChild('password', $live->getPassword());
                $uNode->addChild('email', $live->getEmail());
                $uNode->addChild('active', $live->getActive() ? 1 : 0);
            }
        }

        return $file->asXML(DATAROOT . '/settings/users.xml');
    }

    /**
     * Deletes the given user. This method is just a convenience method over 
     * <em>deleteUserById()</em>.
     * 
     * @param User $user The user to remove.
     * @return boolean The success of the operation.
     * 
     * @see UserManager::deleteUserById() 
     */
    public function deleteUser($user) {
        return $this->deleteUserById($user->getId());
    }

    /**
     * Removes a user from the <em>users.xml</em> file using the user's ID.
     * 
     * @param string $id The ID that identifies the user to delete.
     * @return boolean The success of the operation, <em>true</em> if the user 
     * was deleted, <em>false</em> otherwise.
     */
    public function deleteUserById($id) {
        $file = new XMLFile(DATAROOT . '/settings/users.xml');

        $found = false;
        foreach ($this->users as $live) {
            foreach ($file->user as $stored) {
                if (User::generateId($stored->email) === $id) {

                    $removable = dom_import_simplexml($stored);
                    $removable->parentNode->removeChild($removable);

                    unset($this->users[$id]);
                    unset($this->actives[$id]);
                    unset($this->inactives[$id]);

                    $found = true;
                    break;
                }
            }

            if ($found) {
                break;
            }
        }

        if ($found) {
            return $file->asXML(DATAROOT . '/settings/users.xml');
        }

        return false;
    }

    /**
     * Validates an user's credentials against the existing user information that 
     * is available in the <em>users.xml</em> file. If the user exists AND is 
     * active AND the passwords match (by way of hash comparison) then the user 
     * is considered valid.
     * 
     * @param string $email The user's e-mail used to identify him.
     * @param string $password The user's password, not the hash.
     * @return User The authenticated user or null if the authentication fails.
     */
    public static function login($email, $password) {
        $file = new XMLFile(DATAROOT . '/settings/users.xml');

        foreach ($file->user as $user) {
            if (strval($user->email) === $email) {
                if (intval($user->active) && strval($user->password) === User::getPasswordHash($password, Config::getInstance()->get('system.hash'))) {
                    return new User(strval($user->name), '', $email, 1);
                }
                return null;
            }
        }

        return null;
    }

}

