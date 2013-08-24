<?php

/* Counter.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
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
 * @property int $id
 * @property string $name
 * @property int $starValue
 * @property int $step
 * @property int $enabled
 * @property string $description
 * @property int $active
 *
 * Relations:
 * @property Games[] $games
 */
class Counter extends CActiveRecord {

    /**
     * @return Counter
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{Counter}}';
    }

    public function rules() {
        return array(
            array('name, startValue, step, enabled', 'required'),
            array('name', 'length', 'max' => 150),
            array('startValue, step', 'numerical', 'integerOnly' => true),
            array('active, enabled', 'boolean'),
            //search
            array('name, startValue, enabled', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'games' => array(self::MANY_MANY, 'Game', 'GameCounter(gameId, counterId)'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('counter', 'ID'),
            'name' => Yii::t('counter', 'Name'),
            'startValue' => Yii::t('counter', 'Start value'),
            'step' => Yii::t('counter', 'Step'),
            'description' => Yii::t('counter', 'Description'),
            'enabled' => Yii::t('counter', 'Available to play'),
            'active' => Yii::t('counter', 'Step'),
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
        $criteria->compare('enabled', $this->enabled);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

    public function isEnabledString() {
        return ($this->enabled ? Yii::t('sandscape', 'Yes') : Yii::t('sandscape', 'No'));
    }

}
