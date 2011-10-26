<?php

/* Dice.php
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
 * @property integer $diceId
 * @property string $name
 * @property integer $face
 * @property integer $enabled
 * @property integer $active
 *
 * Relations:
 * @property Games[] $games
 * 
 * @since 1.2, Elvish Shaman
 */
class Dice extends CActiveRecord {

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
            array('name, face', 'safe', 'on' => 'search'),
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
            'face' => 'Nr. Faces'
        );
    }

    /**
     * //TODO: ...
     * 
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('face', $this->face);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('Dice', array('criteria' => $criteria));
    }

}