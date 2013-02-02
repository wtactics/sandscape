<?php

/** @var CardsController $this */
$this->title = Yii::t('sandscape', 'Edit State');

echo $this->renderPartial('_form', array('state' => $state));