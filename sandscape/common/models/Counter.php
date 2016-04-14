<?php

/* Counter.php
 *  
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2016, WTactics Project <http://wtactics.org>
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

namespace common\models;

/**
 * //TODO: documentation
 * 
 * @property integer $id
 * @property string $name
 * @property integer $starValue
 * @property integer $step
 * @property integer $enabled
 * @property string $description
 * @property integer $active
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
final class Counter extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Counter';
    }

//    public function rules() {
//        return array(
//            array('name, startValue, step, enabled', 'required'),
//            array('name', 'length', 'max' => 150),
//            array('startValue, step', 'numerical', 'integerOnly' => true),
//            array('enabled', 'boolean'),
//            //search
//            array('name, startValue, enabled', 'safe', 'on' => 'search'),
//        );
//    }
//    public function attributeLabels() {
//        return array(
//            'id' => Yii::t('counter', 'ID'),
//            'name' => Yii::t('counter', 'Name'),
//            'startValue' => Yii::t('counter', 'Start value'),
//            'step' => Yii::t('counter', 'Step'),
//            'description' => Yii::t('counter', 'Description'),
//            'enabled' => Yii::t('counter', 'Available to play'),
//        );
//    }
}
