<?php

/* PreConsController.php
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
 * Handles basic deck template (or pre-constructed deck), actions.
 * This class was renamed from <em>DeckTemplateController</em>.
 * 
 * @since 1.2, Elvish Shaman
 */
class PreConsController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * 
     * 
     * @since 1.2, Elvish Shaman
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
     * @since 1.2, Elvish Shaman
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
