<?php

class AccountController extends Controller {

    private $menu;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->render('index', array('model' => new User()));
    }

}

?>
