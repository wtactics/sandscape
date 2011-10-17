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
        $filter->unsetAttributes();  // clear any default values
        if (isset($_GET['Card'])) {
            $filter->attributes = $_GET['Card'];
        }

        $this->render('index', array('filter' => $filter));
    }

    public function actionCreate() {
        $new = new Card();
        $this->performAjaxValidation($new);

        if (isset($_POST['Card'])) {
            $new->attributes = $_POST['Card'];
            if ($new->save()) {
                $this->redirect(array('view', 'id' => $new->cardId));
            }
        }

        $this->render('edit', array('card' => $new));
    }

    public function actionView($id) {
        $this->render('view', array('card' => $this->loadCardModel($id)));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Card'])) {
            $model->attributes = $_POST['Card'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->cardId));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    private function loadCardModel($id) {

        if (($card = Card::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $card;
    }

}
