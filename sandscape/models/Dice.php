<?php

/* Dice.php
 *  
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2014, Sérgio Lopes <knitter@wtactics.org>
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
 * @property integer $id
 * @property integer $face
 * @property string $name
 * @property integer $description
 * @property integer $enabled
 * @property integer $active
 */
class Dice extends CActiveRecord {

    /**
     * @return Dice
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{Dice}}';
    }

    public function rules() {
        return array(
            array('face, name, enabled', 'required'),
            array('name', 'length', 'max' => 150),
            array('face', 'numerical', 'integerOnly' => true),
            array('description', 'safe'),
            array('enabled', 'boolean'),
            //search
            array('name, face, enabled', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('dice', 'ID'),
            'name' => Yii::t('dice', 'Name'),
            'face' => Yii::t('dice', 'Number of Faces'),
            'description' => Yii::t('dice', 'Description'),
            'enabled' => Yii::t('dice', 'Can be used in games')
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

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

}
