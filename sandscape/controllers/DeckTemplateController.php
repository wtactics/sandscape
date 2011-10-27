<?php

/* DeckTemplateController.php
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
 * Handles basic deck template actions
 * 
 * @since 1.1, Green Shield
 */
class DeckTemplateController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * 
     * 
     * @since 1.1, Green Shield
     */
    public function actionIndex() {
        $filter = new DeckTemplate('search');
        $filter->unsetAttributes();

        if (isset($_GET['DeckTemplate'])) {
            $filter->attributes = $_GET['DeckTemplate'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * 
     * @param integer $id The deck's database ID.
     * 
     * @since 1.1, Green Shield
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $deck = $this->loadDeckTemplateModel($id);
            if ($deck->userId == Yii::app()->user->id) {

                $deck->active = 0;
                $deck->save();
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Retrieves a DeckTemplate model from the database.
     * 
     * @param integer $id The model's database ID
     * @return  DeckTemplate The loaded model or null if no model was found for the given ID
     * 
     * @since 1.1, Green Shield
     */
    private function loadDeckTemplateModel($id) {
        if (($deck = DeckTemplate::model()->find('active = 1 AND deckTemplateId = :id', array(':id' => (int) $id))) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $deck;
    }

    /**
     * Adding to the default access rules.
     * 
     * @return array
     * 
     * @since 1.1, Green Shield
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'delete'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
