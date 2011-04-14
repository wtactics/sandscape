<?php

class AdminController extends GenericAdminController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
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
