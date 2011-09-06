<?php

/*
 * View.php
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

class View {

    private $layout;
    private $scripts;
    private $styles;
    private $inits;
    private $data;
    private $theme;
    private $themePath;
    private $parcials;
    private $controller;

    public function __construct($controller, $theme, $layout = '//layouts/admin-layout') {
        $this->controller = $controller;
        $this->layout = $layout;
        $this->theme = $theme;
        $this->themePath = APPROOT . '/themes/' . $this->theme . '/';
        $this->scripts = array();
        $this->styles = array();
        $this->inits = array();
        $this->data = array();
        $this->parcials = array();
    }

    public function __get($name) {
        return (isset($this->data[$name]) ? $this->data[$name] : null);
    }

    public function createURL($path) {
        $base = StaySimple::app()->getURL() . (Config::getInstance()->get('site.hideindex') ? '' : 'index.php/');
        if (StaySimple::app()->getLocation() == StaySimple::$ADMIN) {
            $base .= Config::getInstance()->get('system.path') . '/';
        }

        return $base . $path;
    }

    public function includePluginOutput($outputID) {
        return Plugin::getOutput($outputID, $this);
    }

    public function includeTemplateFile($name) {
        $name = $this->themePath . $name . '.php';
        if (is_file($name))
            include $name;
    }

    public function registerScript($script, $asset = null) {
        $important = false;
        if ($script[0] === '!') {
            $script = str_replace('!', '', $script);
            $important = true;
        }

        if (!isset($this->scripts[$script])) {

            if ($important) {
                $this->scripts = array_merge(array("$script" => array('name' => $script)), $this->scripts);
            } else {
                $this->scripts[$script]['name'] = $script;
            }
            if (!$asset) {
                $asset = $this->theme;
            }

            $this->scripts[$script]['asset'] = $asset;
        }
    }

    public function registerStyle($style, $asset = null, $media = 'screen') {
        $important = false;
        if ($style[0] === '!') {
            $style = str_replace('!', '', $style);
            $important = true;
        }

        if (!isset($this->styles[$style])) {
            if ($important) {
                $this->styles = array_merge(array("$style" => array('name' => $style)), $this->styles);
            } else {
                $this->styles[$style]['name'] = $style;
            }
            if (!$asset) {
                $asset = $this->theme;
            }

            $this->styles[$style]['asset'] = $asset;
            $this->styles[$style]['media'] = $media;
        }
    }

    public function registerInitScript($script, $onready = true) {
        if ($onready) {
            $this->inits['ready'][] = $script;
        } else {
            $this->inits['alone'][] = $script;
        }
    }

    public function getSiteFullURL() {
        return StaySimple::app()->getURL() . 'index.php/';
    }

    public function getStyleSection() {
        $base = $this->getSiteFullURL() . 'resource/get/';

        ob_start();
        foreach ($this->styles as $style) {
            echo "\n", '<link rel="stylesheet" type="text/css" media="', $style['media'],
            '" href="', $base, $style['asset'], '/', $style['name'], '" />';
        }
        echo "\n";

        return ob_get_clean();
    }

    public function getScriptSection() {
        $base = $this->getSiteFullURL() . 'resource/get/';
        ob_start();
        foreach ($this->scripts as $script) {
            echo "\n", '<script type="text/javascript" src="', $base, $script['asset'],
            '/', $script['name'], '"></script>';
        }
        echo "\n";

        return ob_get_clean();
    }

    public function getInitScriptSection() {
        ob_start();
        if (count($this->inits)) {
            echo "\n", '<script type="text/javascript">';
            if (isset($this->inits['ready'])) {
                echo "\n$(document).ready(function() {";
                foreach ($this->inits['ready'] as $script) {
                    echo "\n", $script;
                }
                echo "\n});\n";
            }

            if (isset($this->inits['alone'])) {
                foreach ($this->inits['alone'] as $script) {
                    echo "\n", $script;
                }
                echo "\n\n";
            }

            echo '</script>';
        }

        return ob_get_clean();
    }

    public function getContentSection() {
        ob_start();
        foreach ($this->parcials as $parcial) {
            echo $parcial;
        }

        return ob_get_clean();
    }

    public function getHeaderSection($template = null) {
        ob_start();

        echo '<meta name="author" content="', $this->page->getAuthor(), '" />', "\n";
        echo '<meta name="description" content="', $this->page->getMetaDescription(), '" />', "\n";
        echo '<meta name="keywords" content="', $this->page->getMetaKeywords(), '" />', "\n";

        return ob_get_clean();
    }

    public function getMainMenuSection($id = 'mainnav', $template = null) {
        ob_start();

        echo '<ul id="', $id, '">';
        foreach ($this->pagemanager->getMenuPages() as $entry) {
            echo '<li><a href="', $this->createURL($entry->getName()), '"', ($this->page->getName() == $entry->getName() ? ' class="current"' : ''), '>', $entry->getMenuTitle(), '</a></li>', "\n";
        }
        echo '</ul>';

        return ob_get_clean();
    }

    public function getSecundaryMenuSection($id = 'secnav', $template = null) {
        $wkpage = $this->page;
        if ($this->page->getParent() != '') {
            $wkpage = PageManager::loadPage($this->page->getParent());
        }

        if ($wkpage->hasChildren()) {
            ob_start();
            echo '<ul id="', $id, '">';
            foreach ($wkpage->getChildren() as $child) {
                echo '<li><a href="', $this->createURL($child->getParent() . '/' . $child->getName()), '">', $child->getTitle(), '</a></li>', "\n";
            }
            echo '</ul>';

            return ob_get_clean();
        }

        return '';
    }

    public function getSiteTitle() {
        return Config::getInstance()->get('site.name');
    }

    public function getAssetLink($asset, $base = null) {
        if (!$base) {
            $base = $this->theme;
        }
        return $this->getSiteFullURL() . 'resource/get/' . $base . '/' . $asset;
    }

    public function getDownloadLink($file) {
        return $this->getSiteFullURL() . 'resource/file/' . $file;
    }

    public function getContactEmail() {
        return Config::getInstance()->get('system.email');
    }

    public function getStatySimpleFooterCredits() {
        return ucfirst($this->getTranslatedString('STAY_GENERAL_USING')) . ' <a href="http://code.google.com/p/stay-simple-cms/">StaySimple CMS</a>';
    }

    public function getStaySimpleVersion() {
        return SSVERSION;
    }

    public function renderPlugins($hook) {
        return Plugin::getOutput($hook, $this);
    }

    public function render($view, $data = array(), $return = false) {
        if (empty($view)) {
            throw new Exception('Invalid view.');
        }

        if (is_object($data)) {
            $data = get_object_vars($data);
        } else if (!is_array($data)) {
            $data = array($data => $data);
        }
        $this->data = array_merge($this->data, $data);

        $file = $this->themePath . $view . '.php';
        ob_start();
        if (is_file($file)) {
            include $file;
        } else if (is_file($view)) {
            include $view;
        }

        if ($return) {
            return ob_get_clean();
        }
        $this->parcials[] = ob_get_clean();
        $this->output();
    }

    public function output() {
        $output = '';
        $path = null;
        if (strpos($this->layout, '//layouts') === 0) {
            $name = explode('//layouts/', $this->layout);
            $path = APPROOT . '/themes/layouts/' . $name[1] . '.php';
        } else {
            $path = $this->themePath . $this->layout . '.php';
        }

        if (is_file($path)) {
            ob_start();
            include $path;
            $output = ob_get_clean();
        }

        echo $output;
    }

    public function getMessages() {
        $messages = array();

        while (($m = $this->controller->popMessage()) != null) {
            $messages[] = $m;
        }

        return $messages;
    }

    public function getTranslatedString($key, $params = array()) {
        return StaySimple::app()->getTranslatedString($key, $params);
    }

    public function getAccessKey($text) {
        $found = array();
        $matched = preg_match('/<em>([a-zA-Z])<\/em>/', $string, $found);
        if ($matched != 1) {
            return null;
        }
        return strtolower($found[1]);
    }

    public function getSystemLanguage() {
        return Config::getInstance()->get('system.locale.language');
    }

    public function getAllPublishedPages() {
        return $this->pagemanager->getPublishedPages();
    }

    public function getShortDateFormat() {
        return Config::getInstance()->get('system.locale.shortdateformat');
    }

    public function getLongDateFormat() {
        return Config::getInstance()->get('system.locale.longdateformat');
    }

    public function getTimeFormat() {
        return Config::getInstance()->get('system.locale.timeformat');
    }

}
