<?php

/* UserController.php
 *  
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2016, WTactics Project <http://wtactics.org>
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
final class UserController extends \yii\web\Controller {

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

    public function actionIndex() {
//        $filter = new User('search');
//        $filter->unsetAttributes();
//
//        if (isset($_GET['User'])) {
//            $filter->attributes = $_GET['User'];
//        }
//
//        $this->render('index', array('filter' => $filter));
    }

    public function actionNew() {
//        $user = new User();
//        $this->performAjaxValidation('user-form', $user);
//
//        if (isset($_POST['User'])) {
//            $user->attributes = $_POST['User'];
//            if ($user->save()) {
//                $this->redirect(array('edit', 'id' => $user->id));
//            }
//        }
//
//        $this->render('create', array('user' => $user));
    }

    public function actionEdit($id) {
//        $user = $this->loadUserModel($id);
//        $this->performAjaxValidation('user-form', $user);
//
//        if (isset($_POST['User'])) {
//            $user->attributes = $_POST['User'];
//            if ($user->save()) {
//                $this->redirect(array('edit', 'id' => $user->id));
//            }
//        }
//
//        $this->render('update', array('user' => $user));
    }

    public function actionDelete($id) {
//        $user = $this->loadUserModel($id);
//
//        $user->active = 0;
//        $user->save();
//
//        if (!isset($_GET['ajax'])) {
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
//        }
    }

//    public function actionAccount() {
//        $user = $this->loadUserModel(Yii::app()->user->id);
//        $this->performAjaxValidation('user-form', $user);
//
//        if (isset($_POST['User'])) {
//            $user->attributes = $_POST['User'];
//            if ($user->save()) {
//                $this->redirect(array('account'));
//            }
//        }
//
//        $this->render('account', array('user' => $user));
//    }
//
//    public function actionStats($id) {
//        $user = $this->loadUserModel(Yii::app()->user->id);
//        $this->render('stats');
//    }
//
//    public function actionDecks($id) {
//        $user = $this->loadUserModel(Yii::app()->user->id);
//        $this->render('decks');
//    }

    /**
     * @param integer $id
     * 
     * @return \common\models\User
     * @throws \yii\web\NotFoundHttpException
     */
    private function findUser($id) {
        if (($user = User::findOne((int) $id)) !== null) {
            return $user;
        }

        throw new NotFoundHttpException(Yii::t('sandscape', '//TODO: ...'));
    }

}
