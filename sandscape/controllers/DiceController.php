<?php

/* DiceController.php
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

class DiceController extends BaseController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

//    public function accessRules() {
//        return array(
//            array(
//                'allow',
//                'actions' => array('index', 'create', 'view', 'update', 'delete'),
//                'expression' => '$user->role == "administrator"'
//            ),
//            array(
//                'deny',
//                'users' => array('*')
//            )
//        );
//    }

    public function actionIndex() {
        $filter = new Dice('search');
        $filter->unsetAttributes();

        if (isset($_GET['Dice'])) {
            $filter->attributes = $_GET['Dice'];
        }

        $this->render('index', array('filter' => $filter));
    }

    public function actionNew() {
//        $dice = new Dice();
//
//        $this->performAjaxValidation('dice-form', $dice);
//
//        if (isset($_POST['Dice'])) {
//            $dice->attributes = $_POST['Dice'];
//            if ($dice->save()) {
//                $this->redirect(array('view', 'id' => $dice->id));
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
//                $this->redirect(array('view', 'id' => $dice->id));
//            }
//        }
//
//        $this->render('update', array('dice' => $dice));
    }

    public function actionDelete($id) {
//        if (Yii::app()->user->role == 'administrator' && Yii::app()->request->isPostRequest) {
//            $dice = $this->loadDiceModel($id);
//
//            $dice->active = 0;
//            $dice->save();
//
//            if (!isset($_GET['ajax'])) {
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
//            }
//        } else {
//            throw new CHttpException(400, Yii::t('sandscape', 'Invalid request. Please do not repeat this request again.'));
//        }
    }

    private function loadDiceModel($id) {
        if (!($dice = Dice::model()->findByPk((int) $id))) {
            throw new CHttpException(404, Yii::t('sandscape', 'The requested page does not exist.'));
        }
        return $dice;
    }

}
