<?php

/* CountersController.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
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
     * Retrieves a <em>Counter</em> model from the database.
     * 
     * @param integer $id The model's database ID
     * @return Counter The loaded model or null if no model was found for the given ID
     */
    private function loadCounterModel($id) {
        if (!($counter = Counter::model()->findByPk((int) $id))) {
            throw new CHttpException(404, Yii::t('sandscape', 'The requested counter is unavailable.'));
        }
        return $counter;
    }

    /**
     * Default action, shows a list of existing (active) player counters.
     */
    public function actionIndex() {
        $filter = new Counter('search');
        $filter->unsetAttributes();

        if (isset($_GET['Counter'])) {
            $filter->attributes = $_GET['Counter'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Allows administrators to create new counters.
     */
    public function actionCreate() {
        $counter = new Counter();
        $this->performAjaxValidation('counter-form', $counter);

        if (isset($_POST['Counter'])) {
            $counter->attributes = $_POST['Counter'];
            if ($counter->save()) {
                $this->redirect(array('view', 'id' => $counter->id));
            }
        }

        $this->render('create', array('counter' => $counter));
    }

    public function actionView($id) {
        $counter = $this->loadCounterModel($id);
        $this->render('view', array('counter' => $counter));
    }

    /**
     * Updates a counter's information.
     */
    public function actionUpdate($id) {
        $counter = $this->loadCounterModel($id);
        $this->performAjaxValidation('counter-form', $counter);

        if (isset($_POST['erCounter'])) {
            $counter->attributes = $_POST['Counter'];
            if ($counter->save()) {
                $this->redirect(array('view', 'id' => $counter->id));
            }
        }

        $this->render('update', array('counter' => $counter));
    }

    /**
     * Marks the selected counter as inactive, removing it from the system.
     */
    public function actionDelete($id) {
        if (Yii::app()->user->role == 'administrator' && Yii::app()->request->isPostRequest) {
            $counter = $this->loadCounterModel($id);

            $counter->active = 0;
            $counter->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('sandscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

}
