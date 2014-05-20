<?php

/** @var StatesController $this */
$this->title = Yii::t('sandscape', 'New State');

echo $this->renderPartial('_form', array('state' => $state));
