<?php

/* SiteController.php
 * 
 * This file is part of SandScape.
 *
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 */

class SiteController extends AppController {

    public function actionIndex() {
        $this->render('pages/home');
    }

    public function actionAbout() {
        $this->render('pages/about');
    }

    public function actionLogin() {
        $login = new LoginForm();
        $register = new RegisterForm();

        if (isset($_POST['LoginForm'])) {
            $login->attributes = $_POST['LoginForm'];
            if ($login->validate() && $login->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        } else if (isset($_POST['RegisterForm'])) {
            $register->attributes = $_POST['RegisterForm'];
            if ($register->validate() && $register->register()) {
                //TODO: don't redirect, just show success messages
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        $this->render('login', array('login' => $login, 'register' => $register));
    }

    public function actionLogout() {
        if (($sd = SessionData::model()->findByPk(Yii::app()->user->id)) !== null) {
            $sd->delete();
        }

        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    //TODO: incomplete
    public function actionLostPassword() {
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
        //TODO: proper error handling, view doesn't exist
        if (($error = Yii::app()->errorHandler->error)) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

}