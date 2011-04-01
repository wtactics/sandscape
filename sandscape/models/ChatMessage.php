<?php

/**
 * This is the model class for table "ChatMessage".
 *
 * The followings are the available columns in table 'ChatMessage':
 * @property string $messageId
 * @property string $message
 * @property string $sent
 * @property string $userId
 * @property string $chatId
 *
 * The followings are the available model relations:
 * @property Chat $chat
 * @property User $user
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
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('message, sent, userId, chatId', 'required'),
            array('message', 'length', 'max' => 255),
            array('userId, chatId', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('messageId, message, sent, userId, chatId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'chat' => array(self::BELONGS_TO, 'Chat', 'chatId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'messageId' => 'Message',
            'message' => 'Message',
            'sent' => 'Sent',
            'userId' => 'User',
            'chatId' => 'Chat',
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
        $criteria->compare('message', $this->message, true);
        $criteria->compare('sent', $this->sent, true);
        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('chatId', $this->chatId, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

}