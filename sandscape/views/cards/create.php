<?php

/** @var CardsController $this */
$this->title = Yii::t('sandsacpe', 'New Card');

echo $this->renderPartial('_form', array('card' => $card));
