<?php

class Page extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, body, updated', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            //array('title, body', 'safe', 'on' => 'search'),
        );
    }
    
    public function __toString() {
         return $this->body;
    }

}
