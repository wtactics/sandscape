<?php

class AdminController extends GenericAdminController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $viewData = array('menu' => $this->menu);
        $this->render('index', $viewData);
    }

}

?>
