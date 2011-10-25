<?php

/* DeckController.php
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
 * Handles all deck management actions that users can perform.
 * 
 * @since 1.0, Sudden Growth
 */
class DeckController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Default action used to list all decks for the current user.
     * The filter is applied in the view since it's there that the search method 
     * is called.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionIndex() {
        $this->updateUserActivity();

        $filter = new Deck('search');
        $filter->unsetAttributes();

        if (isset($_GET['Deck'])) {
            $filter->attributes = $_GET['Deck'];
        }

        $templates = DeckTemplate::model()->findAll('active = 1');
        $this->render('index', array('filter' => $filter, 'templates' => $templates));
    }

    /**
     * Creates a new deck and redirects the user to the <em>update</em> action 
     * uppon success.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionCreate() {
        $this->updateUserActivity();

        $new = new Deck();

        if (isset($_POST['Deck'])) {
            $new->attributes = $_POST['Deck'];

            $new->userId = Yii::app()->user->id;
            $new->created = date('Y-m-d H:i');

            if ($new->save()) {
                if (isset($_POST['using']) && !empty($_POST['using'])) {
                    foreach ($_POST['using'] as $cardname) {
                        $dkc = new DeckCard();
                        $cardId = explode('card-', $cardname);
                        $dkc->cardId = (int) $cardId[1];
                        $dkc->deckId = $new->deckId;

                        $dkc->save();
                    }
                }

                $this->redirect(array('update', 'id' => $new->deckId));
            }
        }

        $cards = Card::model()->findAll('active = 1');
        $this->render('edit', array('deck' => $new, 'cards' => $cards));
    }

    /**
     * Allows for updates to existing decks. The deck is identified by the given 
     * ID and the interface will allow for both the deck's info to be changed and 
     * the associated cards, if any.
     * 
     * @param integer $id The deck ID to update.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionUpdate($id) {
        $this->updateUserActivity();

        $deck = $this->loadDeckModel($id);

        if (isset($_POST['Deck'])) {
            $deck->attributes = $_POST['Deck'];
            if ($deck->save()) {

                //Remove all associations, and add only those that have been sent.
                //Worse case scenerio: user changes deck name but all cards are 
                //removed and added again.
                DeckCard::model()->deleteAll('deckId = :id', array(':id' => $deck->deckId));

                if (isset($_POST['autoFill']) && (int) $_POST['autoFill']) {
                    $cards = Card::model()->findAll('active = 1');
                    //auto-filling with 62 random cards
                    if (($max = count($cards))) {
                        for ($i = 0; $i < 62; $i++) {
                            $dkc = new DeckCard();
                            $dkc->cardId = $cards[rand(0, $max - 1)];
                            $dkc->deckId = $deck->deckId;

                            $dkc->save();
                        }
                    }
                } else if (isset($_POST['using']) && !empty($_POST['using'])) {
                    foreach ($_POST['using'] as $cardname) {
                        $dkc = new DeckCard();
                        $cardId = explode('card-', $cardname);
                        $dkc->cardId = (int) $cardId[1];
                        $dkc->deckId = $deck->deckId;

                        $dkc->save();
                    }
                }

                $this->redirect(array('update', 'id' => $deck->deckId));
            }
        }

        $cards = Card::model()->findAll('active = 1');
        $this->render('edit', array('deck' => $deck, 'cards' => $cards));
    }

    /**
     * Deletes a model from the database. Only POST requests are accepted so this 
     * method is used only in the list of decks for the current user.
     * 
     * Only the owner of a deck can delete it.
     * 
     * @param integer $id The deck's database ID.
     * 
     * @since 1.0, Sudden Growth
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $deck = $this->loadDeckModel($id);
            if ($deck->userId == Yii::app()->user->id) {

                $deck->active = 0;
                $deck->save();

                $this->updateUserActivity();
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Creates a <em>DeckTemplate</em> from a <em>Deck</em> object.
     * 
     * @param integer $id The deck's ID.
     * 
     * @since 1.1, Green Shield
     */
    public function actionMakeTemplate($id) {
        $deck = $this->loadDeckModel($id);

        $template = new DeckTemplate();
        $template->name = $deck->name;
        $template->created = $deck->created;
        if ($template->save()) {

            foreach ($deck->deckCards as $dkc) {
                $dktc = new DeckTemplateCard();
                $dktc->deckTemplateId = $template->deckTemplateId;
                $dktc->cardId = $dkc->cardId;
                
                //NOTE: ignoring save errors
                $dktc->save();
            }
        }

        $this->redirect(array('update', 'id' => $id));
    }

    /**
     * Creates a <em>Deck</em> from the selected template ID, <em>DeckTemplate</em>.
     */
    public function actionFromTemplate() {
        if (isset($_POST['preconslst']) && (int) $_POST['preconslst']) {
            if (($template = DeckTemplate::model()->findByPk((int) $_POST['preconslst'])) !== null) {
                $deck->name = $template->name;
                $deck->created = date('Y-m-d H:i:s');
                if ($deck->save()) {

                    foreach ($template->templatesCard as $tplc) {
                        $dkc = new DeckCard();
                        $dkc->deckId = $deck->deckId;
                        $dkc->cardId = $tplc->cardId;

                        //NOTE: ignoring save errors
                        $dkc->save();
                    }
                }
            }
        }

        $this->redirect(array('index'));
    }

    /**
     * Retrieves a Deck model from the database.
     * 
     * @param integer $id The model's database ID
     * @return  Deck The loaded model or null if no model was found for the given ID
     * 
     * @since 1.0, Sudden Growth
     */
    private function loadDeckModel($id) {
        if (($deck = Deck::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $deck;
    }

    /**
     * Adding to the default access rules.
     * 
     * @return array
     * 
     * @since 1.0, Sudden Growth
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete', 'fromTemplate'),
                        'users' => array('@')
                    ),
                    array('allow',
                        'actions' => array('makeTemplate'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
