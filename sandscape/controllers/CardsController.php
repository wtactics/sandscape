<?php

/* CardsController.php
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
 * Handles card administration available to administrations.
 * This class was renamed from <em>CardController</em>.
 */
class CardsController extends ApplicationController {

    private static $NORMAL_WIDTH = 250;
    private static $NORMAL_HEIGHT = 354;
    private static $SMALL_WIDTH = 81;
    private static $SMALL_HEIGHT = 115;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Adds new rules for this controller.
     * 
     * @return array The merged rules array.
     */
    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'create', 'view', 'update'),
                'expression' => '$user->role == "administrator"'
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }

    /**
     * Loads a card model from the database.
     * 
     * @param integer $id The ID for the card.
     * @return Card The card model.
     */
    private function loadCardModel($id) {
        if (!($card = Card::model()->findByPk((int) $id))) {
            throw new CHttpException(404, Yii::t('sandscape', 'The requested card does not exist.'));
        }
        return $card;
    }

    /**
     * Default administration action that lists all existing cards.
     */
    public function actionIndex() {
        $filter = new Card('search');
        $filter->unsetAttributes();

        if (isset($_GET['Card'])) {
            $filter->attributes = $_GET['Card'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Creates a new card and allows for image uploads, creating all the necessary 
     * thumbs and reverted copies.
     */
    public function actionCreate() {
        $card = new Card();
        $this->performAjaxValidation('card-form', $card);

        if (isset($_POST['Card'])) {
            $card->attributes = $_POST['Card'];

            $this->saveUpload($card, 'face');
            $this->saveUpload($card, 'back');

            if ($card->save()) {
                $this->redirect(array('view', 'id' => $card->id));
            }
        }

        $this->render('create', array('card' => $card));
    }

    public function actionView($id) {
        $card = $this->loadCardModel($id);
        $this->render('view', array('card' => $card));
    }

    /**
     * Updates a card's information.
     * 
     * @param integer $id The card ID we want to update.
     */
    public function actionUpdate($id) {
        $card = $this->loadCardModel($id);
        $this->performAjaxValidation('card-form', $card);

        if (isset($_POST['Card'])) {
            $card->attributes = $_POST['Card'];

            $this->saveUpload($card, 'face');
            $this->saveUpload($card, 'back');

            if ($card->save()) {
                $this->redirect(array('view', 'id' => $card->id));
            }
        }

        $this->render('update', array('card' => $card));
    }

    /**
     * Deletes a card by making it inactive.
     * 
     * @param integer $id The card ID.
     */
    public function actionDelete($id) {
        if (Yii::app()->user->role == 'administrator' && Yii::app()->request->isPostRequest) {
            $card = $this->loadCardModel($id);

            $card->active = 0;
            $card->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('sandscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    private function saveUpload(Card $card, $field) {
        Yii::import('ext.PhpThumbFactory');
        $path = Yii::getPathOfAlias('webroot') . '/gamedata/cards';
        $upfile = CUploadedFile::getInstance($card, $field);

        if ($upfile !== null) {
            $name = md5($upfile->name . time()) . substr($upfile->name, strpos($upfile->name, '.'));

            $sizes = getimagesize($upfile->tempName);
            $imgFactory = PhpThumbFactory::create($upfile->tempName);

            //250 width, 354 height
            if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
                $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
            }

            $imgFactory->save($path . '/' . $name);
            $imgFactory->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)->save($path . '/thumbs/' . $name);
            $imgFactory->rotateImageNDegrees(180)->save($path . '/thumbs/reversed/' . $name);

            $card->$field = $name;
        }
    }

}
