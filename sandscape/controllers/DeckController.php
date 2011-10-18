<?php

/* DeckController.php
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

class DeckController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->updateUserActivity();
        
        $filter = new Deck('search');
        $filter->unsetAttributes();

        if (isset($_GET['Deck'])) {
            $model->attributes = $_GET['Deck'];
        }

        $this->render('index', array('filter' => $filter));
    }

    public function actionCreate() {
        $this->updateUserActivity();
        
        $new = new Deck();

        if (isset($_POST['Deck'])) {
            $new->attributes = $_POST['Deck'];

            $new->userId = 1;
            $new->created = date('Y-m-d H:i');
            $new->active = 1;

            if ($new->save()) {
                //TODO: validate redirect
                $this->redirect(array('index'));
            }
        }

        $this->render('edit', array('deck' => $new));
    }

    public function actionUpdate($id) {
        $this->updateUserActivity();
        
        $deck = $this->loadDeckModel($id);

        if (isset($_POST['Deck'])) {
            $model->attributes = $_POST['Deck'];
            if ($model->save()) {
                //TODO: validate redirect
                $this->redirect(array('index'));
            }
        }

        $this->render('edit', array('deck' => $deck));
    }

    public function actionDelete($id) {
        $this->updateUserActivity();
        
        if (Yii::app()->request->isPostRequest) {
            $this->loadDeckModel($id)->delete();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    private function loadDeckModel($id) {
        if (($deck = Deck::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $deck;
    }

}
