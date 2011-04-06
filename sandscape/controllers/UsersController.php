<?php

class UsersController extends GenericAdminController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        
        $this->menu[4]['active'] = true;
    }

    public function actionIndex() {
        $user = new User('search');
        $user->unsetAttributes();

        if (isset($_GET['User']))
            $user->attributes = $_GET['User'];

        //TODO: paging, action buttons (reset key, reset password, activate)
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
                        'buttons' => array('view' => array('visible' => 'false'))
                    ),
                ),
            )
        );

        $this->render('index', $viewData);
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $user = $this->loadModel($id);
            $user->setAttribute('active', 0);
            $user->save();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionUpdate($id) {
        $user = $this->loadModel($id);
        $this->performAjaxValidation($user);

        //TODO: success message...
        $success = false;
        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            $success = $user->save();
        }

        $viewData = array(
            'menu' => array(
                'id' => 'submenu',
                'items' => $this->menu
            ),
            'model' => $user
        );

        $this->render('update', $viewData);
    }

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
    }

    public function loadModel($id) {
        $model = User::model()->findByPk((int) $id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    private function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
