<?php
/*
 * controllers/AdminController.php
 * 
 * This file is part of SandScape.
 * http://sandscape.sourceforge.net/
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
class AdminController extends GenericAdminController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        
        $this->menu[0]['active'] = true;
    }

    public function actionIndex() {
        $viewData = array('menu' => $this->menu);
        $this->render('index', $viewData);
    }

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array('index'),
                'expression' => function ($user, $rule) {
                    return (!Yii::app()->user->isGuest && Yii::app()->user->role === 'admin');
                }
                )), parent::accessRules());
    }

}

?>
