<?php

/*
 * components/Controller.php
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

/**
 * Base controller class for all controllers.
 */
class Controller extends CController {

    private $menu;
    private $sessionMenu;

    function __construct($id, $module) {
        parent::__construct($id, $module);

        $this->layout = '//layouts/main';
        $this->menu = array(
            array(
                'label' => 'About',
                'url' => array('/site')
            ),
            array(
                'label' => 'Lobby',
                'url' => array('/lobby'),
                'visible' => (!Yii::app()->user->isGuest)
            ),
            array(
                'label' => 'Statistics',
                'url' => array('/stats'),
                'visible' => (!Yii::app()->user->isGuest)
            ),
            array(
                'label' => 'My Cards',
                'url' => array('/mycards'),
                'visible' => (!Yii::app()->user->isGuest)
            ),
            array(
                'label' => 'Administration',
                'url' => array('/admin'),
                'visible' => (!Yii::app()->user->isGuest && Yii::app()->user->role === 'admin')
            )
        );

        $url = Yii::app()->request->baseUrl . '/images/';

        $this->sessionMenu = array(
            array(
                'label' => '<img src="' . $url . 'vcard.png" title="Profile"/>',
                'url' => array('/account'),
                'visible' => (!Yii::app()->user->isGuest)
            ),
            array(
                'label' => '<img src="' . $url . 'lock.png" title="Logout"/>',
                'url' => array('/site/logout'),
                'visible' => (!Yii::app()->user->isGuest)
            ),
            array(
                'label' => '<img src="' . $url . 'lock.png" title="Login"/>',
                'url' => array('/site/login'),
                'visible' => (Yii::app()->user->isGuest)
            )
        );
    }

    /**
     * Sets the current active menu, from the main menu.
     * 
     * @param type $index menu index, zero based.
     */
    public function setActiveMenu($index) {
        foreach ($this->menu as $m) {
            $m[$index]['url']['active'] = false;
        }

        $this->menu[$index]['url']['active'] = true;
    }

    /**
     * Returns the main applicatio menu.
     * 
     * @return array with the application menu.
     */
    public function getMenu() {
        return $this->menu;
    }

    /**
     * Returns the menu with login/logout actions and other actions that depend 
     * on the logged user.
     * 
     * @return array with the menu that is based on the current user/session.
     */
    public function getSessionMenu() {
        return $this->sessionMenu;
    }

    public function filters() {
        return array(
            'accessControl',
        );
    }

    /**
     * Returns the common access rules used by all controllers. The basic rules 
     * deny access to every action and to every user.
     * 
     * The method <em>must</em> be overloaded by children classes so that  
     * actions in those classes become available to users.
     * 
     * This method also provides a place where a general deny rule is 
     * implemented, thus preventing the existance of controllers without access 
     * rules.
     * 
     * @return array with the access rules.
     */
    public function accessRules() {
        return array(array('deny', 'users' => array('*')));
    }

}
