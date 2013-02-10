<?php

/** @var StatesController $this */
$this->title = Yii::t('interface', 'New State');

echo $this->renderPartial('_form', array('state' => $state));