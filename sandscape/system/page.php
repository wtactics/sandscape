<?php

abstract class Page {

    private $view;

    public function __construct($view) {
        $this->view = $view;
    }

    public abstract function index();

    public function show() {
        ob_start();
        include VIEWSPATH . $this->view . '.php';
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;
    }

}