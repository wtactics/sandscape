<?php

/* CountersController.php
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
 * Allows administrators to manage player counters that will be available for 
 * users and their games.
 */
class CountersController extends ApplicationController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Default action, shows a list of existing (active) player counters.
     * 
     * @since 1.3, Soulharvester
     */
    public function actionIndex() {
        $filter = new PlayerCounter('search');
        $filter->unsetAttributes();

        if (isset($_GET['PlayerCounter'])) {
            $filter->attributes = $_GET['PlayerCounter'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Allows administrators to create new counters.
     * 
     * @since 1.3, Soulharvester
     */
    public function actionCreate() {
        $new = new PlayerCounter();

        $this->performAjaxValidation('playercounter-form', $new);

        if (isset($_POST['PlayerCounter'])) {
            $new->attributes = $_POST['PlayerCounter'];
            if ($new->save()) {
                $this->redirect(array('update', 'id' => $new->playerCounterId));
            }
        }

        $this->render('edit', array('counter' => $new));
    }

    /**
     * Updates a counter's information.
     * 
     * @since 1.3, Soulharvester
     */
    public function actionUpdate($id) {
        $counter = $this->loadPlayerCounterModel($id);

        $this->performAjaxValidation('playercounter-form', $counter);

        if (isset($_POST['PlayerCounter'])) {
            $counter->attributes = $_POST['PlayerCounter'];
            if ($counter->save()) {
                $this->redirect(array('update', 'id' => $counter->playerCounterId));
            }
        }

        $this->render('edit', array('counter' => $counter));
    }

    /**
     * Marks the selected counter as inactive, removing it from the system.
     * 
     * @since 1.3, Soulharvester
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $counter = $this->loadPlayerCounterModel($id);
            $counter->active = 0;
            $counter->save();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Retrieves a <em>PlayerCounter</em> model from the database.
     * 
     * @param integer $id The model's database ID
     * @return Dice The loaded model or null if no model was found for the given ID
     * 
     * @since 1.3, Soulharvester
     */
    private function loadPlayerCounterModel($id) {
        if (($counter = PlayerCounter::model()->find('active = 1 AND playerCounterId = :id', array(':id' => (int) $id))) === null) {
            throw new CHttpException(404, 'The requested counter is unavailable.');
        }
        return $counter;
    }

    /**
     * Adding to the default access rules.
     * 
     * @return array
     * 
     * @since 1.3, Soulharvester
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
