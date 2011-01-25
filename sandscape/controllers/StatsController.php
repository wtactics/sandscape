<?php

class StatsController extends CController {

    public function __construct($id, $module=null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->render('index');
    }

}

?>
