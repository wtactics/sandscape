<?php

/* DiceController.php
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
final class DiceController extends \yii\web\Controller {

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
//        $filter = new Dice('search');
//        $filter->unsetAttributes();
//
//        if (isset($_GET['Dice'])) {
//            $filter->attributes = $_GET['Dice'];
//        }
//
//        $this->render('index', array('filter' => $filter));
    }

    public function actionNew() {
//        $dice = new Dice();
//        $this->performAjaxValidation('dice-form', $dice);
//
//        if (isset($_POST['Dice'])) {
//            $dice->attributes = $_POST['Dice'];
//            if ($dice->save()) {
//                $this->redirect(array('edit', 'id' => $dice->id));
//            }
//        }
//
//        $this->render('create', array('dice' => $dice));
    }

    public function actionEdit($id) {
//        $dice = $this->loadDiceModel($id);
//        $this->performAjaxValidation('dice-form', $dice);
//
//        if (isset($_POST['Dice'])) {
//            $dice->attributes = $_POST['Dice'];
//            if ($dice->save()) {
//                $this->redirect(array('edit', 'id' => $dice->id));
//            }
//        }
//
//        $this->render('update', array('dice' => $dice));
    }

    public function actionDelete($id) {
//        $dice = $this->loadDiceModel($id);
//
//        $dice->active = 0;
//        $dice->save();
//
//        if (!isset($_GET['ajax'])) {
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
//        }
    }

    /**
     * @param integer $id
     * 
     * @return \common\models\Dice
     * @throws \yii\web\NotFoundHttpException
     */
    private function findDice($id) {
        if (($dice = Dice::findOne((int) $id)) !== null) {
            return $dice;
        }

        throw new NotFoundHttpException(Yii::t('sandscape', '//TODO: ...'));
    }

}
