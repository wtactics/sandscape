<?php

/** @var CardsController $this */
$this->title = Yii::t('interface', 'Edit State');

echo $this->renderPartial('_form', array('state' => $state));