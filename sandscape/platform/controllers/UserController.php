<?php

/* UserController.php
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

use app\models\filters\Users;
use common\models\User;

/**
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
final class UserController extends \yii\web\Controller {
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

    /**
     * @return string
     */
    public function actionIndex() {
        $filter = new Users();
        return $this->render('index', ['filter' => $filter]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionNew() {
        $user = new User();

        if ($user->load(Yii::$app->request->post())) {
            if ($user->save()) {
                return $this->redirect(['edit', 'id' => $user->id]);
            }
        }

        $this->render('new', ['user' => $user]);
    }

    /**
     * @param string $id
     * @return \yii\web\Response
     */
    public function actionEdit($id) {
        $user = $this->findUser($id);
        if ($user->load(Yii::$app->request->post())) {
            if ($user->save()) {
                return $this->redirect(['edit', 'id' => $user->id]);
            }
        }

        return $this->render('edit', ['user' => $user]);
    }

    /**
     * @param string $id
     * @return \yii\web\Response
     */
    public function actionRemove($id) {
        $user = $this->findUser($id);
        //TODO: ...

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     */
    public function actionDecks($id) {
//TODO: ...
//        $user = $this->loadUserModel(Yii::app()->user->id);
//        $this->render('decks');
    }

    /**
     * @param integer $id
     * 
     * @return \common\models\User
     * @throws \yii\web\NotFoundHttpException
     */
    private function findUser($id) {
        if (($user = User::findOne((int) $id)) !== null) {
            return $user;
        }

        throw new NotFoundHttpException(Yii::t('sandscape', 'Unable to find the requested user.'));
    }

}
