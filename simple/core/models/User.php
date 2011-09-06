<?php

/*
 * User.php
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
 * The User class represents a user and stores all user related information. It 
 * is created by reading the <em>users.xml</em> file and used when editing or 
 * creating a user.
 */
class User {

    private $name;
    private $password;
    private $email;
    private $active;

    /**
     * Creates a new user. This class offers no writable property.
     * 
     * @param string $name
     * @param string $password
     * @param string $email
     * @param integer $active 
     */
    public function __construct($name = '', $password = '', $email = '', $active = 1) {
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
        $this->active = (bool) $active;

        $this->id = self::generateId($this->email);
    }

    /**
     * Returns the user's name.
     * 
     * @return string The name of this user or an empty string.
     */
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns the user's password. A password is a SHA1 hash stored for this 
     * user.
     * 
     * @return string The password for this user or an empty string.
     */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Returns the user's e-mail address.
     * 
     * @return string The user's e-mail or an empty string.
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Setting the e-mail will trigger an ID regeneration.
     * @param type $email 
     */
    public function setEmail($email) {
        $this->email = $email;
        $this->id = self::generateId($this->email);
    }

    /**
     * Returns the flag that indicates that the user is active and is able to 
     * login into the system.
     * 
     * @return integer Returns 1 (one) if the user is active or 0 (zero) otherwise. 
     */
    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = (bool) $active;
    }

    /**
     * Returns a string that identifies the user using a CRC32 hash.
     * 
     * @return string The user's CRC32 hash. 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Generates a CRC32 hash, converted to hexadecimal, that allows easy 
     * identification of users. The hash is created using the user's e-mail, the 
     * only information that is unique, and makes possible to identify a user 
     * through the various requests made to the system.
     * 
     * @param string $email The e-mail address used to create the hash.
     * @return string A CRC32 hash formated for hexadecimal.
     */
    public static function generateId($email = null) {
        if (!$email) {
            $email = $this->email;
        }

        return dechex(sprintf('%u', crc32($email)));
    }

    /**
     * Generates a password hash with the current hash method used by this user.
     * 
     * @param string $password The password to hash.
     * @param string $extra The extra value to append to a password value.
     * @return string The resulting hash string.
     */
    public static function getPasswordHash($password, $extra = null) {
        if ($extra) {
            return sha1($password . $extra);
        }
        return sha1($password);
    }

}
