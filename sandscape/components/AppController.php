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
 * http://wtactics.org
 */

/**
 * Base controller class for every Sandscape controller class.
 * 
 * <em>AppController</em> is the parent class for every other controller class 
 * created to answer standard web requests.
 * 
 * Any sub-class should override the <em>accessRules</em> method.
 * 
 * @since 1.0
 */
class AppController extends CController {

    /**
     *
     * @var string The current layout used by this controller. Should always be 
     * a valid layout file form the default layout folder, <em>//layouts</em> 
     */
    public $layout = '//layouts/site';

    /**
     *
     * @var array Main menu used by every controller. Though it shows and hides 
     * options based on the user type, it does not provide security for those 
     * options. 
     */
    protected $menu;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        //main menu and its options
        $this->menu = array(
            array('label' => 'Home', 'url' => array('site/index')),
            array('label' => 'About', 'url' => array('site/about')),
            //visible only to authenticated users
            array('label' => 'Play', 'url' => array('game/lobby'), 'visible' => !Yii::app()->user->isGuest),
            //visible only to administrators
            array('label' => 'Administration', 'url' => array('administration/index'),
                'items' => array(
                    array('label' => 'Cards', 'url' => array('card/index')),
                    array('label' => 'Users', 'url' => array('user/index')),
                ),
                'visible' => !Yii::app()->user->isGuest && Yii::app()->user->class
            ),
            //visible only to authenticated users
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

    /**
     * Offers model validation to AJAX requests. It is used by forms that provide 
     * AJAX validation while the user is filling in the form fields.
     * 
     * @param string $form The name of the form to check, this is the named use to 
     * identify the form in the <em>$_POST</em> array.
     * @param CActiveRecord $model The model to validate, a <em>CActiveRecord</em>
     * sub-class.
     */
    public final function performAjaxValidation($form, $model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Every method that needs to register user activity must call <em>updateUserActivity</em>
     * so that the information is stored in the database. 
     */
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

    /**
     * Tells Yii that every AppController instance will require access validation
     * and will provide a <em>accessRules</em> method with the access rules for 
     * each of its actions.
     * 
     * @return array The filters array.
     */
    public function filters() {
        return array(
            'accessControl',
        );
    }

    /**
     * Default access rules. These rules will deny access to every action from 
     * any user, either a regular user, and administrator or a simple guest.
     * 
     * Every child class needs to override this method and merge their access 
     * rules to the default rules.
     * 
     * If the child class only overrides the method returning a complete new set 
     * of rules, it must make sure that all actions have an access rule.
     * 
     * @return array The rules array
     */
    public function accessRules() {
        return array(array('deny', 'users' => array('*')));
    }

}