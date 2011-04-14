<?php

class StatsController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array('index'),
                'users' => array('@')
                )), parent::accessRules());
    }

}

?>
