<?php

/* DiceController.php
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

/**
 * Allows administrators to manage dice that will be available for users and 
 * their games.
 */
class DiceController extends ApplicationController {

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

    /**
     * Retrieves a <em>Dice</em> model from the database.
     * 
     * @param integer $id The model's database ID
     * @return Dice The loaded model or null if no model was found for the given ID
     */
    private function loadDiceModel($id) {
        if (!($dice = Dice::model()->findByPk((int) $id))) {
            throw new CHttpException(404, Yii::t('sandscape', 'The requested page does not exist.'));
        }
        return $dice;
    }

    /**
     * Default action, shows a list of existing (active) dice in the system.
     */
    public function actionIndex() {
        $filter = new Dice('search');
        $filter->unsetAttributes();

        if (isset($_GET['Dice'])) {
            $filter->attributes = $_GET['Dice'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Allows administrators to create new dice to be used in games.
     */
    public function actionCreate() {
        $dice = new Dice();

        $this->performAjaxValidation('dice-form', $dice);

        if (isset($_POST['Dice'])) {
            $dice->attributes = $_POST['Dice'];
            if ($dice->save()) {
                $this->redirect(array('view', 'id' => $dice->id));
            }
        }

        $this->render('create', array('dice' => $dice));
    }

    public function actionView($id) {
        $dice = $this->loadDiceModel($id);
        $this->render('view', array('dice' => $dice));
    }

    /**
     * Updates a dice information.
     */
    public function actionUpdate($id) {
        $dice = $this->loadDiceModel($id);
        $this->performAjaxValidation('dice-form', $dice);

        if (isset($_POST['Dice'])) {
            $dice->attributes = $_POST['Dice'];
            if ($dice->save()) {
                $this->redirect(array('view', 'id' => $dice->id));
            }
        }

        $this->render('update', array('dice' => $dice));
    }

    /**
     * Marks selected dice as inactive, removing them from the system.
     */
    public function actionDelete($id) {
        if (Yii::app()->user->role == 'administrator' && Yii::app()->request->isPostRequest) {
            $dice = $this->loadDiceModel($id);

            $dice->active = 0;
            $dice->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('sandscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

}
