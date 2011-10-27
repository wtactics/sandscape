<?php

/* AdministrationController.php
 * 
 * This file is part of SandScape.
 *
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 * http://wtactics.org
 */

/**
 * 
 * @since 1.0, Sudden Growth
 */
class AdministrationController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->render('index');
    }

    /**
     * Removes <em>ChatMessage</em> records from the database. All messages that 
     * have a <em>sent</em> date lower than the given date will be considered, 
     * also, messages can include game messages but only those created by users.
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
     *
     * @return array New rules array.
     * 
     * @since 1.0, Sudden Growth
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'pruneChats', 'findOrphan',
                            'clearGames'
                        ),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}

