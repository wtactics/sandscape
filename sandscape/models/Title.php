<?php

/* Title.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
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
 * @property int $titleId
 * @property string $description
 * @property int $active
 *
 * Relations:
 * @property User[] $users
 */
class Title extends CActiveRecord {

    /**
     * @return Title
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Title';
    }

    public function rules() {
        return array(
            array('description', 'required'),
            array('description', 'length', 'max' => 150),
            //search
            array('description', 'safe', 'on' => 'search')
        );
    }

    public function relations() {
        return array(
            'users' => array(self::MANY_MANY, 'USer', 'UserTitle(userId, titleId)'),
        );
    }

    public function attributeLabels() {
        return array(
            'titleId' => 'ID',
            'description' => 'Description'
        );
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('description', $this->description, true);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('Title', array('criteria' => $criteria));
    }

}