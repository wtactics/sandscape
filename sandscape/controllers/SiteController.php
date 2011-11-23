<?php

/* SiteController.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
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
 * 
 * @since 1.0, Sudden Growth
 */
class SiteController extends AppController {

    /**
     * Loads the home page.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionIndex() {
        $this->render('pages/home');
    }

    /**
     * Loads the about page.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionAbout() {
        $this->render('pages/about');
    }

    /**
     * Loads the attribution page with all the credits.
     * 
     * @since 1.3, Soulharvester
     */
    public function actionAttribution() {
        $this->render('pages/attribution');
    }

    /**
     * Allows users to login and to register new accounts.
     * Registration and authentication are handle in the same action since they 
     * are made in the same view.
     * 
     * @since 1.0, Sudden Growth
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

    public function actionRecoverPassword() {
        //TODO: not implemented yet, incomplete
        $recover = new RecoverForm();
        if (isset($_POST['RecoverForm'])) {
            $recover->attributes = $_POST['RecoverForma'];
            if ($recover->validate() && $recover->recover()) {
                $this->redirect('site/login');
            }
        }

        $this->render('lostpwd', array('recover' => $recover));
    }

    public function actionError() {
        //TODO: not implemented yet, proper error handling
        if (($error = Yii::app()->errorHandler->error)) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Site access rules allow for every action without restriction, except for 
     * the <em>logout</em> action.
     * 
     * @return array The new rules array.
     * 
     * @since 1.0, Sudden Growth
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'about', 'login', 'recoverPassword',
                            'error', 'attribution'),
                        'users' => array('*')
                    ),
                    array('allow',
                        'actions' => array('logout'),
                        'users' => array('@')
                    )
                        ), parent::accessRules());
    }

}