<?php

/*
 * UsersController.php
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

class UsersController extends GenericAdminController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->menu[4]['active'] = true;
    }

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array('index', 'update', 'delete'),
                'expression' => function ($user, $rule) {
                    return (!Yii::app()->user->isGuest && Yii::app()->user->role === 'admin');
                }
                )), parent::accessRules());
    }

    /**
     * Lists all active users in the database.
     */
    public function actionIndex() {
        $user = new User('search');
        $user->unsetAttributes();

        if (isset($_GET['User']))
            $user->attributes = $_GET['User'];

        $viewData = array(
            'menu' => array(
                'id' => 'submenu',
                'items' => $this->menu
            ),
            'grid' => array(
                'dataProvider' => $user->search(),
                'filter' => $user,
                'columns' => array(
                    'name',
                    'email',
                    array(
                        'name' => 'visited',
                        'value' => 'date("Y/m/d - H:m", $data->visited)',
                        'filter' => false
                    ),
                    array(
                        'name' => 'admin',
                        'value' => '$data->admin',
                        'filter' => array('Regular', 'Administrator')
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'view' => array('visible' => 'false'),
                            'resetKey' => array(
                                'label' => 'Reset Act. Key',
                                'url' => Yii::app()->createUrl("/users/resetKey/", array("id" => $data->userId)),
                                'imageUrl' => '',
                                'click' => ''
                            ),
                            'resetPassword' => array('
                                label' => 'Reset Password',
                                'url' => Yii::app()->createUrl("/users/resetPassword/", array("id" => $data->userId)),
                                'imageUrl' => '',
                                'click' => ''
                            ),
                            'activate' => array(
                                'label' => 'Activate user',
                                'url' => Yii::app()->createUrl("/users/activate/", array("id" => $data->userId)),
                                'imageUrl' => '',
                                'click' => ''
                            )
                        )
                    ),
                ),
            )
        );

        $this->render('index', $viewData);
    }

    /**
     * Updates a user's information.
     * 
     * @param integer $id ID for the user to update.
     */
    public function actionUpdate($id) {
        $user = $this->loadUser($id);

        $viewData = array(
            'menu' => array(
                'id' => 'submenu',
                'items' => $this->menu
            )
        );

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            $viewData['success'] = $user->save();
        }

        $viewData['model'] = $user;
        $this->render('update', $viewData);
    }

    /**
     * Deletes a user by marking him as inactive.
     * 
     * @param integer $id ID for the user to remove.
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $user = $this->loadUser($id);
            $user->setAttribute('active', 0);
            $user->save();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

            Yii::app()->end();
        }
        else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    //TODO: 
    public function actionResetKey($id) {
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    //TODO:
    public function actionResertPassword($id) {
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    //TODO:
    public function actionActivate() {
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /*


      public function actionCreate() {
      $user = new User();
      $this->performAjaxValidation($user);

      //TODO: success message...
      $success = false;
      if (isset($_POST['User'])) {
      $user->attributes = $_POST['User'];

      //TODO: password, autentication key, so on...
      //User::generatePassword();
      //User::generateKey();
      $success = $user->save();
      }

      $viewData = array(
      'menu' => array(
      'id' => 'submenu',
      'items' => $this->menu
      ),
      'model' => $user
      );

      $this->render('create', $viewData);
      } */

    private function loadUser($userId) {
        $user = User::model()->findByPk((int) $userId);

        if ($user === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $user;
    }

}
