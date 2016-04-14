<?php

/* Deck.php
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
 * @property string $createdOn
 * @property string $back
 * @property int $ownerId
 * @property int $active
 *
 * @property User $user
 * @property Card[] $cards
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project 
 */
final class Deck extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Deck';
    }

//    public function rules() {
//        return array(
//            array('name', 'required'),
//            array('name, back', 'length', 'max' => 255),
//            array('ownerId', 'numerical', 'integerOnly' => true),
//            //search
//            array('name, createdOn', 'safe', 'on' => 'search'),
//        );
//    }
//    public function relations() {
//        return array(
//            'user' => array(self::BELONGS_TO, 'User', 'ownerId'),
//            'cards' => array(self::MANY_MANY, 'Card', 'DeckCard(deckId, cardId)')
//        );
//    }
//    public function attributeLabels() {
//        return array(
//            'id' => Yii::t('deck', 'ID'),
//            'name' => Yii::t('deck', 'Name'),
//            'createdOn' => Yii::t('deck', 'Created On'),
//            'back' => Yii::t('deck', 'Back Image'),
//            'userId' => Yii::t('deck', 'Owner')
//        );
//    }
}
