<?php

class PasswordForm extends CFormModel {

    public $password;
    public $password_repeat;

    public function __construct($scenario = '') {
        parent::__construct($scenario);
    }

    public function rules() {
        return array(
            array('password, password_repeat', 'required'),
            array('password', 'compare')
        );
    }

    public function attributeLabels() {
        return array(
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
        );
    }

}
