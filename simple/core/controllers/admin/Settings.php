<?php

/*
 * Settings.php
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

class Settings extends Administration {

    public function __construct() {
        parent::__construct();

        $this->validateUser();
    }

    public function start() {
        $config = Config::getInstance();

        if (isset($_POST['Settings'])) {

            $config->set('site.home', $_POST['home']);
            $config->set('site.name', $_POST['name']);
            $config->set('site.theme', $_POST['sitheme']);
            $config->set('site.hideindex', $_POST['hideindex']);
            $config->set('system.email', $_POST['email']);
            $config->set('system.path', $_POST['path']);
            $config->set('system.theme', $_POST['systheme']);
            $config->set('system.pingengines', $_POST['pingengines']);
            $config->set('system.locale.language', $_POST['language']);
            $config->set('system.locale.shortdateformat', $_POST['shortdateformat']);
            $config->set('system.locale.longdateformat', $_POST['longdateformat']);
            $config->set('system.locale.timeformat', $_POST['timeformat']);

            if (!$config->save()) {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_SETTINGS_SAVE_ERROR'), Message::$ERROR));
            } else {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_SETTINGS_SAVE_SUCCESS')));
            }
        }

        $settings = (object) array(
                    'site' => (object) array(
                        'home' => $config->get('site.home'),
                        'name' => $config->get('site.name'),
                        'theme' => $config->get('site.theme'),
                        'hideindex' => $config->get('site.hideindex')
                    ),
                    'system' => (object) array(
                        'email' => $config->get('system.email'),
                        'path' => $config->get('system.path'),
                        'theme' => $config->get('system.theme'),
                        'pingengines' => $config->get('system.pingengines'),
                        'locale' => (object) array(
                            'language' => $config->get('system.locale.language'),
                            'shortdateformat' => $config->get('system.locale.shortdateformat'),
                            'longdateformat' => $config->get('system.locale.longdateformat'),
                            'timeformat' => $config->get('system.locale.timeformat')
                        )
                    )
        );

        $pages = array();
        $manager = new PageManager();
        $manager->loadAll();
        foreach ($manager->getTopPages() as $p) {
            $pages[] = array($p->getName(), $p->getTitle());
        }

        $loglevels = array(array('1', 'INFO'), array('2', 'WARNING'), array('3', 'ERROR'));
        $themes = StaySimple::app()->listSiteTemplates();

        $devthemes = array();
        foreach (StaySimple::app()->listAdminTemplates() as $template) {
            $devthemes[] = array($template->getFolder(), $template->getName());
        }
        $languages = StaySimple::app()->listLanguages();

        $this->render('settings', array(
            'content' => 'settings',
            'settings' => $settings,
            'toppages' => $pages,
            'themes' => $themes,
            'devthemes' => $devthemes,
            'languages' => $languages
        ));
    }

    public function backup() {
        $file = BackupManager::generateFull();
        if ($file) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=backup.' . date('Ymd') . '.zip');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
        }
        //NOTE: because it's not possible to show the error in the correct controller
        //if the above fails no error is shown to the user.
    }

    public function prune() {
        if (!BackupManager::deleteOld()) {
            $this->queueMessage(new Message('There was an error while removing the old backups.', Message::$ERROR));
        } else {
            $this->queueMessage(new Message('Old backups removed successfully.'));
        }
        $this->redirect('settings');
    }

    public function installTheme() {
        foreach ($_FILES as $file) {
            $file = (object) $file;
            if (!$file->error) {
                if (($zip = zip_open($file->tmp_name))) {
                    while ($entry = zip_read($zip)) {
                        $filename = THEMEROOT . '/' . zip_entry_name($entry);
                        if (!is_dir(dirname($filename)))
                            mkdir(dirname($filename), 0777, true);

                        if (zip_entry_filesize($entry)) {
                            file_put_contents($filename, zip_entry_read($entry, zip_entry_filesize($entry)));
                        }
                    }

                    $this->queueMessage(new Message($this->getTranslatedString('STAY_SETTINGS_THEME_INSTALL_SUCCESS'), Message::$SUCESS));
                } else {
                    $this->queueMessage(new Message($this->getTranslatedString('STAY_SETTINGS_THEME_FILETYPE'), Message::$ERROR));
                }
            } else {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_SETTINGS_THEME_UPLOAD_ERROR'), Message::$ERROR));
            }
        }
        $this->redirect('settings');
    }

    public function previewTheme($params = array()) {
        echo '<div id="themepreviewdiv">';
        if (isset($params[0])) {
            $file = THEMEROOT . '/' . $params[0] . '/theme.xml';
            if (is_file($file)) {
                $file = new XMLFile($file);

                echo '<div style="text-align: right"><a href="#">', $this->getTranslatedString('STAY_SETTINGS_PREVIEW_THEME_USE_THEME'),
                '</a></div><p><img id="themepreviewscrn" src="';
                if (is_file(THEMEROOT . '/' . $params[0] . '/' . strval($file->screenshot))) {
                    echo $this->getView()->getAssetLink(strval($file->screenshot), $params[0]);
                } else {
                    echo $this->getView()->getAssetLink('images/noimage.png', 'ui');
                }
                echo '" /></p>';

                echo '<p id="themepreviewdescription"><span class="themepreviewlabel">',
                $this->getTranslatedString('STAY_SETTINGS_PREVIEW_THEME_DSC_NAME'),
                ':</span><span>', strval($file->name), '</span><br /><span class="themepreviewlabel">',
                $this->getTranslatedString('STAY_SETTINGS_PREVIEW_THEME_DSC_AUTHOR'),
                ':</span><span>', strval($file->author), '</span><br/><span class="themepreviewlabel">',
                $this->getTranslatedString('STAY_SETTINGS_PREVIEW_THEME_DSC_TEMPLATES'),
                ':</span><span>';

                foreach ($file->templates->template as $tp) {
                    echo $tp->title, '&nbsp;';
                }

                echo '</span><br /><span><a href="', strval($file->url->link), '">', strval($file->url->title),
                '</a></span><br /><span class="themepreviewlabel">', $this->getTranslatedString('STAY_SETTINGS_PREVIEW_THEME_DSC_DSC'),
                ':</span><span>', strval($file->description), '</span></p><div style="clear: both" />';
            } else {
                echo '<p id="themepreviewerror">', $this->getTranslatedString('SETTINGS_PREVIEW_THEME_INVALID'), '</p>';
            }
        } else {
            echo '<p>', $this->getTranslatedString('SETTINGS_PREVIEW_THEME_INVALID'), '</p>';
        }

        echo '</div>';
    }

}