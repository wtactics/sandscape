<?php

/* PasswordForm.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011, the Sandscape team.
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
 * The <em>PasswordForm</em> may be used whenever a password change is made by the user.
 * 
 * Attributes for <em>PasswordForm</em>:
 * @property string $current The current password for the user that is changing the password.
 * @property string $password The new password.
 * @property string $password_repeat The new password repeated for validation purposes.
 * 
 * @since 1.0, Sudden Growth
 */
class PasswordForm extends CFormModel {

    public $current;
    public $password;
    public $password_repeat;

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
        if (User::model()->find('userId = :id AND password = :pwd', array(
                    ':id' => Yii::app()->user->id,
                    ':pwd' => User::hash($this->current))
                ) === null) {
            $this->addError($attribute, 'Invalid password.');
        }
    }

    public function attributeLabels() {
        return array(
            'current' => 'Current Password',
            'password' => 'New Password',
            'password_repeat' => 'Repeat Password',
        );
    }

}
