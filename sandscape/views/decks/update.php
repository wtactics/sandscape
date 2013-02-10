<?php

/** @var DecksController $this */
$this->title = Yii::t('interface', 'Edit Deck');

echo $this->renderPartial('_form', array('deck' => $deck));
