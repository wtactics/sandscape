<?php

/* CardController.php
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

class CardController extends AppController {

    public function actionIndex() {
        $filter = new Card('search');
        $filter->unsetAttributes();

        if (isset($_GET['Card'])) {
            $filter->attributes = $_GET['Card'];
        }

        $this->render('index', array('filter' => $filter));
    }

    //TODO: allow image upload
    public function actionCreate() {
        $new = new Card();
        $this->performAjaxValidation('card-form', $new);

        if (isset($_POST['Card'])) {
            $new->attributes = $_POST['Card'];

            $new->active = 1;
            if ($new->save()) {
                $this->redirect(array('view', 'id' => $new->cardId));
            }
        }

        $this->render('edit', array('card' => $new));
    }

    //TODO: allow image upload
    public function actionUpdate($id) {
        $card = $this->loadCardModel($id);

        if (isset($_POST['Card'])) {
            $card->attributes = $_POST['Card'];
            if ($card->save())
                $this->redirect(array('view', 'id' => $card->cardId));
        }

        $this->render('edit', array('card' => $card));
    }

    //TODO: validate this action, maybe not needed as create/upadate are enough
    public function actionView($id) {
        $this->render('view', array('card' => $this->loadCardModel($id)));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->loadCardModel($id)->delete();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    private function loadCardModel($id) {
        if (($card = Card::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $card;
    }

    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete', 'view'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
