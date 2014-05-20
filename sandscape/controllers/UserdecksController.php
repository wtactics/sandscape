<?php

/* DecksController.php
 *  
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2014, Sérgio Lopes <knitter@wtactics.org>
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

class DecksController extends BaseController {

//    private static $NORMAL_WIDTH = 250;
//    private static $NORMAL_HEIGHT = 354;
//    private static $SMALL_WIDTH = 81;
//    private static $SMALL_HEIGHT = 115;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'edit', 'delete'),
                'expression' => '$user->isAdministrator()'
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }

    public function actionIndex() {
        $cardCount = 1;
        //$cardCount = intval(Card::model()->count('active = 1'));

        $filter = new Deck('search');
        $filter->unsetAttributes();

        if (isset($_GET['Deck'])) {
            $filter->attributes = $_GET['Deck'];
        }

        $this->render('index', array('filter' => $filter, 'cardCount' => $cardCount));
    }

    public function actionEdit($id) {
        $deck = $this->loadDeckModel($id);
        $this->performAjaxValidation('deck-form', $deck);

        if (isset($_POST['Deck'])) {
            $deck->attributes = $_POST['Deck'];
            //$this->saveUpload($deck);

            if ($deck->save()) {

                //Remove all associations, and add only those that have been sent.
                //Worse case scenerio: user changes deck name but all cards are 
                //removed and added again.
                //DeckCard::model()->deleteAll('deckId = :id', array(':id' => $deck->deckId));
                //$this->redirect(array('view', 'id' => $deck->id));
            }
        }

        $this->render('update', array('deck' => $deck));
    }

    public function actionDelete($id) {
        $deck = $this->loadDeckModel($id);

        $deck->active = 0;
        $deck->save();

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    private function saveUpload(Deck $deck) {
//        Yii::import('ext.PhpThumbFactory');
//        $path = Yii::getPathOfAlias('webroot') . '/gamedata/decks';
//        $upfile = CUploadedFile::getInstance($deck, 'back');
//
//        if ($upfile !== null) {
//            $name = md5($upfile->name . time()) . substr($upfile->name, strpos($upfile->name, '.'));
//
//            $sizes = getimagesize($upfile->tempName);
//            $imgFactory = PhpThumbFactory::create($upfile->tempName);
//
//            //250 width, 354 height
//            if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
//                $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
//            }
//            $imgFactory->save($path . '/' . $name)
//                    ->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)
//                    ->save($path . '/thumbs/' . $name)
//                    ->rotateImageNDegrees(180)
//                    ->save($path . '/thumbs/reversed/' . $name);
//
//            $token->image = $name;
//        }
    }

    private function loadDeckModel($id) {
        if (($deck = Deck::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, Yii::t('sandscape', 'The deck you are trying to find is invalid.'));
        }

        return $deck;
    }

}
