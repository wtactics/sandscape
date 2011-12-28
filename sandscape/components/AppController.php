<?php

/* AppController.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011, the Sandscape team.
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
     * @var string The current layout used by this controller. Should always be 
     * a valid layout file form the default layout folder, <em>//layouts</em> 
     */
    public $layout = '//layouts/site';

    /**
     * @var array Main menu used by every controller. Though it shows and hides 
     * options based on the user type, it does not provide security for those 
     * options. 
     */
    protected $menu;

    /**
     * @var string The page title.
     */
    protected $title;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        //main menu and its options
        $this->menu = array(
            array(
                'label' => 'Home',
                'url' => array('site/index'),
                'linkOptions' => array('class' => 'row-first'),
            ),
            array(
                'label' => 'About',
                'url' => array('site/about')
            ),
            array(
                'label' => 'Play',
                'url' => array('lobby/index'),
                //visible only to authenticated users
                'visible' => !Yii::app()->user->isGuest),
            array(
                'label' => 'Administration',
                'url' => 'javascript:;',
                'items' => array(
                    array(
                        'label' => 'Cards',
                        'url' => array('cards/index')
                    ),
                    array(
                        //game elements sub-menu
                        'label' => 'Game Elements &Gt;',
                        'url' => 'javascript:;',
                        'items' => array(
                            array(
                                'label' => 'Dice',
                                'url' => array('dice/index'),
                                'linkOptions' => array('class' => 'column-first'),
                            ),
                            array(
                                'label' => 'Player Counters',
                                'url' => array('counters/index')
                            ),
                            array(
                                'label' => 'States',
                                'url' => array('states/index')
                            ),
                            array(
                                'label' => 'Tokens',
                                'url' => array('tokens/index'),
                                'linkOptions' => array('class' => 'column-last'),
                            ),
                        ),
                    ),
                    array(
                        'label' => 'Pre-constructed',
                        'url' => array('precons/index')
                    ),
                    array(
                        'label' => 'Users',
                        'url' => array('users/index')
                    ),
                    array(
                        // sandscape settings sub-menu
                        'label' => 'Settings &Gt;',
                        'url' => 'javascript:;',
                        'items' => array(
                            array(
                                'label' => 'Chat Filter',
                                'url' => array('administration/chatfilter'),
                                'linkOptions' => array('class' => 'column-first'),
                            ),
                            array(
                                'label' => 'Chat Logs',
                                'url' => array('chatlogs/index'),
                            ),
                            array(
                                'label' => 'Game Options',
                                'url' => array('administration/gameoptions')),
                            array(
                                'label' => 'Maintenance Tools',
                                'url' => array('administration/maintenancetools')),
                            array(
                                'label' => 'Sandscape Settings',
                                'url' => array('administration/sandscapesettings'),
                                'linkOptions' => array('class' => 'column-last'),
                            ),
                        ),
                        'linkOptions' => array('class' => 'column-last'),
                    ),
                ),
                //visible only to administrators
                'visible' => !Yii::app()->user->isGuest && Yii::app()->user->class,
            ),
            array(
                // account sub-menu
                'label' => 'Account',
                'url' => 'javascript:;',
                'items' => array(
                    array('label' => 'Decks', 'url' => array('decks/index')),
                    array('label' => 'Games', 'url' => array('account/games')),
                    array('label' => 'Profile', 'url' => array('profile/index')),
                    array(
                        'label' => 'Logout',
                        'url' => array('site/logout'),
                        'linkOptions' => array('class' => 'column-last'),
                    ),
                ),
                'linkOptions' => array('class' => 'row-last'),
                //visible only to authenticated users
                'visible' => !Yii::app()->user->isGuest
            ),
            array(
                'label' => 'Login',
                'url' => array('site/login'),
                'linkOptions' => array('class' => 'row-last'),
                //visible only to guests
                'visible' => Yii::app()->user->isGuest),
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
        if (isset($_POST['ajax']) && ($_POST['ajax'] === $form || (is_array($form) && in_array($_POST['ajax'], $form)))) {
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