<?php

/** @var CardsController $this */
$this->title = Yii::t('interface', 'New Card');

echo $this->renderPartial('_form', array('card' => $card));
