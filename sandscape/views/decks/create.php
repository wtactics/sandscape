<?php

/** @var DecksController $this */
$this->title = Yii::t('sandscape', 'New Deck');

echo $this->renderPartial('_form', array('deck' => $deck));
