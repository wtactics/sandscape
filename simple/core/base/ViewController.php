<?php

/*
 * ViewController.php
 *
 * (C) 2011, StaySimple team.
 *
 * This file is part of StaySimple.
 * http://code.google.com/p/stay-simple-cms/
 *
 * StaySimple is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * StaySimple is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with StaySimple.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * A generic controller that has a view object.
 */
abstract class ViewController extends Controller {

    private $view;

    public function __construct($theme, $layout = '//layouts/admin-layout') {
        parent::__construct();
        $this->view = new View($this, $theme, $layout);
    }

    /**
     * Renders the given view. This method just passes the control to the 
     * current view.
     * 
     * @param string $view The name of the view to render.
     * @param array $data A key/value array of variables to make available in 
     * the view.
     * 
     * @see View::render()
     */
    public function render($view, $data = array()) {
        $this->view->render($view, $data);
    }

    /**
     * Returns the view created for this controller. Currently it's always an 
     * instance of <em>View</em> to which we pass the this controller, the 
     * theme it uses and the layout.
     * 
     * @return View The view owned by this controller.
     */
    public function getView() {
        return $this->view;
    }

}
