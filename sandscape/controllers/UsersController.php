<?php

/* UsersController.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * Manages users. Does not provide user registration or login and logout 
 * actions as thoses are handled by the <em>SiteController</em> class.
 * 
 * This class was renamed from <em>UserController</em> after all profile/account 
 * related actions were removed and only administration actions were left.
 * 
 * @since 1.2, Elvish Shaman
 */
class UsersController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Lists all existing users.
     * 
     * @since 1.2, Elvish Shaman
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
     * Adds a new user to the system.
     * 
     * @since 1.2, Elvish Shaman
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
     * @since 1.2, Elvish Shaman
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
     * @since 1.2, Elvish Shaman
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

    /**
     * Loads a <em>User</em> model from the database
     * @param integer $id The user ID.
     * @return User The loaded user model.
     * 
     * @since 1.2, Elvish Shaman
     */
    private function loadUserModel($id) {
        if (($user = User::model()->find('active = 1 AND userId = :id', array(':id' => (int) $id))) === null) {
            throw new CHttpException(404, 'The user you are trying to load doesn\'t exist.');
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
                        'actions' => array('index', 'create', 'update', 'delete'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
