<?php

/**
 * @property string $email
 * @property string $password
 * @property int $rememberMe
 */
class LoginForm extends CFormModel {

    public $email;
    public $password;
    public $rememberMe;
    private $identity;

    public function rules() {
        return array(
            array('email, password', 'required'),
            array('email', 'email'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels() {
        return array(
            'email' => Yii::t('sandscape', 'E-mail'),
            'password' => Yii::t('sandscape', 'Password'),
            'rememberMe' => Yii::t('sandscape', 'Remember me'),
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->identity = new UserIdentity($this->email, $this->password);
            if (!$this->identity->authenticate()) {
                $this->addError('password', Yii::t('sandscape', 'Incorrect e-mail or password.'));
            }
        }
    }

    public function login() {
        if ($this->validate()) {

            if ($this->identity === null) {
                $this->identity = new UserIdentity($this->email, $this->password);
                $this->identity->authenticate();
            }

            if ($this->identity->errorCode === Credentials::ERROR_NONE) {
                //remember for 7 days
                $duration = $this->rememberMe ? 3600 * 24 * 7 : 0;
                Yii::app()->user->login($this->identity, $duration);

                return true;
            }
        }

        return false;
    }

}
