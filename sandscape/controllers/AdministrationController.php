<?php

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

    public function actionPruneChats() {
        if (isset($_POST['lobby'])) {
            
        }
        if (isset($_POST['game'])) {
            
        }

        //$this->redirect(array('index'));
    }

    public function actionFindOrphan() {
        
    }

    public function actionClearGames() {
        
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
