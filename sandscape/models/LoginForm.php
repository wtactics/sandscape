<?php

class LoginForm extends CFormModel {

    public $email;
    public $password;
    public $rememberMe;
    private $identity;

    public function rules() {
        return array(
            array('email, password', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels() {
        return array(
            'email' => 'E-mail',
            'password' => 'Password',
            'rememberMe' => 'Remember me next time'
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->identity = new Identity($this->email, $this->password);
            switch ($this->identity->authenticate()) {
                case CUserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                    Yii::app()->user->login($this->identity, $duration);
                    return true;
                case CUserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError('email', 'Email address is incorrect.');
                    break;
                case CUserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError('password', 'Wrong password.');
                    break;
            }
        }

        return false;
    }

}
