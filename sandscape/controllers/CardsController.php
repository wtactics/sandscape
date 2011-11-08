<?php

/* CardsController.php
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
 * Handles card administration available to administrations.
 * This class was renamed from <em>CardController</em>.
 * 
 * @since 1.2, Elvish Shaman
 */
class CardsController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Default administration action that lists all existing cards.
     * 
     * @since 1.2, Elvish Shaman
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
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionCreate() {
        $new = new Card();
        $this->performAjaxValidation('card-form', $new);

        if (isset($_POST['Card'])) {
            $new->attributes = $_POST['Card'];
            if ($new->save()) {

                $path = Yii::getPathOfAlias('webroot') . '/_cards';
                $upfile = CUploadedFile::getInstance($new, 'image');
                if ($upfile !== null) {
                    $name = md5('[CARDID=' . $new->cardId . ']=' . $upfile->name) . '.' . $upfile->extensionName;

                    $sizes = getimagesize($upfile->tempName);
                    $imgFactory = PhpThumbFactory::create($upfile->tempName);

                    //320 width
                    if ($sizes[0] > 320) {
                        $imgFactory->resize(320, 453);
                    }

                    //453 height
                    if ($sizes[1] > 453) {
                        $imgFactory->resize(320, 453);
                    }
                    $imgFactory->save($path . '/up/' . $name);
                    $imgFactory->resize(81, 115)->save($path . '/up/thumbs/' . $name);

                    $imgFactory = PhpThumbFactory::create($path . '/up/' . $name);
                    $imgFactory->rotateImageNDegrees(180)->save($path . '/down/' . $name);

                    $imgFactory = PhpThumbFactory::create($path . '/down/' . $name);
                    $imgFactory->resize(81, 115)->save($path . '/down/thumbs/' . $name);

                    $new->image = $name;
                    $new->save();
                }

                $this->redirect(array('update', 'id' => $new->cardId));
            }
        }

        $this->render('edit', array('card' => $new));
    }

    /**
     * Updates a card's information.
     * 
     * @param integer $id The card ID we want to update.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionUpdate($id) {
        $card = $this->loadCardModel($id);

        $this->performAjaxValidation('card-form', $card);

        if (isset($_POST['Card'])) {
            $card->attributes = $_POST['Card'];
            if ($card->save()) {
                $path = Yii::getPathOfAlias('webroot') . '/_cards';
                $upfile = CUploadedFile::getInstance($new, 'image');
                if ($upfile !== null) {

                    //remove old images, if they exist.
                    if ($card->image) {
                        //Don't really care if removable fails, will delete orphan 
                        //cards at a later time.
                        unlink($path . '/up/' . $card->image);
                        unlink($path . '/up/thumbs/' . $card->image);
                        unlink($path . '/down/' . $card->image);
                        unlink($path . '/up/thumbs/' . $card->image);

                        $card->image = null;
                    }

                    $name = md5('[CARDID=' . $new->cardId . ']=' . $upfile->name) . '.' . $upfile->extensionName;

                    $sizes = getimagesize($upfile->tempName);
                    $imgFactory = PhpThumbFactory::create($upfile->tempName);

                    //320 width
                    if ($sizes[0] > 320) {
                        $imgFactory->resize(320, 453);
                    }

                    //453 height
                    if ($sizes[1] > 453) {
                        $imgFactory->resize(320, 453);
                    }
                    $imgFactory->save($path . '/up/' . $name);
                    $imgFactory->resize(81, 115)->save($path . '/up/thumbs/' . $name);

                    $imgFactory = PhpThumbFactory::create($path . '/up/' . $name);
                    $imgFactory->rotateImageNDegrees(180)->save($path . '/down/' . $name);

                    $imgFactory = PhpThumbFactory::create($path . '/down/' . $name);
                    $imgFactory->resize(81, 115)->save($path . '/down/thumbs/' . $name);

                    $new->image = $name;
                    $new->save();
                }
                $this->redirect(array('view', 'id' => $card->cardId));
            }
        }

        $this->render('edit', array('card' => $card));
    }

    /**
     * Deletes a card by making it inactive.
     * 
     * @param integer $id The card ID.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionDelete($id) {
        if (Yii::app()->user->class && Yii::app()->request->isPostRequest) {
            $card = $this->loadCardModel($id);

            $card->active = 0;
            $card->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Allows administrators to import cards from CSV files.
     * The cards must be inside a <em>ZIP</em> archive, with a file named 
     * <strong>cards.csv</em> listing all the cards and with all images inside a 
     * folder named <strong>images</em>.
     * 
     * CSV file must have the following fields, in the order:
     *  - name, the name of the card, required field
     *  - rules, the rules text for the card, required field
     *  - image, the image file to use, this file needs to be inside a folder 
     *  named <em>images</em>, this is a required field
     *  - cardscape ID, the ID for cardscape system if this is a card imported 
     *  from Cardscape
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionImport() {
        //card name; card rules; card image; cardscape id
        if (isset($_POST['Upload'])) {
            $upfile = CUploadedFile::getInstanceByName('archive');
            if ($upfile !== null) {
                $destination = Yii::app()->assetManager->basePath . '/import/';
                $path = Yii::getPathOfAlias('webroot') . '/_cards';

                $zip = new ZipArchive();
                if ($zip->open($upfile->tempName) === true) {
                    $zip->extractTo($destination);
                    $zip->close();

                    unlink($upfile->tempName);

                    if (($fh = fopen('cards.csv', 'r')) !== false) {
                        while (($csvLine = fgetcsv($fh, 2500, ',')) !== FALSE) {
                            if (!isset($cvsLine[2])) {
                                continue;
                            }

                            if (($card = Card::model()->find('active = 1 AND name LIKE :name', array(':name' => $csvLine[0]))) === null) {
                                $card = new Card();
                                $card->name = $cvsLine[0];
                            }
                            $card->rules = $cvsLine[1];
                            if (isset($cvsLine[3])) {
                                $card->cardscapeId = (int) $cvsLine[3];
                            }

                            $card->save();
                            //NOTE: Do we really need the extension at the end? 
                            //Can't we just use the MD5 hash?
                            $partials = explode('.', $cvsLine[2]);
                            $ext = array_pop($partials);
                            $name = implode('.', $partials);

                            $sizes = getimagesize($destination . 'cards/' . $cvsLine[2]);
                            $imgFactory = PhpThumbFactory::create($destination . 'cards/' . $cvsLine[2]);

                            $name = md5('[CARDID=' . $card->cardId . ']=' . $name . '.' . $ext);
                            if (is_file($path . '/up/' . $name)) {
                                continue;
                            }

                            //320 width
                            if ($sizes[0] > 320) {
                                $imgFactory->resize(320, 453);
                            }

                            //453 height
                            if ($sizes[1] > 453) {
                                $imgFactory->resize(320, 453);
                            }
                            $imgFactory->save($path . '/up/' . $name);
                            $imgFactory->resize(81, 115)->save($path . '/up/thumbs/' . $name);

                            $imgFactory = PhpThumbFactory::create($path . '/up/' . $name);
                            $imgFactory->rotateImageNDegrees(180)->save($path . '/down/' . $name);

                            $imgFactory = PhpThumbFactory::create($path . '/down/' . $name);
                            $imgFactory->resize(81, 115)->save($path . '/down/thumbs/' . $name);

                            $card->image = $name;
                            $card->save();
                            //
                        }
                        fclose($fh);
                    }
                }
            }
        }

        $this->render('import');
    }

    /**
     * Loads a card model from the database.
     * 
     * @param integer $id The ID for the card.
     * @return Card The card model.
     * 
     * @since 1.2, Elvish Shaman
     */
    private function loadCardModel($id) {
        if (($card = Card::model()->find('active = 1 AND cardId = :id', array(':id' => (int) $id))) === null) {
            throw new CHttpException(404, 'The requested card does not exist.');
        }
        return $card;
    }

    /**
     * Adds new rules for this controller.
     * 
     * @return array The merged rules array.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete', 'view', 'import'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
