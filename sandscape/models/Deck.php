<?php

/**
 * This is the model class for table "Deck".
 *
 * The followings are the available columns in table 'Deck':
 * @property string $deckId
 * @property string $userId
 * @property string $created
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Game[] $games
 */
class Deck extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Deck the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Deck';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userId, created', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('userId', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('deckId, userId, created, active', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
            'games' => array(self::HAS_MANY, 'Game', 'deckB'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'deckId' => 'Deck',
            'userId' => 'User',
            'created' => 'Created',
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

        $criteria->compare('deckId', $this->deckId, true);
        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('active', $this->active);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

}