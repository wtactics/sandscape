<?php

class CardImage extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('filetype, filename, filesize', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'card' => array(self::HAS_ONE, 'Card', 'imageId')
        );
    }

}
