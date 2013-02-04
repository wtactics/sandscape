<?php

/* AppicationController.php
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
 * Base controller class for every Sandscape controller class.
 * 
 * <em>AppController</em> is the parent class for every other controller class 
 * created to answer standard web requests.
 * 
 * Any sub-class should override the <em>accessRules</em> method.
 */
class ApplicationController extends CController {

    /**
     * @var string The current layout used by this controller. Should always be 
     * a valid layout file form the default layout folder, <em>//layouts</em> 
     */
    public $layout;

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
    protected $gameCount;
    protected $deckCount;
    protected $userCount;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        $this->layout = '//layouts/site';

        $this->menu = array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => array(
                    '---',
                    array(
                        'label' => Yii::t('sandscape', 'Home'),
                        'url' => array('site/index'),
                        'visible' => Yii::app()->user->isGuest
                    ),
                    array(
                        'label' => Yii::t('sandscape', 'Login'),
                        'url' => array('site/login'),
                        'visible' => Yii::app()->user->isGuest
                    ),
                    array(
                        'label' => Yii::t('sandscape', 'Dashboard'),
                        'url' => array('dashboard/index'),
                        'visible' => !Yii::app()->user->isGuest
                    ),
                    array(
                        'label' => Yii::t('sandscape', 'Play'),
                        'url' => array('lobby/index'),
                        'visible' => !Yii::app()->user->isGuest
                    ),
                    array(
                        'class' => 'bootstrap.widgets.TbMenu',
                        'label' => Yii::t('backend', 'Game Settings'),
                        'visible' => !Yii::app()->user->isGuest && Yii::app()->user->role == 'administrator',
                        'items' => array(
                            array(
                                'label' => Yii::t('sandscape', 'Cards'),
                                'url' => array('cards/index'),
                            ),
                            '---',
                            array(
                                'label' => Yii::t('sandscape', 'Dice'),
                                'url' => array('dice/index'),
                            ),
                            array(
                                'label' => Yii::t('sandscape', 'Card States'),
                                'url' => array('states/index'),
                            ),
                            array(
                                'label' => Yii::t('sandscape', 'Card Tokens'),
                                'url' => array('tokens/index'),
                            ),
                            '---',
                            array(
                                'label' => Yii::t('sandscape', 'Player Counters'),
                                'url' => array('counters/index'),
                            ),
//                            '---',
//                            array(
//                                'label' => Yii::t('sandscape', 'Gameplay Options'),
//                                'url' => array('administration/gameoptions'),
//                            ),
                        ),
                    ),
                ),
            ),
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'items' => array(
                    array(
                        'label' => Yii::t('sandscape', 'System Settings'),
                        'visible' => !Yii::app()->user->isGuest && Yii::app()->user->role == 'administrator',
                        'items' => array(
                            array(
                                'label' => Yii::t('sandscape', 'Users'),
                                'url' => array('users/index'),
                            ),
//                            '---',
//                            array(
//                                'label' => Yii::t('sandscape', 'Chat Filter'),
//                                'url' => array('administration/chatfilter'),
//                            ),
//                            array(
//                                'label' => Yii::t('sandscape', 'Chat Logs'),
//                                'url' => array('chatlogs/index'),
//                            ),
//                            array(
//                                'label' => Yii::t('sandscape', 'Maintenance Tools'),
//                                'url' => array('administration/maintenancetools'),
//                            ),
//                            array(
//                                'label' => Yii::t('sandscape', 'System Settings'),
//                                'url' => array('administration/sandscapesettings'),
//                            )
                        )
                    ),
                    '---',
                    array(
                        'label' => Yii::app()->user->name,
                        'items' => array(
                            array('label' => Yii::t('sandscape', 'Decks'), 'url' => array('users/decks')),
                            //array('label' => Yii::t('sandscape', 'Games'), 'url' => array('account/index')),
                            '---',
                            array('label' => Yii::t('sandscape', 'Profile'), 'url' => array('users/profile')),
                            '---',
                            array('label' => Yii::t('sandscape', 'Logout'), 'url' => array('site/logout')),
                        ),
                        'visible' => !Yii::app()->user->isGuest
                    ),
                ),
            ),
        );

        //$this->gameCount = intval(Game::model()->count('ended IS NOT NULL'));
        //$this->deckCount = intval(Deck::model()->count('active = 1'));
        //$this->userCount = intval(User::model()->count('active = 1'));
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

}