<?php

class PasswordForm extends CFormModel {

    public $current;
    public $password;
    public $password_repeat;

    public function __construct($scenario = '') {
        parent::__construct($scenario);
    }

    public function rules() {
        return array(
            array('current, password, password_repeat', 'required'),
            array('current', 'confirm'),
            array('password', 'compare')
        );
    }

    public function confirm($attribute, $params) {
        return (User::model()->find('userId = :id AND password = :pwd', array(
                    ':id' => Yii::app()->user->id,
                    ':pwd' => sha1($attribute . Yii::app()->params['hash']))
                ) !== null);
    }

    public function attributeLabels() {
        return array(
            'current' => 'Current Password',
            'password' => 'New Password',
            'password_repeat' => 'Repeat Password',
        );
    }

}
