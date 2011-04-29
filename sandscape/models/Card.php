<?php
/*
 * Controller.php
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
 */
class Card extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array(
            'cardId' => 'ID',
            'name' => 'Name',
            'faction' => 'Faction',
            'type' => 'Type',
            'subtype' => 'Subtype',
            'cost' => 'Cost',
            'threshold' => 'Threshold',
            'attack' => 'Attack',
            'defense' => 'Defense',
            'rules' => 'Rules',
            'author' => 'Author',
            'revision' => 'Revision',
            'cardscapeId' => 'Cardscape ID',
            'imageId' => 'Image ID',
            'private' => 'Private',
            'active' => 'Active'
        );
    }

    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('name, rules', 'required'),
            array('cost, attack, defense, cardscapeId, private, active', 'numerical', 'integerOnly' => true),
            array('name, faction, type, subtype', 'length', 'max' => 150),
            array('threshold, author', 'length', 'max' => 100),
            array('rules', 'length', 'max' => 255),
            array('imageId', 'length', 'max' => 10),
            array('revision', 'safe'),
            // The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('name, faction, type, subtype, cost, threshold, attack, defense, rules, author, cardscapeId, private', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'image' => array(self::BELONGS_TO, 'Cardimage', 'imageId'),
            'users' => array(self::MANY_MANY, 'User', 'Create(cardId, userId)'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria();
        $criteria->order = 'name ASC';

        $criteria->compare('name', $this->name, true);
        $criteria->compare('faction', $this->faction, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('subtype', $this->subtype, true);
        $criteria->compare('cost', $this->cost);
        $criteria->compare('threshold', $this->threshold);
        $criteria->compare('attack', $this->attack);
        $criteria->compare('defense', $this->defense);
        $criteria->compare('rules', $this->rules, true);
        $criteria->compare('author', $this->author, true);
        $criteria->compare('cardscapeId', $this->cardscapeId);
        $criteria->compare('private', $this->private);
        $criteria->compare('active', 1);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }
}