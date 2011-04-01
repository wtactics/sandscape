<?php

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
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('started', 'required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('chatId, started', 'safe', 'on' => 'search'),
        );
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
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
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