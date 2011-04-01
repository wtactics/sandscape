<?php

/**
 * This is the model class for table "Game".
 *
 * The followings are the available columns in table 'Game':
 * @property string $gameId
 * @property string $playerA
 * @property string $playerB
 * @property string $created
 * @property string $started
 * @property string $ended
 * @property integer $running
 * @property string $deckA
 * @property string $deckB
 * @property string $hash
 * @property string $chatId
 * @property integer $private
 *
 * The followings are the available model relations:
 * @property Chat $chat
 * @property Deck $deckA0
 * @property Deck $deckB0
 * @property User $playerA0
 * @property User $playerB0
 * @property Win[] $wins
 */
class Game extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Game the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Game';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('playerA, created, hash, chatId', 'required'),
            array('running, private', 'numerical', 'integerOnly' => true),
            array('playerA, playerB, deckA, deckB, chatId', 'length', 'max' => 10),
            array('hash', 'length', 'max' => 8),
            array('started, ended', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('gameId, playerA, playerB, created, started, ended, running, deckA, deckB, hash, chatId, private', 'safe', 'on' => 'search'),
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
            'deckA0' => array(self::BELONGS_TO, 'Deck', 'deckA'),
            'deckB0' => array(self::BELONGS_TO, 'Deck', 'deckB'),
            'playerA0' => array(self::BELONGS_TO, 'User', 'playerA'),
            'playerB0' => array(self::BELONGS_TO, 'User', 'playerB'),
            'wins' => array(self::HAS_MANY, 'Win', 'gameId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'gameId' => 'Game',
            'playerA' => 'Player A',
            'playerB' => 'Player B',
            'created' => 'Created',
            'started' => 'Started',
            'ended' => 'Ended',
            'running' => 'Running',
            'deckA' => 'Deck A',
            'deckB' => 'Deck B',
            'hash' => 'Hash',
            'chatId' => 'Chat',
            'private' => 'Private',
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

        $criteria->compare('gameId', $this->gameId, true);
        $criteria->compare('playerA', $this->playerA, true);
        $criteria->compare('playerB', $this->playerB, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('started', $this->started, true);
        $criteria->compare('ended', $this->ended, true);
        $criteria->compare('running', $this->running);
        $criteria->compare('deckA', $this->deckA, true);
        $criteria->compare('deckB', $this->deckB, true);
        $criteria->compare('hash', $this->hash, true);
        $criteria->compare('chatId', $this->chatId, true);
        $criteria->compare('private', $this->private);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

}