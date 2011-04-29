<?php
/*
 * Controller.php
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
 */
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
