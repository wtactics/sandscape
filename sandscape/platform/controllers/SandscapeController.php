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

namespace app\controllers;

/**
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
final class SandscapeController extends \yii\web\Controller {
//TODO: ...
//    /**
//     * @inheritdoc
//     */
//    public function behaviors() {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [ 'allow' => false, 'roles' => ['?']],
//                    [
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            return true;
//                        }
//                    ],
//                    [ 'allow' => true, 'roles' => ['@']],
//                ]
//            ]
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex() {
        return $this->render('dashboard');
    }

    public function actionLogin() {
//        $login = new LoginForm();
//        if (isset($_POST['LoginForm'])) {
//            $login->attributes = $_POST['LoginForm'];
//            if ($login->login()) {
//                if (Yii::app()->user->returnUrl) {
//                    $this->redirect(Yii::app()->user->returnUrl);
//                } else {
//                    $this->redirect(array('dashboard'));
//                }
//            }
//        }
//
//        $this->render('login', array('login' => $login));
    }

    public function actionLogout() {
//        Yii::app()->user->logout();
//        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionDashboard() {
        return $this->render('dashboard');
    }

    public function actionRegister() {
//        $register = new RegisterForm();
//        if (isset($_POST['RegisterForm'])) {
//            $register->attributes = $_POST['RegisterForm'];
//            if ($register->register()) {
//                //TODO: show success message;
//            }
//        }
//
//        $this->render('register', array('register' => $register));
    }

}
