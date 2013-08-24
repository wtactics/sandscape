<?php

/* UsersController.php
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
 * Manages users. Does not provide user registration or login and logout 
 * actions as thoses are handled by the <em>SiteController</em> class.
 * 
 * This class was renamed from <em>UserController</em> after all profile/account 
 * related actions were removed and only administration actions were left.
 */
class UsersController extends ApplicationController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Overrides the default rules allowing for user actions. Authenticated users 
     * can view profile and stats information and change their own accounts.
     * 
     * Administrators are allowed to create new users, update information or 
     * delete existing users.
     * 
     * @return array Rules array.
     */
    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'create', 'view', 'update'),
                'expression' => '$user->role == "administrator"'
            ),
            array(
                'allow',
                'actions' => array('profile'),
                'users' => array('@')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }

    /**
     * Loads a <em>User</em> model from the database.
     * 
     * @param integer $id The user ID.
     * @return User The loaded user model.
     */
    private function loadUserModel($id) {
        if (!($user = User::model()->findByPk((int) $id))) {
            throw new CHttpException(404, Yii::t('sandscape', 'The user you are trying to find is invalid.'));
        }
        return $user;
    }

    /**
     * Lists all existing users.
     */
    public function actionIndex() {
        $filter = new User('search');
        $filter->unsetAttributes();

        if (isset($_GET['User'])) {
            $filter->attributes = $_GET['User'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Adds a new user to the system.
     */
    public function actionCreate() {
        $user = new User();
        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->redirect(array('view', 'id' => $user->id));
            }
        }

        $this->render('create', array('user' => $user));
    }

    public function actionView($id) {
        $user = $this->loadUserModel($id);
        $this->render('view', array('user' => $user));
    }

    /**
     * Updates a user's information, this action is only available to administrators.
     * 
     * @param integer $id The user ID that we want to update.
     */
    public function actionUpdate($id) {
        $user = $this->loadUserModel($id);
        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->redirect(array('update', 'id' => $user->id));
            }
        }

        $this->render('update', array('user' => $user));
    }

    /**
     * Handles the AJAX request for user deletion. Only POST requests are valid 
     * and only if the user making the request is and administrator.
     * 
     * @param integer $id User ID
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest && Yii::app()->user->role == 'administrator') {
            $user = $this->loadUserModel($id);

            $user->active = 0;
            $user->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('sandscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionProfile() {
        $user = $this->loadUserModel(Yii::app()->user->id);
        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->redirect(array('profile'));
            }
        }

        $this->render('profile', array('user' => $user));
    }

}
