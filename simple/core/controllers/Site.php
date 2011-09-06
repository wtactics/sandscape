<?php

/*
 * Site.php
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
 * Controller class that shows pages.
 */
class Site extends ViewController {

    private $page;
    private $manager;

    public function __construct($pageName) {
        parent::__construct(Config::getInstance()->get('site.theme'), '//layouts/site-layout');
        $this->manager = new PageManager();

        $this->page = PageManager::loadPage($pageName);
        if (!$this->page->getPublished()) {
            $this->page = PageManager::loadPage('404');
        }
    }

    public function start($params = array()) {
        if ($this->page) {

            foreach (Plugin::getPlugins('pageContentProcessor') as $processor) {
                $method = $processor->method;
                $processor->instance->$method($this->page, $this->getView(), $params);
            }

            $this->manager->loadAll();
            $this->render($this->page->getTemplate(), array('pagemanager' => $this->manager, 'page' => $this->page));
        }
    }

}