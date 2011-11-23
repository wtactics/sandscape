<?php

/* Dice.php
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
 * @property int $diceId
 * @property string $name
 * @property int $face
 * @property int $enabled
 * @property int $active
 *
 * Relations:
 * @property Games[] $games
 * 
 * @since 1.2, Elvish Shaman
 */
class Dice extends CActiveRecord {

    /**
     * @return Dice
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Dice';
    }

    public function rules() {
        return array(
            array('face, name', 'required'),
            array('name', 'length', 'max' => 150),
            array('face, enabled', 'numerical', 'integerOnly' => true),
            //search
            array('name, face, enabled', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'games' => array(self::MANY_MANY, 'Game', 'GameDice(gameId, diceId)'),
        );
    }

    public function attributeLabels() {
        return array(
            'diceId' => 'ID',
            'name' => 'Name',
            'enabled' => 'Enabled',
            'face' => 'Nr. Faces',
            'enabled' => 'Available for play'
        );
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('face', $this->face);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('Dice', array('criteria' => $criteria));
    }

}