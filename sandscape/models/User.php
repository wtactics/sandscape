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

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'User';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, password, email', 'required'),
            array('emailVisibility, acceptMessages, admin, active', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 20),
            array('password, key', 'length', 'max' => 40),
            array('email', 'length', 'max' => 200),
            array('visited', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('userId, name, password, email, key, visited, emailVisibility, acceptMessages, admin, active', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'userId' => 'User',
            'name' => 'Name',
            'password' => 'Password',
            'email' => 'Email',
            'key' => 'Key',
            'visited' => 'Visited',
            'emailVisibility' => 'Email Visibility',
            'acceptMessages' => 'Accept Messages',
            'admin' => 'Admin',
            'active' => 'Active',
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

        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('visited', $this->visited, true);
        $criteria->compare('emailVisibility', $this->emailVisibility);
        $criteria->compare('acceptMessages', $this->acceptMessages);
        $criteria->compare('admin', $this->admin);
        $criteria->compare('active', $this->active);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

}