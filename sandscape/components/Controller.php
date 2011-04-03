<?php

class Controller extends CController {

    private $menu;
    private $sessionMenu;

    function __construct($id, $module) {
        parent::__construct($id, $module);

        $this->layout = '//layouts/main';
        $this->menu = array(
            array('label' => 'About', 'url' => array('/site')),
            array('label' => 'Lobby', 'url' => array('/lobby')),
            array('label' => 'Statistics', 'url' => array('/stats')),
        );
        
        $this->sessionMenu = array(
            array('label' => 'administration', 'url' => array('/admin')),
            array('label' => 'profile', 'url' => array('/account')),
            array('label' => 'logout', 'url' => array('/site/logout')),
        );
    }

    public function setActiveMenu($index) {
        foreach ($this->menu as $m) {
            $m[$index]['url']['active'] = false;
        }

        $this->menu[$index]['url']['active'] = true;
    }

    public function getMenu() {
        return $this->menu;
    }
    
    public function getSessionMenu() {
        return $this->sessionMenu;
    }

}