<?php

/* ChatMessage.php
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

/**
 * This is the model class for table "ChatMessage".
 *
 * The followings are the available columns in table 'ChatMessage':
 * @property string $messageId
 * @property string $message
 * @property string $sent
 * @property string $userId
 * @property string $gameId
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Game $game
 */
class ChatMessage extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return ChatMessage the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ChatMessage';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'game' => array(self::BELONGS_TO, 'Game', 'gameId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'messageId' => 'ID',
            'message' => 'Message',
            'sent' => 'Sent',
            'userId' => 'Author',
            'gameId' => 'Game',
        );
    }

}