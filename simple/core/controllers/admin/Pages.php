<?php

/*
 * Pages.php
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

class Pages extends Administration {

    private $manager;

    public function __construct() {
        parent::__construct();
        $this->manager = new PageManager();

        $this->validateUser();
    }

    public function start($params = array()) {
        $filter = false;

        $this->manager->loadAll();

        if (isset($_POST['filter'])) {
            $filter = intval($_POST['filter']);
            $_SESSION['filter'] = $filter;
        } else if (isset($_SESSION['filter'])) {
            $filter = intval($_SESSION['filter']);
        }

        $filterOptions = array(
            array('0', $this->getTranslatedString('STAY_PAGE_FILTER_ALL')),
            array('1', $this->getTranslatedString('STAY_PAGE_FILTER_PUBLISHED')),
            array('2', $this->getTranslatedString('STAY_PAGE_FILTER_UNPUBLISHED')),
                //TODO: add deleted option
                //array('3', $this->getTranslatedString('STAY_PAGE_FILTER_DELETED')),
        );
        $pages = $this->manager->getTopPages();
        if ($filter) {
            if ($filter == 1) {
                $pages = $this->manager->getPublishedPages();
            } else if ($filter == 2) {
                $pages = $this->manager->getUnpublishedPages();
            } else if ($filter == 3) {
                //TODO: deleted pages filter
            }
        }

        $this->render('pages', array('pages' => $pages, 'filter' => $filter, 'filterOptions' => $filterOptions));
    }

    public function edit($params = array()) {
        $page = new Page('');
        $revisions = null;
        $this->manager->loadAll();
        if (isset($params[0]) && $params[0] != '') {
            $query = $this->manager->getPage($params[0]);

            if ($query) {
                $page = $query;
                $revisions = BackupManager::getBackups($page->getName(), true);
            }
        }

        if (isset($_POST['Page'])) {
            $_POST['name'] = PageManager::cleanSlug($_POST['title']);
            
            $page->bind($_POST);
            if (!$this->manager->savePage($page)) {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PAGE_SAVE_ERROR'), Message::$ERROR));
            } else {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PAGE_SAVE_SUCCESS')));
            }
        }

        $parentPages = array(array('', ''));
        foreach ($this->manager->getTopPages($page) as $top) {
            $parentPages[] = array($top->getName(), $top->getName());
        }

        $pageTemplates = array();
        foreach ($this->manager->listPageTemplates() as $pt) {
            $pageTemplates[] = array($pt->getFile(), $pt->getTitle());
        }
        $this->render('page-edit', array(
            'page' => $page,
            'parentPages' => $parentPages,
            'pageTemplates' => $pageTemplates,
            'revisions' => $revisions,
        ));
    }

    public function delete($params = array()) {
        if (isset($params[0]) && $params[0] != '') {
            if (!$this->manager->deletePage($params[0])) {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PAGE_DELETE_ERROR'), Message::$ERROR));
            } else {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PAGE_DELETE_SUCCESS')));
            }
        } else {
            $this->queueMessage(new Message($this->getTranslatedString('STAY_PAGE_INVALID'), Message::$ERROR));
        }

        $this->redirect('pages');
    }

    public function deleteSelected($params = array()) {
        if (isset($_POST['select'])) {
            $names = $_POST['select'];

            $deletedCount = 0;
            $max = count($names);
            foreach ($names as $name) {
                if (!$this->manager->deletePage($name)) {
                    $this->queueMessage(new Message($this->getTranslatedString('STAY_PAGE_DELETE_SELECTED_ERROR', array($name)), Message::$ERROR));
                } else {
                    $deletedCount++;
                }
            }

            if ($deletedCount == 0) {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PAGE_DELETE_ALL_ERROR'), Message::$ERROR));
            } else if ($max != $deletedCount) {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PAGE_DELETE_SOME_ERROR')));
            } else {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_PAGE_DELETE_ALL_SUCCESS')));
            }
        }
        $this->redirect('pages');
    }

    public function restore($params = array()) {
        if (isset($params[1])) {
            if (!BackupManager::revertPageBackup($params[0], $params[1])) {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_BACKUP_RESTORE_ERROR')), Message::$ERROR);
            } else {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_BACKUP_RESTORE_SUCCESS')));
            }
        } else {
            $this->queueMessage(new Message($this->getTranslatedString('STAY_BACKUP_RESTORE_NO_FILE')), Message::$ERROR);
        }

        if (isset($params[0])) {
            $this->redirect('pages/edit/' . $params[0]);
        } else {
            $this->redirect('pages');
        }
    }

    public function preview($params = array()) {
        if (isset($params[0]) && isset($params[1])) {
            $path = DATAROOT . '/backups/' . $params[0] . '/' . $params[1];
            if (is_file($path)) {
                $xml = new XMLFile($path);
                $link = StaySimple::app()->getURL() . Config::getInstance()->get('system.path') . '/pages/restore/' . $params[0] . '/' . $params[1];
                echo '<div id="selectionButton"><a href="', $link, '">Revert to this backup.</a></div><br /><div id="previewcontent">', strval($xml->text), '</div>';
            }
        }
    }

}