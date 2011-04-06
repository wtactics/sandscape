<?php

class CleanupController extends GenericAdminController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->menu[1]['active'] = true;
    }

    public function actionIndex() {
        $viewData = array(
            'menu' => $this->menu,
            'imageGrid' => array(
                'id' => 'image-grid',
                'dataProvider' => new CActiveDataProvider('CardImage', array(
                    'criteria' => array(
                        'select' => 't.imageId, t.filetype, t.filename, t.filesize',
                        'join' => 'LEFT JOIN Card ON t.imageId = Card.imageId',
                        'condition' => 'Card.imageId IS NULL'
                        ))
                ),
                'columns' => array(
                    'imageId',
                    'filetype',
                    'filename',
                    'filesize',
                    array(
                        'class' => 'CButtonColumn'
                    )
                )
            ),
            //TODO:
            //'chatGrid' => array(
            //    'id' => 'chat-grid',
            //    'dataProvider' => new CActiveDataProvider('Chat', array(
            //        'criteria' => array(
            //            'join'
            //            'condition' => ''
            //        )
            //    ))
            //),
            //TODO:
            'logGrid' => array(
            )
        );

        $this->render('index', $viewData);
    }

}
