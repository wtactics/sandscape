<?php

/* Card.php
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
 * @property string $rules
 * @property string $face
 * @property string $back
 * @property string $backFrom //TODO: revise
 * @property integer $active
 * 
 * @property Deck[] $decks
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
final class Card extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Card';
    }

//    public function rules() {
//        return array(
//            array('name', 'required'),
//            array('name, face, back', 'length', 'max' => 255),
//            array('backFrom', 'in', 'range' => array('default', 'own', 'deck')),
//            array('cardscapeRevisionId', 'numerical', 'integerOnly' => true),
//            array('cardscapeRevisionId', 'default', 'setOnEmpty' => true, 'value' => null),
//            //search
//            array('name, cardscapeRevisionId', 'safe', 'on' => 'search'),
//        );
//    }
//    public function attributeLabels() {
//        return array(
//            'cardId' => Yii::t('card', 'ID'),
//            'name' => Yii::t('card', 'Card Name'),
//            'rules' => Yii::t('card', 'Card Rules'),
//            'face' => Yii::t('card', 'Card Face'),
//            'back' => Yii::t('card', 'Card Back'),
//            'backFrom' => Yii::t('card', 'Use Back From'),
//            'cardscapeRevisionId' => Yii::t('carde', 'Cardscape ID'),
//        );
//    }
//    public final static function backOriginsArray() {
//        return array(
//            'default' => Yii::t('card', 'System Default'),
//            'own' => Yii::t('card', 'Uploaded File'),
//            'deck' => Yii::t('card', 'Use Deck Image')
//        );
//    }
//
//    public function backOriginString() {
//        $origins = self::backOriginsArray();
//        return $origins[$this->backFrom];
//    }
}
