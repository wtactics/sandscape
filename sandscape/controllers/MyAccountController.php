<?php

/*
 * controllers/MyAccountController.php
 * http://sandscape.sourceforge.net/
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

class MyAccountController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        return array_merge(array(
                    array(
                        'allow',
                        'actions' => array('index'/* , 'create'/* , 'update', 'delete' */),
                        'expression' => function ($user, $rule) {
                            return (!Yii::app()->user->isGuest);
                        })
                        ), parent::accessRules());
    }

    public function actionIndex() {
        //$card = new Card('search');
        //$card->unsetAttributes();
        //if (isset($_GET['Card']))
        //    $card->attributes = $_GET['Card'];
        //$viewData = array(
        //    'menu' => array(
        //        'id' => 'submenu',
        //        'items' => $this->menu
        //    ),
        //    'grid' => array(
        //        'id' => 'card-grid',
        //        'dataProvider' => $card->search(),
        //        'filter' => $card,
        //        'columns' => array(
        //            'name',
        //            'faction',
        //            'type',
        //            'subtype',
        //            'author',
        //            'revision',
        //            'cardscapeId',
        //            array(
        //                'name' => 'private',
        //                'value' => '$data->private',
        //                'filter' => array('Public', 'Private')
        //            ),
        //            array(
        //                'class' => 'CButtonColumn'
        //            )
        //        )
        //    ),
        //    'model' => $card
        //);
        //$this->render('index', $viewData);
    }

}
