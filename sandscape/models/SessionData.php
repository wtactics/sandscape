<?php

/**
 * @property integer $userId
 * @property string $token
 * @property string $tokenExpires
 * @property string $lastActivity
 */
class SessionData extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'SessionData';
    }

}