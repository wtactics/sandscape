<?php

class Win extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userId, gameId', 'required'),
            array('userId, gameId', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('userId, gameId', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'game' => array(self::BELONGS_TO, 'Game', 'gameId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

    /**
      public function attributeLabels() {
      return array(
      'userId' => 'User',
      'gameId' => 'Game',
      );
      } */
}