<?php

/* TokenController.php
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
final class TokenController extends \yii\web\Controller {

//    private static $NORMAL_WIDTH = 270;
//    private static $NORMAL_HEIGHT = 382;
//    private static $SMALL_WIDTH = 101;
//    private static $SMALL_HEIGHT = 143;
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
//        $filter = new Token('search');
//        $filter->unsetAttributes();
//
//        if (isset($_GET['Token'])) {
//            $filter->attributes = $_GET['Token'];
//        }
//
//        $this->render('index', array('filter' => $filter));
    }

    public function actionNew() {
//        $token = new Token();
//        $this->performAjaxValidation('token-form', $token);
//
//        if (isset($_POST['Token'])) {
//            $token->attributes = $_POST['Token'];
//            //$this->saveUpload($token);
//
//            if ($token->save()) {
//                $this->redirect(array('edit', 'id' => $token->id));
//            }
//        }
//
//        $this->render('create', array('token' => $token));
    }

    public function actionEdit($id) {
//        $token = $this->loadTokenModel($id);
//        $this->performAjaxValidation('token-form', $token);
//
//        if (isset($_POST['Token'])) {
//            $token->attributes = $_POST['Token'];
//            //$this->saveUpload($token);
//
//            if ($token->save()) {
//                $this->redirect(array('edit', 'id' => $token->id));
//            }
//        }
//
//        $this->render('update', array('token' => $token));
    }

    public function actionDelete($id) {
//        $token = $this->loadTokenModel($id);
//
//        $token->active = 0;
//        $token->save();
//
//        if (!isset($_GET['ajax'])) {
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
//        }
    }

//    private function saveUpload(Token $token) {
//        Yii::import('ext.PhpThumbFactory');
//        $path = Yii::getPathOfAlias('webroot') . '/gamedata/tokens';
//        $upfile = CUploadedFile::getInstance($token, 'image');
//
//        if ($upfile !== null) {
//            $name = md5($upfile->name . time()) . substr($upfile->name, strpos($upfile->name, '.'));
//
//            $sizes = getimagesize($upfile->tempName);
//            $imgFactory = PhpThumbFactory::create($upfile->tempName);
//
//            //250 + 20 width, 354 + 28 height
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
//    }

    /**
     * @param integer $id
     * 
     * @return \common\models\Token
     * @throws \yii\web\NotFoundHttpException
     */
    private function findToken($id) {
        if (($token = Token::findOne((int) $id)) !== null) {
            return $token;
        }

        throw new NotFoundHttpException(Yii::t('sandscape', '//TODO: ...'));
    }

}
