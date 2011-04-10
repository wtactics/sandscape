<?php

class GameController extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);

        $this->layout = '//layouts/game';
    }

    public function actionIndex() {
        $this->render('index');
    }

}
