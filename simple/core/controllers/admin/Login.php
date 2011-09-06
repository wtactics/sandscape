<?php

/*
 * Login.php
 *
 * (C) 2011, StaySimple team.
 *
 * This file is part of StaySimple.
 * http://code.google.com/p/stay-simple-cms/
 *
 * StaySimple is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * StaySimple is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with StaySimple.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Login controller provides a login page.
 */
class Login extends Administration {

    public function __construct() {
        parent::__construct('//layouts/login-layout');
    }

    public function start($params = array()) {
        if (isset($_SESSION['loginData']) && $_SESSION['loginData'] != null && $_SESSION['loginData'] != '') {
            $this->redirect('dashboard');
        }

        $this->render('login/login');
    }

    /**
     * Logs the user in.
     * 
     * If the user's credentials are correct the user is redirected to the 
     * dashboard.
     * 
     * @param array $params Default URL parameters.
     */
    public function login($params = array()) {
        if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            if (($user = UserManager::login($email, $password)) !== null) {
                $_SESSION['loginData'] = serialize($user);

                StaySimple::app()->checkUpdates();
                $this->redirect('dashboard');
            }
        }
        $this->queueMessage(new Message($this->getTranslatedString('STAY_LOGIN_INVALID_USER_PASS')), Message::$ERROR);
        $this->redirect('login');
    }

    /**
     * Logs out the user, redirecting him to the login page.
     * 
     * @param type $params Default URL parameters.
     */
    public function logout($params = array()) {
        unset($_SESSION['loginData']);
        $_SESSION['loginData'] = null;
        $this->redirect('login');
    }

    public function recover($params = array()) {

        if (isset($_POST['doRecover']) && $_POST['doRecover'] == 'doRecover') {
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $um = new UserManager();

                $found = false;
                foreach ($um->loadAll() as $user) {
                    if ($user->getEmail() === $_POST['email']) {

                        $to = $user->getEmail();

                        $old = $user->getPassword();
                        $max = strlen($old) - 1;

                        $npassword = '';
                        for ($i = 0; $i < 10; $i++) {
                            $npassword = $old[rand(0, $max)];
                        }

                        $user->setPassword(User::getPasswordHash($npassword, Config::getInstance()->get('system.hash')));
                        $um->update($user);
                        if ($um->save()) {
                            $subject = $this->getTranslatedString('STAY_LOGIN_RECOVER_EMAIL_SUBJECT', array(
                                Config::getInstance()->get('site.name'))
                            );
                            $message = $this->getTranslatedString('STAY_LOGIN_RECOVER_EMAIL_MESSAGE', array(
                                Config::getInstance()->get('site.name'),
                                $npassword
                                    )
                            );

                            $from = Config::getInstance()->get('system.email');
                            $headers = "From: {$from}\r\nX-Mailer: PHP/" . phpversion();

                            if (mail($to, $subject, $message, $headers)) {
                                $this->queueMessage(new Message($this->getTranslatedString('STAY_LOGIN_RECOVER_MAIL_SENT')));
                            } else {
                                $this->queueMessage(new Message($this->getTranslatedString('STAY_LOGIN_RECOVER_MAIL_ERROR'), Message::$ERROR));
                            }
                        } else {
                            $this->queueMessage(new Message($this->getTranslatedString('STAY_LOGIN_RECOVER_SAVE_PASS_ERROR'), Message::$ERROR));
                        }

                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $this->queueMessage(new Message($this->getTranslatedString('STAY_LOGIN_RECOVER_NO_USER'), Message::$ERROR));
                }
            } else {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_LOGIN_RECOVER_NO_MAIL_GIVEN'), Message::$ERROR));
            }
        }

        $this->render('login/recoverpass');
    }

}