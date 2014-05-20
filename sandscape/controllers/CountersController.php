<?php

/* CounterController.php
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

class CountersController extends BaseController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'new', 'edit', 'delete'),
                'expression' => '$user->isGameMaster()'
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }

    public function actionIndex() {
        $filter = new Counter('search');
        $filter->unsetAttributes();

        if (isset($_GET['Counter'])) {
            $filter->attributes = $_GET['Counter'];
        }

        $this->render('index', array('filter' => $filter));
    }

    public function actionNew() {
        $counter = new Counter();
        $this->performAjaxValidation('counter-form', $counter);

        if (isset($_POST['Counter'])) {
            $counter->attributes = $_POST['Counter'];
            if ($counter->save()) {
                $this->redirect(array('edit', 'id' => $counter->id));
            }
        }

        $this->render('create', array('counter' => $counter));
    }

    public function actionEdit($id) {
        $counter = $this->loadCounterModel($id);
        $this->performAjaxValidation('counter-form', $counter);

        if (isset($_POST['erCounter'])) {
            $counter->attributes = $_POST['Counter'];
            if ($counter->save()) {
                $this->redirect(array('edit', 'id' => $counter->id));
            }
        }

        $this->render('update', array('counter' => $counter));
    }

    public function actionDelete($id) {
        $counter = $this->loadCounterModel($id);

        $counter->active = 0;
        $counter->save();

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    private function loadCounterModel($id) {
        if (!($counter = Counter::model()->findByPk((int) $id))) {
            throw new CHttpException(404, Yii::t('sandscape', 'The requested counter is unavailable.'));
        }
        return $counter;
    }

}
