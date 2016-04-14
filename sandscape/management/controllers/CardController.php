<?php

/* CardController.php
 *  
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2016, WTactics Project <http://wtactics.org>
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

namespace app\controllers;

/**
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
class CardController extends \yii\web\Controller {

    //private static $NORMAL_WIDTH = 250;
    //private static $NORMAL_HEIGHT = 354;
    //private static $SMALL_WIDTH = 81;
    //private static $SMALL_HEIGHT = 115;
//TODO: ...
//    /**
//     * @inheritdoc
//     */
//    public function behaviors() {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [ 'allow' => false, 'roles' => ['?']],
//                    [
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            return true;
//                        }
//                    ],
//                    [ 'allow' => true, 'roles' => ['@']],
//                ]
//            ]
//        ];
//    }

    public function actionIndex() {
//        $filter = new Card('search');
//        $filter->unsetAttributes();
//
//        if (isset($_GET['Card'])) {
//            $filter->attributes = $_GET['Card'];
//        }
//
//        $this->render('index', array('filter' => $filter));
    }

    public function actionNew() {
//        $card = new Card();
//        $this->performAjaxValidation('card-form', $card);
//
//        if (isset($_POST['Card'])) {
//            $card->attributes = $_POST['Card'];
//
//            //$this->saveUpload($card, 'face');
//            //$this->saveUpload($card, 'back');
//
//            if ($card->save()) {
//                $this->redirect(array('edit', 'id' => $card->id));
//            }
//        }
//
//        $this->render('create', array('card' => $card));
    }

    public function actionEdit($id) {
//        $card = $this->loadCardModel($id);
//        $this->performAjaxValidation('card-form', $card);
//
//        if (isset($_POST['Card'])) {
//            $card->attributes = $_POST['Card'];
//
//            //$this->saveUpload($card, 'face');
//            //$this->saveUpload($card, 'back');
//
//            if ($card->save()) {
//                $this->redirect(array('edit', 'id' => $card->id));
//            }
//        }
//
//        $this->render('update', array('card' => $card));
    }

    public function actionDelete($id) {
//        $card = $this->loadCardModel($id);
//
//        $card->active = 0;
//        $card->save();
//
//        if (!isset($_GET['ajax'])) {
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
//        }
    }

//    private function saveUpload(Card $card, $field) {
//        Yii::import('ext.PhpThumbFactory');
//        $path = Yii::getPathOfAlias('webroot') . '/gamedata/cards';
//        $upfile = CUploadedFile::getInstance($card, $field);
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
//
//            $imgFactory->save($path . '/' . $name);
//            $imgFactory->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)->save($path . '/thumbs/' . $name);
//            $imgFactory->rotateImageNDegrees(180)->save($path . '/thumbs/reversed/' . $name);
//
//            $card->$field = $name;
//        }
//    }

    /**
     * @param integer $id
     * 
     * @return \common\models\Card
     * @throws \yii\web\NotFoundHttpException
     */
    private function findCard($id) {
        if (($card = Card::findOne((int) $id)) !== null) {
            return $card;
        }

        throw new NotFoundHttpException(Yii::t('sandscape', '//TODO: ...'));
    }

}
