<?php

class Message extends CActiveRecord {

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }

    public function relations() {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'userId'),
            'game' => array(self::BELONGS_TO, 'Game', 'gameId')
        );
    }

}