<?php

class GenericAdminController extends Controller {

    protected $menu;

    function __construct($id, $module) {
        parent::__construct($id, $module);

        $this->menu = array(
            array('label' => 'Cards', 'url' => array('/cards'), 'linkOptions' => array('class' => 'cardsmenu')),
            array('label' => 'Cleanup', 'url' => array('/cleanup')),
            array('label' => 'CMS', 'url' => array('/pages'), 'linkOptions' => array('class' => 'cmsmenu')),
            array('label' => 'Options', 'url' => array('/options'), 'linkOptions' => array('class' => 'optionsmenu')),
            array('label' => 'Users', 'url' => array('/users'), 'linkOptions' => array('class' => 'usersmenu')),
        );
    }

}

