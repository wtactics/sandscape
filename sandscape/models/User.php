<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property string $userId
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $key
 * @property string $visited
 * @property integer $emailVisibility
 * @property integer $acceptMessages
 * @property integer $admin
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property ChatMessage[] $chatMessages
 * @property Card[] $cards
 * @property Deck[] $decks
 * @property Game[] $games
 * @property Message[] $messages
 * @property Chat[] $chats
 * @property Win $win
 */
class User extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('name, email', 'required'),
            array('name, email', 'unique'),
            array('emailVisibility, acceptMessages, admin, active', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 20),
            array('email', 'length', 'max' => 200),
            array('visited', 'safe'),
            // search rule
            array('name, email', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'chatMessages' => array(self::HAS_MANY, 'ChatMessage', 'userId'),
            'cards' => array(self::MANY_MANY, 'Card', 'Create(userId, cardId)'),
            'decks' => array(self::HAS_MANY, 'Deck', 'userId'),
            'games' => array(self::HAS_MANY, 'Game', 'playerB'),
            'messages' => array(self::HAS_MANY, 'Message', 'sender'),
            'chats' => array(self::MANY_MANY, 'Chat', 'Participate(userId, chatId)'),
            'win' => array(self::HAS_ONE, 'Win', 'userId'),
        );
    }

    public function attributeLabels() {
        return array(
            'userId' => 'ID',
            'name' => 'Name',
            'password' => 'Password',
            'email' => 'E-mail',
            'key' => 'Validation key',
            'visited' => 'Last Visit',
            'emailVisibility' => 'E-mail visible to',
            'acceptMessages' => 'Accept messages',
            'admin' => 'Type'
        );
    }

    public function search() {
        $criteria = new CDbCriteria();
        $criteria->order = 'name ASC';

        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('admin', $this->admin);
        $criteria->compare('active', 1);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

}