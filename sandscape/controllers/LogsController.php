<?php

class LogsController extends Controller {

    private $menu;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->menu = array(
            array('label' => 'Cards', 'url' => array('/cards')),
            array('label' => 'Cleanup', 'url' => array('/cleanup')),
            array('label' => 'CMS', 'url' => array('/pages')),
            array('label' => 'Options', 'url' => array('/options')),
            array('label' => 'Users', 'url' => array('/users')),
        );
    }

    public function actionIndex() {
        $viewData = array('menu' => $this->menu);
        $this->render('index', $viewData);
    }

}

?>
