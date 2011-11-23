<?php

/* AccountController.php
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
 * Offers actions for profile and other user related features. Unlike the 
 * <em>UsersController</em>, the actions in <em>AccountController</em> are 
 * available to regular users.
 * 
 * This class was created to separate administration actions provided by the 
 * <em>UsersController</em> class from those that should be used by every other 
 * user. Most methods were just moved here from the <em>UsersController</em> 
 * class.
 * 
 * @see
 * @since 1.2, Elvish Shaman
 */
class AccountController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Default action shows user's account information.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionIndex() {
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

        $this->render('index', array('user' => $user, 'pwdModel' => $passwordModel));
    }

    /**
     * Lists all games in which this user has participated.
     */
    public function actionGames() {
        //TODO: not implemented yet
        $filter = new Game();
        $filter->unsetAttributes();
        if (isset($_POST['Game'])) {
            $filter->attributes = $_POST['Game'];
        }

        $games = Game::model()->findAll('player1 = :id OR player2 = :id', array(':id' => Yii::app()->user->id));
        $this->render('games', array('games' => $games, 'filter' => $filter));
    }

    /**
     * Provides access to all public information about a given user. This action 
     * is responsible for showing a user's profile to other users.
     * 
     * @param integer $id The user's ID
     */
    public function actionProfile($id) {
        //TODO: not implemented yet!
        $user = $this->loadUserModel($id);
        $this->render('view', array('user' => $user));
    }

    /**
     *
     * @param int $id 
     */
    public function actionViewGame($id) {
        if (($game = Game::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'You are trying to load an invalid game.');
        }

        //don't need the game state, and it's usually a lot of info.
        //NOTE: //TODO: in future prevent the info from being loaded at all
        $game->state = '';
        $this->render('view-game', array('game' => $game));
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
            throw new CHttpException(404, 'You are trying to load an invalid user.');
        }
        return $user;
    }

    /**
     * Overrides the default rules allowing for user actions.
     * 
     * @return array Rules array.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'games', 'profile', 'viewGame'),
                        'users' => array('@')
                    )
                        ), parent::accessRules());
    }

}