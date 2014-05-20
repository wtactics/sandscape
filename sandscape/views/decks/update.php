<?php

/** @var DecksController $this */
$this->title = Yii::t('sandscape', 'Edit Deck');

echo $this->renderPartial('_form', array('deck' => $deck));
