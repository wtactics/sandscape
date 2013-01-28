<?php

/* StageController.php
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

class StageController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        echo 'Not implemented yet!';
    }

    public function actionSwipe() {
        echo 'Not implemented yet!';
        //$this->layout = '//layouts/game';
        //$cards = Card::model()->findAll('active = 1');
        //$this->render('swipe', array('cards' => $cards));
    }

    //TODO: update rules, temporary rules to block any user but administrators.
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'swipe'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}