<?php

/* RecoverForm.php
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
 * Model used in the recover form page. Allows users to recover their password.
 * Recovering a password will create a new password.
 * 
 * @since 1.0, Sudden Growth
 */
class RecoverForm extends CFormModel {

    public $email;

    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email')
        );
    }

    public function attributeLabels() {
        return array(
            'email' => 'Registration E-mail',
        );
    }

    public function recover() {
        //User::hash();
        //TODO: not implemented yet, need code to reset password.
    }

}
