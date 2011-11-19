<?php

/* PlayerCounter.php
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
 * @property int $playerCounterId
 * @property string $name
 * @property int $starValue
 * @property int $step
 * @property int $available
 * @property int $active
 *
 * Relations:
 * @property Games[] $games
 * 
 * @since 1.3, Soulharvester
 */
class PlayerCounter extends CActiveRecord {

    /**
     * @return PlayerCounter
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'PlayerCounter';
    }

    public function rules() {
        return array(
            array('name, startValue, step, available', 'required'),
            array('name', 'length', 'max' => 255),
            array('startValue, step, available', 'numerical', 'integerOnly' => true),
            //search
            array('name, startValue, available', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'games' => array(self::MANY_MANY, 'Game', 'GamePlayerCounter(gameId, playerCounterId)'),
        );
    }

    public function attributeLabels() {
        return array(
            'playerCounterId' => 'ID',
            'name' => 'Name',
            'startValue' => 'Start value',
            'step' => 'Step',
            'available' => 'Available for play'
        );
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('startValue', $this->startValue);
        $criteria->compare('step', $this->step);
        $criteria->compare('available', $this->available);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('PlayerCounter', array('criteria' => $criteria));
    }

}