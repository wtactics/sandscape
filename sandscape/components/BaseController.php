<?php

/* BaseController.php
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

class BaseController extends CController {

    public $layout;
    protected $nav;
    protected $title;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->layout = '//layouts/main';

        $this->nav = array(
            array(
                'class' => 'bootstrap.widgets.TbNav',
                'items' => array(
                    array(
                        'label' => Yii::t('sandscape', 'Home'),
                        'url' => array('sandscape/index'),
                        'visible' => Yii::app()->user->isGuest
                    ),
                    array(
                        'label' => Yii::t('sandscape', 'Dashboard'),
                        'url' => array('sandscape/dashboard'),
                        'visible' => !Yii::app()->user->isGuest
                    ),
                    array(
                        'label' => Yii::t('sandscape', 'Play'),
                        'url' => array('lobby/index'),
                        'visible' => !Yii::app()->user->isGuest
                    )
                )
            ),
            array(
                'class' => 'bootstrap.widgets.TbNav',
                'items' => array(array(
                        'label' => Yii::t('sandscape', 'System'),
                        'items' => array(
                            array(
                                'label' => Yii::t('sandscape', 'Users'),
                                'url' => array('users/index'),
                                'visible' => Yii::app()->user->isAdministrator()
                            ),
                        ),
                    ),
                    array(
                        'label' => Yii::t('sandscape', 'Login'),
                        'url' => array('#'),
                        'items' => array(
                            HHtml::loginForm(array('sandscape/login'))
                        ),
                        'visible' => Yii::app()->user->isGuest
                    ),
                    array(
                        'label' => Yii::t('sandscape', Yii::app()->user->name),
                        'items' => array(
                            array(
                                'label' => Yii::t('sandscape', 'Decks'),
                                'url' => array('decks/index', 'id' => Yii::app()->user->id)
                            ),
                            array(
                                'label' => Yii::t('sandscape', 'Stats'),
                                'url' => array('users/stats', 'id' => Yii::app()->user->id)
                            ),
                            TbHtml::menuDivider(),
                            array(
                                'label' => Yii::t('sandscape', 'Account'),
                                'url' => array('users/account')
                            ),
                            array(
                                'label' => Yii::t('sandscape', 'Logout'),
                                'url' => array('sandscape/logout')
                            ),
                        ),
                        'visible' => !Yii::app()->user->isGuest
                    ),
                ),
                'htmlOptions' => array('class' => 'pull-right')
            ),
            array(
                'class' => 'bootstrap.widgets.TbNav',
                'items' => array(array(
                        'label' => Yii::t('sandscape', 'Game'),
                        'items' => array(
                            array(
                                'label' => Yii::t('sandscape', 'Cards'),
                                'url' => array('cards/index')
                            ),
                            array(
                                'label' => Yii::t('sandscape', 'Decks'),
                                'url' => array('userdecks/index')
                            ),
                            TbHtml::menuDivider(),
                            array(
                                'label' => Yii::t('sandscape', 'Counters'),
                                'url' => array('counters/index')
                            ),
                            array(
                                'label' => Yii::t('sandscape', 'Dice'),
                                'url' => array('dice/index')
                            ),
                            array(
                                'label' => Yii::t('sandscape', 'States'),
                                'url' => array('states/index')
                            ),
                            array(
                                'label' => Yii::t('sandscape', 'Tokens'),
                                'url' => array('tokens/index')
                            ),
                        ),
                        'visible' => Yii::app()->user->isGameMaster()
                    ),
                ),
                'htmlOptions' => array('class' => 'pull-right')
            )
        );
    }

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete'
        );
    }

    /**
     * Performs the AJAX validation.
     * 
     * @param User $model the model to be validated
     * @param string $form
     */
    protected function performAjaxValidation($model, $form) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
