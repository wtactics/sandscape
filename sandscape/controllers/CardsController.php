<?php

/* CardsController.php
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
 * Handles card administration available to administrations.
 * This class was renamed from <em>CardController</em>.
 */
class CardsController extends ApplicationController {

    //private static $NORMAL_WIDTH = 250;
    //private static $NORMAL_HEIGHT = 354;
    //private static $SMALL_WIDTH = 81;
    //private static $SMALL_HEIGHT = 115;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Adds new rules for this controller.
     * 
     * @return array The merged rules array.
     */
    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'create', 'view', 'update'),
                'expression' => '$user->role == "administrator"'
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }

    /**
     * Loads a card model from the database.
     * 
     * @param integer $id The ID for the card.
     * @return Card The card model.
     */
    private function loadCardModel($id) {
        if (!($card = Card::model()->findByPk((int) $id))) {
            throw new CHttpException(404, Yii::t('sandscape', 'The requested card does not exist.'));
        }
        return $card;
    }

    /**
     * Default administration action that lists all existing cards.
     */
    public function actionIndex() {
        $filter = new Card('search');
        $filter->unsetAttributes();

        if (isset($_GET['Card'])) {
            $filter->attributes = $_GET['Card'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Creates a new card and allows for image uploads, creating all the necessary 
     * thumbs and reverted copies.
     */
    public function actionCreate() {
        $card = new Card();
        $this->performAjaxValidation('card-form', $card);

        if (isset($_POST['Card'])) {
            $card->attributes = $_POST['Card'];

//            //TODO: 
//            Yii::import('ext.PhpThumbFactory');
//            $path = Yii::getPathOfAlias('webroot') . '/gamedata/cards';
//            $upfile = CUploadedFile::getInstance($card, 'image');
//
//            if ($upfile !== null) {
//                $name = $upfile->name;
//
//                if (is_file($path . '/' . $name)) {
//                    $name = $card->name . '.' . $name;
//                }
//
//                $sizes = getimagesize($upfile->tempName);
//                $imgFactory = PhpThumbFactory::create($upfile->tempName);
//
//                //250 width, 354 height
//                if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
//                    $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
//                }
//
//                $imgFactory->save($path . '/' . $name);
//                $imgFactory->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)->save($path . '/thumbs/' . $name);
//                $imgFactory->rotateImageNDegrees(180)->save($path . '/thumbs/reversed/' . $name);
//
//                $card->image = $name;
//        }
            if ($card->save()) {
                $this->redirect(array('view', 'id' => $card->cardId));
            }
        }

        $this->render('create', array('card' => $card));
    }

    public function actionView($id) {
        $card = $this->loadCardModel($id);
        $this->render('view', array('card' => $card));
    }

    /**
     * Updates a card's information.
     * 
     * @param integer $id The card ID we want to update.
     */
    public function actionUpdate($id) {
        $card = $this->loadCardModel($id);
        $this->performAjaxValidation('card-form', $card);

        if (isset($_POST['Card'])) {
            $card->attributes = $_POST['Card'];
            if ($card->save()) {
                $this->redirect(array('view', 'id' => $card->cardId));
            }
        }

        $this->render('update', array('card' => $card));
    }

    /**
     * Deletes a card by making it inactive.
     * 
     * @param integer $id The card ID.
     */
    public function actionDelete($id) {
        if (Yii::app()->user->role == 'administrator' && Yii::app()->request->isPostRequest) {
            $card = $this->loadCardModel($id);

            $card->active = 0;
            $card->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('sandscape', 'Invalid request. Please do not repeat this request again.'));
        }
    }

//
//    /**
//     * Allows administrators to import cards from CSV files.
//     * The cards must be inside a <em>ZIP</em> archive, with a file named 
//     * <strong>cards.csv</em> listing all the cards and with all images inside a 
//     * folder named <strong>images</em>.
//     * 
//     * CSV file must have the following fields, in the order:
//     *  - name, the name of the card, required field
//     *  - rules, the rules text for the card, required field
//     *  - image, the image file to use, this file needs to be inside a folder 
//     *  named <em>images</em>, this is a required field
//     *  - cardscape ID, the ID for cardscape system if this is a card imported 
//     *  from Cardscape
//     */
//    public function actionImport() {
//        $saveErrors = array();
//        $uError = false;
//        $success = false;
//
//        if (isset($_POST['Upload'])) {
//            $upfile = CUploadedFile::getInstanceByName('archive');
//            if ($upfile !== null) {
//                $destination = Yii::app()->assetManager->basePath . '/import/';
//                $path = Yii::getPathOfAlias('webroot') . '/_game/cards';
//                if (!$upfile->error) {
//                    $zip = new ZipArchive();
//                    if ($zip->open($upfile->tempName) === true) {
//                        $zip->extractTo($destination);
//                        $zip->close();
//                        unlink($upfile->tempName);
//
//                        if (($fh = fopen($destination . 'cards/cards.csv', 'r')) !== false) {
//                            while (($csvLine = fgetcsv($fh, 2500, ',')) !== FALSE) {
//                                if (!isset($csvLine[2])) {
//                                    continue;
//                                }
//
//                                if (($card = Card::model()->find('name LIKE :name', array(':name' => trim($csvLine[0])))) === null) {
//                                    $card = new Card();
//                                    $card->name = trim($csvLine[0]);
//                                }
//                                $card->active = 1;
//                                $card->rules = trim($csvLine[1]);
//                                if (isset($csvLine[3]) && intval(trim($csvLine[3])) != 0) {
//                                    $card->cardscapeId = intval(trim($csvLine[3]));
//                                }
//
//                                $name = trim($csvLine[2]);
//                                if (!is_file($path . '/' . $name)) {
//                                    $sizes = getimagesize($destination . 'cards/images/' . $name);
//                                    $imgFactory = PhpThumbFactory::create($destination . 'cards/images/' . $name);
//
//                                    //250 width, 354 height
//                                    if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
//                                        $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
//                                    }
//
//                                    $imgFactory->save($path . '/' . $name);
//                                    $imgFactory->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)->save($path . '/thumbs/' . $name);
//                                    $imgFactory->rotateImageNDegrees(180)->save($path . '/thumbs/reversed/' . $name);
//
//                                    $card->image = $name;
//                                }
//                                if (!$card->save()) {
//                                    $saveErrors[] = "Unable to save card named '{$card->name}'";
//                                }
//                            }
//                            fclose($fh);
//                            if (count($saveErrors) == 0) {
//                                $success = true;
//                            }
//
//                            //Remove all entries from import folder, recursively
//                            foreach (new RecursiveIteratorIterator(
//                                    new RecursiveDirectoryIterator($destination), RecursiveIteratorIterator::CHILD_FIRST)
//                            as $entry) {
//                                if ($entry->isDir()) {
//                                    rmdir($entry->__toString());
//                                } else {
//                                    unlink($entry->__toString());
//                                }
//                            }
//                        }
//                    }
//                }
//            } else {
//                $uError = 'An error was found while uploading the file.';
//            }
//        }
//
//        $this->render('import', array(
//            'saveErrors' => $saveErrors,
//            'uError' => $uError,
//            'success' => $success
//        ));
//    }
}
