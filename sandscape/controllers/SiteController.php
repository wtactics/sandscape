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
        $this->render('index');
    }

    public function actionError() {
        //TODO: proper error handling
        if (($error = Yii::app()->errorHandler->error)) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    public function actionLogin() {
        $login = new LoginForm();

        if (isset($_POST['LoginForm'])) {
            $login->attributes = $_POST['LoginForm'];
            if ($login->validate() && $login->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }


        $this->render('login', array('login' => $login));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}

//TODO: actions for semi-static content