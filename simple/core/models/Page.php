<?php

/*
 * Page.php
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
 * Stores page information.
 */
class Page {

    private $name;
    private $text;
    private $updated;
    private $title;
    private $metaKeywords;
    private $metaDescription;
    private $menu;
    private $template;
    private $parent;
    private $published;
    private $author;
    private $children;

    public function __construct($name, $text = null, $updated = null, $title = null, $metaKeywords = null, $metaDescription = null, $menu = array(), $template = null, $parent = null, $published = 0, $author = null, $children = array()) {
        $this->name = $name;
        $this->text = $text;
        $this->updated = $updated;
        $this->title = $title;
        $this->metaKeywords = $metaKeywords;
        $this->metaDescription = $metaDescription;
        if (is_array($menu))
            $menu = (object) $menu;

        $this->menu = $menu;
        $this->template = $template;
        $this->parent = $parent;
        $this->published = $published;
        $this->author = $author;
        $this->children = $children;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getMetaKeywords() {
        return $this->metaKeywords;
    }

    public function getMetaDescription() {
        return $this->metaDescription;
    }

    public function getInMenu() {
        if ($this->menu && isset($this->menu->status))
            return $this->menu->status != 0;

        return false;
    }

    public function getMenuOrder() {
        if ($this->menu && isset($this->menu->order))
            return $this->menu->order;

        return 0;
    }

    public function getMenuTitle() {
        if ($this->menu && isset($this->menu->title))
            return $this->menu->title;

        return null;
    }

    public function getTemplate() {
        return $this->template;
    }

    public function getParent() {
        return $this->parent;
    }

    public function isRoot() {
        return (!$this->parent);
    }

    public function getPublished() {
        return $this->published;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getName() {
        return $this->name;
    }

    public function hasChildren() {
        return count($this->children) > 0;
    }

    public function addChild($page) {
        if (!isset($this->children[$page->getName()])) {
            $this->children[$page->getName()] = $page;
        }
    }

    public function getChildren() {
        return $this->children;
    }

    public function bind($data) {
        $this->name = isset($data['name']) ? $data['name'] : '';
        $this->text = isset($data['text']) ? $data['text'] : '';
        $this->updated = isset($data['updated']) ? $data['updated'] : '';
        $this->title = isset($data['title']) ? $data['title'] : '';
        $this->metaKeywords = isset($data['metaKeywords']) ? $data['metaKeywords'] : '';
        $this->metaDescription = isset($data['metaDescription']) ? $_POST['metaDescription'] : '';

        $this->menu = (object) array(
                    'status' => (isset($data['inMenu']) ? $data['inMenu'] : (isset($data['menuStatus']) ? $data['menuStatus'] : 0)),
                    'order' => isset($data['menuOrder']) ? $data['menuOrder'] : 0,
                    'title' => isset($data['menuTitle']) ? $data['menuTitle'] : ''
        );

        $this->template = isset($data['template']) ? $data['template'] : '';
        $this->parent = isset($data['parent']) ? $data['parent'] : '';
        $this->published = isset($data['published']) ? $data['published'] : 0;
        $this->author = isset($data['author']) ? $data['author'] : '';
    }

    public function getExcerpt($length = 200, $html = true, $more = ' ...') {
        if (!$html) {
            $excerpt = strip_tags($this->text);
        }

        if (function_exists('mb_substr')) {
            return trim(mb_substr($this->text, 0, $length)) . $more;
        }

        return trim(substr($this->text, 0, $length)) . $more;
    }

}