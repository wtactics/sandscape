<?php

/* TokensController.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
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

class TokensController extends ApplicationController {

    //private static $NORMAL_WIDTH = 270;
    //private static $NORMAL_HEIGHT = 382;
    //private static $SMALL_WIDTH = 101;
    //private static $SMALL_HEIGHT = 143;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Adding to the default access rules.
     * 
     * @return array
     */
    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'create', 'view', 'update', 'delete'),
                'expression' => '$user->role == "administrator"'
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }

    private function loadTokenModel($id) {
        if (!($token = Token::model()->findByPk((int) $id))) {
            throw new CHttpException(404, Yii::t('sandscape', 'The requested token does not exist.'));
        }
        return $token;
    }

    /**
     * Lists all existing tokens.
     */
    public function actionIndex() {
        $filter = new Token('search');
        $filter->unsetAttributes();

        if (isset($_GET['Token'])) {
            $filter->attributes = $_GET['Token'];
        }

        $this->render('index', array('filter' => $filter));
    }

    public function actionCreate() {
        $token = new Token();
        $this->performAjaxValidation('token-form', $token);

        if (isset($_POST['Token'])) {
            $token->attributes = $_POST['Token'];

//            Yii::import('ext.PhpThumbFactory');
//            $path = Yii::getPathOfAlias('webroot') . '/_game/tokens';
//            $upfile = CUploadedFile::getInstance($new, 'image');
//
//            if ($upfile !== null) {
//                $name = $upfile->name;
//
//                if (is_file($path . '/' . $name)) {
//                    $name = $new->name . '.' . $name;
//                }
//
//                $sizes = getimagesize($upfile->tempName);
//                $imgFactory = PhpThumbFactory::create($upfile->tempName);
//
//                //250 + 20 width, 354 + 28 height
//                if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
//                    $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
//                }
//                $imgFactory->save($path . '/' . $name)
//                        ->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)
//                        ->save($path . '/thumbs/' . $name)
//                        ->rotateImageNDegrees(180)
//                        ->save($path . '/thumbs/reversed/' . $name);
//
//                $new->image = $name;
//              }
            if ($token->save()) {
                $this->redirect(array('view', 'id' => $token->tokenId));
            }
        }

        $this->render('create', array('token' => $token));
    }

    public function actionView($id) {
        $token = $this->loadTokenModel($id);
        $this->render('view', array('token' => $token));
    }

    public function actionUpdate($id) {
        $token = $this->loadTokenModel($id);
        $this->performAjaxValidation('token-form', $token);

        if (isset($_POST['Token'])) {
            $token->attributes = $_POST['Token'];
            if ($token->save()) {
                $this->redirect(array('update', 'id' => $token->tokenId));
            }
        }

        $this->render('update', array('token' => $token));
    }

    public function actionDelete($id) {
        if (Yii::app()->user->role == 'administrator' && Yii::app()->request->isPostRequest) {
            $token = $this->loadTokenModel($id);

            $token->active = 0;
            $token->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('sandscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

}