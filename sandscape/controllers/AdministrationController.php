<?php

/**
 * 
 * @since 1.0, Sudden Growth
 */
class AdministrationController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * @since 1.0, Sudden Growth
     */
    public function actionIndex() {
        $this->render('index');
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
                        'actions' => array('index'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
