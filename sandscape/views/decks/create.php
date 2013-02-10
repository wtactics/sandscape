<?php

/** @var DecksController $this */
$this->title = Yii::t('interface', 'New Deck');

echo $this->renderPartial('_form', array('deck' => $deck));
