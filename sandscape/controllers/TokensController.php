<?php

/* TokensController.php
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
 * http://wtactics.org
 */

class TokensController extends AppController {

    private static $NORMAL_WIDTH = 270;
    private static $NORMAL_HEIGHT = 382;
    private static $SMALL_WIDTH = 101;
    private static $SMALL_HEIGHT = 143;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Lists all existing tokens.
     * 
     * @since 1.2, Elvish Shaman
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
        $new = new Token();
        $this->performAjaxValidation('token-form', $new);

        if (isset($_POST['Token'])) {
            $new->attributes = $_POST['Token'];
            //TODO: check that the image file is not already in the server or that 
            //no other file with the same name exists
            $path = Yii::getPathOfAlias('webroot') . '/_game/tokens';
            $upfile = CUploadedFile::getInstance($new, 'image');

            if ($upfile !== null) {
                $name = $upfile->name;

                $sizes = getimagesize($upfile->tempName);
                $imgFactory = PhpThumbFactory::create($upfile->tempName);

                //250 + 20 width, 354 + 28 height
                if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
                    $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
                }
                $imgFactory->save($path . '/' . $name)
                        ->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)
                        ->save($path . '/thumbs/' . $name)
                        ->rotateImageNDegrees(180)
                        ->save($path . '/thumbs/reversed/' . $name);

                $new->image = $name;
                $new->save();
            }

            $this->redirect(array('update', 'id' => $new->tokenId));
        }

        $this->render('edit', array('token' => $new));
    }

    public function actionUpdate($id) {
        $token = $this->loadTokenModel($id);
        $this->performAjaxValidation('token-form', $token);

        if (isset($_POST['Token'])) {
            $token->attributes = $_POST['Token'];
            //TODO: check that the image file is not already in the server or that 
            //no other file with the same name exists
            $path = Yii::getPathOfAlias('webroot') . '/_game/tokens';
            $upfile = CUploadedFile::getInstance($token, 'image');

            if ($upfile !== null) {
                $name = $upfile->name;

                $sizes = getimagesize($upfile->tempName);
                $imgFactory = PhpThumbFactory::create($upfile->tempName);
                //250 + 20 width, 354 + 28 height
                if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
                    $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
                }
                $imgFactory->save($path . '/' . $name)
                        ->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)
                        ->save($path . '/thumbs/' . $name)
                        ->rotateImageNDegrees(180)
                        ->save($path . '/thumbs/reversed/' . $name);

                $token->image = $name;
                $token->save();
            }

            $this->redirect(array('update', 'id' => $token->tokenId));
        }

        $this->render('edit', array('token' => $token));
    }

    public function actionDelete($id) {
        if (Yii::app()->user->class && Yii::app()->request->isPostRequest) {
            $token = $this->loadTokenModel($id);

            $token->active = 0;
            $token->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    private function loadTokenModel($id) {
        if (($token = Token::model()->find('active = 1 AND tokenId = :id', array(':id' => (int) $id))) === null) {
            throw new CHttpException(404, 'The token you\'re trying to load doesn\'t exist.');
        }
        return $token;
    }

    /**
     * Adding to the default access rules.
     * 
     * @return array
     * 
     * @since 1.2, Elvish Shaman
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}