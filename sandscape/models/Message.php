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
 * This is the model class for table "Message".
 *
 * The followings are the available columns in table 'Message':
 * @property string $messageId
 * @property string $subject
 * @property string $body
 * @property string $sender
 * @property string $receiver
 *
 * The followings are the available model relations:
 * @property User $receiver0
 * @property User $sender0
 */
class Message extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Message the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Message';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('subject, body, sender, receiver', 'required'),
            array('subject', 'length', 'max' => 150),
            array('sender, receiver', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('messageId, subject, body, sender, receiver', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'receiver0' => array(self::BELONGS_TO, 'User', 'receiver'),
            'sender0' => array(self::BELONGS_TO, 'User', 'sender'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'messageId' => 'Message',
            'subject' => 'Subject',
            'body' => 'Body',
            'sender' => 'Sender',
            'receiver' => 'Receiver',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('messageId', $this->messageId, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('sender', $this->sender, true);
        $criteria->compare('receiver', $this->receiver, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

}