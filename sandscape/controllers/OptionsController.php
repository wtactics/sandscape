<?php

class OptionsController extends GenericAdminController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->menu[3]['active'] = true;
    }

    public function actionIndex() {
        $viewData = array('menu' => $this->menu);
        $this->render('index', $viewData);
    }

}

?>
