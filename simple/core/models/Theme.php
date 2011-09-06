<?php

/*
 * Theme.php
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
 * Stores theme information.
 */
class Theme {

    private $folder;
    private $type;
    private $name;
    private $author;
    private $url;
    private $urlTitle;
    private $version;
    private $description;
    private $screenshot;
    private $minVersion;
    private $templates;

    public function __construct($folder, $type, $name, $author, $url, $urlTitle, $version, $description, $screenshot, $minVersion, $templates = null) {
        $this->folder = $folder;
        $this->type = $type;
        $this->name = $name;
        $this->author = $author;
        $this->url = $url;
        $this->urlTitle = $urlTitle;
        $this->version = $version;
        $this->description = $description;
        $this->screenshot = $screenshot;
        $this->minVersion = $minVersion;
        $this->templates = $templates;
    }

    public function getFolder() {
        return $this->folder;
    }

    public function getType() {
        return $this->type;
    }

    public function getName() {
        return $this->name;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getUrlTitle() {
        return $this->urlTitle;
    }

    public function getVersion() {
        return $this->version;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getScreenshot() {
        return $this->screenshot;
    }

    public function getMinVersion() {
        return $this->minVersion;
    }

    public function getTemplates() {
        return $this->templates;
    }

}
