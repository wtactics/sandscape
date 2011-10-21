<?php

class AdministrationController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
