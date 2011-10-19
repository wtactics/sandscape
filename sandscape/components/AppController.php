<?php

/* AppController.php
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
 */

class AppController extends CController {

    public $layout = '//layouts/site';
    protected $menu;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->menu = array(
            array('label' => 'Home', 'url' => array('site/index')),
            array('label' => 'About', 'url' => array('site/about')),
            array('label' => 'Play', 'url' => array('game/lobby'), 'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Administration', 'url' => array('administration/index'),
                'items' => array(
                    array('label' => 'Cards', 'url' => array('card/index')),
                    array('label' => 'Users', 'url' => array('user/index')),
                ),
                'visible' => !Yii::app()->user->isGuest && Yii::app()->user->class
            ),
            array('label' => 'Account', 'url' => array('user/account'),
                'items' => array(
                    array('label' => 'Decks', 'url' => array('deck/index')),
                    array('label' => 'Profile', 'url' => array('user/profile')),
                    array('label' => 'Logout', 'url' => array('site/logout')),
                ),
                'visible' => !Yii::app()->user->isGuest
            ),
            array('label' => 'Login', 'url' => array('site/login'), 'visible' => Yii::app()->user->isGuest)
        );
    }

    public final function performAjaxValidation($form, $model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public final function updateUserActivity() {
        if (!Yii::app()->user->isGuest) {
            $sd = null;
            if (($sd = SessionData::model()->findByPk(Yii::app()->user->id)) === null) {
                $sd = new SessionData();
                $sd->userId = Yii::app()->user->id;
            }

            $sd->lastActivity = date('Y-m-d H:i', time());
            $sd->save();
        }
    }

}