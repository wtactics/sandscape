<?php

/* GameController.php
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

class GameController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->redirect(array('lobby'));
    }

    public function actionLobby() {
        //TODO: not implemented yet
        $search = new CDbCriteria();
        $search->compare('running', 1)->compare('private', 0);

        $games = Game::model()->findAll($search);

        $this->render('lobby', array('games' => $games));
    }

    public function actionCreate() {
        //TODO: not implemented yet
    }

    public function actionJoin() {
        //TODO: not implemented yet
    }

    public function actionPlay($id) {
        //TODO: not implemented yet
        $this->layout = '//layouts/game';

        $game = $this->loadGameById($id);
        $this->render('board');
    }

    private function loadGameById($id) {
        if (($game = Game::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $game;
    }

}
