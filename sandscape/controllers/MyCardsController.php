<?php

/*
 * controllers/MyCardsController.php
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

class MyCardsController extends Controller {

    function __construct($id, $module) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array('index', 'create'/* , 'update', 'delete' */),
                'expression' => function ($user, $rule) {
                    return (!Yii::app()->user->isGuest);
                })
                ), parent::accessRules());
    }

    public function actionIndex() {
//        $card = new Card('search');
//        $card->unsetAttributes();
//        if (isset($_GET['Card']))
//            $card->attributes = $_GET['Card'];
//
//        $viewData = array(
//            'menu' => array(
//                'id' => 'submenu',
//                'items' => $this->menu
//            ),
//            'grid' => array(
//                'id' => 'card-grid',
//                'dataProvider' => $card->search(),
//                'filter' => $card,
//                'columns' => array(
//                    'name',
//                    'faction',
//                    'type',
//                    'subtype',
//                    'author',
//                    'revision',
//                    'cardscapeId',
//                    'private',
//                    array(
//                        'class' => 'CButtonColumn'
//                    )
//                )
//            ),
//            'model' => $card
//        );
//        $this->render('index', $viewData);
    }

    public function actionCreate() {
//        $card = new Card();
//        $image = new CardImage();
//
//        if (isset($_POST['Card'])) {
//            $card->attributes = $_POST['Card'];
//
//            $upload = CUploadedFile::getInstance($image, 'file');
//
//            $image->filetype = $upload->type;
//            $image->filename = $upload->name;
//            $image->filesize = $upload->size;
//            $image->filedata = file_get_contents($upload->tempName);
//
//            if ($image->save()) {
//                $card->imageId = $image->imageId;
//                if ($card->save())
//                    $this->redirect(array('view', 'id' => $card->cardId));
//            }
//        }
//
//        $viewData = array(
//            'menu' => $this->menu,
//            'card' => $card,
//            'image' => $image
//        );
//
//        $this->render('create', $viewData);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
//    public function actionUpdate($id) {
//        $model = $this->loadModel($id);
    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
//        if (isset($_POST['Card'])) {
//            $model->attributes = $_POST['Card'];
//            if ($model->save())
//                $this->redirect(array('view', 'id' => $model->cardId));
//        }
//        $this->render('update', array(
//            'model' => $model,
//        ));
//    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id the ID of the model to be deleted
     */
//    public function actionDelete($id) {
//        if (Yii::app()->request->isPostRequest) {
//                    // we only allow deletion via POST request
//            $this->loadModel($id)->delete();
    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//            if (!isset($_GET['ajax']))
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//        }
//        else
//            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
//    }

    public function loadModel($id) {
        $card = Card::model()->findByPk((int) $id);
        if ($card === null)
            throw new CHttpException(404, 'The requested card does not exist.');
        return $card;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    //   protected function performAjaxValidation($model) {
    //       if (isset($_POST['ajax']) && $_POST['ajax'] === 'card-form') {
    //           echo CActiveForm::validate($model);
    //           Yii::app()->end();
    //       }
    //   }
}
