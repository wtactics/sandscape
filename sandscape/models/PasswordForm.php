<?php

/* Card.php
 * 
 * This file is part of SandScape.
 *
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 * http://wtactics.org
 */

/**
 * The <em>PasswordForm</em> may be used whenever a password change is made by the user.
 * 
 * Attributes for <em>PasswordForm</em>:
 * @property string $current The current password for the user that is changing the password.
 * @property string $password The new password.
 * @property string $password_repeat The new password repeated for validation purposes.
 * 
 * @since 1.0
 */
class PasswordForm extends CFormModel {

    public $current;
    public $password;
    public $password_repeat;

    public function __construct($scenario = '') {
        parent::__construct($scenario);
    }

    public function rules() {
        return array(
            array('current, password, password_repeat', 'required'),
            array('current', 'confirm'),
            array('password', 'compare')
        );
    }

    /**
     * Validates the old password. This method is called automatically by the 
     * validation process and is the same method that was configured in the rules
     * array.
     * 
     * @param stringe $attribute The old password.
     * @param array $params
     * 
     * @return boolean True if the old password is valid, false otherwise
     */
    public function confirm($attribute, $params) {
        return (User::model()->find('userId = :id AND password = :pwd', array(
                    ':id' => Yii::app()->user->id,
                    ':pwd' => User::hash($attribute))
                ) !== null);
    }

    public function attributeLabels() {
        return array(
            'current' => 'Current Password',
            'password' => 'New Password',
            'password_repeat' => 'Repeat Password',
        );
    }

}
