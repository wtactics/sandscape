<?php

/* State.php
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
 * A state, like a token, is an image that is added to the card's image while 
 * playing. And like tokens, states have no meaning in the game engine so users 
 * can use states for whatever they want.
 * 
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property int $active
 * 
 * @see Token
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
final class State extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'State';
    }

//    public function rules() {
//        return array(
//            array('name, image', 'required'),
//            array('name', 'length', 'max' => 150),
//            array('image', 'length', 'max' => 255),
//            array('description', 'safe'),
//            //search
//            array('name', 'safe', 'on' => 'search'),
//        );
//    }
//    public function attributeLabels() {
//        return array(
//            'id' => Yii::t('state', 'ID'),
//            'name' => Yii::t('state', 'Name'),
//            'image' => Yii::t('state', 'Image'),
//            'desription' => Yii::t('state', 'Description')
//        );
//    }
}
