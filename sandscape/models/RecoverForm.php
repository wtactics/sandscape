<?php

class RecoverForm extends CFormModel {

    public $email;

    public function __construct($scenario = '') {
        parent::__construct($scenario);
    }

    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email')
        );
    }

    public function attributeLabels() {
        return array(
            'email' => 'Registration E-mail',
        );
    }

    public function recover() {
        
    }

}
