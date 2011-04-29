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
/**
 * This is the model class for table "Chat".
 *
 * The followings are the available columns in table 'Chat':
 * @property string $chatId
 * @property string $started
 *
 * The followings are the available model relations:
 * @property ChatMessage[] $chatMessages
 * @property Game[] $games
 * @property User[] $users
 */
class Chat extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Chat the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Chat';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'chatMessages' => array(self::HAS_MANY, 'ChatMessage', 'chatId'),
            'games' => array(self::HAS_MANY, 'Game', 'chatId'),
            'users' => array(self::MANY_MANY, 'User', 'Participate(chatId, userId)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'chatId' => 'Chat',
            'started' => 'Started',
        );
    }

    /**
     * Searches the database for records that match the given criteria. It is 
     * used mainly in grids.
     * 
     * @return CActiveDataProvider with all the found records.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('chatId', $this->chatId, true);
        $criteria->compare('started', $this->started, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

}