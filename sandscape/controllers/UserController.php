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
 * http://wtactics.org
 */

/**
 * Manages users, their accounts and profiles. Does not provide user registration 
 * or login and logout actions as thoses are handled by the <em>SiteController</em>
 * class.
 * 
 * @since 1.0, Sudden Growth
 */
class UserController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * @since 1.0, Sudden Growth
     */
    public function actionIndex() {
        $filter = new User('search');
        $filter->unsetAttributes();

        if (isset($_POST['User'])) {
            $filter->attributes = $_POST['User'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * @since 1.0, Sudden Growth
     */
    public function actionCreate() {
        $new = new User();

        $this->performAjaxValidation('user-form', $new);

        if (isset($_POST['User'])) {
            $new->attributes = $_POST['User'];
            if ($new->save()) {
                $this->redirect(array('update', 'id' => $new->userId));
            }
        }

        $this->render('edit', array('user' => $new));
    }

    /**
     * Updates a user's information, this action is only available to administrators.
     * 
     * @param integer $id The user ID that we want to update.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionUpdate($id) {
        $user = $this->loadUserModel($id);

        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->redirect(array('update', 'id' => $user->userId));
            }
        }

        $this->render('edit', array('user' => $user));
    }

    /**
     * Handles the AJAX request for user deletion. Only POST requests are valid 
     * and only if the user making the request is and administrator.
     * 
     * @param integer $id User ID
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest && Yii::app()->user->class) {
            $user = $this->loadUserModel($id);
            if ($user) {
                $user->active = 0;
                $user->save();
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    //TODO: not implemented yet
    public function actionAccount() {
        $this->updateUserActivity();
        $user = $this->loadUserModel(Yii::app()->user->id);
        $this->render('account', array('user' => $user));
    }

    /**
     * Provides access to the user's profile.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionProfile() {
        $this->updateUserActivity();

        $user = $this->loadUserModel(Yii::app()->user->id);
        $passwordModel = new PasswordForm();

        $this->performAjaxValidation(
                array('profile-form', 'password-form'), array($user, $passwordModel)
        );

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->redirect(array('profile'));
            }
        } else if (isset($_POST['PasswordForm'])) {
            $passwordModel->attributes = $_POST['PasswordForm'];
            if ($passwordModel->validate()) {
                $user->password = User::hash($passwordModel->password);
                if ($user->save()) {
                    $this->redirect(array('profile'));
                }
            }
        }

        $this->render('profile', array('user' => $user, 'pwdModel' => $passwordModel));
    }

    public function actionView($id) {
        //TODO: not implemented yet!
        $user = $this->loadUserModel($id);
        $this->render('view', array('user' => $user));
    }

    /**
     * Loads a <em>User</em> model from the database
     * @param integer $id The user ID.
     * @return User The loaded user model.
     * 
     * @since 1.0, Sudden Growth
     */
    private function loadUserModel($id) {
        if (($user = User::model()->find('active = 1 AND userId = :id', array(':id' => (int) $id))) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $user;
    }

    /**
     * Overrides the default rules allowing for user actions. Authenticated users 
     * can view profile and stats information and change their own accounts.
     * 
     * Administrators are allowed to create new users, update information or 
     * delete existing users.
     * 
     * @return array Rules array.
     * 
     * @since 1.0, Sudden Growth
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('account', 'profile', 'view'),
                        'users' => array('@')
                    ),
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
