<?php

class Upgrade extends Administration {

    function __construct() {
        parent::__construct();

        $this->validateUser();
    }

    public function start($params = array()) {
        $this->render('upgrade');
    }

}
