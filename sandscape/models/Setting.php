<?php

/* Setting.php
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
 * Model class for the <strong>Setting</strong> table. Stores system wide settings.
 * 
 * Properties for the <em>Setting</em> class:
 * 
 * @property string $key The setting name, identifies this setting
 * @property string $value The setting value
 * @property string $description A text description that explains what this setting does
 * 
 * @since 1.1, Green Shield
 */
class Setting extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('value', 'required'),
            array('value, description', 'length', 'max' => 255)
        );
    }

    public function tableName() {
        return 'Setting';
    }

}