<?php

/* AdministrationController.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * The <em>AdministrationController</em> class provides most, if not all, of the 
 * administration actions available in Sandscape.
 * 
 * @since 1.0, Sudden Growth
 */
class AdministrationController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Default action that shows the administration section with all the tabs.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionIndex() {
        $settings = array();
        foreach (Setting::model()->findAll() as $setting) {
            $settings[$setting->key] = (object) array(
                        'value' => $setting->value,
                        'description' => $setting->description
            );
        }
        $this->render('index', array('settings' => $settings));
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
     * 
     * @since 1.2, Elvish Shaman
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
     * Saves general settings from <em>Settings</em> tab in administration.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionSaveGameSettings() {
        //TODO: validate input properly
        //TODO: //NOTE: better way to find if any of the settings are missing
        //and add descriptions to missing settings.
        if (isset($_POST['GameSettings'])) {
            if (($fixDeckNr = Setting::model()->findByPk('fixdecknr')) === null) {
                $fixDeckNr = new Setting();
                $fixDeckNr->key = 'fixdecknr';
            }
            $fixDeckNr->value = (int) $_POST['fixdecknr'];
            $fixDeckNr->save();

            if (($decksPerGame = Setting::model()->findByPk('deckspergame')) === null) {
                $decksPerGame = new Setting();
                $decksPerGame->key = 'deckspergame';
            }
            $decksPerGame->value = (int) $_POST['deckspergame'];
            $decksPerGame->save();

            if (($useAnyDice = Setting::model()->findByPk('useanydice')) === null) {
                $useAnyDice = new Setting();
                $useAnyDice->key = 'useanydice';
            }
            $useAnyDice->value = (int) $_POST['useanydice'];
            $useAnyDice->save();

            if (($gameChatSpectators = Setting::model()->findByPk('gamechatspectators')) === null) {
                $gameChatSpectators = new Setting();
                $gameChatSpectators->key = 'gamechatspectators';
            }
            $gameChatSpectators->value = (int) $_POST['gamechatspectators'];
            $gameChatSpectators->save();
        }

        $this->redirect(array('index'));
    }

    /**
     * Saves words to filter in chat messages.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionSaveWords() {
        if (isset($_POST['wfilter'])) {
            if (($setting = Setting::model()->findByPk('wordfilter')) === null) {
                $setting = new Setting();
                $setting->key = 'wordfilter';
            }
            $setting->value = trim($_POST['wfilter']);
            $setting->save();
        }

        $this->redirect(array('index'));
    }

    /**
     * Saves Sandscape related settings.
     * 
     * @since 1.3, Soulharvester
     */
    public function actionSaveSandscapeSettings() {
        //TODO: validate input properly
        //TODO: //NOTE: better way to find if any of the settings are missing
        //and add descriptions to missing settings.
        if (isset($_POST['SandscapeSettings'])) {
            if (($fixDeckNr = Setting::model()->findByPk('cardscapeurl')) === null) {
                $fixDeckNr = new Setting();
                $fixDeckNr->key = 'cardscapeurl';
            }
            $fixDeckNr->value = $_POST['cardscapeurl'];
            $fixDeckNr->save();

            if (($decksPerGame = Setting::model()->findByPk('allowavatar')) === null) {
                $decksPerGame = new Setting();
                $decksPerGame->key = 'allowavatar';
            }
            $decksPerGame->value = (int) $_POST['allowavatar'];
            $decksPerGame->save();

            if (($useAnyDice = Setting::model()->findByPk('avatarsize')) === null) {
                $useAnyDice = new Setting();
                $useAnyDice->key = 'avatarsize';
            }
            $useAnyDice->value = $_POST['avatarsize'];
            $useAnyDice->save();
        }

        $this->redirect(array('index'));
    }

    /**
     *
     * @return array New rules array.
     * 
     * @since 1.0, Sudden Growth
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'pruneChats', 'removeOrphan',
                            'saveGameSettings', 'saveSandscapeSettings', 'saveWords'
                        ),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}

