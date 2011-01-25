<?php

class GameController extends CController {

    public function  __construct($id,$module=null) {
        parent::__construct($id, $module);
        $this->layout = '//layouts/game';

    }
    
    public function actionIndex() {
        $this->render('index');
    }
}

?>
