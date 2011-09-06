<?php

/*
 * PageManager.php
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

class PageManager extends Manager {

    private $pages;
    private $published;
    private $unpublished;
    private $menu;
    private $top;

    public function __construct() {
        parent::__construct();

        $this->pages = array();
        $this->published = array();
        $this->unpublished = array();
        $this->menu = array();
        $this->top = array();
    }

    private function listPageFiles($onlyname = false) {
        $found = array();

        if (($dh = opendir(DATAROOT . '/pages'))) {
            while (($filename = readdir($dh)) !== false) {
                if (($pos = strpos($filename, '.xml')) && $pos == (strlen($filename) - 4)) {
                    if ($onlyname) {
                        $arr = explode('.', $filename);
                        unset($arr[count($arr) - 1]);

                        $found[] = implode('.', $arr);
                    } else {
                        $found[] = $filename;
                    }
                }
            }
            closedir($dh);
        }

        return $found;
    }

    public function getPage($name) {
        if (isset($this->pages[$name]))
            return $this->pages[$name];

        return null;
    }

    public function getPages($exclude = null) {
        $pages = $this->pages;
        if ($exclude) {
            $pages = array();
            if (is_object($exclude))
                $exclude = $exclude->getName();

            foreach ($this->pages as $name => $page) {
                if ($name !== $exclude) {
                    $pages[$name] = $page;
                }
            }
        }

        return $pages;
    }

    public static function pageExists($name) {
        return is_file(DATAROOT . '/pages/' . $name . '.xml');
    }

    public function loadAll() {
        $this->pages = array();

        $temp = array();
        foreach ($this->listPageFiles(true) as $name) {
            $p = $this->loadSinglePage($name);
            $this->pages[$name] = $p;

            //store parent-child relation until every page is loaded
            if ($p->getParent() != '') {
                $temp[$p->getParent()][] = $p;
            } else {
                $this->top[$name] = $p;
            }

            if ($p->getPublished()) {
                $this->published[$name] = $p;
            } else {
                $this->unpublished[$name] = $p;
            }

            if ($p->getInMenu()) {
                $this->menu[$name] = $p;
            }
        }

        //add children to correct parent
        foreach ($temp as $parent => $children) {
            foreach ($children as $child) {
                $this->pages[$parent]->addChild($child);
            }
        }

        $this->sortMenu();

        return $this->pages;
    }

    public static function loadPage($name) {
        $me = new PageManager();
        $me->loadAll();

        return $me->pages[$name];
    }

    private function loadSinglePage($name) {
        $xml = new XMLFile(DATAROOT . '/pages/' . $name . '.xml');

        return new Page($name, html_entity_decode(strval($xml->text), ENT_NOQUOTES, 'UTF-8'), intval($xml->updated),
                        html_entity_decode(strval($xml->title), ENT_NOQUOTES, 'UTF-8'),
                        html_entity_decode(strval($xml->meta->keywords), ENT_NOQUOTES, 'UTF-8'),
                        html_entity_decode(strval($xml->meta->description), ENT_NOQUOTES, 'UTF-8'),
                        (object) array(
                            'status' => intval($xml->menu->status),
                            'order' => intval($xml->menu->order),
                            'title' => html_entity_decode(strval($xml->menu->title), ENT_NOQUOTES, 'UTF-8')
                        ), strval($xml->template), html_entity_decode(strval($xml->parent), ENT_NOQUOTES, 'UTF-8'),
                        intval($xml->published), html_entity_decode(strval($xml->author), ENT_NOQUOTES, 'UTF-8'));
    }

    public function getMenuPages() {
        return $this->menu;
    }

    public function getUnpublishedPages() {
        return $this->unpublished;
    }

    public function getPublishedPages() {
        return $this->published;
    }

    private function sortMenu() {
        uasort($this->menu, function ($page1, $page2) {
                    return $page1->getMenuOrder() - $page2->getMenuOrder();
                });
    }

    public function getTopPages($exclude = null) {
        $pages = $this->top;
        if ($exclude) {
            $pages = array();
            if (is_object($exclude))
                $exclude = $exclude->getName();
        }

        foreach ($this->top as $name => $page) {
            if ($name !== $exclude) {
                $pages[$name] = $page;
            }
        }

        return $pages;
    }

    public function savePage(Page $page) {
        if (!$page->getName() || trim($page->getName()) == '') {
            return false;
        }

        $filepath = DATAROOT . '/pages/' . $page->getName() . '.xml';
        if (is_file($filepath)) {
            if (BackupManager::backupPage($page->getName())) {
                $this->deletePage($page->getName());
            }
        }

        $xml = new XMLFile('<page version="' . SSVERSION . '"></page>');

        $xml->addChild('updated', time());
        $xml->addChildWithCData('title', $page->getTitle());

        $meta = $xml->addChild('meta');
        $child = $meta->addChild('keywords');
        $xml->addCData($child, $page->getMetaKeywords());
        $child = $meta->addChild('description');
        $xml->addCData($child, $page->getMetaDescription());

        $menu = $xml->addChild('menu');
        $menu->addChild('status', ($page->getInMenu() ? 1 : 0));
        $child = $menu->addChild('title');

        $xml->addCData($child, $page->getMenuTitle());
        $menu->addChild('order', $page->getMenuOrder());
        $xml->addChild('template', $page->getTemplate());
        $xml->addChild('parent', $page->getParent());
        $xml->addChild('published', $page->getPublished());
        $xml->addChildWithCData('author', 'StaySimple');
        $xml->addChildWithCData('text', $page->getText());

        $success = $xml->asXML(DATAROOT . '/pages/' . $page->getName() . '.xml');

        if (!$success) {
            BackupManager::revertPageBackup($name);
        }

        return $success;
    }

    public function deletePage($name) {
        $page = DATAROOT . '/pages/' . $name . '.xml';
        if (is_file($page)) {
            BackupManager::backupPage($name);
            return unlink($page);
        }

        return false;
    }

    public function listPageTemplates() {
        $templates = array();

        $file = APPROOT . '/themes/' . Config::getInstance()->get('site.theme') . '/theme.xml';
        if (is_file($file)) {
            $xml = new XMLFile($file);

            foreach ($xml->templates->template as $template) {
                $templates[] = new PageTemplate($template->title, $template->file);
            }
        }

        return $templates;
    }

    public static function cleanSlug($title, $delimiter = '-') {
        return preg_replace("/[\/_|+ -]+/", $delimiter, strtolower(trim(preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', iconv('UTF-8', 'ASCII//TRANSLIT', $title)), '-')));
    }

}
