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
        
        $url = Yii::app()->request->baseUrl .'/images/';
        
        $this->sessionMenu = array(
            array('label' => '<img src="'. $url .'widgets.png" title="Administration"/>', 'url' => array('/admin')),
            array('label' => '<img src="'. $url .'vcard.png" title="Profile"/>', 'url' => array('/account')),
            array('label' => '<img src="'. $url .'lock.png" title="Logout"/>', 'url' => array('/site/logout')),
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