<?php

class Card extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array(
            'cardId' => 'ID',
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
            'cardscapeId' => 'Cardscape ID',
            'imageId' => 'Image ID',
            'private' => 'Private',
            'active' => 'Active'
        );
    }

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

}