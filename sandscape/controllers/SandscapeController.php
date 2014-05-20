<?php

/* SandscapeController.php
 *  
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2014, Sérgio Lopes <knitter@wtactics.org>
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

class SandscapeController extends BaseController {

//    public function accessRules() {
//        return array(
//            array(
//                'allow',
//                'actions' => array('index', 'login', 'recoverPassword', 'error'),
//                'users' => array('*')
//            ),
//            array(
//                'allow',
//                'actions' => array('logout'),
//                'users' => array('@')
//            ),
//            array(
//                'deny',
//                'users' => array('*')
//            )
//        );
//    }


    public function actionIndex() {
        $this->render('index');
    }

    public function actionLogin() {
//        $login = new LoginForm();
//        $register = new RegisterForm();
//
//        $this->performAjaxValidation('register-form', $register);
//
//        if (isset($_POST['LoginForm'])) {
//            $login->attributes = $_POST['LoginForm'];
//            if ($login->validate() && $login->login()) {
//                $this->redirect(Yii::app()->user->returnUrl);
//            }
//        } else if (isset($_POST['RegisterForm'])) {
//            $register->attributes = $_POST['RegisterForm'];
//            if ($register->validate() && $register->register()) {
//                $login->email = $register->email;
//                $login->password = $register->password;
//
//                if ($login->login()) {
//                    $this->redirect(Yii::app()->user->returnUrl);
//                } else {
//                    $this->redirect(array('index'));
//                }
//            }
//        }
//
//        $this->render('login', array('login' => $login, 'register' => $register));
    }

    public function actionLogout() {
        //if (($sd = SessionData::model()->findByPk(Yii::app()->user->id)) !== null) {
        //    $sd->delete();
        //}

        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionError() {
        if (($error = Yii::app()->errorHandler->error)) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    public function actionDashboard() {
        $this->render('dashboard');
    }

}
