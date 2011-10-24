<?php

/* CardController.php
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
 * 
 * @since 1.0, Sudden Growth
 */
class CardController extends AppController {

    /**
     * Default administration action that lists all existing cards.
     * 
     * @since 1.0, Sudden Growth
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
     * @since 1.1, Green Shield
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
     * @since 1.1, Green Shield
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

    public function actionView($id) {
        //TODO: not implemented yet, incomplete
        $this->render('view', array('card' => $this->loadCardModel($id)));
    }

    /**
     * Deletes a card by making it inactive.
     * 
     * @param integer $id The card ID.
     * 
     * @since 1.1, Green Shield
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

    public function actionImport() {
        //TODO: untested, the code hasn't been properly tested.
        //card name; card rules; card image; cardscape id

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

                        $card = new Card();
                        $card->name = $cvsLine[0];
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

        $this->render('import');
    }

    /**
     * Loads a card model from the database.
     * 
     * @param integer $id The ID for the card.
     * @return Card The card model.
     * 
     * @since 1.0, Sudden Growth
     */
    private function loadCardModel($id) {
        if (($card = Card::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $card;
    }

    /**
     * Adds new rules for this controller.
     * 
     * @return array The merged rules array.
     * 
     * @since 1.0, Sudden Growth
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
