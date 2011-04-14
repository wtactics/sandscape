<?php

class SiteController extends Controller {

    public function actionIndex() {
        $this->render('index', array('page' => Page::model()->find('pageId = :id', array(':id' => 'about'))));
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
