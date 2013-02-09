<?php

/* AdministrationController.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The <em>AdministrationController</em> class provides most, if not all, of the 
 * administration actions available in Sandscape.
 */
class AdministrationController extends ApplicationController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Removes <em>ChatMessage</em> records from the database. All messages that 
     * have a <em>sent</em> date lower than the given date will be considered, 
     * also, messages can include game messages but only those created by users.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionPruneChats() {

        $condition = 'sent < \':date\'';
        if (!isset($_POST['gamemessages'])) {
            $condition .= ' AND gameId IS NULL';
        }

        ChatMessage::model()->deleteAll($condition, array(':date' => $_POST['date']));
        $this->redirect(array('index'));
    }

    /**
     * Finds and removes images that are not in use by card objects.
     */
    public function actionRemoveOrphan() {
        $images = CFileHelper::find('', array(
                    'fileTypes' => array('jpg', 'jpeg', 'png'),
                    'level' => 0
                ));
        if (count($images)) {
            $existing = array();
            $remove = array();
            foreach (Card::model()->findAll() as $card) {
                $existing[] = $card->image;
            }

            if (count($existing)) {
                foreach ($images as $image) {
                    if (in_array($image, $existing)) {
                        continue;
                    }

                    $remove[] = $image;
                }

                foreach ($remove as $file) {
                    unlink($file);
                }
            }
        }

        $this->redirect(array('index'));
    }

    /**
     * Allows an administrator to change the words filtered in the chat area.
     */
    public function actionChatFilter() {
        $words = '';
        if (($setting = Setting::model()->findByPk('wordfilter')) != null) {
            $words = $setting->value;
        } else {
            $setting = new Setting();
            $setting->key = 'wordfilter';
            $setting->group = 'wordfilter';
        }

        if (isset($_POST['wfilter'])) {
            $setting->value = trim($_POST['wfilter']);
            if ($setting->save()) {
                $this->redirect(array('chatfilter'));
            }
        }

        $this->render('chat-filter', array('words' => $words));
    }

    /**
     * Game related settings.
     */
    public function actionGameOptions() {
        $settings = array(
            'fixdecknr' => 0,
            'deckspergame' => 1,
            'useanydice' => 0,
            'gamechatspectators' => 0
        );

        foreach (Setting::model()->findAll('`group` = :g', array(':g' => 'game')) as $setting) {
            $settings[$setting->key] = $setting;
        }

        if (isset($_POST['GameSettings'])) {
            if (($fixDeckNr = Setting::model()->findByPk('fixdecknr')) === null) {
                $fixDeckNr = new Setting();
                $fixDeckNr->key = 'fixdecknr';
                $fixDeckNr->group = 'game';
            }
            $fixDeckNr->value = (int) $_POST['fixdecknr'];
            $fixDeckNr->save();

            if (($decksPerGame = Setting::model()->findByPk('deckspergame')) === null) {
                $decksPerGame = new Setting();
                $decksPerGame->key = 'deckspergame';
                $decksPerGame->group = 'game';
            }
            $decksPerGame->value = (int) $_POST['deckspergame'];
            $decksPerGame->save();

            if (($useAnyDice = Setting::model()->findByPk('useanydice')) === null) {
                $useAnyDice = new Setting();
                $useAnyDice->key = 'useanydice';
                $useAnyDice->group = 'game';
            }
            $useAnyDice->value = (int) $_POST['useanydice'];
            $useAnyDice->save();

            if (($gameChatSpectators = Setting::model()->findByPk('gamechatspectators')) === null) {
                $gameChatSpectators = new Setting();
                $gameChatSpectators->key = 'gamechatspectators';
                $gameChatSpectators->group = 'game';
            }
            $gameChatSpectators->value = (int) $_POST['gamechatspectators'];
            $gameChatSpectators->save();

            $this->redirect(array('gameoptions'));
        }

        $this->render('game-settings', array('settings' => $settings));
    }

    /**
     * General Sandscape settings.
     */
    public function actionSandscapeSettings() {
        $settings = array(
            'cardscapeurl' => '',
            'allowavatar' => 1,
            'avatarsize' => '100x75',
            'sysemail' => ''
        );

        foreach (Setting::model()->findAll('`group` = :g', array(':g' => 'general')) as $setting) {
            $settings[$setting->key] = $setting;
        }

        if (isset($_POST['SandscapeSettings'])) {
            if (($cardscapeUrl = Setting::model()->findByPk('cardscapeurl')) === null) {
                $cardscapeUrl = new Setting();
                $cardscapeUrl->key = 'cardscapeurl';
                $cardscapeUrl->group = 'general';
            }
            $cardscapeUrl->value = $_POST['cardscapeurl'];
            $cardscapeUrl->save();

            if (($allowAvatar = Setting::model()->findByPk('allowavatar')) === null) {
                $allowAvatar = new Setting();
                $allowAvatar->key = 'allowavatar';
                $allowAvatar->group = 'general';
            }
            $allowAvatar->value = (int) $_POST['allowavatar'];
            $allowAvatar->save();

            if (($avatarSize = Setting::model()->findByPk('avatarsize')) === null) {
                $avatarSize = new Setting();
                $avatarSize->key = 'avatarsize';
                $avatarSize->group = 'general';
            }
            $avatarSize->value = $_POST['avatarsize'];
            $avatarSize->save();

            if (($sysEmail = Setting::model()->findByPk('sysemail')) === null) {
                $sysEmail = new Setting();
                $sysEmail->key = 'sysemail';
                $sysEmail->group = 'general';
            }
            $sysEmail->value = $_POST['sysemail'];
            $sysEmail->save();

            $this->redirect(array('sandscapesettings'));
        }
        $this->render('general-settings', array('settings' => $settings));
    }

    /**
     * Access to basic maintenance tools.
     */
    public function actionMaintenanceTools() {
        $this->render('tools');
    }

    /**
     *
     * @return array New rules array.
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'pruneChats', 'removeOrphan',
                            'saveGameSettings', 'saveSandscapeSettings', 'saveWords',
                            'chatFilter', 'gameOptions', 'maintenanceTools', 'sandscapeSettings'
                        ),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}

