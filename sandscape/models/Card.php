<?php

/**
 * This is the model class for table "Card".
 *
 * The followings are the available columns in table 'Card':
 * @property string $cardId
 * @property string $faction
 * @property string $type
 * @property string $subtype
 * @property integer $cost
 * @property string $threshold
 * @property integer $attack
 * @property integer $defense
 * @property string $rules
 * @property string $author
 * @property string $revision
 * @property integer $cardscapeId
 * @property string $imageId
 * @property integer $private
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Cardimage $image
 * @property User[] $users
 */
class Card extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Card the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Card';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rules, author, imageId', 'required'),
            array('cost, attack, defense, cardscapeId, private, active', 'numerical', 'integerOnly' => true),
            array('faction, type, subtype', 'length', 'max' => 150),
            array('threshold, author', 'length', 'max' => 100),
            array('rules', 'length', 'max' => 255),
            array('imageId', 'length', 'max' => 10),
            array('revision', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('cardId, faction, type, subtype, cost, threshold, attack, defense, rules, author, revision, cardscapeId, imageId, private, active', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'image' => array(self::BELONGS_TO, 'Cardimage', 'imageId'),
            'users' => array(self::MANY_MANY, 'User', 'Create(cardId, userId)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'cardId' => 'Card',
            'faction' => 'Faction',
            'type' => 'Type',
            'subtype' => 'Subtype',
            'cost' => 'Cost',
            'threshold' => 'Threshold',
            'attack' => 'Attack',
            'defense' => 'Defense',
            'rules' => 'Rules',
            'author' => 'Author',
            'revision' => 'Revision',
            'cardscapeId' => 'Cardscape',
            'imageId' => 'Image',
            'private' => 'Private',
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

        $criteria->compare('cardId', $this->cardId, true);
        $criteria->compare('faction', $this->faction, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('subtype', $this->subtype, true);
        $criteria->compare('cost', $this->cost);
        $criteria->compare('threshold', $this->threshold, true);
        $criteria->compare('attack', $this->attack);
        $criteria->compare('defense', $this->defense);
        $criteria->compare('rules', $this->rules, true);
        $criteria->compare('author', $this->author, true);
        $criteria->compare('revision', $this->revision, true);
        $criteria->compare('cardscapeId', $this->cardscapeId);
        $criteria->compare('imageId', $this->imageId, true);
        $criteria->compare('private', $this->private);
        $criteria->compare('active', $this->active);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

}