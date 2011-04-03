<?php

class SiteController extends Controller {

    public function actionIndex() {
        $this->render('index', array('page' => Page::model()->find('pageId = :id', array(':id' => 'about'))));
    }

}
