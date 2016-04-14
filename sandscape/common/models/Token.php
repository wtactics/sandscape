<?php

/* Token.php
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
 * A token is an image attached to a card while playing a game. The token as no 
 * meaning to the game engine and users can use tokens for whatever rule they 
 * want. Tokens will be placed above the card's image.
 * 
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property integer $active
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
final class Token extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Token';
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
//            'id' => Yii::t('token', 'ID'),
//            'name' => Yii::t('token', 'Name'),
//            'image' => Yii::t('token', 'Image'),
//            'description' => Yii::t('token', 'Description')
//        );
//    }
}
