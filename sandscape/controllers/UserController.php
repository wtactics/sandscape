<?php

/* UserController.php
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

class UserController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $filter = new User('search');
        $filter->unsetAttributes();

        if (isset($_POST['User'])) {
            $filter->attributes = $_POST['User'];
        }

        $this->render('index', array('filter' => $filter));
    }

    public function actionCreate() {
        $new = new User();
        $this->performAjaxValidation('user-form', $new);

        if (isset($_POST['User'])) {
            $new->attributes = $_POST['User'];
            if ($new->save()) {
                //TODO: validate redirect
                $this->redirect(array('index'));
            }
        }

        $this->render('edit', array('user' => $new));
    }

    public function actionUpdate($id) {
        $user = $this->loadUserModel($id);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                //TODO: validate redirect
                $this->redirect(array('index'));
            }
        }

        $this->render('edit', array('user' => $user));
    }

    public function actionAccount() {
        $user = null;
        $this->render('account', array('user' => $user));
    }

    public function actionProfile() {
        $user = $this->loadUserModel(Yii::app()->user->id);
        $passwordModel = new PasswordForm();

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->redirect(array('profile'));
            }
        } else if (isset($_POST['PasswordForm'])) {
            //TODO: change password
            //$user->attributes = $_POST['PasswordForm'];
            //if ($user->save()) {
            //}
        }

        $this->render('profile', array('user' => $user, 'pwdModel' => $passwordModel));
    }

    private function loadUserModel($id) {
        if (($user = User::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $user;
    }

}
