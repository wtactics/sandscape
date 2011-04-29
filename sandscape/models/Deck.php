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
     * Searches the database for records that match the given criteria. It is 
     * used mainly in grids.
     * 
     * @return CActiveDataProvider with all the found records.
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