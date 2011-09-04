<?php

/*
 * controllers/CardsController.php
 * http://sandscape.sourceforge.net/
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

class CardsController extends GenericAdminController {

    function __construct($id, $module) {
        parent::__construct($id, $module);
        $this->menu[1]['active'] = true;
    }

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array('index', 'create'/* , 'update', 'delete' */),
                'expression' => function ($user, $rule) {
                    return (!Yii::app()->user->isGuest && Yii::app()->user->role === 'admin');
                })
                ), parent::accessRules());
    }

    public function actionIndex() {
        $card = new Card('search');
        $card->unsetAttributes();
        if (isset($_GET['Card']))
            $card->attributes = $_GET['Card'];

        $viewData = array(
            'menu' => array(
                'id' => 'submenu',
                'items' => $this->menu
            ),
            'grid' => array(
                'id' => 'card-grid',
                'dataProvider' => $card->search(),
                'filter' => $card,
                'columns' => array(
                    'name',
                    'faction',
                    'type',
                    'subtype',
                    'author',
                    'revision',
                    'cardscapeId',
                    array(
                        'name' => 'private',
                        'value' => '$data->private',
                        'filter' => array('Public', 'Private')
                    ),
                    array(
                        'class' => 'CButtonColumn'
                    )
                )
            ),
            'model' => $card
        );
        $this->render('index', $viewData);
    }

    public function actionCreate() {
        $card = new Card();
        $normal = new CardImage();

        if (isset($_POST['Card'])) {
            //1 - normal size, 2 - reduced, 3 - rotated
            
            $reduced = new CardImage();
            //$rotated = new CardImage();

            $card->attributes = $_POST['Card'];

            $upload = CUploadedFile::getInstance($normal, 'file');

            $normal->filetype = $reduced->filetype = /* $rotated->filetype = */ $upload->getType();
            $normal->filename = $reduced->filename = /* $rotated->filename = */ $upload->getName();
            $normal->filesize = $upload->getSize();
            $normal->filedata = file_get_contents($upload->getTempName());

            $normal->type = 1;
            $reduced->type = 2;
            //$rotated->type = 3;
            //Resize image to create smaller cards.
            //Usable size is around 81x113 (widthxheigh)
            //Create rotated card
            Yii::import('application.extensions.image.Image');
            $worker = new Image($upload->getTempName());
            $worker->resize(81, 113);
            $thumbname = $upload->getTempName() . '.thumb.' .$upload->getExtensionName();
            $worker->save($thumbname);
            //
            $reduced->filesize = filesize($thumbname);
            $reduced->filedata = file_get_contents($thumbname);

            if ($card->save()) {
                //TODO: create user<->card relation
                $normal->cardId = $card->cardId;
                $reduced->cardId = $card->cardId;

                //TODO: show errors on image not created/saved
                $normal->save();
                $reduced->save();
                $this->redirect(array('view', 'id' => $card->cardId));
            }
        }

        $viewData = array(
            'menu' => $this->menu,
            'card' => $card,
            'image' => $normal
        );

        $this->render('create', $viewData);
    }

///////
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
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
     * If deletion is successful, the browser will be redirected to the 'index' page.
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Card::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'card-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
