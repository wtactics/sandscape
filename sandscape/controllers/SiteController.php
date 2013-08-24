<?php

/* SiteController.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The <em>SiteController</em> handles general website related information like 
 * static pages, login, logout and registration action.
 */
class SiteController extends ApplicationController {

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'login', 'recoverPassword', 'error'),
                'users' => array('*')
            ),
            array(
                'allow',
                'actions' => array('logout'),
                'users' => array('@')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }

    /**
     * Loads the home page.
     */
    public function actionIndex() {
        $this->render('index');
    }

    /**
     * Allows users to login and to register new accounts.
     * Registration and authentication are handle in the same action since they 
     * are made in the same view.
     */
    public function actionLogin() {
        $login = new LoginForm();
        $register = new RegisterForm();

        $this->performAjaxValidation('register-form', $register);

        if (isset($_POST['LoginForm'])) {
            $login->attributes = $_POST['LoginForm'];
            if ($login->validate() && $login->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        } else if (isset($_POST['RegisterForm'])) {
            $register->attributes = $_POST['RegisterForm'];
            if ($register->validate() && $register->register()) {
                $login->email = $register->email;
                $login->password = $register->password;

                if ($login->login()) {
                    $this->redirect(Yii::app()->user->returnUrl);
                } else {
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('login', array('login' => $login, 'register' => $register));
    }

    /**
     * Action to remove a logged in user.
     */
    public function actionLogout() {
        if (($sd = SessionData::model()->findByPk(Yii::app()->user->id)) !== null) {
            $sd->delete();
        }

        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Allows a user to recover a lost password.
     * 
     * @throws CException If anything prevents the system from sending the new 
     * password to the user's e-mail address.
     * 
     * @throws CHttpException If the e-mail doesn't exist or no user could be 
     * found.
     */
    public function actionRecoverPassword() {
        //TODO: make into template
//        $recover = new RecoverForm();
//        if (isset($_POST['RecoverForm'])) {
//            $recover->attributes = $_POST['RecoverForma'];
//            if ($recover->validate()) {
//                if (($setting = Setting::model()->findByPk('sysemail')) !== null && $setting->value != '') {
//                    $from = $setting->value;
//
//                    $user = User::model()->find('email = :e', array(':e' => $recover->email));
//
//                    if ($user) {
//                        $password = User::randomPassword();
//                        $user->password = User::hash($password);
//                        if ($user->save()) {
//                            Yii::import('ext.email.*');
//
//                            $mailer = new PHPMailer();
//                            $mailer->AddAddress($user->email, $user->name);
//                            $mailer->From = $from;
//                            $mailer->Subject = Yii::t('sandscape', 'Password reset by administrator');
//                            $mailer->Body = Yii::t('sandscape', "An administrator reset your password. Your new password is: {password} \n\nSent by SandScape, please don't replay to this e-mail.", array('{password}' => $password));
//
//                            try {
//                                $mailer->Send();
//                                $this->redirect('site/login');
//                            } catch (phpmailerException $pe) {
//                                throw new CException(Yii::t('sandscape', 'Unable to send new password to user\'s e-mail address.'));
//                            }
//                        }
//                    } else {
//                        throw new CHttpException(400, Yii::t('sandscape', 'Invalid request. Please do not repeat this request again.'));
//                    }
//                } else {
//                    throw new CException(Yii::t('sandscape', 'Unable to reset the user\'s password.'));
//                }
//            }
//        }
//
//        $this->render('lostpwd', array('recover' => $recover));
    }

    /**
     * Shows system errors and exception.
     * 
     * @since 1.3, Soulharvester 
     */
    public function actionError() {
        if (($error = Yii::app()->errorHandler->error)) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

}
