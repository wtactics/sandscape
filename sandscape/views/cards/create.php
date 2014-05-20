<?php

/** @var CardsController $this */
$this->title = Yii::t('sandscape', 'New Card');

echo $this->renderPartial('_form', array('card' => $card));
