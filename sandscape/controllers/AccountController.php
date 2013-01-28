<?php

/* AccountController.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
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

        $this->performAjaxValidation('profile-form', $user);
        $this->performAjaxValidation('password-form', $passwordModel);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->redirect(array('index'));
            }
        } else if (isset($_POST['PasswordForm'])) {
            $passwordModel->attributes = $_POST['PasswordForm'];
            if ($passwordModel->validate()) {
                $user->password = User::hash($passwordModel->password);
                if ($user->save()) {
                    $this->redirect(array('index'));
                }
            }
        } else if (isset($_POST['Avatar'])) {
            if (isset($_POST['Avatar']['url'])) {
                $url = $_POST['Avatar']['url'];
                if (strpos($url, 'http://') === 0) {
                    $user->avatar = $url;
                }

                //TODO: ...
                //} else if() {  
            }

            if ($user->save()) {
                $this->redirect(array('index'));
            }
        }

        //NOTE: //TODO: move to a configuration file that we can i18n
        $countries = array(
            'pt' => 'Portugal',
            'en' => 'England',
            'us' => 'USA',
            'fr' => 'France',
            'sp' => 'Spain'
                //...
        );

        $size = '100x75';
        if (($setting = Setting::model()->findByPk('avatarsize')) !== null) {
            $size = $setting->value;
        }

        $this->render('index', array(
            'user' => $user,
            'pmodel' => $passwordModel,
            'countries' => $countries,
            'avatarSize' => $size
        ));
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
     *
     * @param int $id 
     */
    public function actionGame($id) {
        if (($game = Game::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'You are trying to load an invalid game.');
        }


        $decks = array();
        foreach ($game->decks as $deck) {
            if ($deck->userId == Yii::app()->user->id) {
                if (($stats = DeckGameStats::model()->find('gameId = :game AND deckId = :deck', array(
                    ':game' => $game->gameId, ':deck' => $deck->deckId))) === null) {

                    $stats = new DeckGameStats();

                    $stats->gameId = $id;
                    $stats->deckId = $deck->deckId;
                    $stats->rating = 0;

                    $stats->save();
                }
                $decks[] = array('deck' => $deck, 'stats' => $stats);
            }
        }

        //don't need the game state, and it's usually a lot of info.
        //NOTE: //TODO: in future prevent the info from being loaded at all
        $game->state = '';

        $this->render('game', array(
            'game' => $game,
            'decks' => $decks
        ));
    }

    public function actionStarRatingAjax() {
        if (isset($_POST['rate']) && isset($_POST['game']) && isset($_POST['deck'])) {
            $gameId = intval($_POST['game']);
            $deckId = intval($_POST['deck']);

            if (($stats = DeckGameStats::model()->find('gameId = :game AND deckId = :deck', array(
                ':game' => $gameId, ':deck' => $deckId))) === null) {

                $stats = new DeckGameStats();

                $stats->gameId = $gameId;
                $stats->deckId = $deckId;
            }

            $stats->rating = $_POST['rate'];
            $stats->save();
        }
    }

    public function actionNotesAjax() {
        if (isset($_POST['notes']) && isset($_POST['game']) && isset($_POST['deck'])) {
            $gameId = intval($_POST['game']);
            $deckId = intval($_POST['deck']);

            if (($stats = DeckGameStats::model()->find('gameId = :game AND deckId = :deck', array(
                ':game' => $gameId, ':deck' => $deckId))) === null) {

                $stats = new DeckGameStats();

                $stats->gameId = $gameId;
                $stats->deckId = $deckId;
                $stats->rating = 0;
            }

            $stats->notes = $_POST['notes'];
            $stats->save();
        }
    }

    /**
     * Provides access to all public information about a given user. This action 
     * is responsible for showing a user's profile to other users.
     * 
     * @param integer $id The user's ID
     */
    public function actionProfile($id) {
        $this->render('profile');
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
                        'actions' => array('index', 'games', 'profile', 'game',
                            'starratingajax', 'notesajax'
                        ),
                        'users' => array('@')
                    )
                        ), parent::accessRules());
    }

}