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
 * @since 1.0
 */
class DeckController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Default action used to list all decks for the current user.
     * The filter is applied in the view since it's there that the search method 
     * is called.
     */
    public function actionIndex() {
        $this->updateUserActivity();

        $filter = new Deck('search');
        $filter->unsetAttributes();

        if (isset($_GET['Deck'])) {
            $filter->attributes = $_GET['Deck'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Creates a new deck and redirects the user to the <em>update</em> action 
     * uppon success.
     */
    public function actionCreate() {
        $this->updateUserActivity();

        $new = new Deck();

        if (isset($_POST['Deck'])) {
            $new->attributes = $_POST['Deck'];

            $new->userId = 1;
            $new->created = date('Y-m-d H:i');

            if ($new->save()) {
                if (isset($_POST['autoFill']) && (int) $_POST['autoFill']) {
                    $cards = Card::model()->findAll('active = 1');
                    //auto-filling with 62 random cards
                    if (($max = count($cards))) {
                        for ($i = 0; $i < 62; $i++) {
                            $dkc = new DeckCard();
                            $dkc->cardId = $cards[rand(0, $max - 1)]->cardId;
                            $dkc->deckId = $new->deckId;

                            $dkc->save();
                        }
                    }
                } else if (isset($_POST['using']) && !empty($_POST['using'])) {
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
     * Retrieves a Deck model from the database.
     * 
     * @param integer $id The model's database ID
     * @return  Deck The loaded model or null if no model was found for the given ID
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
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete'),
                        'users' => array('@')
                    )
                        ), parent::accessRules());
    }

}
