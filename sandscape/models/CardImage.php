<?php

class CardImage extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('filetype, filename, filesize, filedata', 'required'),
            array('filetype, filename', 'length', 'max' => 200),
            array('filesize', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('imageId, filetype, filename, filesize, filedata', 'safe', 'on' => 'search'),
        );
    }

    /**
      public function relations() {
      // NOTE: you may need to adjust the relation name and the related
      // class name for the relations automatically generated below.
      return array(
      );
      } */
}
