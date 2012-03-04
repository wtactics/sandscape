<?php

/* Reward.php
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
 * @property int $rewardId
 * @property string $description
 * @property string $icon
 * @property int $reusable
 * @property int $active
 *
 * Relations:
 * @property User[] $users
 * 
 * @since 1.4, Serenitu
 */
class Reward extends CActiveRecord {

    /**
     * @return Reward
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Reward';
    }

    public function rules() {
        return array(
            array('description', 'required'),
            array('description', 'length', 'max' => 150),
            array('icon', 'length', 'max' => 255),
            array('reusable', 'numerical', 'integerOnly' => true),
            //search
            array('description', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'users' => array(self::MANY_MANY, 'User', 'UserReward(userId, rewardId)'),
        );
    }

    public function attributeLabels() {
        return array(
            'rewardId' => 'ID',
            'description' => 'Description',
            'reusable' => 'Reusable'
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

        return new CActiveDataProvider('Reward', array('criteria' => $criteria));
    }

}