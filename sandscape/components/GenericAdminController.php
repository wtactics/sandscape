<?php

/*
 * GenericAdminController.php
 * 
 * This file is part of SandScape.
 * 
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 */

/**
 * A base controller class, used by all administration controllers, that 
 * provides an administration menu.
 * 
 * @since 1.0
 * @author Sérgio Lopes
 */
class GenericAdminController extends Controller {

    /**
     * Menu available to all administration controllers.
     */
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
