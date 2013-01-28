<?php

/* DeckController.php
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
 * Handles all deck management actions that users can perform.
 * This class was renamed from <em>DeckController</em>.
 * 
 * @since 1.2, Elvish Shaman
 */
class DecksController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Default action used to list all decks for the current user.
     * The filter is applied in the view since it's there that the search method 
     * is called.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionIndex() {
        $this->updateUserActivity();

        $cardCount = intval(Card::model()->count('active = 1'));

        $filter = new Deck('search');
        $filter->unsetAttributes();

        if (isset($_GET['Deck'])) {
            $filter->attributes = $_GET['Deck'];
        }

        $templates = DeckTemplate::model()->findAll('active = 1');
        $this->render('index', array(
            'filter' => $filter,
            'templates' => $templates,
            'cardCount' => $cardCount
        ));
    }

    /**
     * Creates a new deck and redirects the user to the <em>update</em> action 
     * uppon success.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionCreate() {
        $this->updateUserActivity();

        $new = new Deck();

        $this->performAjaxValidation('deck-form', $new);

        if (isset($_POST['Deck'])) {
            $new->attributes = $_POST['Deck'];

            $new->userId = Yii::app()->user->id;
            $new->created = date('Y-m-d H:i');

            if ($new->save()) {
                if (isset($_POST['selected']) && !empty($_POST['selected'])) {
                    foreach ($_POST['selected'] as $cardId) {
                        $dkc = new DeckCard();
                        $dkc->cardId = (int) $cardId;
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
     * @since 1.2, Elvish Shaman
     */
    public function actionUpdate($id) {
        $this->updateUserActivity();

        $deck = $this->loadDeckModel($id);

        $this->performAjaxValidation('deck-form', $deck);

        if (isset($_POST['Deck'])) {
            $deck->attributes = $_POST['Deck'];
            if ($deck->save()) {

                //Remove all associations, and add only those that have been sent.
                //Worse case scenerio: user changes deck name but all cards are 
                //removed and added again.
                DeckCard::model()->deleteAll('deckId = :id', array(':id' => $deck->deckId));

                if (isset($_POST['selected']) && !empty($_POST['selected'])) {
                    foreach ($_POST['selected'] as $cardId) {
                        $dkc = new DeckCard();
                        $dkc->cardId = (int) $cardId;
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
     * @since 1.2, Elvish Shaman
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
     * @since 1.2, Elvish Shaman
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
            if (($template = DeckTemplate::model()->find('active = 1 AND deckTemplateId = :id', array(
                ':id' => (int) $_POST['preconslst']))
                    ) !== null) {

                $deck = new Deck();
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
     * Loads a card image from the database and returns the result as a JSON 
     * encoded object to be used by AJAX calls.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionImagePreview() {
        $result = array('success' => 0);
        if (isset($_POST['card']) && (int) $_POST['card'] != 0) {
            if (($card = Card::model()->findByPk((int) $_POST['card'])) !== null) {
                $result['success'] = 1;
                $result['image'] = $card->image;
            }
        }

        echo json_encode($result);
    }

    /**
     * Allows users to view deck information whitout the distractions of the 
     * editing interface.
     * 
     * @param integer $id The deck ID for the deck we want to view.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionView($id) {
        $deck = $this->loadDeckModel($id);
        $this->render('view', array('deck' => $deck));
    }

    public function actionExport($id, $type) {
        switch ($type) {
            case 'pdf':
                $this->exportPDF($id);
                break;
            case 'txt':
                $this->exportTXT($id);
                break;
            case 'html':
                $this->exportHTML($id);
                break;
            default:
                throw new CHttpException(404, 'Invalid export option.');
        }
    }

    private function exportPDF($id) {
        //TODO: not implemented yet!        
        $pdf = new tFPDF();

        //header()
        //...
    }

    private function exportTXT($id) {
        //TODO: not implemented yet!
        //security checks
        //count existing cards
        //export data
        $deck = Deck::model()->findByPk($id);
        $data = null;
        $data = sprintf($file, "Card List for %s (%d cards)\n\n", $deck->name, count($deck->cards));
        foreach ($deck->cards as $card) {
            $data .= sprintf($file, "%s - %d\n", $card->name, 0);
        }

        //header()
        echo $data;
    }

    private function exportHTML($id) {
        //TODO: not implemented yet!
        //load HTML template
        //fill template with data
        //copy images to temp
        //zip html file and images
        //output zip file
    }

    /**
     * Retrieves a Deck model from the database.
     * 
     * @param integer $id The model's database ID.
     * @return Deck The loaded model or null if no model was found for the 
     * given ID.
     * 
     * @since 1.2, Elvish Shaman
     */
    private function loadDeckModel($id) {
        if (($deck = Deck::model()->find('active = 1 AND deckId = :id', array(':id' => (int) $id))) === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $deck;
    }

    /**
     * Adding to the default access rules.
     * 
     * @return array
     * 
     * @since 1.2, Elvish Shaman
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete',
                            'fromTemplate', 'view', 'imagePreview', 'export'),
                        'users' => array('@')
                    ),
                    array('allow',
                        'actions' => array('makeTemplate'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
