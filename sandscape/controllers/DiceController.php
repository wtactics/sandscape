<?php

/* DiceController.php
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

/**
 * @since 1.2, Elvish Shaman
 */
class DiceController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * @since 1.2, Elvish Shaman
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
     * @since 1.2, Elvish Shaman
     */
    public function actionCreate() {
        $new = new Dice();

        if (isset($_POST['Dice'])) {
            $new->attributes = $_POST['Dice'];
            if ($new->save()) {
                $this->redirect(array('update', 'id' => $new->diceId));
            }
        }

        $this->render('edit', array('dice' => $new));
    }

    /**
     * @since 1.2, Elvish Shaman
     */
    public function actionUpdate($id) {
        $dice = $this->loadDiceModel($id);

        if (isset($_POST['Dice'])) {
            $dice->attributes = $_POST['Dice'];
            if ($dice->save()) {
                $this->redirect(array('update', 'id' => $dice->diceId));
            }
        }

        $this->render('edit', array('dice' => $dice));
    }

    /**
     * @since 1.2, Elvish Shaman
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $dice = $this->loadDiceModel($id);
            $dice->active = 0;
            $dice->save();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Retrieves a <em>Dice</em> model from the database.
     * 
     * @param integer $id The model's database ID
     * @return Dice The loaded model or null if no model was found for the given ID
     * 
     * @since 1.2, Elvish Shaman
     */
    private function loadDiceModel($id) {
        if (($dice = Dice::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $dice;
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
