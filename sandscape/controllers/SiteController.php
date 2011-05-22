<?php
/*
 * controllers/SiteController.php
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
class SiteController extends Controller {

    public function actionIndex() {
        //$this->render('index', array('page' => Page::model()->find('pageId = :id', array(':id' => 'about'))));
        $this->render('aboutpage');
    }

    public function actionLogin() {
        $formModel = new LoginForm;

        if (isset($_POST['LoginForm'])) {
            $formModel->attributes = $_POST['LoginForm'];
            if ($formModel->validate())
                $this->redirect(Yii::app()->user->returnUrl);
        }

        $this->render('login', array('model' => $formModel));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function accessRules() {
        return array(array('allow', 'users' => array('*')));
    }

}
